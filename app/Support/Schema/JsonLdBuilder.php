<?php

namespace App\Support\Schema;

use App\Models\Faq;
use App\Models\Product;
use App\Models\Review;
use App\Support\MediaUrl;
use Carbon\Carbon;
use Illuminate\Support\Collection;

class JsonLdBuilder
{
    public function baseUrl(): string
    {
        return config('schema.site_url');
    }

    public function organizationId(): string
    {
        return $this->baseUrl().'/#organization';
    }

    public function websiteId(): string
    {
        return $this->baseUrl().'/#website';
    }

    public function localBusinessId(): string
    {
        return $this->baseUrl().'/#localbusiness';
    }

    /**
     * @return array<string, mixed>
     */
    public function wrapGraph(array $nodes): array
    {
        return [
            '@context' => 'https://schema.org',
            '@graph' => array_values($nodes),
        ];
    }

    /**
     * @return array<string, mixed>
     */
    public function organizationNode(): array
    {
        $org = config('schema.organization');

        return [
            '@type' => 'Organization',
            '@id' => $this->organizationId(),
            'name' => $org['name'],
            'url' => $this->baseUrl().'/',
            'logo' => $this->imageObject(
                $org['logo'],
                (int) ($org['logo_width'] ?? 0),
                (int) ($org['logo_height'] ?? 0),
            ),
            'telephone' => $org['telephone'],
            'sameAs' => config('schema.same_as'),
        ];
    }

    /**
     * @return array<string, mixed>
     */
    public function websiteNode(): array
    {
        return [
            '@type' => 'WebSite',
            '@id' => $this->websiteId(),
            'url' => $this->baseUrl().'/',
            'name' => config('schema.website.name'),
            'publisher' => ['@id' => $this->organizationId()],
            'inLanguage' => 'th-TH',
        ];
    }

    /**
     * @return array<string, mixed>
     */
    public function localBusinessNode(?array $geoOverride = null): array
    {
        $business = config('schema.local_business');
        $geo = $geoOverride ?? $business['geo'];

        return [
            '@type' => 'LocalBusiness',
            '@id' => $this->localBusinessId(),
            'name' => $business['name'],
            'image' => $this->imageObject(
                $business['image'],
                (int) ($business['image_width'] ?? 0),
                (int) ($business['image_height'] ?? 0),
            ),
            'url' => $this->baseUrl().'/',
            'telephone' => $business['telephone'],
            'priceRange' => $business['price_range'],
            'address' => array_merge(['@type' => 'PostalAddress'], $business['address']),
            'geo' => [
                '@type' => 'GeoCoordinates',
                'latitude' => (string) $geo['latitude'],
                'longitude' => (string) $geo['longitude'],
            ],
            'openingHoursSpecification' => array_map(
                fn (array $hours) => array_merge(['@type' => 'OpeningHoursSpecification'], $hours),
                $business['opening_hours']
            ),
        ];
    }

    /**
     * @param  list<array{name: string, url?: string|null}>  $items
     * @return array<string, mixed>
     */
    public function breadcrumbNode(string $pageUrl, array $items): array
    {
        $elements = [];

        foreach ($items as $index => $item) {
            $position = $index + 1;
            $isLast = $position === count($items);

            $element = [
                '@type' => 'ListItem',
                'position' => $position,
                'name' => $item['name'],
            ];

            if (! $isLast && filled($item['url'] ?? null)) {
                $element['item'] = $item['url'];
            }

            $elements[] = $element;
        }

        return [
            '@type' => 'BreadcrumbList',
            '@id' => rtrim($pageUrl, '/').'/#breadcrumb',
            'itemListElement' => $elements,
        ];
    }

    /**
     * @param  Collection<int, Faq>  $faqs
     * @return array<string, mixed>|null
     */
    public function faqPageNode(string $pageUrl, Collection $faqs): ?array
    {
        if ($faqs->isEmpty()) {
            return null;
        }

        return [
            '@type' => 'FAQPage',
            '@id' => rtrim($pageUrl, '/').'/#faq',
            'mainEntity' => $faqs->map(fn (Faq $faq) => [
                '@type' => 'Question',
                'name' => $faq->question,
                'acceptedAnswer' => [
                    '@type' => 'Answer',
                    'text' => $faq->answer,
                ],
            ])->values()->all(),
        ];
    }

    /**
     * @param  Collection<int, Product>  $items
     * @return array<string, mixed>
     */
    public function buildCatalogSchema(Collection $items, string $pageUrl, string $listName, array $breadcrumb): array
    {
        $nodes = [
            $this->organizationNode(),
            $this->websiteNode(),
            $this->breadcrumbNode($pageUrl, $breadcrumb),
            [
                '@type' => 'ItemList',
                '@id' => rtrim($pageUrl, '/').'/#itemlist',
                'name' => $listName,
                'itemListElement' => $items->values()->map(fn (Product $item, int $index) => [
                    '@type' => 'ListItem',
                    'position' => $index + 1,
                    'url' => $this->itemUrl($item),
                    'name' => $item->name,
                ])->all(),
            ],
        ];

        return $this->wrapGraph($nodes);
    }

    /**
     * @param  Collection<int, Faq>  $faqs
     * @param  Collection<int, Review>|null  $reviews
     * @return array<string, mixed>
     */
    public function buildProductSchema(
        Product $product,
        Collection $faqs,
        ?Collection $reviews = null,
        ?string $relatedServiceUrl = null,
    ): array {
        $pageUrl = $this->productUrl($product);
        $breadcrumb = $this->productBreadcrumb($product);

        $productNode = [
            '@type' => 'Product',
            '@id' => $pageUrl.'/#product',
            'name' => $product->name,
            'description' => $this->description($product),
            'image' => $this->productImages($product),
            'sku' => $product->sku ?? $product->slug,
            'brand' => [
                '@type' => 'Brand',
                'name' => $product->brand ?? 'ศิริพงษ์ เซอร์วิส',
            ],
            'category' => $this->productCategories($product),
            'offers' => $this->productOffer($product, $pageUrl),
        ];

        if (filled($product->mpn)) {
            $productNode['mpn'] = $product->mpn;
        }

        if (filled($product->gtin13)) {
            $productNode['gtin13'] = $product->gtin13;
        }

        $additionalProperties = $this->additionalProperties($product);
        if ($additionalProperties !== []) {
            $productNode['additionalProperty'] = $additionalProperties;
        }

        $weight = $this->weightNode($product);
        if ($weight !== null) {
            $productNode['weight'] = $weight;
        }

        if ($relatedServiceUrl !== null) {
            $productNode['isRelatedTo'] = ['@id' => rtrim($relatedServiceUrl, '/').'/#service'];
        }

        $approvedReviews = $reviews ?? $product->approvedReviews ?? collect();
        if ($approvedReviews->isNotEmpty()) {
            $productNode['aggregateRating'] = $this->aggregateRating($approvedReviews);
            $productNode['review'] = $this->reviewNodes($approvedReviews);
        }

        $nodes = [
            $this->organizationNode(),
            $this->websiteNode(),
            $this->breadcrumbNode($pageUrl, $breadcrumb),
            $productNode,
        ];

        $faqNode = $this->faqPageNode($pageUrl, $faqs);
        if ($faqNode !== null) {
            $nodes[] = $faqNode;
        }

        return $this->wrapGraph($nodes);
    }

    /**
     * @param  Collection<int, Product>  $serviceOffers
     * @param  Collection<int, Faq>  $faqs
     * @return array<string, mixed>
     */
    public function buildServiceSchema(Product $service, Collection $serviceOffers, Collection $faqs, ?array $geoOverride = null): array
    {
        $pageUrl = $this->serviceUrl($service);
        $breadcrumb = $this->serviceBreadcrumb($service);

        $serviceNode = [
            '@type' => 'Service',
            '@id' => $pageUrl.'/#service',
            'name' => $service->name,
            'serviceType' => $service->category?->name ?? 'บริการซ่อมเครื่องดูดฝุ่น',
            'description' => $this->description($service),
            'provider' => ['@id' => $this->localBusinessId()],
            'areaServed' => array_map(
                fn (string $area) => ['@type' => 'AdministrativeArea', 'name' => $area],
                config('schema.local_business.area_served')
            ),
            'availableChannel' => [
                '@type' => 'ServiceChannel',
                'servicePhone' => [
                    '@type' => 'ContactPoint',
                    'telephone' => config('schema.local_business.telephone'),
                ],
                'serviceUrl' => $pageUrl,
            ],
            'hasOfferCatalog' => $this->serviceOfferCatalog($serviceOffers),
        ];

        $nodes = [
            $this->organizationNode(),
            $this->websiteNode(),
            $this->localBusinessNode($geoOverride),
            $this->breadcrumbNode($pageUrl, $breadcrumb),
            $serviceNode,
        ];

        $faqNode = $this->faqPageNode($pageUrl, $faqs);
        if ($faqNode !== null) {
            $nodes[] = $faqNode;
        }

        return $this->wrapGraph($nodes);
    }

    /**
     * @param  Collection<int, Product>  $services
     * @return array<string, mixed>
     */
    public function buildHomeSchema(Collection $services, ?array $geoOverride = null): array
    {
        $pageUrl = $this->baseUrl().'/';
        $business = config('schema.local_business');

        $localBusiness = array_merge($this->localBusinessNode($geoOverride), [
            'areaServed' => array_map(
                fn (string $area) => ['@type' => 'AdministrativeArea', 'name' => $area],
                $business['area_served']
            ),
            'hasOfferCatalog' => $this->serviceOfferCatalog($services),
        ]);

        $nodes = [
            $this->organizationNode(),
            $this->websiteNode(),
            $localBusiness,
            $this->breadcrumbNode($pageUrl, [
                ['name' => 'หน้าแรก', 'url' => $pageUrl],
            ]),
        ];

        return $this->wrapGraph($nodes);
    }

    /**
     * @param  Collection<int, Product>  $services
     * @return array<string, mixed>
     */
    private function serviceOfferCatalog(Collection $services): array
    {
        return [
            '@type' => 'OfferCatalog',
            'name' => 'รายการบริการและค่าบริการ',
            'itemListElement' => $services->map(function (Product $service) {
                $offer = [
                    '@type' => 'Offer',
                    'itemOffered' => [
                        '@type' => 'Service',
                        'name' => $service->name,
                    ],
                ];

                $priceSpec = $this->priceSpecification($service);
                if ($priceSpec !== null) {
                    $offer['priceSpecification'] = $priceSpec;
                }

                return $offer;
            })->values()->all(),
        ];
    }

    /**
     * @return array<string, mixed>|null
     */
    private function priceSpecification(Product $item): ?array
    {
        $price = $this->effectivePrice($item);

        if ($price === null) {
            if ((float) $item->price <= 0) {
                return [
                    '@type' => 'PriceSpecification',
                    'price' => '0',
                    'priceCurrency' => 'THB',
                ];
            }

            return [
                '@type' => 'PriceSpecification',
                'minPrice' => $this->formatPrice((float) $item->price),
                'maxPrice' => $this->formatPrice((float) $item->price),
                'priceCurrency' => 'THB',
            ];
        }

        if ($item->sale_price !== null && (float) $item->sale_price < (float) $item->price) {
            return [
                '@type' => 'PriceSpecification',
                'minPrice' => $this->formatPrice((float) $item->sale_price),
                'maxPrice' => $this->formatPrice((float) $item->price),
                'priceCurrency' => 'THB',
            ];
        }

        return [
            '@type' => 'PriceSpecification',
            'price' => $this->formatPrice($price),
            'priceCurrency' => 'THB',
        ];
    }

    /**
     * @return array<string, mixed>
     */
    private function productOffer(Product $product, string $pageUrl): array
    {
        $offer = [
            '@type' => 'Offer',
            '@id' => $pageUrl.'/#offer',
            'url' => $pageUrl,
            'priceCurrency' => 'THB',
            'availability' => 'https://schema.org/InStock',
            'itemCondition' => 'https://schema.org/NewCondition',
            'seller' => ['@id' => $this->organizationId()],
            'priceValidUntil' => $this->priceValidUntil(),
            'hasMerchantReturnPolicy' => array_merge(
                ['@type' => 'MerchantReturnPolicy'],
                config('schema.return_policy')
            ),
            'shippingDetails' => $this->shippingDetails(),
        ];

        $price = $this->effectivePrice($product);
        if ($price !== null) {
            $offer['price'] = $this->formatPrice($price);

            if ($product->sale_price !== null && (float) $product->sale_price < (float) $product->price) {
                $offer['validFrom'] = $this->bangkokNow()->startOfMonth()->format('Y-m-d\TH:i:sP');
            }
        } else {
            $offer['price'] = '0';
            $offer['availability'] = 'https://schema.org/PreOrder';
        }

        return $offer;
    }

    /**
     * @return array<string, mixed>
     */
    private function shippingDetails(): array
    {
        $shipping = config('schema.shipping');

        return [
            '@type' => 'OfferShippingDetails',
            'shippingRate' => [
                '@type' => 'MonetaryAmount',
                'value' => $shipping['rate'],
                'currency' => $shipping['currency'],
            ],
            'shippingDestination' => [
                '@type' => 'DefinedRegion',
                'addressCountry' => $shipping['destination_country'],
            ],
            'deliveryTime' => [
                '@type' => 'ShippingDeliveryTime',
                'handlingTime' => [
                    '@type' => 'QuantitativeValue',
                    'minValue' => $shipping['handling_min'],
                    'maxValue' => $shipping['handling_max'],
                    'unitCode' => 'DAY',
                ],
                'transitTime' => [
                    '@type' => 'QuantitativeValue',
                    'minValue' => $shipping['transit_min'],
                    'maxValue' => $shipping['transit_max'],
                    'unitCode' => 'DAY',
                ],
            ],
        ];
    }

    /**
     * @return list<string|array<string, mixed>>
     */
    private function productCategories(Product $product): array
    {
        $categories = [
            [
                '@type' => 'CategoryCode',
                'inCodeSet' => 'https://www.google.com/basepages/producttype/taxonomy-with-ids.en-US.txt',
                'codeValue' => config('schema.google_product_category'),
            ],
        ];

        if ($product->category) {
            $categories[] = 'เครื่องดูดฝุ่น > '.$product->category->name;
        }

        return $categories;
    }

    /**
     * @return list<string>
     */
    private function productImages(Product $product): array
    {
        $images = $product->images
            ->map(fn ($image) => MediaUrl::resolve($image->path))
            ->filter()
            ->values()
            ->all();

        if ($images === [] && $product->imageUrl()) {
            $images[] = $product->imageUrl();
        }

        return $images !== [] ? $images : [config('schema.organization.logo')];
    }

    /**
     * @return list<array<string, mixed>>
     */
    private function additionalProperties(Product $product): array
    {
        if (! is_array($product->specs) || $product->specs === []) {
            return [];
        }

        $properties = [];

        foreach ($product->specs as $spec) {
            if (! is_array($spec) || blank($spec['name'] ?? null)) {
                continue;
            }

            $property = [
                '@type' => 'PropertyValue',
                'name' => $spec['name'],
                'value' => (string) ($spec['value'] ?? ''),
            ];

            if (filled($spec['unitText'] ?? null)) {
                $property['unitText'] = $spec['unitText'];
            }

            $properties[] = $property;
        }

        return $properties;
    }

    /**
     * @return array<string, mixed>|null
     */
    private function weightNode(Product $product): ?array
    {
        if (! is_array($product->specs)) {
            return null;
        }

        foreach ($product->specs as $spec) {
            if (($spec['name'] ?? '') !== 'น้ำหนัก' || ! isset($spec['value'])) {
                continue;
            }

            return [
                '@type' => 'QuantitativeValue',
                'value' => (float) $spec['value'],
                'unitCode' => 'KGM',
            ];
        }

        return null;
    }

    /**
     * @param  Collection<int, Review>  $reviews
     * @return array<string, mixed>
     */
    private function aggregateRating(Collection $reviews): array
    {
        return [
            '@type' => 'AggregateRating',
            'ratingValue' => (string) round($reviews->avg('rating'), 1),
            'reviewCount' => (string) $reviews->count(),
            'bestRating' => '5',
        ];
    }

    /**
     * @param  Collection<int, Review>  $reviews
     * @return list<array<string, mixed>>
     */
    private function reviewNodes(Collection $reviews): array
    {
        return $reviews->map(fn (Review $review) => [
            '@type' => 'Review',
            'author' => ['@type' => 'Person', 'name' => $review->reviewer_name],
            'datePublished' => $review->created_at->timezone('Asia/Bangkok')->format('Y-m-d'),
            'reviewRating' => [
                '@type' => 'Rating',
                'ratingValue' => (string) $review->rating,
                'bestRating' => '5',
            ],
            'reviewBody' => $review->comment ?? '',
        ])->values()->all();
    }

    private function description(Product $product): string
    {
        return strip_tags((string) ($product->short_description ?: $product->description ?: $product->name));
    }

    private function effectivePrice(Product $product): ?float
    {
        if ($product->sale_price !== null && (float) $product->sale_price > 0) {
            return (float) $product->sale_price;
        }

        if ((float) $product->price > 0) {
            return (float) $product->price;
        }

        return null;
    }

    private function formatPrice(float $price): string
    {
        return (string) (int) round($price);
    }

    private function priceValidUntil(): string
    {
        $target = $this->bangkokNow()->endOfYear();

        if ($target->lessThanOrEqualTo($this->bangkokNow()->addDays(7))) {
            $target = $this->bangkokNow()->addYear()->endOfYear();
        }

        return $target->format('Y-m-d\TH:i:sP');
    }

    private function bangkokNow(): Carbon
    {
        return Carbon::now('Asia/Bangkok');
    }

    /**
     * @return array<string, mixed>|string
     */
    private function imageObject(string $url, int $width = 0, int $height = 0): array|string
    {
        if ($width <= 0 || $height <= 0) {
            return $url;
        }

        return [
            '@type' => 'ImageObject',
            'url' => $url,
            'width' => $width,
            'height' => $height,
        ];
    }

    public function productUrl(Product $product): string
    {
        return $this->baseUrl().'/products/'.$product->slug;
    }

    public function serviceUrl(Product $service): string
    {
        return $this->baseUrl().'/services/'.$service->slug;
    }

    public function categoryUrl(string $slug): string
    {
        return $this->baseUrl().'/products/category/'.$slug;
    }

    private function itemUrl(Product $item): string
    {
        return $item->type === 'service'
            ? $this->serviceUrl($item)
            : $this->productUrl($item);
    }

    /**
     * @return list<array{name: string, url?: string|null}>
     */
    private function productBreadcrumb(Product $product): array
    {
        $items = [
            ['name' => 'หน้าแรก', 'url' => $this->baseUrl().'/'],
            ['name' => 'สินค้าและบริการ', 'url' => $this->baseUrl().'/products'],
        ];

        if ($product->category) {
            $items[] = [
                'name' => $product->category->name,
                'url' => $this->categoryUrl($product->category->slug),
            ];
        }

        $items[] = ['name' => $product->name, 'url' => null];

        return $items;
    }

    /**
     * @return list<array{name: string, url?: string|null}>
     */
    private function serviceBreadcrumb(Product $service): array
    {
        $items = [
            ['name' => 'หน้าแรก', 'url' => $this->baseUrl().'/'],
            ['name' => 'บริการ', 'url' => $this->baseUrl().'/products#services'],
        ];

        if ($service->category) {
            $items[] = ['name' => $service->category->name, 'url' => null];
        }

        $items[] = ['name' => $service->name, 'url' => null];

        return $items;
    }
}
