<?php

return [
    ':vendor/:package_name' => [
        'di'     => [
            20 => 'di.php', // 20 stands for the loading sequence, bigger number will be loaded later
        ],
        'routes' => [
            20 => 'routes.php', // 20 stands for the loading sequence, bigger number will be loaded later
        ],

        'commands' => [
            // 20 stands for the loading sequence, bigger number will be loaded later
            20 => [
//                'your:command' => Phwoolcon\Skeleton\Command\YourCommand::class,
            ],
        ],

        'class_aliases' => [
            // 20 stands for the loading sequence, bigger number will be loaded later
            20 => [
//                'ShortClass' => Phwoolcon\Skeleton\Some\LongClassName::class,
            ],
        ],

        'assets' => [
//            'hello-css' => [
//                'foo/style.css',
//                'foo/bar.css',
//            ],
//            'hello-js' => [
//                'foo/bar.js',
//                'foo/baz.js',
//            ],
        ],
    ],
];
