# :package_name

[![Latest Version on Packagist][ico-version]][link-packagist]
[![Build Status][ico-travis]][link-travis]
[![Coverage Status][ico-scrutinizer]][link-scrutinizer]
[![Quality Score][ico-code-quality]][link-code-quality]
[![Total Downloads][ico-downloads]][link-downloads]
[![Software License][ico-license]](LICENSE.md)

**Note:** Replace ```:author_name``` ```:author_username``` ```:author_website``` ```:author_email``` ```:vendor``` ```:package_name``` ```:package_description``` with their correct values in [README.md](README.md), [CHANGELOG.md](CHANGELOG.md), [CONTRIBUTING.md](CONTRIBUTING.md), [LICENSE.md](LICENSE.md) and [composer.json](composer.json) files, then delete this line. You can run `$ php prefill.php` in the command line to make all replacements at once. Delete the file prefill.php as well.

This is where your description should go. Try and limit it to a paragraph or two, and maybe throw in a mention of what
PSRs you support to avoid any confusion with users and contributors.

## Structure

The directory structure of this project should be like this:
```bash
phwoolcon-package/
    assets/         # Static assets (js/css/image/fonts ... etc)
    config/         # Config files
    locale/         # Translation files
        en/
        zh_CN/
    views/          # Templates
src/
    Controllers/
    Models/
tests/
    resource/       # Test resources
        assets/
        config/
        locale/
        views/
    Unit/           # Unit test cases
    Integration/    # Integration test cases
```

## Install
Install as a `phwoolcon` package.

If this library has been published to packagist.org or GitHub.com
```bash
bin/import-package :vendor/:package_name
```

If this is a private repository
```bash
bin/import-package :git_repo
```

## Usage
### Configuration
See [phwoolcon-package/config/](phwoolcon-package/config/)
### Templates
See [phwoolcon-package/views/](phwoolcon-package/views/)
### Assets
See [phwoolcon-package/assets/](phwoolcon-package/assets/)
### Locale
See [phwoolcon-package/locale/](phwoolcon-package/locale/)
### Routes
See [phwoolcon-package/routes.php](phwoolcon-package/routes.php)
### Dependency Injection
See [phwoolcon-package/di.php](phwoolcon-package/di.php)
### Controllers
See [src/Controllers/](src/Controllers/)

## Change log

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Testing

``` bash
$ vendor/bin/phpunit
```

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) and [CODE_OF_CONDUCT](CODE_OF_CONDUCT.md) for details.

## Security

If you discover any security related issues, please email :author_email instead of using the issue tracker.

## Credits

- [:author_name][link-author]
- [All Contributors][link-contributors]

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

[ico-version]: https://img.shields.io/github/release/phwoolcon/skeleton.svg?style=flat-square
[ico-license]: https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square
[ico-travis]: https://img.shields.io/travis/phwoolcon/skeleton/master.svg?style=flat-square
[ico-scrutinizer]: https://img.shields.io/scrutinizer/coverage/g/phwoolcon/skeleton.svg?style=flat-square
[ico-code-quality]: https://img.shields.io/scrutinizer/g/phwoolcon/skeleton.svg?style=flat-square
[ico-downloads]: https://img.shields.io/packagist/dt/phwoolcon/skeleton.svg?style=flat-square

[link-packagist]: https://packagist.org/packages/phwoolcon/skeleton
[link-travis]: https://travis-ci.org/phwoolcon/skeleton
[link-scrutinizer]: https://scrutinizer-ci.com/g/phwoolcon/skeleton/code-structure/master/code-coverage
[link-code-quality]: https://scrutinizer-ci.com/g/phwoolcon/skeleton
[link-downloads]: https://packagist.org/packages/phwoolcon/skeleton
[link-author]: https://github.com/:author_username
[link-contributors]: ../../contributors
