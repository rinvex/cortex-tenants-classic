<?php

declare(strict_types=1);

namespace Cortex\Tenantable\Console\Commands;

use Illuminate\Console\Command;
use Rinvex\Fort\Traits\AbilitySeeder;
use Rinvex\Fort\Traits\ArtisanHelper;
use Illuminate\Support\Facades\Schema;

class SeedCommand extends Command
{
    use AbilitySeeder;
    use ArtisanHelper;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cortex:seed:tenantable';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Seed Default Cortex Tenantable data.';

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        $this->warn('Seed cortex/tenantable:');

        if ($this->ensureExistingTenantableTables()) {
            // No seed data at the moment!
        }

        if ($this->ensureExistingFortTables()) {
            $this->seedAbilities(realpath(__DIR__.'/../../../resources/data/abilities.json'));
        }
    }

    /**
     * Ensure existing tenantable tables.
     *
     * @return bool
     */
    protected function ensureExistingTenantableTables()
    {
        if (! $this->hasTenantableTables()) {
            $this->call('cortex:migrate:tenantable');
        }

        return true;
    }

    /**
     * Check if all required tenantable tables exists.
     *
     * @return bool
     */
    protected function hasTenantableTables()
    {
        return Schema::hasTable(config('rinvex.tenantable.tables.tenants'))
               && Schema::hasTable(config('rinvex.tenantable.tables.tenantables'));
    }
}
