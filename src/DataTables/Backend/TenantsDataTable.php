<?php

declare(strict_types=1);

namespace Cortex\Tenantable\DataTables\Backend;

use Cortex\Tenantable\Models\Tenant;
use Cortex\Foundation\DataTables\AbstractDataTable;
use Cortex\Tenantable\Transformers\Backend\TenantTransformer;

class TenantsDataTable extends AbstractDataTable
{
    /**
     * {@inheritdoc}
     */
    protected $model = Tenant::class;

    /**
     * {@inheritdoc}
     */
    protected $transformer = TenantTransformer::class;

    /**
     * Get columns.
     *
     * @return array
     */
    protected function getColumns()
    {
        return [
            'name' => ['title' => trans('cortex/tenantable::common.name'), 'render' => '"<a href=\""+routes.route(\'backend.tenants.edit\', {tenant: full.id})+"\">"+data+"</a>"', 'responsivePriority' => 0],
            'email' => ['title' => trans('cortex/tenantable::common.email')],
            'phone' => ['title' => trans('cortex/tenantable::common.phone')],
            'owner' => ['title' => trans('cortex/tenantable::common.owner'), 'orderable' => false, 'searchable' => false],
            'country' => ['title' => trans('cortex/tenantable::common.country'), 'orderable' => false, 'searchable' => false],
            'language' => ['title' => trans('cortex/tenantable::common.language'), 'orderable' => false, 'searchable' => false],
            'created_at' => ['title' => trans('cortex/tenantable::common.created_at')],
            'updated_at' => ['title' => trans('cortex/tenantable::common.updated_at')],
        ];
    }
}
