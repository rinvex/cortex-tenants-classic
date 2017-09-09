<?php

declare(strict_types=1);

namespace Cortex\Tenants\Http\Controllers\Adminarea;

use Illuminate\Http\Request;
use Cortex\Foundation\DataTables\LogsDataTable;
use Rinvex\Tenants\Contracts\TenantContract;
use Cortex\Tenants\DataTables\Adminarea\TenantsDataTable;
use Cortex\Foundation\Http\Controllers\AuthorizedController;
use Cortex\Tenants\Http\Requests\Adminarea\TenantFormRequest;

class TenantsController extends AuthorizedController
{
    /**
     * {@inheritdoc}
     */
    protected $resource = 'tenants';

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return app(TenantsDataTable::class)->with([
            'id' => 'cortex-tenants-tenants',
            'phrase' => trans('cortex/tenants::common.tenants'),
        ])->render('cortex/foundation::adminarea.pages.datatable');
    }

    /**
     * Display a listing of the resource logs.
     *
     * @return \Illuminate\Http\Response
     */
    public function logs(TenantContract $tenant)
    {
        return app(LogsDataTable::class)->with([
            'type' => 'tenants',
            'resource' => $tenant,
            'id' => 'cortex-tenants-tenants-logs',
            'phrase' => trans('cortex/tenants::common.tenants'),
        ])->render('cortex/foundation::adminarea.pages.datatable-logs');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Cortex\Tenants\Http\Requests\Adminarea\TenantFormRequest $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(TenantFormRequest $request)
    {
        return $this->process($request, app('rinvex.tenants.tenant'));
    }

    /**
     * Update the given resource in storage.
     *
     * @param \Cortex\Tenants\Http\Requests\Adminarea\TenantFormRequest $request
     * @param \Rinvex\Tenants\Contracts\TenantContract                $tenant
     *
     * @return \Illuminate\Http\Response
     */
    public function update(TenantFormRequest $request, TenantContract $tenant)
    {
        return $this->process($request, $tenant);
    }

    /**
     * Delete the given resource from storage.
     *
     * @param \Rinvex\Tenants\Contracts\TenantContract $tenant
     *
     * @return \Illuminate\Http\Response
     */
    public function delete(TenantContract $tenant)
    {
        $tenant->delete();

        return intend([
            'url' => route('adminarea.tenants.index'),
            'with' => ['warning' => trans('cortex/tenants::messages.tenant.deleted', ['slug' => $tenant->slug])],
        ]);
    }

    /**
     * Show the form for create/update of the given resource.
     *
     * @param \Rinvex\Tenants\Contracts\TenantContract $tenant
     *
     * @return \Illuminate\Http\Response
     */
    public function form(TenantContract $tenant)
    {
        $countries = countries();
        $owners = app('rinvex.fort.user')->all()->pluck('username', 'id');
        $languages = collect(languages())->pluck('name', 'iso_639_1');

        return view('cortex/tenants::adminarea.forms.tenant', compact('tenant', 'owners', 'countries', 'languages'));
    }

    /**
     * Process the form for store/update of the given resource.
     *
     * @param \Illuminate\Http\Request                    $request
     * @param \Rinvex\Tenants\Contracts\TenantContract $tenant
     *
     * @return \Illuminate\Http\Response
     */
    protected function process(Request $request, TenantContract $tenant)
    {
        // Prepare required input fields
        $data = $request->all();

        // Save tenant
        $tenant->fill($data)->save();

        return intend([
            'url' => route('adminarea.tenants.index'),
            'with' => ['success' => trans('cortex/tenants::messages.tenant.saved', ['slug' => $tenant->slug])],
        ]);
    }
}
