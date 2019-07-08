# SirGrimorum's TransArticles

[![Latest Version on Packagist][ico-version]][link-packagist]
[![Software License][ico-license]](LICENSE.md)
[![Build Status][ico-travis]][link-travis]
[![Coverage Status][ico-scrutinizer]][link-scrutinizer]
[![Quality Score][ico-code-quality]][link-code-quality]
[![Total Downloads][ico-downloads]][link-downloads]


Localization using a datablase table for Laravel 5.6. Include a function to add Translation form DB to javascript.

## Install

Via Composer

``` bash
$ composer require :sirgrimorum/transarticles
```

Create Table

``` bash
$ php artisan migrate
```

Publish Configuration

``` bash
$php artisan vendor:publish --tag=config
```

## Usage

Bring a translated article

``` php
$text = TransArticles::get("scope.nickname");
```

## Articles to JavaScript

Load javascript object with all translations of a given scope

``` html
{!! TransArticles::getjs('scope') !!}
<script>
    (function() {
        alert(translations.scope.nickname);
    })();
</script>
```

Load javascript object with translated article

``` html
{!! TransArticles::getjs('scope.nickname') !!}
<script>
    (function() {
        alert(translations.scope.nickname);
    })();
</script>
```

## Blade directives


Bring a translated article using the Blade directive

``` html
@transarticles("scope.nickname")
```

Load javascript object with all translations of a given scope using the Blade directive

``` html
@transarticles_tojs('scope')
<script>
    (function() {
        alert(translations.scope.nickname);
    })();
</script>
```

Load javascript object with translated article using the Blade directive

``` html
@transarticles_tojs('scope.nickname')
<script>
    (function() {
        alert(translations.scope.nickname);
    })();
</script>
```

## Security

If you discover any security related issues, please email andres.espinosa@grimorum.com instead of using the issue tracker.

## Credits

- SirGrimorum [link-author]
- Grimorum Ltda. [link-contributors]

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

[ico-version]: https://img.shields.io/packagist/v/sirgrimorum/transarticles.svg?style=flat-square
[ico-license]: https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square
[ico-travis]: https://img.shields.io/scrutinizer/build/g/sirgrimorum/transarticles.svg?style=flat-square
[ico-scrutinizer]: https://img.shields.io/scrutinizer/coverage/g/sirgrimorum/transarticles.svg?style=flat-square
[ico-code-quality]: https://img.shields.io/scrutinizer/g/sirgrimorum/transarticles.svg?style=flat-square
[ico-downloads]: https://img.shields.io/packagist/dt/sirgrimorum/transarticles.svg?style=flat-square

[link-packagist]: https://packagist.org/packages/sirgrimorum/transarticles
[link-travis]: https://scrutinizer-ci.com/g/sirgrimorum/transarticles/inspections
[link-scrutinizer]: https://scrutinizer-ci.com/g/sirgrimorum/transarticles/code-structure
[link-code-quality]: https://scrutinizer-ci.com/g/sirgrimorum/transarticles
[link-downloads]: https://github.com/sirgrimorum/transarticles
[link-author]: https://github.com/sirgrimorum
[link-contributors]: http://grimorum.com
