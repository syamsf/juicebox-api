<?php

namespace Modules\SharedCommon\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class CustomMigrationCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:custom-migration {module : The name of the module} {name : The name of the migration}';

    protected $description = 'Create a new migration file in a specific module directory';

    public function handle(): void {
        $name   = $this->argument('name');
        $module = ucwords($this->argument('module'));
        $module = str_replace(" ", "", $module);

        $path     = "modules/{$module}/Extras/database/migrations";
        $realPath = base_path($path);

        if (!file_exists($realPath)) {
            mkdir($realPath, 0755, true);
        }

        Artisan::call('make:migration', [
            'name' => $name,
            '--path' => $path
        ]);

        $this->info('Migration created successfully.');
    }
}
