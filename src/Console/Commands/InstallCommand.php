<?php

declare(strict_types=1);

namespace Cortex\Tenants\Console\Commands;

use Illuminate\Console\Command;

class InstallCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cortex:install:tenants';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Install Cortex Tenants Module.';

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        $this->warn($this->description);
        $this->call('cortex:migrate:tenants');
        $this->call('cortex:seed:tenants');
        $this->call('cortex:publish:tenants');
    }
}
