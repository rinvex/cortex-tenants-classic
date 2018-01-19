<?php

declare(strict_types=1);

namespace Cortex\Tenants\Console\Commands;

use Rinvex\Tenants\Console\Commands\RollbackCommand as BaseRollbackCommand;

class RollbackCommand extends BaseRollbackCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cortex:rollback:tenants';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Rollback Cortex Tenants Tables.';

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle(): void
    {
        parent::handle();

        $this->call('migrate:reset', ['--path' => 'app/cortex/tenants/database/migrations']);
    }
}
