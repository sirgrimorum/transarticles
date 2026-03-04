# Changelog

All notable changes to TransArticles will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.1.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [Unreleased]

## [1.3.4] - 2026-03-02

### Fixed
- Resolved Scrutinizer MySQL test database setup issue

## [1.3.3] - 2026-03-01

### Added
- Laravel 12 support
- Minimum PHP version raised to 8.2

## [1.3.2] - 2026-03-01

### Added
- Scrutinizer CI configuration using PHP 8.2 and PHPUnit 10

## [1.3.1] - 2026-03-01

### Added
- Comprehensive test suite using MySQL (orchestra/testbench)

## [1.3.0] - 2026-02-23

### Changed
- Updated compatibility to PHP ^8.x and Laravel ^9.0|^10.0|^11.0
- Minimum PHP raised from 7.x to 8.x

## [1.2.14] - 2020-09-29

### Fixed
- Error when CrudGenerator is installed but the model does not have `get()` method registered

## [1.2.13] - 2020-09-03

### Added
- Support for CrudGenerator's `CrudGenForModels` trait on the Article model

### Fixed
- Avoid integer/bigint type error on `user_id` foreign key in older Laravel versions

## [1.2.11] - 2019-08-05

### Added
- `trans_article()` global helper function

## [1.2.10] - 2019-07-30

### Added
- `transarticles:createseed --all` flag to seed all tables, not just articles

## [1.2.9] - 2019-07-30

### Fixed
- Seeder name error in generated seed class

## [1.2.8] - 2019-07-30

### Added
- `transarticles:createseed` artisan command to generate a seed file from the current `articles` table

## [1.2.7] - 2019-07-08

### Fixed
- BigInt support on the `id` column (Laravel 5.8+)
- Autoload naming corrections

## [1.2.6] - 2019-07-08

### Added
- `getjs()` supports exposing a single `scope.nickname` (not only whole scopes) to JavaScript

### Fixed
- Various error display improvements in fallback content rendering

---

> Versions prior to 1.2.6 are not documented here.

[Unreleased]: https://github.com/sirgrimorum/transarticles/compare/1.3.4...HEAD
[1.3.4]: https://github.com/sirgrimorum/transarticles/compare/1.3.3...1.3.4
[1.3.3]: https://github.com/sirgrimorum/transarticles/compare/1.3.2...1.3.3
[1.3.2]: https://github.com/sirgrimorum/transarticles/compare/1.3.1...1.3.2
[1.3.1]: https://github.com/sirgrimorum/transarticles/compare/1.3.0...1.3.1
[1.3.0]: https://github.com/sirgrimorum/transarticles/compare/1.2.14...1.3.0
[1.2.14]: https://github.com/sirgrimorum/transarticles/compare/1.2.13...1.2.14
[1.2.13]: https://github.com/sirgrimorum/transarticles/compare/1.2.11...1.2.13
[1.2.11]: https://github.com/sirgrimorum/transarticles/compare/1.2.10...1.2.11
[1.2.10]: https://github.com/sirgrimorum/transarticles/compare/1.2.9...1.2.10
[1.2.9]: https://github.com/sirgrimorum/transarticles/compare/1.2.8...1.2.9
[1.2.8]: https://github.com/sirgrimorum/transarticles/compare/1.2.7...1.2.8
[1.2.7]: https://github.com/sirgrimorum/transarticles/releases/tag/1.2.7
