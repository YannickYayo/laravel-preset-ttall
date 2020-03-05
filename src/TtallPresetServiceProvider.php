<?php

namespace YannickYayo\TtallPreset;

use Illuminate\Pagination\Paginator;
use Illuminate\Support\ServiceProvider;
use Laravel\Ui\AuthCommand;
use Laravel\Ui\UiCommand;

class TtallPresetServiceProvider extends ServiceProvider
{
    public function boot()
    {
        UiCommand::macro('ttall', function ($command) {
            TtallPreset::install();

            $command->comment('Ttall scaffolding installed successfully.');
            $command->comment('Please run "composer update" to install the new composer\'s packages.');
            $command->comment('Please run "php artisan vendor:publish --provider="Barryvdh\Debugbar\ServiceProvider"" to publish Laravel Debugbar\'s config.');
            $command->comment('Please run "npm install && npm run dev" to compile your fresh scaffolding.');
        });

        AuthCommand::macro('ttall', function ($command) {
            TtallPreset::installAuth();

            $command->comment('Ttall scaffolding with auth views installed successfully.');
            $command->comment('Please run "composer update" to install the new composer\'s packages.');
            $command->comment('Please run "php artisan vendor:publish --provider="Barryvdh\Debugbar\ServiceProvider"" to publish Laravel Debugbar\'s config.');
            $command->comment('Please run "npm install && npm run dev" to compile your fresh scaffolding.');
        });

        Paginator::defaultView('pagination::default');

        Paginator::defaultSimpleView('pagination::simple-default');
    }
}
