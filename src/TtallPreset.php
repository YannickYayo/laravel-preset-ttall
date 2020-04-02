<?php

namespace YannickYayo\TtallPreset;

use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Laravel\Ui\Presets\Preset;
use Symfony\Component\Finder\SplFileInfo;

class TtallPreset extends Preset
{
    /**
     * Installation without auth scaffolding.
     */
    public static function install(): void
    {
        static::updatePackages();
        static::updatePackages(false);
        static::updateComposerPackages();
        static::updateComposerPackages(false);
        static::updateComposerScripts();
        static::updatePackagesScripts();
        static::updateStyles();
        static::updateBootstrapping();
        static::updateWelcomePage();
        static::updatePagination();
        static::updateLayout();
        static::removeNodeModules();
    }

    /**
     * Installation with auth scaffolding.
     */
    public static function installAuth(): void
    {
        static::scaffoldAuth();

        if (self::getLaravelVersion() == '7.x') {
            static::scaffoldController();
        }
    }

    /**
     * Update the "composer.json" file scripts key.
     */
    protected static function updateComposerScripts(): void
    {
        if (! file_exists(base_path('composer.json'))) {
            return;
        }

        $composer = json_decode(file_get_contents(base_path('composer.json')), true);

        $composer['scripts'] = static::updateComposerScriptsArray(
            array_key_exists('scripts', $composer) ? $composer['scripts'] : []
        );

        ksort($composer['scripts']);

        file_put_contents(
            base_path('composer.json'),
            json_encode($composer, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT).PHP_EOL
        );
    }

    /**
     * Merging the composer "scripts" key.
     *
     * @param array $composer
     *
     * @return array
     */
    protected static function updateComposerScriptsArray(array $composer): array
    {
        $test = self::getLaravelVersion() == '6.x' ? 'phpunit --colors=always --stop-on-defect' : '@php artisan test';

        return array_merge([
            'post-update-cmd' => [
                'Illuminate\\Foundation\\ComposerScripts::postUpdate',
                '@php artisan ide-helper:generate',
                '@php artisan ide-helper:models -W',
            ],
            'format' => 'php-cs-fixer fix --path-mode=intersection --config=.php_cs ./',
            'test' => $test,
            'analyse' => 'phpstan analyse',
        ], $composer);
    }

    /**
     * Update the "package.json" file scripts key.
     */
    protected static function updatePackagesScripts(): void
    {
        if (! file_exists(base_path('package.json'))) {
            return;
        }

        $packages = json_decode(file_get_contents(base_path('package.json')), true);

        $packages['scripts'] = static::updatePackagesScriptsArray(
            array_key_exists('scripts', $packages) ? $packages['scripts'] : []
        );

        ksort($packages['scripts']);

        file_put_contents(
            base_path('package.json'),
            json_encode($packages, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT).PHP_EOL
        );
    }

    /**
     * Merging the package "scripts" key.
     *
     * @param array $packages
     *
     * @return array
     */
    protected static function updatePackagesScriptsArray(array $packages): array
    {
        return array_merge([
            'format' => "prettier --write 'resources/js/*.{js,jsx}'",
            'lint' => "eslint '**/*.{js,jsx}' --quiet --fix",
        ], $packages);
    }

    /**
     * Merging packages from package.json.
     *
     * @param array $packages
     * @param string $dev
     *
     * @return array
     */
    protected static function updatePackageArray(array $packages, string $dev): array
    {
        if ($dev == 'devDependencies') {
            return array_merge([
                'eslint' => '^6.8.0',
                'eslint-config-airbnb' => '^18.0.1',
                'eslint-config-prettier' => '^6.10.0',
                'eslint-plugin-import' => '^2.20.1',
                'eslint-plugin-jsx-a11y' => '^6.2.3',
                'eslint-plugin-react' => '^7.18.3',
                'eslint-plugin-react-hooks' => '^1.7.0',
                'prettier' => '^1.19.1',
            ], Arr::except($packages, [
                'axios',
                'laravel-mix',
                'lodash',
            ]));
        } else {
            return array_merge([
                'axios' => '^0.19',
                'laravel-mix' => '^5.0.1',
                'laravel-mix-purgecss' => '^4.1',
                'laravel-mix-tailwind' => '^0.1.0',
                'lodash' => '^4.17.13',
                'tailwindcss' => '^1.2',
                'alpinejs' => '^2.2',
                'turbolinks' => '^5.2.0',
            ], $packages);
        }
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

        $composer = json_decode(file_get_contents(base_path('composer.json')), true);

        $composer[$configurationKey] = static::updateComposerPackageArray(
            array_key_exists($configurationKey, $composer) ? $composer[$configurationKey] : [],
            $configurationKey
        );

        ksort($composer[$configurationKey]);

        file_put_contents(
            base_path('composer.json'),
            json_encode($composer, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT).PHP_EOL
        );
    }

    /**
     * Updat packages from composer.json.
     *
     * @param array $composer
     * @param string $dev
     *
     * @return array
     */
    protected static function updateComposerPackageArray(array $composer, string $dev): array
    {
        if ($dev == 'require-dev') {
            return array_merge([
                'barryvdh/laravel-debugbar' => '^3.2',
                'barryvdh/laravel-ide-helper' => '^2.6',
                'friendsofphp/php-cs-fixer' => '^2.16',
                'nunomaduro/larastan' => '^0.5.2',
            ], $composer);
        } else {
            return array_merge([
                'livewire/livewire' => '^1.0',
            ], $composer);
        }
    }

    /**
     * Update resources/css/app.css.
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
     * Update webpack.mix.js and resources/js/bootstrap.js.
     */
    protected static function updateBootstrapping(): void
    {
        copy(__DIR__.'/ttall-stubs/tailwind.config.js', base_path('tailwind.config.js'));

        copy(__DIR__.'/ttall-stubs/webpack.mix.js', base_path('webpack.mix.js'));

        copy(__DIR__.'/ttall-stubs/resources/js/app.js', resource_path('js/app.js'));
        copy(__DIR__.'/ttall-stubs/resources/js/bootstrap.js', resource_path('js/bootstrap.js'));
        copy(__DIR__.'/ttall-stubs/resources/js/turbolinks.js', resource_path('js/turbolinks.js'));

        copy(__DIR__.'/ttall-stubs/.eslintignore', base_path('.eslintignore'));
        copy(__DIR__.'/ttall-stubs/.eslintrc.json', base_path('.eslintrc.json'));
        copy(__DIR__.'/ttall-stubs/.php_cs', base_path('.php_cs'));
        copy(__DIR__.'/ttall-stubs/.prettierrc', base_path('.prettierrc'));
        copy(__DIR__.'/ttall-stubs/phpstan.neon', base_path('phpstan.neon'));
    }

    /**
     * Update the welcome.blade.php file.
     */
    protected static function updateWelcomePage(): void
    {
        (new Filesystem)->delete(resource_path('views/welcome.blade.php'));

        copy(__DIR__.'/ttall-stubs/resources/views/welcome.blade.php', resource_path('views/welcome.blade.php'));
    }

    /**
     * Update the pagination views.
     */
    protected static function updatePagination(): void
    {
        (new Filesystem)->delete(resource_path('views/vendor/paginate'));

        (new Filesystem)->copyDirectory(__DIR__.'/ttall-stubs/resources/views/vendor/pagination', resource_path('views/vendor/pagination'));
    }

    /**
     * Update the app layout.
     */
    protected static function updateLayout(): void
    {
        (new Filesystem)->delete(resource_path('views/layouts'));

        (new Filesystem)->copyDirectory(__DIR__.'/ttall-stubs/resources/views/layouts', resource_path('views/layouts'));
    }

    /**
     * Scaffold Auth controllers.
     */
    protected static function scaffoldController(): void
    {
        if (! is_dir($directory = app_path('Http/Controllers/Auth'))) {
            mkdir($directory, 0755, true);
        }

        $filesystem = new Filesystem;

        collect($filesystem->allFiles(base_path('vendor/laravel/ui/stubs/Auth')))
            ->each(function (SplFileInfo $file) use ($filesystem) {
                $filesystem->copy(
                    $file->getPathname(),
                    app_path('Http/Controllers/Auth/'.Str::replaceLast('.stub', '.php', $file->getFilename()))
                );
            });
    }

    /**
     * Scaffold auth system.
     */
    protected static function scaffoldAuth(): void
    {
        file_put_contents(app_path('Http/Controllers/HomeController.php'), static::compileControllerStub());

        file_put_contents(
            base_path('routes/web.php'),
            "Auth::routes();\n\nRoute::get('/home', 'HomeController@index')->name('home');\n\n",
            FILE_APPEND
        );

        tap(new Filesystem, function ($filesystem) {
            $filesystem->copyDirectory(__DIR__.'/ttall-stubs/resources/views', resource_path('views'));

            if (self::getLaravelVersion() == '7.x') {
                collect($filesystem->allFiles(base_path('vendor/laravel/ui/stubs/migrations')))
                    ->each(function (SplFileInfo $file) use ($filesystem) {
                        $filesystem->copy(
                            $file->getPathname(),
                            database_path('migrations/'.$file->getFilename())
                        );
                    });
            }
        });
    }

    /**
     * Update HomeController.stub namespace.
     */
    protected static function compileControllerStub(): string
    {
        $template = file_get_contents(__DIR__.'/ttall-stubs/controllers/HomeController.stub');

        return str_replace(
            ['{{namespace}}', '{{@return}}'],
            [app()->getNamespace(), '@return \Illuminate\Contracts\Support\Renderable'],
            $template
        );
    }

    /**
     * Get the current Laravel version.
     *
     * @return string
     */
    private static function getLaravelVersion(): string
    {
        return Str::startsWith(app()->version(), '6.') ? '6.x' : '7.x';
    }
}
