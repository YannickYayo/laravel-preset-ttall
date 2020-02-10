<?php

namespace YannickYayo\TtallPreset;

use Illuminate\Pagination\Paginator;
use Illuminate\Support\ServiceProvider;
use Illuminate\Foundation\Console\PresetCommand;

class TtallPresetServiceProvider extends ServiceProvider
{
    public function boot()
    {
        PresetCommand::macro('ttall', function ($command) {
            TtallPreset::install();

            $command->info('Ttall scaffolding installed successfully.');
            $command->info('Please run "composer update" to install the new composer\'s packages.');
            $command->info('Please run "npm install && npm run dev" to compile your fresh scaffolding.');
        });

        PresetCommand::macro('ttall-auth', function ($command) {
            TtallPreset::installAuth();

            $command->info('Ttall scaffolding with auth views installed successfully.');
            $command->info('Please run "composer update" to install the new composer\'s packages.');
            $command->info('Please run "npm install && npm run dev" to compile your fresh scaffolding.');
        });

        Paginator::defaultView('pagination::default');

        Paginator::defaultSimpleView('pagination::simple-default');
    }
}
