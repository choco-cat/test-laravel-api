<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class InstallProject extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'project:install';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Run the project installation';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->info('Generate key');
        Artisan::call('key:generate');

        Artisan::call('storage:link');

        $frameworkDirectory = storage_path('framework');
        if (!file_exists($frameworkDirectory)) {
            mkdir($frameworkDirectory, 0755, true);
        }

        $subdirectories = ['sessions', 'cache', 'views'];
        foreach ($subdirectories as $subdirectory) {
            $subdirectoryPath = $frameworkDirectory . '/' . $subdirectory;
            if (!file_exists($subdirectoryPath)) {
                mkdir($subdirectoryPath, 0755, true);
            }
        }

        $this->info('Run migrations');
        Artisan::call('migrate');

        $this->info('Run seeders');
        Artisan::call('db:seed');

        $this->info('Generate Api documentation');
        Artisan::call('l5-swagger:generate');

        $this->alert('Installation complete successful!');

        return Command::SUCCESS;
    }
}
