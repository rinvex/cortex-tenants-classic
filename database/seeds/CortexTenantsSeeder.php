<?php

declare(strict_types=1);

use Illuminate\Database\Seeder;

class CortexTenantsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Bouncer::allow('owner')->to('access-managerarea');

        Bouncer::allow('admin')->to('list', config('rinvex.tenants.models.tenant'));
        Bouncer::allow('admin')->to('create', config('rinvex.tenants.models.tenant'));
        Bouncer::allow('admin')->to('update', config('rinvex.tenants.models.tenant'));
        Bouncer::allow('admin')->to('delete', config('rinvex.tenants.models.tenant'));
        Bouncer::allow('admin')->to('audit', config('rinvex.tenants.models.tenant'));
    }
}
