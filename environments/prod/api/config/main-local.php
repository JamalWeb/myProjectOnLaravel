<?php
return [
    'components' => [
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => '',
        ],
        'urlManager'      => [
            'baseUrl' => 'http://api.mappa.one',
        ],
        'urlManagerFront' => [
            'baseUrl' => 'http://mappa.one',
        ],
    ],
];
