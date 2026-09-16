<?php

namespace App\Support\Schema;

use App\Models\Blog;
use App\Models\Faq;
use App\Models\Page;
use App\Models\Portfolio;
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

    public function authorId(): string
    {
        return $this->baseUrl().'/#author-technician';
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
    public function localBusinessNode(): array
    {
        $business = config('schema.local_business');
        $geo = $business['geo'];

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
    public function buildServiceSchema(Product $service, Collection $serviceOffers, Collection $faqs): array
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
            $this->localBusinessNode(),
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
     * @return array<string, mixed>
     */
    public function buildPageSchema(Page $page): array
    {
        $pageUrl = $this->pageUrl($page);
        $faqs = $page->faqItems();

        $serviceNode = [
            '@type' => 'Service',
            '@id' => $pageUrl.'/#service',
            'name' => $page->title,
            'serviceType' => $page->primary_keyword ?: 'บริการซ่อมเครื่องดูดฝุ่น',
            'description' => strip_tags((string) ($page->intro ?: $page->title)),
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
        ];

        $nodes = [
            $this->organizationNode(),
            $this->websiteNode(),
            $this->localBusinessNode(),
            $this->breadcrumbNode($pageUrl, $this->pageBreadcrumb($page)),
            $serviceNode,
        ];

        if ($faqs->isNotEmpty()) {
            $nodes[] = [
                '@type' => 'FAQPage',
                '@id' => rtrim($pageUrl, '/').'/#faq',
                'mainEntity' => $faqs->map(fn ($faq) => [
                    '@type' => 'Question',
                    'name' => $faq->question,
                    'acceptedAnswer' => [
                        '@type' => 'Answer',
                        'text' => $faq->answer,
                    ],
                ])->values()->all(),
            ];
        }

        return $this->wrapGraph($nodes);
    }

    /**
     * @param  Collection<int, Blog>  $blogs
     * @return array<string, mixed>
     */
    public function buildBlogIndexSchema(Collection $blogs): array
    {
        $pageUrl = $this->baseUrl().'/blog';

        $nodes = [
            $this->organizationNode(),
            $this->websiteNode(),
            $this->localBusinessWithArea(),
            $this->breadcrumbNode($pageUrl, [
                ['name' => 'หน้าแรก', 'url' => $this->baseUrl().'/'],
                ['name' => 'บทความ', 'url' => null],
            ]),
            [
                '@type' => 'ItemList',
                '@id' => rtrim($pageUrl, '/').'/#itemlist',
                'name' => 'บทความซ่อมเครื่องดูดฝุ่น',
                'itemListElement' => $blogs->values()->map(fn (Blog $blog, int $index) => [
                    '@type' => 'ListItem',
                    'position' => $index + 1,
                    'url' => $this->blogUrl($blog),
                    'name' => $blog->title,
                ])->all(),
            ],
        ];

        return $this->wrapGraph($nodes);
    }

    /**
     * Article + Person + LocalBusiness + BreadcrumbList + optional FAQPage.
     * No HowTo, no aggregateRating on articles (SEO package rules).
     *
     * @return array<string, mixed>
     */
    public function buildBlogSchema(Blog $blog): array
    {
        $pageUrl = $this->blogUrl($blog);
        $faqs = $blog->faqItems();

        $article = [
            '@type' => 'Article',
            '@id' => rtrim($pageUrl, '/').'/#article',
            'headline' => $blog->title,
            'description' => $blog->seoDescription(),
            'image' => $this->blogImageObject($blog),
            'author' => ['@id' => $this->authorId()],
            'publisher' => ['@id' => $this->organizationId()],
            'inLanguage' => 'th-TH',
            'mainEntityOfPage' => [
                '@type' => 'WebPage',
                '@id' => $pageUrl,
            ],
        ];

        if ($published = $blog->datePublished()) {
            $article['datePublished'] = $published;
        }

        if ($modified = $blog->dateModified()) {
            $article['dateModified'] = $modified;
        }

        $nodes = [
            $this->localBusinessWithArea(),
            $this->personNode($blog),
            $this->organizationNode(),
            $this->websiteNode(),
            $article,
            $this->breadcrumbNode($pageUrl, [
                ['name' => 'หน้าแรก', 'url' => $this->baseUrl().'/'],
                ['name' => 'บทความ', 'url' => $this->baseUrl().'/blog'],
                ['name' => $blog->title, 'url' => null],
            ]),
        ];

        if ($faqs->isNotEmpty()) {
            $nodes[] = [
                '@type' => 'FAQPage',
                '@id' => rtrim($pageUrl, '/').'/#faq',
                'mainEntity' => $faqs->map(fn ($faq) => [
                    '@type' => 'Question',
                    'name' => $faq->question,
                    'acceptedAnswer' => [
                        '@type' => 'Answer',
                        'text' => $faq->answer,
                    ],
                ])->values()->all(),
            ];
        }

        return $this->wrapGraph($nodes);
    }

    /**
     * Short case page: WebPage + LocalBusiness (geo) + BreadcrumbList.
     * Primary keyword differs from related blog to avoid cannibalization.
     *
     * @return array<string, mixed>
     */
    public function buildPortfolioCaseSchema(Portfolio $portfolio): array
    {
        $pageUrl = $this->portfolioCaseUrl($portfolio);

        $webPage = [
            '@type' => 'WebPage',
            '@id' => $pageUrl,
            'name' => $portfolio->title,
            'description' => $portfolio->seoDescription(),
            'isPartOf' => ['@id' => $this->websiteId()],
            'about' => ['@id' => $this->localBusinessId()],
            'inLanguage' => 'th-TH',
        ];

        if ($image = $portfolio->imageUrl()) {
            $webPage['primaryImageOfPage'] = $image;
            $images = array_values(array_unique(array_filter([
                $portfolio->beforeImageUrl(),
                $portfolio->afterImageUrl(),
                MediaUrl::resolve($portfolio->image),
            ])));
            if ($images !== []) {
                $webPage['image'] = count($images) === 1 ? $images[0] : $images;
            }
        }

        if ($portfolio->relatedBlog) {
            $webPage['relatedLink'] = $this->blogUrl($portfolio->relatedBlog);
        }

        $nodes = [
            $this->organizationNode(),
            $this->websiteNode(),
            $this->localBusinessWithArea(),
            $this->breadcrumbNode($pageUrl, [
                ['name' => 'หน้าแรก', 'url' => $this->baseUrl().'/'],
                ['name' => 'ผลงาน', 'url' => $this->baseUrl().'/portfolio'],
                ['name' => $portfolio->title, 'url' => null],
            ]),
            $webPage,
        ];

        return $this->wrapGraph($nodes);
    }

    public function blogUrl(Blog $blog): string
    {
        return rtrim($this->baseUrl(), '/').$blog->urlPath();
    }

    public function portfolioCaseUrl(Portfolio $portfolio): string
    {
        $path = $portfolio->urlPath() ?? '/portfolio';

        return rtrim($this->baseUrl(), '/').$path;
    }

    /**
     * @return array<string, mixed>
     */
    public function personNode(?Blog $blog = null): array
    {
        $name = $blog?->authorName() ?? (string) config('schema.author.name');
        $jobTitle = $blog?->authorJobTitle() ?? (string) config('schema.author.job_title');
        $description = $blog?->authorDescription() ?? (string) config('schema.author.description');
        $aboutPath = (string) config('schema.author.about_path', '/about-us');

        return [
            '@type' => 'Person',
            '@id' => $this->authorId(),
            'name' => $name,
            'jobTitle' => $jobTitle,
            'description' => $description,
            'worksFor' => ['@id' => $this->organizationId()],
            'url' => rtrim($this->baseUrl(), '/').$aboutPath,
        ];
    }

    /**
     * @return array<string, mixed>
     */
    private function localBusinessWithArea(): array
    {
        $business = config('schema.local_business');

        return array_merge($this->localBusinessNode(), [
            'description' => 'รับซ่อมและถอดล้างเครื่องดูดฝุ่นทุกยี่ห้อ มีบริการรับ-ส่งถึงที่ในกรุงเทพฯ',
            'areaServed' => array_map(
                fn (string $area) => ['@type' => 'AdministrativeArea', 'name' => $area],
                $business['area_served'] ?? []
            ),
        ]);
    }

    /**
     * @return array<string, mixed>|string
     */
    private function blogImageObject(Blog $blog): array|string
    {
        $url = $blog->imageUrl() ?: (string) config('schema.organization.logo');
        $width = (int) ($blog->image_width ?: config('schema.organization.logo_width') ?: 0);
        $height = (int) ($blog->image_height ?: config('schema.organization.logo_height') ?: 0);

        return $this->imageObject($url, $width, $height);
    }

    public function pageUrl(Page $page): string
    {
        return rtrim($this->baseUrl(), '/').$page->urlPath();
    }

    /**
     * @return list<array{name: string, url?: string|null}>
     */
    private function pageBreadcrumb(Page $page): array
    {
        $items = [
            ['name' => 'หน้าแรก', 'url' => $this->baseUrl().'/'],
        ];

        if ($page->parent) {
            $items[] = [
                'name' => $page->parent->title,
                'url' => $this->pageUrl($page->parent),
            ];
        }

        $items[] = ['name' => $page->title, 'url' => null];

        return $items;
    }

    /**
     * @param  Collection<int, Product>  $services
     * @return array<string, mixed>
     */
    public function buildHomeSchema(Collection $services): array
    {
        $pageUrl = $this->baseUrl().'/';
        $business = config('schema.local_business');

        $localBusiness = array_merge($this->localBusinessNode(), [
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
