<?php

declare(strict_types=1);

namespace Cortex\Tenants\Database\Seeders;

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
        $accessAbilities = [
            ['name' => 'update-tenant', 'title' => 'Update Tenant'],
            ['name' => 'access-managerarea', 'title' => 'Access managerarea'],
        ];

        $abilities = [
            ['name' => 'list', 'title' => 'List tenants', 'entity_type' => 'tenant'],
            ['name' => 'import', 'title' => 'Import tenants', 'entity_type' => 'tenant'],
            ['name' => 'export', 'title' => 'Export tenants', 'entity_type' => 'tenant'],
            ['name' => 'create', 'title' => 'Create tenants', 'entity_type' => 'tenant'],
            ['name' => 'update', 'title' => 'Update tenants', 'entity_type' => 'tenant'],
            ['name' => 'delete', 'title' => 'Delete tenants', 'entity_type' => 'tenant'],
            ['name' => 'audit', 'title' => 'Audit tenants', 'entity_type' => 'tenant'],
        ];

        $accessareas = [
            ['name' => 'managerarea', 'slug' => 'managerarea', 'is_protected' => true, 'is_scoped' => false, 'is_indexable' => false, 'prefix' => 'managerarea'],
            ['name' => 'tenantarea', 'slug' => 'tenantarea', 'is_protected' => true],
        ];

        collect($accessAbilities)->each(function (array $ability) {
            app('cortex.auth.ability')->firstOrCreate([
                'name' => $ability['name'],
            ], $ability);
        });

        collect($abilities)->each(function (array $ability) {
            app('cortex.auth.ability')->firstOrCreate([
                'name' => $ability['name'],
                'entity_type' => $ability['entity_type'],
            ], $ability);
        });

        collect($accessareas)->each(function (array $accessarea) {
            app('cortex.foundation.accessarea')->firstOrCreate([
                'slug' => $accessarea['slug'],
            ], $accessarea);
        });
    }
}
