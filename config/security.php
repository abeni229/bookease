<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Security Configuration
    |--------------------------------------------------------------------------
    |
    | Configuration des paramètres de sécurité pour BookEase
    |
    */

    'rate_limiting' => [
        'booking' => [
            'index' => 60,    // requêtes par minute
            'slots' => 30,
            'store' => 10,    // réservations par minute
        ],
        'auth' => [
            'login' => 5,     // tentatives de connexion par minute
            'register' => 5,
        ],
    ],

    'validation' => [
        'max_name_length' => 255,
        'max_description_length' => 1000,
        'max_phone_length' => 20,
        'max_price' => 1000000,
        'min_duration' => 5,
        'max_duration' => 480, // 8 heures
        'max_future_booking_days' => 90, // 3 mois
    ],

    'spam_protection' => [
        'honeypot_field' => 'website',
        'timestamp_field' => 'timestamp',
        'min_request_time' => 3, // secondes
        'suspicious_patterns' => [
            '/<script/i',
            '/javascript:/i',
            '/on\w+\s*=/i',
            '/<iframe/i',
            '/<object/i',
            '/<embed/i',
            '/base64,/i',
            '/data:text/i',
        ],
    ],
];
