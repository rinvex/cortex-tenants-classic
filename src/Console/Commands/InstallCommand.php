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
    protected $signature = 'cortex:install:tenants {--f|force : Force the operation to run when in production.} {--r|resource=* : Specify which resources to publish.}';

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
    public function handle(): void
    {
        $this->alert($this->description);

        $this->call('cortex:publish:tenants', ['--force' => $this->option('force'), '--resource' => $this->option('resource')]);
        $this->call('cortex:migrate:tenants', ['--force' => $this->option('force')]);
        $this->call('cortex:seed:tenants');

        $this->call('cortex:activate', ['--module' => 'cortex/tenants']);
    }
}
