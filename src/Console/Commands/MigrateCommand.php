<?php

declare(strict_types=1);

namespace Cortex\Tenantable\Console\Commands;

use Rinvex\Tenantable\Console\Commands\MigrateCommand as BaseMigrateCommand;

class MigrateCommand extends BaseMigrateCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cortex:migrate:tenantable';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Migrate Cortex Tenantable Tables.';
}
