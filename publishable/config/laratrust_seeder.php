<?php

return [
    'role_structure' => [
        'superadministrator' => [
            'users' => 'c,r,u,d',
            'permissions' => 'c,r,u,d',
            'roles' => 'c,r,u,d',
            'posts' => 'c,r,u,d',
            'tags' => 'c,r,u,d',
            'categories' => 'c,r,u,d',
            'databases' => 'c,r,u,d'
        ],
        'administrator' => [
            'users' => 'c,r,u,d',
            'permissions' => 'c,r,u,d',
            'roles' => 'c,r,u,d',
            'posts' => 'c,r,u,d',
            'tags' => 'c,r,u,d',
            'categories' => 'c,r,u,d'
        ],
        'user' => [
            'permissions' => 'r',
            'roles' => 'r',
            'posts' => 'r',
            'tags' => 'r',
            'categories' => 'r',
        ],
    ],
    'permission_structure' => [
        'cru_user' => [
            'databases' => 'c,r,u'
        ],
    ],
    'permissions_map' => [
        'c' => 'create',
        'r' => 'read',
        'u' => 'update',
        'd' => 'delete'
    ]
];
