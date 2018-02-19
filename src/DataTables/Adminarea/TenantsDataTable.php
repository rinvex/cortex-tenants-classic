<?php

declare(strict_types=1);

namespace Cortex\Tenants\DataTables\Adminarea;

use Rinvex\Tenants\Models\Tenant;
use Cortex\Foundation\DataTables\AbstractDataTable;

class TenantsDataTable extends AbstractDataTable
{
    /**
     * {@inheritdoc}
     */
    protected $model = Tenant::class;

    /**
     * Get the query object to be processed by dataTables.
     *
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Query\Builder|\Illuminate\Support\Collection
     */
    public function query()
    {
        $query = app($this->model)->query()->with(['user']);

        return $this->applyScopes($query);
    }

    /**
     * Get columns.
     *
     * @return array
     */
    protected function getColumns(): array
    {
        $link = config('cortex.foundation.route.locale_prefix')
            ? '"<a href=\""+routes.route(\'adminarea.tenants.edit\', {tenant: full.name, locale: \''.$this->request->segment(1).'\'})+"\">"+data+"</a>"'
            : '"<a href=\""+routes.route(\'adminarea.tenants.edit\', {tenant: full.name})+"\">"+data+"</a>"';

        return [
            'title' => ['title' => trans('cortex/tenants::common.title'), 'render' => $link.'+(full.is_active ? " <i class=\"text-success fa fa-check\"></i>" : " <i class=\"text-danger fa fa-close\"></i>")', 'responsivePriority' => 0],
            'email' => ['title' => trans('cortex/tenants::common.email')],
            'phone' => ['title' => trans('cortex/tenants::common.phone')],
            'user.username' => ['title' => trans('cortex/tenants::common.user'), 'data' => 'user.username'],
            'country_code' => ['title' => trans('cortex/tenants::common.country')],
            'language_code' => ['title' => trans('cortex/tenants::common.language')],
            'created_at' => ['title' => trans('cortex/tenants::common.created_at'), 'render' => "moment(data).format('MMM Do, YYYY')"],
            'updated_at' => ['title' => trans('cortex/tenants::common.updated_at'), 'render' => "moment(data).format('MMM Do, YYYY')"],
        ];
    }
}
