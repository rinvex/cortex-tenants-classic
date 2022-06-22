<?php

declare(strict_types=1);

namespace Cortex\Tenants\DataTables\Adminarea;

use Cortex\Tenants\Models\Tenant;
use Illuminate\Http\JsonResponse;
use Illuminate\Database\Eloquent\Builder;
use Cortex\Tenants\Transformers\TenantTransformer;
use Cortex\Foundation\DataTables\AbstractDataTable;

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
     * Display ajax response.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function ajax(): JsonResponse
    {
        return datatables($this->query())
            ->setTransformer(app($this->transformer))
            ->filterColumn('country_code', function (Builder $builder, $keyword) {
                $countryCode = collect(countries())->search(function ($country) use ($keyword) {
                    return mb_strpos($country['name'], $keyword) !== false || mb_strpos($country['emoji'], $keyword) !== false;
                });

                ! $countryCode || $builder->where('country_code', $countryCode);
            })
            ->filterColumn('language_code', function (Builder $builder, $keyword) {
                $languageCode = collect(languages())->search(function ($language) use ($keyword) {
                    return mb_strpos($language['name'], $keyword) !== false;
                });

                ! $languageCode || $builder->where('language_code', $languageCode);
            })
            ->orderColumn('name', 'name->"$.'.app()->getLocale().'" $1')
            ->make(true);
    }

    /**
     * Get columns.
     *
     * @return array
     */
    protected function getColumns(): array
    {
        $link = config('cortex.foundation.route.locale_prefix')
            ? '"<a href=\""+routes.route(\'adminarea.cortex.tenants.tenants.edit\', {tenant: full.id, locale: \''.$this->request()->segment(1).'\'})+"\">"+data+"</a>"'
            : '"<a href=\""+routes.route(\'adminarea.cortex.tenants.tenants.edit\', {tenant: full.id})+"\">"+data+"</a>"';

        return [
            'id' => ['checkboxes' => '{"selectRow": true}', 'exportable' => false, 'printable' => false],
            'name' => ['title' => trans('cortex/tenants::common.name'), 'render' => $link.'+(full.is_active ? " <i class=\"text-success fa fa-check\"></i>" : " <i class=\"text-danger fa fa-close\"></i>")', 'responsivePriority' => 0],
            'email' => ['title' => trans('cortex/tenants::common.email')],
            'phone' => ['title' => trans('cortex/tenants::common.phone')],
            'country_code' => ['title' => trans('cortex/tenants::common.country'), 'render' => 'full.country_emoji+" "+data'],
            'language_code' => ['title' => trans('cortex/tenants::common.language')],
            'created_at' => ['title' => trans('cortex/tenants::common.created_at'), 'render' => "moment(data).format('YYYY-MM-DD, hh:mm:ss A')"],
            'updated_at' => ['title' => trans('cortex/tenants::common.updated_at'), 'render' => "moment(data).format('YYYY-MM-DD, hh:mm:ss A')"],
        ];
    }
}
