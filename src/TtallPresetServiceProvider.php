<?php

namespace YannickYayo\TtallPreset;

use Illuminate\Pagination\Paginator;
use Illuminate\Support\ServiceProvider;
use Laravel\Ui\UiCommand;

class TtallPresetServiceProvider extends ServiceProvider
{
    public function boot()
    {
        UiCommand::macro('ttall', function ($command) {
            TtallPreset::install();

            $command->info('Ttall scaffolding installed successfully.');
            $command->info('Please run "composer update" to install the new composer\'s packages.');
            $command->info('Please run "php artisan vendor:publish --provider="Barryvdh\Debugbar\ServiceProvider"" to publish Laravel Debugbar\'s config.');
            $command->info('Please run "npm install && npm run dev" to compile your fresh scaffolding.');
        });

        UiCommand::macro('ttall-auth', function ($command) {
            $command->call('ui:auth');
            TtallPreset::installAuth();

            $command->info('Ttall scaffolding with auth views installed successfully.');
            $command->info('Please run "composer update" to install the new composer\'s packages.');
            $command->info('Please run "php artisan vendor:publish --provider="Barryvdh\Debugbar\ServiceProvider"" to publish Laravel Debugbar\'s config.');
            $command->info('Please run "npm install && npm run dev" to compile your fresh scaffolding.');
        });

        Paginator::defaultView('pagination::default');

        Paginator::defaultSimpleView('pagination::simple-default');
    }
}
