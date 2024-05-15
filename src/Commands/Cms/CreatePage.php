<?php

namespace CarlosYassuo\Laravel\Commands\Cms;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class CreatePage extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cms:page {name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a cms new page.';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        File::makeDirectory(resource_path('views/cms/pages/' . $this->argument('name') . '/' . 'index.blade.php'), 0755, true); // Create a new directory
        //mkdir(base_path('resources/views/cms/pages/' . $this->argument('name') . '/' . 'index.blade.php'));
        //mkdir(base_path('resources/views/cms/pages/' . $this->argument('name') . '/' . 'save.blade.php')); // Create a new directory
        $this->info('Page created successfully.' . resource_path('views\\cms\\pages\\' . $this->argument('name')));
    }
}
