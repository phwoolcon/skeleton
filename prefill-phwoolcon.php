<?php
include __DIR__ . '/prefill.php';

echo "\n";
echo "----------------------------------------------------------------------\n";
echo "Please, provide the following information:\n";
echo "----------------------------------------------------------------------\n";
$phwoolconFields = [
    'git_repo' => [
        'Git repository',
        'The git repository of the package',
        'git@github.com:{package_vendor}/{package_name}.git',
    ],
    'license' => ['Choose license', '1 - APACHE 2.0, 2 - MIT, 3 - Proprietary', '1'],
    'licensor' => ['Licensor', 'The owner of this package', '{package_vendor}'],
];
$phwoolconReplacements = [
    ':vendor' => function () use (&$values) {
        return $values['package_vendor'];
    },
    ':package_name' => function () use (&$values) {
        return $values['package_name'];
    },
    'phwoolcon/skeleton' => function () use (&$values) {
        return "{$values['package_vendor']}/{$values['package_name']}";
    },
    ':licensor' => function () use (&$values) {
        return $values['licensor'];
    },
    ':license' => function () use (&$values) {
        $licenses = [
            1 => 'Apache-2.0',
            2 => 'MIT',
            3 => 'Proprietary',
        ];
        return isset($licenses[$values['license']]) ? $licenses[$values['license']] : $licenses[1];
    },
    '{yyyy}' => function () {
        return date('Y');
    },
    ':git_repo' => function () use (&$values) {
        return $values['git_repo'];
    },
    'The MIT License (MIT). Please see [License File](LICENSE.md)' => function () use (&$values) {
        $licenses = [
            1 => 'The Apache License, Version 2.0. Please see [License File](LICENSE.md)',
            2 => 'The MIT License (MIT). Please see [License File](LICENSE.md)',
            3 => 'Proprietary License. Please see [License File](LICENSE.md)',
        ];
        return isset($licenses[$values['license']]) ? $licenses[$values['license']] : $licenses[1];
    },
    'license-MIT-brightgreen.svg' => function () use (&$values) {
        $licenses = [
            1 => 'license-Apache%202.0-brightgreen.svg',
            2 => 'license-MIT-brightgreen.svg',
            3 => 'license-Proprietary-brightgreen.svg',
        ];
        return isset($licenses[$values['license']]) ? $licenses[$values['license']] : $licenses[1];
    },
];

foreach ($phwoolconFields as $f => $field) {
    if ($f == 'licensor' && $values['license'] != 3) {
        $values['licensor'] = '';
        continue;
    }
    $default = isset($field[COL_DEFAULT]) ? interpolate($field[COL_DEFAULT], $values) : '';
    $prompt = sprintf('%s%s%s: ', $field[COL_DESCRIPTION], $field[COL_HELP] ? ' (' . $field[COL_HELP] . ')' : '',
        $field[COL_DEFAULT] !== '' ? ' [' . $default . ']' : '');
    $values[$f] = read_from_console($prompt);
    if (empty($values[$f])) {
        $values[$f] = $default;
    }
}
echo "\n";

$localComposerFile = __DIR__ . '/composer.local.json';
$files[] = $localComposerFile;

foreach ($files as $f) {
    $contents = file_get_contents($f);
    foreach ($phwoolconReplacements as $str => $func) {
        $contents = str_replace($str, $func(), $contents);
    }
    file_put_contents($f, $contents);
}

// Apply license
if ($values['license'] == 3) {
    unlink(__DIR__ . '/LICENSE.md');
    unlink(__DIR__ . '/LICENSE.APACHE2.md');
    rename(__DIR__ . '/LICENSE.PROPRIETARY.md', __DIR__ . '/LICENSE.md');
} elseif ($values['license'] == 2) {
    unlink(__DIR__ . '/LICENSE.APACHE2.md');
    unlink(__DIR__ . '/LICENSE.PROPRIETARY.md');
} else {
    unlink(__DIR__ . '/LICENSE.md');
    unlink(__DIR__ . '/LICENSE.PROPRIETARY.md');
    rename(__DIR__ . '/LICENSE.APACHE2.md', __DIR__ . '/LICENSE.md');
}

echo "Done.\n";
echo "Now you should remove the file '" . basename(__FILE__) . "'.\n";
