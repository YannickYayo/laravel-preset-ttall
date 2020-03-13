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
            if ($command->option('auth')) {
                TtallPreset::installAuth();

                $command->info('Ttall auth scaffolding installed successfully.');
            }
            $command->info('Please run "composer update" to install the new composer\'s packages.');
            $command->info('Please run "npm install && npm run dev" to compile your fresh scaffolding.');
        });

        Paginator::defaultView('pagination::default');

        Paginator::defaultSimpleView('pagination::simple-default');
    }
}
