<?php

return [
    'services'=> [
        'twitter' => [
            'consumer_key'    => env('TWITTER_CONSUMER_KEY'),
            'consumer_secret' => env('TWITTER_CONSUMER_SECRET'),
            'access_token'    => env('TWITTER_ACCESS_TOKEN'),
            'access_secret'   => env('TWITTER_ACCESS_SECRET')
        ],
        'facebook_poster' => [
            'app_id'       => getenv('FACEBOOK_APP_ID'),
            'app_secret'   => getenv('FACEBOOK_APP_SECRET'),
            'access_token' => getenv('FACEBOOK_ACCESS_TOKEN'),
        ]
    ]
];
