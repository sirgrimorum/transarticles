# TransArticles

![Latest Version on Packagist](https://img.shields.io/packagist/v/sirgrimorum/transarticles.svg?style=flat-square)
![PHP Version](https://img.shields.io/packagist/php-v/sirgrimorum/transarticles.svg?style=flat-square)
![Total Downloads](https://img.shields.io/packagist/dt/sirgrimorum/transarticles.svg?style=flat-square)
![License](https://img.shields.io/packagist/l/sirgrimorum/transarticles.svg?style=flat-square)

Database-backed multilingual content for Laravel. Store rich-text articles in the database instead of flat files, retrieve them by locale, expose them to JavaScript, and manage them via the CrudGenerator admin — all with a single helper call.

## Features

- **Database-backed translations** — articles stored per locale in the `articles` table
- **Automatic locale fallback** — returns any available language when the current locale is missing
- **Dot-notation keys** — `scope.nickname` addressing (e.g. `help.contact_us`)
- **JavaScript exposure** — publish a whole scope of articles to a JS global for frontend use
- **Blade directives** — render or expose articles without leaving the template
- **`trans_article()` helper** — global function usable anywhere in PHP
- **Seeder generation** — dump the current `articles` table to a seed file with one command
- **CrudGenerator integration** — articles can be managed via the CrudGenerator admin when both packages are installed

## Requirements

- PHP >= 8.2
- Laravel >= 9.0

## Installation

```bash
composer require sirgrimorum/transarticles
```

### Run migrations

```bash
php artisan migrate
```

This creates the `articles` table with columns: `id`, `nickname`, `scope`, `lang`, `content`, `activated`, `user_id`.

### Publish configuration (optional)

```bash
php artisan vendor:publish --provider="Sirgrimorum\TransArticles\TransArticlesServiceProvider" --tag=config
```

Publishes `config/sirgrimorum/transarticles.php`.

## Configuration

`config/sirgrimorum/transarticles.php`

```php
return [
    // Eloquent model used to store articles
    'default_articles_model' => \Sirgrimorum\TransArticles\Models\Article::class,

    // Database column that stores the locale code
    'default_lang_column' => 'lang',

    // Model scope used to find a single article
    'default_findarticle_function_name' => 'findArticle',

    // Model scope used to find a collection of articles
    'default_findarticles_function_name' => 'findArticles',

    // JavaScript global variable for exposed articles
    'default_base_var' => 'translations',
];
```

## Creating Articles

Insert records directly or use the CrudGenerator admin (if installed):

```php
\Sirgrimorum\TransArticles\Models\Article::create([
    'scope'     => 'homepage',
    'nickname'  => 'hero_title',
    'lang'      => 'en',
    'content'   => '<h1>Welcome to our site</h1>',
    'activated' => true,
]);
```

## Retrieving Articles

### Facade

```php
use Sirgrimorum\TransArticles\Facades\TransArticles;

// Returns content for the current locale (or fallback)
$html = TransArticles::get('homepage.hero_title');

// Expose a scope as a <script> tag
$script = TransArticles::getjs('homepage');
```

### Helper function

```php
echo trans_article('homepage.hero_title');
```

### Blade directives

```blade
{{-- Render an article inline --}}
@transarticles('homepage.hero_title')

{{-- Expose an entire scope to JavaScript --}}
@transarticles_tojs('homepage')

{{-- Custom JS variable name --}}
@transarticles_tojs('homepage', 'pageContent')
```

### JavaScript usage (after `@transarticles_tojs`)

```js
// window.translations.homepage.hero_title => "<h1>Welcome...</h1>"
document.getElementById('hero').innerHTML = translations.homepage.hero_title;
```

## Locale Fallback Behaviour

1. Look for an article with `lang = App::getLocale()` and `activated = true`
2. If not found, return any activated article for that `scope.nickname`
3. If still not found, return the nickname itself (useful for spotting missing articles)

A warning label is shown when content is returned in a fallback language.

## Artisan Commands

### `transarticles:createseed`

Generates a database seed file from the current `articles` table:

```bash
# Seed only the articles table
php artisan transarticles:createseed

# Seed all tables (excluding migrations)
php artisan transarticles:createseed --all

# Force overwrite
php artisan transarticles:createseed --force
```

The generated seed file is placed in `database/seeds/` (or `database/seeders/` for Laravel 8+).

## API Reference

### `TransArticles::get()`

```php
TransArticles::get(string $nickname): string
```

Returns the HTML content of the article identified by `scope.nickname` for the current locale.

### `TransArticles::getjs()`

```php
TransArticles::getjs(
    string $scope,      // Scope to expose (or 'scope.nickname' for a single article)
    string $basevar = '' // JS global variable (defaults to config 'default_base_var')
): string
```

Returns a `<script>` tag that assigns all articles in the scope to `window.{basevar}.{scope}`.

### `trans_article()`

```php
trans_article(string $nickname): string
```

Global helper — equivalent to `TransArticles::get($nickname)`.

### Blade directive — `@transarticles`

```blade
@transarticles(string $nickname)
```

### Blade directive — `@transarticles_tojs`

```blade
@transarticles_tojs(string $scope, string $basevar = '')
```

## License

The MIT License (MIT). See [LICENSE.md](LICENSE.md).
