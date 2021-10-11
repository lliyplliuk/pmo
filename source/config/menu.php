<?php
return [
    ['item' => 'Админка',
        'subitems' => [
            ['name' => 'Управление пользователями',
                'url' => '/user/admin',
                'role' => 'admin',
                'divider' => true
            ],
            ['name' => 'Справочники',
                'subitems' => [
                    ['name' => 'Производственные единицы',
                        'url' => '/directory?dir=Pes',
                        'role' => ['admin']
                    ],
                    ['name' => 'Системы',
                        'url' => '/directory?dir=Systems',
                        'role' => ['admin']
                    ],
                    ['name' => 'Ресурсы',
                        'url' => '/directory?dir=projects\PmoResource',
                        'role' => ['admin']
                    ],
                    ['name' => 'Роли ресурсов',
                        'url' => '/directory?dir=projects\PmoResourcesRole',
                        'role' => ['admin']
                    ],
                    ['name' => 'Дирекции',
                        'url' => '/directory?dir=projects\PmoDirections',
                        'role' => ['admin']
                    ],
                ],
            ],
        ]
    ],
    ['item' => 'Управление проектами',
        'subitems' => [
            ['name' => 'Все проекты',
                'url' => '/pmo',
                'role' => ['pmo'],
                'divider' => true
            ],
        ],
    ]
];
