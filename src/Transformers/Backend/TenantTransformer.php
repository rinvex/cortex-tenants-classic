<?php

declare(strict_types=1);

namespace Cortex\Tenantable\Transformers\Backend;

use Cortex\Tenantable\Models\Tenant;
use League\Fractal\TransformerAbstract;

class TenantTransformer extends TransformerAbstract
{
    /**
     * @return array
     */
    public function transform(Tenant $tenant)
    {
        return [
            'id' => (int) $tenant->id,
            'name' => (string) $tenant->name,
            'email' => (string) $tenant->email,
            'phone' => (string) $tenant->phone,
            'address' => (string) $tenant->address,
            'owner' => (string) $tenant->owner->username,
            'country_code' => (string) $tenant->country_code ? country($tenant->country_code)->getName().'&nbsp;&nbsp;'.country($tenant->language_code)->getEmoji() : '',
            'language_code' => (string) $tenant->language_code ? language($tenant->language_code)->getName() : '',
            'created_at' => (string) $tenant->created_at,
            'updated_at' => (string) $tenant->updated_at,
        ];
    }
}
