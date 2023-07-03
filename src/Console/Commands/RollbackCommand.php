<?php

declare(strict_types=1);

namespace Cortex\Tenants\Console\Commands;

use Symfony\Component\Console\Attribute\AsCommand;
use Rinvex\Tenants\Console\Commands\RollbackCommand as BaseRollbackCommand;

#[AsCommand(name: 'cortex:rollback:tenants')]
class RollbackCommand extends BaseRollbackCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cortex:rollback:tenants {--f|force : Force the operation to run when in production.}';

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
        $path = config('cortex.tenants.autoload_migrations') ?
            realpath(__DIR__.'/../../../database/migrations') :
            $this->laravel->databasePath('migrations/cortex/tenants');

        if (file_exists($path)) {
            $this->call('migrate:reset', [
                '--path' => $path,
                '--force' => $this->option('force'),
            ]);
        } else {
            $this->warn('No migrations found! Consider publish them first: <fg=green>php artisan cortex:publish:tenants</>');
        }

        parent::handle();
    }
}
