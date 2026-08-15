<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Permission Restrictions
    |--------------------------------------------------------------------------
    |
    | Define role-based access restrictions.
    |
    *   'route-prefix' => false                    // deny ALL access, hide menu
    |   'route-prefix' => ['action' => false]      // deny specific action, hide button
    |
    | Forced access will throw a 403 error.
    |
    */

    'admin' => [
        'cms-type' => false,
        'field' => false,
        'section' => false,
        'content' => false,
        'category' => false,
        'tag' => false,
        'menu' => false,
        'user' => false,

        'wms-product' => [
            'create' => false,
        ],
        'wms-pekerjaan' => false,
        'settings.company' => false,
        'settings.env' => false,
    ],
    'teknisi' => [
        'cms-type' => false,
        'field' => false,
        'section' => false,
        'content' => false,
        'category' => false,
        'tag' => false,
        'menu' => false,
        'user' => false,

        'wms-product' => [
            'create' => false,
        ],
        'wms-so' => false,
        'wms-customer' => false,
        'wms-jasa' => false,
        'settings.company' => false,
        'settings.env' => false,
    ],
    'supervisor' => [
        'cms-type' => false,
        'field' => false,
        'section' => false,
        'content' => false,
        'category' => false,
        'tag' => false,
        'menu' => false,
        'user' => false,

        'wms-product' => [
            'create' => false,
        ],
        'wms-customer' => false,
        'wms-jasa' => false,
        'settings.company' => false,
        'settings.env' => false,
    ],
    'administrator' => [
        'settings.company' => false,
        'settings.env' => false,
    ],
];
