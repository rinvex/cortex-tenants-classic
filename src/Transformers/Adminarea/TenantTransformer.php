<?php

declare(strict_types=1);

namespace Cortex\Tenants\Transformers\Adminarea;

use League\Fractal\TransformerAbstract;
use Rinvex\Tenants\Models\Tenant;

class TenantTransformer extends TransformerAbstract
{
    /**
     * @return array
     */
    public function transform(Tenant $tenant): array
    {
        return [
            'id' => (int) $tenant->getKey(),
            'slug' => (string) $tenant->slug,
            'name' => (string) $tenant->name,
            'email' => (string) $tenant->email,
            'phone' => (string) $tenant->phone,
            'address' => (string) $tenant->address,
            'is_active' => (bool) $tenant->is_active,
            'owner' => (string) $tenant->owner->username,
            'country_code' => (string) $tenant->country_code ? country($tenant->country_code)->getName().'&nbsp;&nbsp;'.country($tenant->country_code)->getEmoji() : '',
            'language_code' => (string) $tenant->language_code ? language($tenant->language_code)->getName() : '',
            'created_at' => (string) $tenant->created_at,
            'updated_at' => (string) $tenant->updated_at,
        ];
    }
}
