<?php

return [
    'site_url' => rtrim(env('APP_URL', 'https://www.siriphong-vacuum.com'), '/'),

    'organization' => [
        'name' => config('data.name'),
        'logo' => config('data.logo'),
        'logo_width' => config('data.logo_width'),
        'logo_height' => config('data.logo_height'),
        'telephone' => config('data.phone'),
        'email' => config('data.email'),
    ],

    'website' => [
        'name' => config('data.name'),
    ],

    'local_business' => [
        'name' => config('data.name'),
        'image' => config('data.logo'),
        'image_width' => config('data.logo_width'),
        'image_height' => config('data.logo_height'),
        'telephone' => config('data.phone'),
        'price_range' => '฿฿',
        'address' => config('data.address_structured'),
        'geo' => [
            'latitude' => '13.754198',
            'longitude' => '100.501705',
        ],
        'opening_hours' => [
            [
                'dayOfWeek' => ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'],
                'opens' => '08:00',
                'closes' => '18:00',
            ],
        ],
        'area_served' => [
            'กรุงเทพมหานคร',
            'นนทบุรี',
            'ปทุมธานี',
            'สมุทรปราการ',
        ],
    ],

    'same_as' => array_values(array_filter([
        config('data.line'),
        config('data.facebook') !== 'n/a' ? config('data.facebook') : null,
    ])),

    'google_product_category' => 'Home & Garden > Household Appliances > Vacuums',

    'return_policy' => [
        'applicableCountry' => 'TH',
        'returnPolicyCategory' => 'https://schema.org/MerchantReturnFiniteReturnWindow',
        'merchantReturnDays' => 7,
        'returnMethod' => 'https://schema.org/ReturnByMail',
        'returnFees' => 'https://schema.org/FreeReturn',
    ],

    'shipping' => [
        'rate' => '0',
        'currency' => 'THB',
        'destination_country' => 'TH',
        'handling_min' => 0,
        'handling_max' => 1,
        'transit_min' => 1,
        'transit_max' => 3,
    ],
];
