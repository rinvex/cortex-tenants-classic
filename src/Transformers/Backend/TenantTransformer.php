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
            'country' => (string) $tenant->country_code ? $tenant->country->getName().'&nbsp;&nbsp;'.$tenant->country->getEmoji() : '',
            'language' => (string) $tenant->language_code ? $tenant->language->getName() : '',
            'created_at' => (string) $tenant->created_at,
            'updated_at' => (string) $tenant->updated_at,
        ];
    }
}
