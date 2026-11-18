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

    public function canonicalBaseUrl(): string
    {
        return (string) preg_replace('#^(https?://)www\.#i', '$1', $this->baseUrl());
    }

    public function businessId(): string
    {
        return rtrim((string) config('contact.url'), '/').'/#business';
    }

    public function organizationId(): string
    {
        return $this->businessId();
    }

    public function websiteId(): string
    {
        return $this->canonicalBaseUrl().'/#website';
    }

    public function localBusinessId(): string
    {
        return $this->businessId();
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
        $deduped = [];
        $indexById = [];

        foreach (array_values($nodes) as $node) {
            if (! is_array($node)) {
                continue;
            }

            $id = $node['@id'] ?? null;
            if (! is_string($id) || $id === '') {
                $deduped[] = $node;

                continue;
            }

            if (! isset($indexById[$id])) {
                $indexById[$id] = count($deduped);
                $deduped[] = $node;

                continue;
            }

            $existingType = $deduped[$indexById[$id]]['@type'] ?? '';
            $newType = $node['@type'] ?? '';
            if ($newType === 'LocalBusiness' && $existingType !== 'LocalBusiness') {
                $deduped[$indexById[$id]] = $node;
            }
        }

        return [
            '@context' => 'https://schema.org',
            '@graph' => array_values($deduped),
        ];
    }

    /**
     * @return array<string, mixed>
     */
    public function organizationNode(): array
    {
        $org = config('schema.organization');
        $address = config('schema.local_business.address', []);
        $businessImage = $this->businessImageUrl();

        $node = [
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

        if (is_array($address) && $address !== []) {
            $node['address'] = array_merge(['@type' => 'PostalAddress'], $address);
        }

        if (filled($businessImage)) {
            $node['image'] = $businessImage;
        }

        return $node;
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
        $imageUrl = $this->businessImageUrl();

        $node = [
            '@type' => 'LocalBusiness',
            '@id' => $this->localBusinessId(),
            'name' => $business['name'],
            'url' => $this->baseUrl().'/',
            'telephone' => $business['telephone'],
            'priceRange' => $business['price_range'],
            'address' => array_merge(['@type' => 'PostalAddress'], $business['address'] ?? []),
            'openingHoursSpecification' => array_map(
                fn (array $hours) => array_merge(['@type' => 'OpeningHoursSpecification'], $hours),
                $business['opening_hours'] ?? []
            ),
            'areaServed' => array_map(
                fn (string $area) => ['@type' => 'AdministrativeArea', 'name' => $area],
                $business['area_served'] ?? []
            ),
        ];

        if ($this->organizationId() !== $this->localBusinessId()) {
            $node['parentOrganization'] = ['@id' => $this->organizationId()];
        }

        if (filled($imageUrl)) {
            $node['image'] = $this->imageObject(
                $imageUrl,
                (int) ($business['image_width'] ?? 0),
                (int) ($business['image_height'] ?? 0),
            );
        }

        $geo = $this->geoCoordinates($business['geo'] ?? null);
        if ($geo !== null) {
            $node['geo'] = $geo;
        }

        return $node;
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
     * @param  Collection<int, Faq|object|array{question: string, answer: string}>  $faqs
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
            'mainEntity' => $faqs->map(function ($faq) {
                $question = is_array($faq) ? (string) ($faq['question'] ?? '') : (string) $faq->question;
                $answer = is_array($faq) ? (string) ($faq['answer'] ?? '') : (string) $faq->answer;

                return [
                    '@type' => 'Question',
                    'name' => $question,
                    'acceptedAnswer' => [
                        '@type' => 'Answer',
                        'text' => $answer,
                    ],
                ];
            })->values()->all(),
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
     * Schema for the products/services hub (industrial vacuum sales pillar).
     *
     * Product nodes are built only for catalog items that have a sellable price
     * (same collection that renders the "สินค้าที่จำหน่าย" cards). Category-style
     * fake Products must not appear in hasOfferCatalog.
     *
     * @param  Collection<int, Product>  $products  Active product-type items shown on the hub
     * @param  Collection<int, Product>  $services  Active service-type items for OfferCatalog
     * @param  Collection<int, array{question: string, answer: string}>  $faqs
     * @param  list<array{name: string, url?: string|null}>  $breadcrumb
     * @return array<string, mixed>
     */
    public function buildProductsHubSchema(
        Collection $products,
        Collection $services,
        string $pageUrl,
        string $listName,
        array $breadcrumb,
        Collection $faqs,
        string $serviceName,
        string $serviceDescription,
        string $dateModified,
    ): array {
        $business = config('schema.local_business');

        $pricedProducts = $products
            ->filter(fn (Product $product) => $this->effectivePrice($product) !== null)
            ->values();

        $nodes = [
            $this->organizationNode(),
            $this->websiteNode(),
            $this->localBusinessNode(),
            $this->breadcrumbNode($pageUrl, $breadcrumb),
            [
                '@type' => 'WebPage',
                '@id' => rtrim($pageUrl, '/'),
                'name' => $listName,
                'url' => $pageUrl,
                'dateModified' => $dateModified,
                'author' => ['@id' => $this->organizationId()],
                'publisher' => ['@id' => $this->organizationId()],
                'isPartOf' => ['@id' => $this->websiteId()],
            ],
            [
                '@type' => 'Service',
                '@id' => rtrim($pageUrl, '/').'/#service',
                'serviceType' => 'จำหน่ายและซ่อมเครื่องดูดฝุ่นโรงงานอุตสาหกรรม',
                'name' => $serviceName,
                'description' => $serviceDescription,
                'provider' => ['@id' => $this->localBusinessId()],
                'areaServed' => array_map(
                    fn (string $area) => ['@type' => 'AdministrativeArea', 'name' => $area],
                    $business['area_served'] ?? []
                ),
                'hasOfferCatalog' => [
                    '@type' => 'OfferCatalog',
                    'name' => 'บริการซ่อมเครื่องดูดฝุ่นอุตสาหกรรม',
                    'itemListElement' => $services->values()->map(fn (Product $service) => [
                        '@type' => 'Offer',
                        'itemOffered' => [
                            '@type' => 'Service',
                            'name' => $service->name,
                            'url' => $this->serviceUrl($service),
                        ],
                    ])->all(),
                ],
            ],
            [
                '@type' => 'ItemList',
                '@id' => rtrim($pageUrl, '/').'/#itemlist',
                'name' => $listName,
                'itemListElement' => $pricedProducts->map(fn (Product $product, int $index) => [
                    '@type' => 'ListItem',
                    'position' => $index + 1,
                    'url' => $this->productUrl($product),
                    'name' => $product->name,
                ])->all(),
            ],
        ];

        foreach ($pricedProducts as $product) {
            $nodes[] = $this->hubProductNode($product);
        }

        $faqNode = $this->faqPageNode($pageUrl, $faqs);
        if ($faqNode !== null) {
            $nodes[] = $faqNode;
        }

        return $this->wrapGraph($nodes);
    }

    /**
     * Compact Product node for the products hub (offers required; no fake ratings).
     *
     * @return array<string, mixed>
     */
    private function hubProductNode(Product $product): array
    {
        $pageUrl = $this->productUrl($product);
        $price = $this->effectivePrice($product);

        $mainImage = $product->imageUrl();

        return [
            '@type' => 'Product',
            '@id' => $pageUrl.'#product',
            'name' => $product->name,
            'description' => $this->description($product),
            'image' => $mainImage ?: $this->productImages($product),
            'url' => $pageUrl,
            'sku' => $product->sku ?: $product->slug,
            'brand' => [
                '@type' => 'Brand',
                'name' => $product->brand ?: (string) config('schema.organization.name'),
            ],
            'offers' => [
                '@type' => 'Offer',
                'url' => $pageUrl,
                'price' => $this->formatPrice($price ?? 0),
                'priceCurrency' => 'THB',
                'availability' => 'https://schema.org/InStock',
                'itemCondition' => 'https://schema.org/NewCondition',
                'seller' => ['@id' => $this->localBusinessId()],
            ],
        ];
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
     * @param  Collection<int, Product>  $products
     * @return array<string, mixed>
     */
    public function buildThreeMotorPageSchema(Page $page, Collection $products): array
    {
        $origin = rtrim((string) config('contact.url'), '/');
        $pageUrl = $origin.'/industrial-vacuum-3-motor';
        $schema = is_array($page->block('schema')) ? $page->block('schema') : [];
        $faqs = $page->faqItems();
        $imageUrl = $page->heroImageUrl();

        $article = [
            '@type' => 'Article',
            '@id' => $pageUrl.'#article',
            'headline' => $schema['headline'] ?? $page->title,
            'description' => $schema['description'] ?? strip_tags((string) $page->intro),
            'author' => ['@id' => $origin.'/#siriphong'],
            'publisher' => ['@id' => $origin.'/#business'],
            'datePublished' => $schema['date_published'] ?? '2026-11-18',
            'dateModified' => $schema['date_modified'] ?? '2026-11-18',
            'mainEntityOfPage' => $pageUrl,
            'inLanguage' => 'th-TH',
            'about' => [
                'เครื่องดูดฝุ่น 3 มอเตอร์',
                'เครื่องดูดฝุ่นอุตสาหกรรม',
            ],
        ];

        if (filled($imageUrl)) {
            $article['image'] = $imageUrl;
        }

        $areaServed = collect(config('contact.area_served_schema', []))
            ->map(fn (array $area) => [
                '@type' => $area['type'] ?? 'AdministrativeArea',
                'name' => $area['name'] ?? '',
            ])
            ->filter(fn (array $area) => filled($area['name']))
            ->values()
            ->all();

        $serviceNode = [
            '@type' => 'Service',
            '@id' => $pageUrl.'#service',
            'name' => $schema['service_name'] ?? 'ซ่อมเครื่องดูดฝุ่น 3 มอเตอร์',
            'serviceType' => $schema['service_type'] ?? 'ซ่อมเครื่องดูดฝุ่นอุตสาหกรรม 3 มอเตอร์',
            'provider' => ['@id' => $origin.'/#business'],
            'areaServed' => $areaServed,
            'offers' => [
                '@type' => 'Offer',
                'priceCurrency' => 'THB',
                'price' => (string) ($schema['service_price'] ?? '1650'),
                'description' => $schema['service_price_description'] ?? 'ซ่อมหรือเปลี่ยนมอเตอร์ ราคาเริ่มต้นต่อตัว',
            ],
        ];

        $productList = [
            '@type' => 'ItemList',
            '@id' => $pageUrl.'#products',
            'name' => 'เครื่องดูดฝุ่น 3 มอเตอร์ที่ศิริพงษ์ เซอร์วิสจำหน่าย',
            'itemListElement' => $products->values()->map(fn (Product $product, int $index) => [
                '@type' => 'ListItem',
                'position' => $index + 1,
                'name' => $product->name,
                'url' => $origin.'/products/'.$product->slug,
            ])->all(),
        ];

        $breadcrumb = [
            '@type' => 'BreadcrumbList',
            'itemListElement' => [
                [
                    '@type' => 'ListItem',
                    'position' => 1,
                    'name' => 'หน้าแรก',
                    'item' => $origin.'/',
                ],
                [
                    '@type' => 'ListItem',
                    'position' => 2,
                    'name' => 'เครื่องดูดฝุ่น 3 มอเตอร์',
                    'item' => $pageUrl,
                ],
            ],
        ];

        $nodes = [
            $article,
            $serviceNode,
            $productList,
            $breadcrumb,
        ];

        if ($faqs->isNotEmpty()) {
            $nodes[] = [
                '@type' => 'FAQPage',
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
        unset($services);

        $origin = rtrim((string) config('contact.url'), '/');
        $pageUrl = $origin.'/';
        $contact = config('contact');
        $meta = config('home.meta');
        $faqs = config('home.faqs', []);

        $areaServed = array_map(
            fn (array $area) => ['@type' => $area['type'], 'name' => $area['name']],
            $contact['area_served_schema'] ?? []
        );

        $nodes = [
            [
                '@type' => 'LocalBusiness',
                '@id' => $origin.'/#business',
                'name' => $contact['name'],
                'alternateName' => ['Siriphong Service', 'ร้านช่างต้อย ซ่อมเครื่องดูดฝุ่นอุตสาหกรรม'],
                'description' => 'ซ่อม ขาย และให้เช่าเครื่องดูดฝุ่นอุตสาหกรรม เครื่องดูดฝุ่นโรงงาน เครื่องดูดฝุ่น 3 มอเตอร์ เครื่องดูดน้ำเชิงพาณิชย์ และเครื่องคาร์แคร์ทุกยี่ห้อ ไฟบ้าน 1 เฟส ตั้งแต่ 30 ลิตรขึ้นไป แจ้งราคาก่อนซ่อม รับประกันงานซ่อม 90 วัน',
                'url' => $pageUrl,
                'telephone' => $contact['phone_schema'],
                'image' => $meta['og_image'],
                'logo' => $contact['logo_url'],
                'founder' => ['@id' => $origin.'/#siriphong'],
                'foundingDate' => '2002',
                'address' => array_merge(['@type' => 'PostalAddress'], $contact['address_structured'] ?? []),
                'openingHoursSpecification' => [[
                    '@type' => 'OpeningHoursSpecification',
                    'dayOfWeek' => ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'],
                    'opens' => $contact['opens'],
                    'closes' => $contact['closes'],
                ]],
                'areaServed' => $areaServed,
                'priceRange' => '฿300 - ฿8,000',
                'knowsLanguage' => ['th', 'en'],
                'sameAs' => array_values(array_filter([
                    $contact['google_share'] ?? null,
                    $contact['line'] ?? null,
                ])),
                'hasOfferCatalog' => [
                    '@type' => 'OfferCatalog',
                    'name' => 'ซ่อม ขาย เช่า เครื่องดูดฝุ่นอุตสาหกรรม',
                    'itemListElement' => [
                        ['@type' => 'Offer', 'itemOffered' => ['@type' => 'Service', 'name' => 'ซ่อมเครื่องดูดฝุ่นอุตสาหกรรม', 'url' => $origin.'/vacuum-repair']],
                        ['@type' => 'Offer', 'itemOffered' => ['@type' => 'Service', 'name' => 'ซ่อมมอเตอร์เครื่องดูดฝุ่น', 'url' => $origin.'/services/motor-repair'], 'priceSpecification' => ['@type' => 'PriceSpecification', 'minPrice' => 1650, 'priceCurrency' => 'THB']],
                        ['@type' => 'Offer', 'itemOffered' => ['@type' => 'Service', 'name' => 'เปลี่ยนแปรงถ่านเครื่องดูดฝุ่น', 'url' => $origin.'/services/carbon-brush'], 'priceSpecification' => ['@type' => 'PriceSpecification', 'minPrice' => 250, 'priceCurrency' => 'THB']],
                        ['@type' => 'Offer', 'itemOffered' => ['@type' => 'Service', 'name' => 'ตรวจเช็คเครื่องดูดฝุ่น', 'url' => $origin.'/services/diagnosis'], 'priceSpecification' => ['@type' => 'PriceSpecification', 'price' => 250, 'priceCurrency' => 'THB']],
                        ['@type' => 'Offer', 'itemOffered' => ['@type' => 'Service', 'name' => 'เช่าเครื่องดูดฝุ่นสำรองระหว่างซ่อม'], 'priceSpecification' => ['@type' => 'UnitPriceSpecification', 'price' => 500, 'priceCurrency' => 'THB', 'unitText' => 'เดือน']],
                        ['@type' => 'Offer', 'itemOffered' => ['@type' => 'Product', 'name' => 'เครื่องดูดฝุ่นอุตสาหกรรม', 'url' => $origin.'/products/category/industrial-vacuum']],
                    ],
                ],
            ],
            [
                '@type' => 'Person',
                '@id' => $origin.'/#siriphong',
                'name' => $contact['owner_name'],
                'alternateName' => ['ช่างต้อย', 'เฮียต้อย'],
                'jobTitle' => 'เจ้าของและช่างซ่อมเครื่องดูดฝุ่นอุตสาหกรรม',
                'description' => 'ช่างซ่อมเครื่องดูดฝุ่นอุตสาหกรรมและเครื่องคาร์แคร์ ตั้งแต่ปี พ.ศ. 2545',
                'url' => $origin.'/about-us',
                'worksFor' => ['@id' => $origin.'/#business'],
                'knowsAbout' => ['เครื่องดูดฝุ่นอุตสาหกรรม', 'ซ่อมเครื่องดูดฝุ่นอุตสาหกรรม', 'มอเตอร์เครื่องดูดฝุ่น', 'เครื่องดูดฝุ่น 3 มอเตอร์', 'เครื่องดูดฝุ่นคาร์แคร์', 'เครื่องดูดน้ำเชิงพาณิชย์'],
            ],
            [
                '@type' => 'WebSite',
                '@id' => $origin.'/#website',
                'url' => $pageUrl,
                'name' => $contact['name'],
                'publisher' => ['@id' => $origin.'/#business'],
                'inLanguage' => 'th-TH',
            ],
            [
                '@type' => 'WebPage',
                '@id' => $origin.'/#webpage',
                'url' => $pageUrl,
                'name' => $meta['title'],
                'isPartOf' => ['@id' => $origin.'/#website'],
                'about' => ['@id' => $origin.'/#business'],
                'dateModified' => $meta['date_modified'],
                'inLanguage' => 'th-TH',
            ],
            [
                '@type' => 'BreadcrumbList',
                'itemListElement' => [
                    ['@type' => 'ListItem', 'position' => 1, 'name' => 'หน้าแรก', 'item' => $pageUrl],
                ],
            ],
            [
                '@type' => 'FAQPage',
                'mainEntity' => array_map(fn (array $faq) => [
                    '@type' => 'Question',
                    'name' => $faq['question'],
                    'acceptedAnswer' => [
                        '@type' => 'Answer',
                        'text' => $faq['answer'],
                    ],
                ], $faqs),
            ],
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
            'seller' => ['@id' => $this->localBusinessId()],
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
        return number_format($price, 2, '.', '');
    }

    private function businessImageUrl(): ?string
    {
        $path = config('schema.local_business.image') ?: config('data.hero_image') ?: config('data.logo');

        return MediaUrl::resolve(is_string($path) ? $path : null);
    }

    /**
     * @param  array{latitude?: mixed, longitude?: mixed}|null  $geo
     * @return array<string, mixed>|null
     */
    private function geoCoordinates(?array $geo): ?array
    {
        if ($geo === null) {
            return null;
        }

        $latitude = $geo['latitude'] ?? null;
        $longitude = $geo['longitude'] ?? null;

        if (! filled($latitude) || ! filled($longitude)) {
            return null;
        }

        return [
            '@type' => 'GeoCoordinates',
            'latitude' => (string) $latitude,
            'longitude' => (string) $longitude,
        ];
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
