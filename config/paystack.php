<?php


return [
    'base_url' => env('PAYSTACK_API'),
    'secret_key' => env('PAYSTACK_SECRET_KEY'),
    'endpoints' => [
        'list_banks' => '/bank',
        'resolve_bank' => '/bank/resolve'
    ]
];