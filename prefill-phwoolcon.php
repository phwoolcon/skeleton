<?php
$composerFile = __DIR__ . '/composer.json';
$colonRestoredContent = str_replace([
    'packagist-colon-',
    '@pass-packagist-check.com',
    'https://pass-packagist-check.com/',
    '"license": "MIT"',
], [':', '', '', '"license": ":license"'], file_get_contents($composerFile));
file_put_contents($composerFile, $colonRestoredContent);

include __DIR__ . '/prefill.php';
/* @var array $values */
$namePattern = '|^[\w\-\.]+$|';
if (!preg_match($namePattern, $values['package_vendor'])) {
    echo "Error: Invalid vendor name {$values['package_vendor']}\n";
    exit(1);
}
if (!preg_match($namePattern, $values['package_name'])) {
    echo "Error: Invalid package name {$values['package_name']}\n";
    exit(1);
}

$packagePath = '';
$packageParentPath = '';
if (isset($_SERVER['PHWOOLCON_ROOT_PATH'])) {
    $packagePath = "{$_SERVER['PHWOOLCON_ROOT_PATH']}/vendor/{$values['package_vendor']}/{$values['package_name']}";
    if (file_exists($packagePath)) {
        echo "Error: Package {$values['package_vendor']}/{$values['package_name']} already exists!\n";
        exit(1);
    }
    if (is_file($packageParentPath = dirname($packagePath))) {
        echo "Error: Invalid vendor name {$values['package_vendor']}\n";
        exit(1);
    }
}

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
    'Phwoolcon\\Skeleton' => function () use (&$values) {
        return $values['psr4_namespace'];
    },
    'League\\Skeleton' => function () use (&$values) {
        return $values['psr4_namespace'];
    },
    ':psr_vendor' => function () use (&$values) {
        return $values['psr_vendor'];
    },
    ':psr_package' => function () use (&$values) {
        return $values['psr_package'];
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
    'bootstrap="vendor/autoload.php"' => function () {
        return 'bootstrap="vendor/phwoolcon/test-starter/start.php"';
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

$files[] = __DIR__ . '/composer.local.json';
$files[] = __DIR__ . '/phwoolcon-package/di.php';
$files[] = __DIR__ . '/phwoolcon-package/package.php';
$files[] = __DIR__ . '/phwoolcon-package/routes.php';
$files[] = __DIR__ . '/phwoolcon-package/views/admin/default/example/users.phtml';
$files[] = __DIR__ . '/src/Controllers/AdminController.php';
$files[] = __DIR__ . '/src/Controllers/WebApiController.php';
$files[] = __DIR__ . '/tests/Unit/SkeletonClassTest.php';

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

// Replace description in readme
$readme = file_get_contents($readmeFile = __DIR__ . '/README.md');
$replaceStart = strpos($readme, '**Note:** Replace ```');
$replaceEnd = strpos($readme, '## Structure', $replaceStart) - 2;
$readme = substr_replace($readme, $values['package_description'], $replaceStart, $replaceEnd - $replaceStart);

file_put_contents($readmeFile, $readme);

// Rename skeleton files
rename(__DIR__ . '/phwoolcon-package/locale/en/skeleton.php',
    __DIR__ . "/phwoolcon-package/locale/en/{$values['package_name']}.php");
rename(__DIR__ . '/phwoolcon-package/locale/zh_CN/skeleton.php',
    __DIR__ . "/phwoolcon-package/locale/zh_CN/{$values['package_name']}.php");

// Remove prefill script
unlink(__DIR__ . '/prefill.php');
unlink(__FILE__);

// Install as a phwoolcon package
if ($packagePath && $packageParentPath) {
    if (!is_dir($packageParentPath)) {
        mkdir($packageParentPath, 0777, true);
    }
    chdir(dirname(__DIR__));
    rename(__DIR__, $packagePath);
    chdir($packagePath);
    $gitRepo = escapeshellarg($values['git_repo']);
    $gitCmd = "git init && git add ./ && git remote add origin {$gitRepo}";
    $process = proc_open($gitCmd, $fds = [STDIN, STDOUT, STDERR], $pipes);
    proc_close($process);
}

echo "Done.\n";
