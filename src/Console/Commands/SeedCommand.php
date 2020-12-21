<?php

declare(strict_types=1);

namespace Cortex\Tenants\Console\Commands;

use Illuminate\Console\Command;
use Cortex\Tenants\Database\Seeders\CortexTenantsSeeder;

class SeedCommand extends Command
{
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
    public function handle(): void
    {
        $this->alert($this->description);

        $this->call('db:seed', ['--class' => CortexTenantsSeeder::class]);

        $this->line('');
    }
}
