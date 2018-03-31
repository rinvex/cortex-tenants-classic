<?php

declare(strict_types=1);

namespace Cortex\Tenants\Transformers\Adminarea;

use Cortex\Tenants\Models\Tenant;
use League\Fractal\TransformerAbstract;

class TenantTransformer extends TransformerAbstract
{
    /**
     * @return array
     */
    public function transform(Tenant $tenant): array
    {
        return [
            'id' => (string) $tenant->getRouteKey(),
            'name' => (string) $tenant->name,
            'email' => (string) $tenant->email,
            'phone' => (string) $tenant->phone,
            'owner' => (object) $tenant->owner,
            'country_code' => (string) $tenant->country_code ? country($tenant->country_code)->getName() : null,
            'language_code' => (string) $tenant->language_code ? language($tenant->language_code)->getName() : null,
            'created_at' => (string) $tenant->created_at,
            'updated_at' => (string) $tenant->updated_at,
        ];
    }
}
