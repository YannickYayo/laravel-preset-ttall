<?php

namespace YannickYayo\TtallPreset;

use Illuminate\Support\Arr;
use Illuminate\Container\Container;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Foundation\Console\Presets\Preset;

class TtallPreset extends Preset
{
    /**
     * Installation without auth scaffolding
     */
    public static function install(): void
    {
        static::updatePackages();
        static::updateComposerPackages();
        static::updateStyles();
        static::updateBootstrapping();
        static::updateWelcomePage();
        static::updatePagination();
        static::removeNodeModules();
    }

    /**
     * Installation with auth scaffolding
     */
    public static function installAuth()
    {
        static::install();
        static::scaffoldAuth();
    }

    /**
     * Updat packages from package.json
     *
     * @param array $packages
     *
     * @return array
     */
    protected static function updatePackageArray(array $packages): array
    {
        return array_merge([
            'laravel-mix' => '^5.0.1',
            'laravel-mix-purgecss' => '^4.1',
            'laravel-mix-tailwind' => '^0.1.0',
            'tailwindcss' => '^1.2',
            'alpinejs' => '^1.9.7',
            'turbolinks' => '^5.2.0',
            'eslint' => '^6.8.0',
            'eslint-config-airbnb' => '^18.0.1',
            'eslint-config-prettier' => '^6.10.0',
            'eslint-plugin-import' => '^2.20.1',
            'eslint-plugin-jsx-a11y' => '^6.2.3',
            'eslint-plugin-react' => '^7.18.3',
            'eslint-plugin-react-hooks' => '^1.7.0',
            'prettier' => '^1.19.1',
        ], Arr::except($packages, [
            'bootstrap',
            'bootstrap-sass',
            'popper.js',
            'laravel-mix',
            'jquery',
        ]));
    }

    /**
     * Update the "composer.json" file.
     *
     * @param  bool  $dev
     * @return void
     */
    protected static function updateComposerPackages(bool $dev = true): void
    {
        if (! file_exists(base_path('composer.json'))) {
            return;
        }

        $configurationKey = $dev ? 'require-dev' : 'require';

        $packages = json_decode(file_get_contents(base_path('composer.json')), true);

        $packages[$configurationKey] = static::updateComposerPackageArray(
            array_key_exists($configurationKey, $packages) ? $packages[$configurationKey] : []
        );

        ksort($packages[$configurationKey]);

        file_put_contents(
            base_path('composer.json'),
            json_encode($packages, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT).PHP_EOL
        );
    }

    /**
     * Updat packages from composer.json
     *
     * @param array $packages
     *
     * @return array
     */
    protected static function updateComposerPackageArray(array $packages): array
    {
        return array_merge([
            'livewire/livewire' => '^0.7.0',
            'barryvdh/laravel-debugbar' => '^3.2',
            'barryvdh/laravel-ide-helper' => '^2.6',
            'friendsofphp/php-cs-fixer' => '^2.16',
            'nunomaduro/larastan' => '^0.5.1',
        ], $packages);
    }

    /**
     * Update resources/css/app.css
     */
    protected static function updateStyles(): void
    {
        tap(new Filesystem, function ($filesystem) {
            $filesystem->deleteDirectory(resource_path('sass'));
            $filesystem->delete(public_path('js/app.js'));
            $filesystem->delete(public_path('css/app.css'));

            if (! $filesystem->isDirectory($directory = resource_path('css'))) {
                $filesystem->makeDirectory($directory, 0755, true);
            }
        });

        copy(__DIR__.'/ttall-stubs/resources/css/app.css', resource_path('css/app.css'));
    }

    /**
     * Update webpack.mix.js and resources/js/bootstrap.js
     */
    protected static function updateBootstrapping(): void
    {
        copy(__DIR__.'/tailwindcss-stubs/tailwind.config.js', base_path('tailwind.config.js'));

        copy(__DIR__.'/ttall-stubs/webpack.mix.js', base_path('webpack.mix.js'));

        copy(__DIR__.'/ttall-stubs/resources/js/bootstrap.js', resource_path('js/bootstrap.js'));
        
        copy(__DIR__.'/ttall-stubs/.eslintignore', resource_path('.eslintignore'));
        copy(__DIR__.'/ttall-stubs/.eslintrc.json', resource_path('.eslintrc.json'));
        copy(__DIR__.'/ttall-stubs/.prettierrc', resource_path('.prettierrc'));
        copy(__DIR__.'/ttall-stubs/.php_cs', resource_path('.php_cs'));
        copy(__DIR__.'/ttall-stubs/phpstan.neon', resource_path('phpstan.neon'));
    }

    /**
     * Update the welcome.blade.php file
     */
    protected static function updateWelcomePage(): void
    {
        (new Filesystem)->delete(resource_path('views/welcome.blade.php'));

        copy(__DIR__.'/ttall-stubs/resources/views/welcome.blade.php', resource_path('views/welcome.blade.php'));
    }

    /**
     * Update the pagination views
     */
    protected static function updatePagination(): void
    {
        (new Filesystem)->delete(resource_path('views/vendor/paginate'));

        (new Filesystem)->copyDirectory(__DIR__.'/ttall-stubs/resources/views/vendor/pagination', resource_path('views/vendor/pagination'));
    }

    /**
     * Scaffold auth system
     */
    protected static function scaffoldAuth(): void
    {
        file_put_contents(app_path('Http/Controllers/HomeController.php'), static::compileControllerStub());

        file_put_contents(
            base_path('routes/web.php'),
            "Auth::routes();\n\nRoute::get('/home', 'HomeController@index')->name('home');\n\n",
            FILE_APPEND
        );

        (new Filesystem)->copyDirectory(__DIR__.'/ttall-stubs/resources/views', resource_path('views'));
    }

    /**
     * Update HomeController.stub namespace
     */
    protected static function compileControllerStub(): void
    {
        return str_replace(
            '{{namespace}}',
            Container::getInstance()->getNamespace(),
            file_get_contents(__DIR__.'/ttall-stubs/controllers/HomeController.stub')
        );
    }
}
