# Laravel 6.0+ Frontend preset for The TTALL Stack

An opiniated Laravel front-end scaffolding preset for TTALL stack - Taiwlindcss | Turbolinks | Alpinejs | Laravel | Livewire.
<br>

### For Laravel >= 7.0, please use the [3.x branch](https://github.com/YannickYayo/laravel-preset-ttall/tree/3.x)!

<hr>

It comes with usefull packages and configurations :

- Laravel debugbar
- Laravel IDE Helper
- Php CS Fixer
- Larastan
- Eslint (Airbnb rules)
- Prettier

## 1. Usage

1. Fresh install Laravel >= 6.0 and `cd` to your app.
2. Install this preset via `composer require yannickyayo/laravel-preset-ttall "^1.1" --dev`. Laravel will automatically discover this package. No need to register the service provider.

### a. For Presets without Authentication

1. Use `php artisan preset ttall` for the basic preset
2. `composer update`
3. `php artisan vendor:publish --provider="Barryvdh\Debugbar\ServiceProvider"` to publish the Laravel Debugbar's config file
4. `npm install && npm run dev`
5. `php artisan serve` (or equivalent) to run server and test preset.

### b. For Presets with Authentication

1. Use `php artisan preset ttall-auth` for the basic preset, auth route entry and auth views in one go. (NOTE: If you run this command several times, be sure to clean up the duplicate Auth entries in `routes/web.php`)
2. `composer update`
3. `php artisan vendor:publish --provider="Barryvdh\Debugbar\ServiceProvider"` to publish the Laravel Debugbar's config file
4. `npm install && npm run dev`
5. `php artisan serve` (or equivalent) to run server and test preset.

### Config

The default `tailwind.config.js` configuration file included by this package is including the `Inter` font family. You should wish to make changes by removing the file and run `node_modules/.bin/tailwind init`, which will generate a fresh configuration file for you, which you are free to change to suit your needs.<br>
The `Inter` font family is included in your `resources/layouts/app.blade.php` file.

Add a new i18n string in the `resources/lang/XX/pagination.php` file for each language that your app uses:

```php
'previous' => '&laquo; Previous',
'next' => 'Next &raquo;',
'goto_page' => 'Goto page #:page', // Add this line
```

This should help with accessibility

```html
<li>
  <a href="URL?page=2" class="..." aria-label="Goto page #2">
    2
  </a>
</li>
```

### scripts

A composer's script is added automatically to tell `Laravel IDE Helper` to rescan your `Facades` and `Models` files :

```json
"scripts":{
    "post-update-cmd": [
        "Illuminate\\Foundation\\ComposerScripts::postUpdate",
        "@php artisan ide-helper:generate",
        "@php artisan ide-helper:meta"
    ]
}
```

Scripts are also added to your `package.json` and `composer.json` to run specific actions :

- `composer format` : will use `php-cs-fixer` to format your php files
- `composer test` : will use the `php artisan test` command to run your phpunit tests
- `composer analyse` : will use `larastan` to analyse your code
- `npm run format` : will format your js files on `resources/js` folder
- `npm run lint` : will find issues in your js files based on Airbnb's rules and try to fix them

### Screenshots

_Coming soon..._
