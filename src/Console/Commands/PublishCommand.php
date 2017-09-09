<?php

declare(strict_types=1);

namespace Cortex\Tenants\Console\Commands;

use Illuminate\Console\Command;

class PublishCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cortex:publish:tenants';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Publish Cortex Tenants Resources.';

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        $this->warn('Publish cortex/tenants:');
        $this->call('vendor:publish', ['--tag' => 'rinvex-tenants-config']);
        $this->call('vendor:publish', ['--tag' => 'cortex-tenants-views']);
        $this->call('vendor:publish', ['--tag' => 'cortex-tenants-lang']);
    }
}
