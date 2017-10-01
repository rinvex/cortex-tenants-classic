<?php

declare(strict_types=1);

namespace Cortex\Tenants\Console\Commands;

use Illuminate\Console\Command;
use Rinvex\Support\Traits\SeederHelper;

class SeedCommand extends Command
{
    use SeederHelper;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cortex:seed:tenants';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Seed Cortex Tenants Data.';

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        $this->warn('Seed cortex/tenants:');

        if ($this->ensureExistingDatabaseTables('rinvex/fort')) {
            $this->seedResources(app('rinvex.fort.ability'), realpath(__DIR__.'/../../../resources/data/abilities.json'), ['name', 'description', 'policy']);
            $this->seedResources(app('rinvex.fort.role'), realpath(__DIR__.'/../../../resources/data/roles.json'), ['name', 'description']);
            $this->seedResources(app('rinvex.pages.page'), realpath(__DIR__.'/../../../resources/data/pages.json'), ['title', 'view'], function () {
                // Update page route domain
                app('rinvex.pages.page')->query()->update(['domain' => '{subdomain}.'.domain()]);
            });
        }
    }
}
