<?php

declare(strict_types=1);

namespace Cortex\Tenants\Console\Commands;

use Rinvex\Tenants\Console\Commands\MigrateCommand as BaseMigrateCommand;

class MigrateCommand extends BaseMigrateCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cortex:migrate:tenants';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Migrate Cortex Tenants Tables.';

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        parent::handle();

        $this->call('migrate', ['--step' => true, '--path' => 'app/cortex/tenants/database/migrations']);
    }
}
