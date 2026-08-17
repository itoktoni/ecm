<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Menu Configuration
    |--------------------------------------------------------------------------
    |
    | Define menu items for desktop sidebar, mobile drawer, and bottom nav.
    | Each item: route (string), icon (string), label (string)
    | Sections: label (string), items (array)
    | Bottom nav: only 5 items max, uses short label
    |
    */

    'sidebar' => [
        [
            'label' => null,
            'items' => [
                ['route' => 'dashboard', 'icon' => 'dashboard', 'label' => 'Dashboard'],
            ],
        ],
        [
            'label' => 'Management',
            'items' => [
                ['route' => 'user.getTable', 'icon' => 'manage_accounts', 'label' => 'Users'],
            ],
        ],
        [
            'label' => 'CMS',
            'items' => [
                ['route' => 'cms-type.getTable', 'icon' => 'category', 'label' => 'Types'],
                ['route' => 'field.getTable', 'icon' => 'account_tree', 'label' => 'Fields'],
                ['route' => 'section.getTable', 'icon' => 'view_module', 'label' => 'Sections'],
                ['route' => 'content.getTable', 'icon' => 'library_books', 'label' => 'Content'],
                ['route' => 'category.getTable', 'icon' => 'category', 'label' => 'Categories'],
                ['route' => 'tag.getTable', 'icon' => 'label', 'label' => 'Tags'],
                ['route' => 'menu.getTable', 'icon' => 'menu', 'label' => 'Menus'],
            ],
        ],
        [
            'label' => 'Master Data',
            'items' => [
                ['route' => 'wms-customer.getTable', 'icon' => 'groups', 'label' => 'Customer'],
                ['route' => 'wms-jasa.getTable', 'icon' => 'science', 'label' => 'Jasa'],
                ['route' => 'wms-product.getTable', 'icon' => 'inventory_2', 'label' => 'Product'],
            ],
        ],
        [
            'label' => 'Sales',
            'items' => [
                ['route' => 'orders.index', 'icon' => 'shopping_cart_checkout', 'label' => 'Order Masuk'],
                ['route' => 'wms-so.getTable', 'icon' => 'point_of_sale', 'label' => 'Sales Order'],
                ['route' => 'wms-pekerjaan.getTable', 'icon' => 'engineering', 'label' => 'Pekerjaan Saya'],
            ],
        ],
        [
            'label' => 'Settings',
            'items' => [
                ['route' => 'settings.company', 'icon' => 'business', 'label' => 'Perusahaan'],
                ['route' => 'profile.edit', 'icon' => 'person', 'label' => 'My Profile'],
                ['route' => 'settings.env', 'icon' => 'settings', 'label' => 'Environment'],
            ],
        ],
    ],

    'bottom_nav' => [
        ['route' => 'dashboard', 'icon' => 'home', 'label' => 'Home'],
        ['route' => 'profile.edit', 'icon' => 'person', 'label' => 'Profile'],
    ],

];
