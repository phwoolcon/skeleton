<?php
include __DIR__ . '/prefill.php';

echo "----------------------------------------------------------------------\n";
echo "Please, provide the following information:\n";
echo "----------------------------------------------------------------------\n";
$phwoolconFields = [
    'git_repo' => [
        'Git repository',
        'The git repository of the package',
        'git@github.com:{package_vendor}/{package_name}.git',
    ],
    'license' => ['Choose license', '1 - APACHE 2.0, 2 - MIT', '1'],
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
    ':license' => function () use (&$values) {
        return $values['license'] == 2 ? 'MIT' : 'Apache-2.0';
    },
    '{yyyy}' => function () {
        return date('Y');
    },
    ':git_repo' => function () use (&$values) {
        return $values['git_repo'];
    },
    'The MIT License (MIT). Please see [License File](LICENSE.md)' => function () use (&$values) {
        return $values['license'] == 2 ? 'The MIT License (MIT). Please see [License File](LICENSE.md)' :
            'The Apache License, Version 2.0. Please see [License File](LICENSE.md)';
    },
    'license-MIT-brightgreen.svg' => function () use (&$values) {
        return $values['license'] == 2 ? 'license-MIT-brightgreen.svg' : 'license-Apache%202.0-brightgreen.svg';
    },
];

foreach ($phwoolconFields as $f => $field) {
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
if ($values['license'] == 2) {
    unlink(__DIR__ . '/LICENSE.APACHE2.md');
} else {
    unlink(__DIR__ . '/LICENSE.md');
    rename(__DIR__ . '/LICENSE.APACHE2.md', __DIR__ . '/LICENSE.md');
}

echo "Done.\n";
echo "Now you should remove the file '" . basename(__FILE__) . "'.\n";
