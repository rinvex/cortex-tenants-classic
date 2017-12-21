<?php

declare(strict_types=1);

namespace Cortex\Tenants\Http\Controllers\Adminarea;

use Illuminate\Http\Request;
use Rinvex\Tenants\Contracts\TenantContract;
use Cortex\Foundation\DataTables\LogsDataTable;
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
     * @param \Cortex\Tenants\DataTables\Adminarea\TenantsDataTable $tenantsDataTable
     *
     * @return \Illuminate\Http\JsonResponse|\Illuminate\View\View
     */
    public function index(TenantsDataTable $tenantsDataTable)
    {
        return $tenantsDataTable->with([
            'id' => 'cortex-tenants',
            'phrase' => trans('cortex/tenants::common.tenants'),
        ])->render('cortex/foundation::adminarea.pages.datatable');
    }

    /**
     * Display a listing of the resource logs.
     *
     * @param \Rinvex\Tenants\Contracts\TenantContract    $tenant
     * @param \Cortex\Foundation\DataTables\LogsDataTable $logsDataTable
     *
     * @return \Illuminate\Http\JsonResponse|\Illuminate\View\View
     */
    public function logs(TenantContract $tenant, LogsDataTable $logsDataTable)
    {
        return $logsDataTable->with([
            'tab' => 'logs',
            'type' => 'tenants',
            'resource' => $tenant,
            'title' => $tenant->name,
            'id' => 'cortex-tenants-logs',
            'phrase' => trans('cortex/tenants::common.tenants'),
        ])->render('cortex/foundation::adminarea.pages.datatable-tab');
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
     * @param \Rinvex\Tenants\Contracts\TenantContract                  $tenant
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
        $languages = collect(languages())->pluck('name', 'iso_639_1');
        $owners = app('rinvex.fort.user')->role('manager')->get()->pluck('username', 'id');
        $groups = app('rinvex.tenants.tenant')->distinct()->get(['group'])->pluck('group', 'group')->toArray();

        return view('cortex/tenants::adminarea.pages.tenant', compact('tenant', 'owners', 'countries', 'languages', 'groups'));
    }

    /**
     * Process the form for store/update of the given resource.
     *
     * @param \Illuminate\Http\Request                 $request
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
