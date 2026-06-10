@props(['service'])

@php
$schema = [
    "@context" => "https://schema.org",
    "@type" => "Service",
    "name" => $service['title'],
    "description" => $service['meta_desc'],
    "provider" => [
        "@type" => "LocalBusiness",
        "name" => "ศิริพงษ์ เซอร์วิส",
        "telephone" => "081-234-5678",
        "url" => url()->current()
    ],
    "areaServed" => "กรุงเทพมหานครและปริมณฑล",
    "offers" => [
        "@type" => "Offer",
        "availability" => "https://schema.org/InStock"
    ]
];
@endphp

<script type="application/ld+json">
{!! json_encode($schema, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES) !!}
</script>