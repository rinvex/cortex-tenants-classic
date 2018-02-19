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
     * List all tenants.
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
     * List tenant logs.
     *
     * @param \Cortex\Tenants\Models\Tenant               $tenant
     * @param \Cortex\Foundation\DataTables\LogsDataTable $logsDataTable
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
     * Create new tenant.
     *
     * @param \Cortex\Tenants\Models\Tenant $tenant
     *
     * @return \Illuminate\View\View
     */
    public function create(Tenant $tenant)
    {
        return $this->form($tenant);
    }

    /**
     * Edit given tenant.
     *
     * @param \Cortex\Tenants\Models\Tenant $tenant
     *
     * @return \Illuminate\View\View
     */
    public function edit(Tenant $tenant)
    {
        return $this->form($tenant);
    }

    /**
     * Show tenant create/edit form.
     *
     * @param \Cortex\Tenants\Models\Tenant $tenant
     *
     * @return \Illuminate\View\View
     */
    protected function form(Tenant $tenant)
    {
        $countries = collect(countries())->map(function ($country, $code) {
            return [
                'id' => $code,
                'text' => $country['name'],
                'emoji' => $country['emoji'],
            ];
        })->values();
        $languages = collect(languages())->pluck('name', 'iso_639_1');
        $users = app('cortex.auth.manager')->all()->pluck('username', 'id');
        $groups = app('rinvex.tenants.tenant')->distinct()->get(['group'])->pluck('group', 'group')->toArray();

        return view('cortex/tenants::adminarea.pages.tenant', compact('tenant', 'users', 'countries', 'languages', 'groups'));
    }

    /**
     * Store new tenant.
     *
     * @param \Cortex\Tenants\Http\Requests\Adminarea\TenantFormRequest $request
     * @param \Cortex\Tenants\Models\Tenant                             $tenant
     *
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    public function store(TenantFormRequest $request, Tenant $tenant)
    {
        return $this->process($request, $tenant);
    }

    /**
     * Update given tenant.
     *
     * @param \Cortex\Tenants\Http\Requests\Adminarea\TenantFormRequest $request
     * @param \Cortex\Tenants\Models\Tenant                             $tenant
     *
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    public function update(TenantFormRequest $request, Tenant $tenant)
    {
        return $this->process($request, $tenant);
    }

    /**
     * Process stored/updated tenant.
     *
     * @param \Illuminate\Foundation\Http\FormRequest $request
     * @param \Cortex\Tenants\Models\Tenant           $tenant
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
            'with' => ['success' => trans('cortex/foundation::messages.resource_saved', ['resource' => 'tenant', 'id' => $tenant->name])],
        ]);
    }

    /**
     * Destroy given tenant.
     *
     * @param \Cortex\Tenants\Models\Tenant $tenant
     *
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    public function destroy(Tenant $tenant)
    {
        $tenant->delete();

        return intend([
            'url' => route('adminarea.tenants.index'),
            'with' => ['warning' => trans('cortex/foundation::messages.resource_deleted', ['resource' => 'tenant', 'id' => $tenant->name])],
        ]);
    }
}
