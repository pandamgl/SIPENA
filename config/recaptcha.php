
<?php

return [
    'site_key' => env('RECAPTCHA_SITE_KEY'),
    'secret_key' => env('RECAPTCHA_SECRET_KEY'),

    'allowed_hostnames' => array_filter(array_map(
        'trim',
        explode(',', (string) env('RECAPTCHA_ALLOWED_HOSTNAMES', ''))
    )),
];
