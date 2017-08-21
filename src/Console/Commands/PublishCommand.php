<?php

declare(strict_types=1);

namespace Cortex\Tenantable\Console\Commands;

use Illuminate\Console\Command;

class PublishCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cortex:publish:tenantable';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Publish Cortex Tenantable Resources.';

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        $this->warn('Publish cortex/tenantable:');
        $this->call('vendor:publish', ['--tag' => 'rinvex-tenantable-config']);
        $this->call('vendor:publish', ['--tag' => 'cortex-tenantable-views']);
        $this->call('vendor:publish', ['--tag' => 'cortex-tenantable-lang']);
    }
}
