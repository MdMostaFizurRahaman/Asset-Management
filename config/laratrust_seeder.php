<?php

return [
    'role_structure' => [
        'Admin' => [
//            'admins' => 'c,r,u,d',
//            'profile' => 'r,u',
//            'admin-permission' => 'c,r,u,d',
//            'vendor-permission' => 'c,r,u,d',
//            'company-permission' => 'c,r,u,d',
//            'company' => 'c,r,u,d',
        ],
        'Custom' => [
            'admin' => 'c,r,u,d',
            'profile' => 'r,u',
            'admin-permission' => 'c,r,u,d',
            'vendor-permission' => 'c,r,u,d',
            'company-permission' => 'c,r,u,d',
            'company' => 'c,r,u,d',
        ],
    ],
    'permissions_map' => [
        'c' => 'create',
        'r' => 'read',
        'u' => 'update',
        'd' => 'delete'
    ]
];
