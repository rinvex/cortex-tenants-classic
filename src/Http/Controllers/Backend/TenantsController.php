<?php

declare(strict_types=1);

namespace Cortex\Tenantable\Http\Controllers\Backend;

use Illuminate\Http\Request;
use Rinvex\Fort\Models\User;
use Cortex\Tenantable\Models\Tenant;
use Cortex\Foundation\DataTables\LogsDataTable;
use Cortex\Tenantable\DataTables\Backend\TenantsDataTable;
use Cortex\Foundation\Http\Controllers\AuthorizedController;
use Cortex\Tenantable\Http\Requests\Backend\TenantFormRequest;

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
            'id' => 'cortex-tenantable-tenants',
            'phrase' => trans('cortex/tenantable::common.tenants'),
        ])->render('cortex/foundation::backend.partials.datatable');
    }

    /**
     * Display a listing of the resource logs.
     *
     * @return \Illuminate\Http\Response
     */
    public function logs(Tenant $tenant)
    {
        return app(LogsDataTable::class)->with([
            'type' => 'tenants',
            'resource' => $tenant,
            'id' => 'cortex-tenantable-tenants-logs',
            'phrase' => trans('cortex/tenantable::common.tenants'),
        ])->render('cortex/foundation::backend.partials.datatable-logs');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Cortex\Tenantable\Http\Requests\Backend\TenantFormRequest $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(TenantFormRequest $request)
    {
        return $this->process($request, new Tenant());
    }

    /**
     * Update the given resource in storage.
     *
     * @param \Cortex\Tenantable\Http\Requests\Backend\TenantFormRequest $request
     * @param \Cortex\Tenantable\Models\Tenant                           $tenant
     *
     * @return \Illuminate\Http\Response
     */
    public function update(TenantFormRequest $request, Tenant $tenant)
    {
        return $this->process($request, $tenant);
    }

    /**
     * Delete the given resource from storage.
     *
     * @param \Cortex\Tenantable\Models\Tenant $tenant
     *
     * @return \Illuminate\Http\Response
     */
    public function delete(Tenant $tenant)
    {
        $tenant->delete();

        return intend([
            'url' => route('backend.tenants.index'),
            'with' => ['warning' => trans('cortex/tenantable::messages.tenant.deleted', ['tenantId' => $tenant->id])],
        ]);
    }

    /**
     * Show the form for create/update of the given resource.
     *
     * @param \Cortex\Tenantable\Models\Tenant $tenant
     *
     * @return \Illuminate\Http\Response
     */
    public function form(Tenant $tenant)
    {
        $countries = countries();
        $owners = User::all()->pluck('username', 'id');
        $languages = collect(languages())->pluck('name', 'iso_639_1');

        return view('cortex/tenantable::backend.forms.tenant', compact('tenant', 'owners', 'countries', 'languages'));
    }

    /**
     * Process the form for store/update of the given resource.
     *
     * @param \Illuminate\Http\Request         $request
     * @param \Cortex\Tenantable\Models\Tenant $tenant
     *
     * @return \Illuminate\Http\Response
     */
    protected function process(Request $request, Tenant $tenant)
    {
        // Prepare required input fields
        $data = $request->all();

        // Save tenant
        $tenant->fill($data)->save();

        return intend([
            'url' => route('backend.tenants.index'),
            'with' => ['success' => trans('cortex/tenantable::messages.tenant.saved', ['tenantId' => $tenant->id])],
        ]);
    }
}
