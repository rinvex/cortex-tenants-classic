<?php

declare(strict_types=1);

namespace Cortex\Tenants\Console\Commands;

use Rinvex\Tenants\Console\Commands\PublishCommand as BasePublishCommand;

class PublishCommand extends BasePublishCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cortex:publish:tenants {--force : Overwrite any existing files.}';

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
        parent::handle();

        $this->call('vendor:publish', ['--tag' => 'cortex-tenants-lang', '--force' => $this->option('force')]);
        $this->call('vendor:publish', ['--tag' => 'cortex-tenants-views', '--force' => $this->option('force')]);
        $this->call('vendor:publish', ['--tag' => 'cortex-tenants-config', '--force' => $this->option('force')]);
        $this->call('vendor:publish', ['--tag' => 'cortex-tenants-migrations', '--force' => $this->option('force')]);
    }
}
