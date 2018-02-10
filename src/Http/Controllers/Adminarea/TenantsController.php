<?php

declare(strict_types=1);

namespace Cortex\Tenants\Http\Controllers\Adminarea;

use Rinvex\Tenants\Models\Tenant;
use Illuminate\Foundation\Http\FormRequest;
use Cortex\Foundation\DataTables\LogsDataTable;
use Cortex\Tenants\DataTables\Adminarea\TenantsDataTable;
use Cortex\Foundation\Http\Controllers\AuthorizedController;
use Cortex\Tenants\Http\Requests\Adminarea\TenantFormRequest;

class TenantsController extends AuthorizedController
{
    /**
     * {@inheritdoc}
     */
    protected $resource = 'tenant';

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
            'id' => 'adminarea-tenants-index-table',
            'phrase' => trans('cortex/tenants::common.tenants'),
        ])->render('cortex/foundation::adminarea.pages.datatable');
    }

    /**
     * Get a listing of the resource logs.
     *
     * @param \Rinvex\Tenants\Models\Tenant $tenant
     *
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    public function logs(Tenant $tenant, LogsDataTable $logsDataTable)
    {
        return $logsDataTable->with([
            'resource' => $tenant,
            'tabs' => 'adminarea.tenants.tabs',
            'phrase' => trans('cortex/tenants::common.tenants'),
            'id' => "adminarea-tenants-{$tenant->getKey()}-logs-table",
        ])->render('cortex/foundation::adminarea.pages.datatable-logs');
    }

    /**
     * Show the form for create/update of the given resource.
     *
     * @param \Rinvex\Tenants\Models\Tenant $tenant
     *
     * @return \Illuminate\View\View
     */
    public function form(Tenant $tenant)
    {
        $countries = collect(countries())->map(function ($country, $code) {
            return [
                'id' => $code,
                'text' => $country['name'],
                'emoji' => $country['emoji'],
            ];
        })->values();
        $languages = collect(languages())->pluck('name', 'iso_639_1');
        $owners = app('rinvex.fort.user')->withAnyRoles(['manager'])->get()->pluck('username', 'id');
        $groups = app('rinvex.tenants.tenant')->distinct()->get(['group'])->pluck('group', 'group')->toArray();

        return view('cortex/tenants::adminarea.pages.tenant', compact('tenant', 'owners', 'countries', 'languages', 'groups'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Cortex\Tenants\Http\Requests\Adminarea\TenantFormRequest $request
     *
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    public function store(TenantFormRequest $request)
    {
        return $this->process($request, app('rinvex.tenants.tenant'));
    }

    /**
     * Update the given resource in storage.
     *
     * @param \Cortex\Tenants\Http\Requests\Adminarea\TenantFormRequest $request
     * @param \Rinvex\Tenants\Models\Tenant                             $tenant
     *
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    public function update(TenantFormRequest $request, Tenant $tenant)
    {
        return $this->process($request, $tenant);
    }

    /**
     * Process the form for store/update of the given resource.
     *
     * @param \Illuminate\Foundation\Http\FormRequest $request
     * @param \Rinvex\Tenants\Models\Tenant           $tenant
     *
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    protected function process(FormRequest $request, Tenant $tenant)
    {
        // Prepare required input fields
        $data = $request->validated();

        // Save tenant
        $tenant->fill($data)->save();

        return intend([
            'url' => route('adminarea.tenants.index'),
            'with' => ['success' => trans('cortex/foundation::messages.resource_saved', ['resource' => 'tenant', 'id' => $tenant->slug])],
        ]);
    }

    /**
     * Delete the given resource from storage.
     *
     * @param \Rinvex\Tenants\Models\Tenant $tenant
     *
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    public function delete(Tenant $tenant)
    {
        $tenant->delete();

        return intend([
            'url' => route('adminarea.tenants.index'),
            'with' => ['warning' => trans('cortex/foundation::messages.resource_deleted', ['resource' => 'tenant', 'id' => $tenant->slug])],
        ]);
    }
}
