<?php

/*
 * Group Title empty to show separate section but as root menu
 * Items key = route name
 * Permission = permission to access. empty for public
 * Icon: from https://feathericons.com/
 */

return [
    'menu' => [
        'dashboard' => [
            'group_title' => '',
            'items' => [
                'dashboard' => [
                    'title' => 'Dashboard',
                    'icon_class' => 'fe fe-home'
                ]
            ]
        ],
        'administrator' => [
            'group_title' => 'Administrator',
            'items' => [
                'users' => [
                    'permission' => 'read users',
                    'title' => 'Users',
                    'icon_class' => 'fe fe-users'
                ],
                'roles' => [
                    'permission' => 'read roles',
                    'title' => 'Roles',
                    'icon_class' => 'fe fe-user-check',
                ],
                'permissions' => [
                    'permission' => 'read permissions',
                    'title' => 'Permissions',
                    'icon_class' => 'fe fe-key',
                ],
            ]
        ],
        'settings' => [
            'group_title' => 'Settings',
            'items' => [
                'settings.settings' => [
//                    'permission' => 'manage settings',
                    'title' => 'Settings',
                    'icon_class' => 'fe fe-settings'
                ],
                'settings.language' => [
//                    'permission' => 'manage settings',
                    'title' => 'Language',
                    'icon_class' => 'fe fe-file-text'
                ],      
                'settings.category' => [
//                    'permission' => 'manage settings',
                    'title' => 'Category',
                    'icon_class' => 'fe fe-file-text'
                ], 
                'settings.company' => [
//                    'permission' => 'manage settings',
                    'title' => 'Company',
                    'icon_class' => 'fe fe-file-text'
                ], 
                'settings.unit' => [
//                    'permission' => 'manage settings',
                    'title' => 'Unit',
                    'icon_class' => 'fe fe-file-text'
                ],   
                'settings.brand' => [
//                    'permission' => 'manage settings',
                    'title' => 'Brand',
                    'icon_class' => 'fe fe-file-text'
                ],  
                'settings.catalog' => [
//                    'permission' => 'manage settings',
                    'title' => 'Catalog',
                    'icon_class' => 'fe fe-file-text'
                ],                  
                'settings.neighbourhood' => [
//                    'permission' => 'manage settings',
                    'title' => 'Neighbourhood',
                    'icon_class' => 'fe fe-file-text'
                ],                
                'settings.subscription' => [
//                    'permission' => 'manage settings',
                    'title' => 'Subscription',
                    'icon_class' => 'fe fe-file-text'
                ],  
                'settings.banner-ad' => [
//                    'permission' => 'manage settings',
                    'title' => 'Banner-Ad',
                    'icon_class' => 'fe fe-file-text'
                ],    
                'settings.made-in' => [
                    // 'permission' => 'manage settings',
                    'title' => 'Made-In',
                    'icon_class' => 'fe fe-file-text'
                ],                
                'settings.page-content' => [
                    // 'permission' => 'manage settings',
                    'title' => 'Page-Content',
                    'icon_class' => 'fe fe-file-text'
                ],
            ]
        ],
    ],
];
