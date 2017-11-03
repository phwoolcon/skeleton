<?php

return [
    ':vendor/:package_name' => [
        'di' => [
            20 => 'di.php', // 20 stands for the loading sequence, bigger number will be loaded later
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
    ],
];
