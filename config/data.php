<?php

$contact = require __DIR__.'/contact.php';

return [
    'name' => 'ศิริพงษ์ ซ่อมเครื่องดูดฝุ่น',
    'phone' => $contact['phone'],
    'phone_formatted' => $contact['phone_formatted'],
    'email' => $contact['email'],
    'address' => $contact['address'],
    'address_structured' => $contact['address_structured'],
    'taxid' => 'n/a',
    'facebook' => 'n/a',
    'line' => $contact['line'],
    'logo' => 'https://pub-a9d72b3edcf74bf293a84deb6ffa217b.r2.dev/logo.webp',
    'logo_width' => 500,
    'logo_height' => 347,
    'favicon' => 'https://pub-a9d72b3edcf74bf293a84deb6ffa217b.r2.dev/fav.ico',
    'hero_image' => 'siriphong.jpg',
    'line_qr' => 'line-qr.jpg',
];
