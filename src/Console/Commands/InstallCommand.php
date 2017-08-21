<?php

declare(strict_types=1);

namespace Cortex\Tenantable\Console\Commands;

use Illuminate\Console\Command;

class InstallCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cortex:install:tenantable';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Install Cortex Tenantable Module.';

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        $this->warn('Install cortex/tenantable:');
        $this->call('cortex:migrate:tenantable');
        $this->call('cortex:seed:tenantable');
        $this->call('cortex:publish:tenantable');
    }
}
