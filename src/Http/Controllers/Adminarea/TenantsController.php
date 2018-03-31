<?php

declare(strict_types=1);

namespace Cortex\Tenants\Http\Controllers\Adminarea;

use Cortex\Tenants\Models\Tenant;
use Illuminate\Foundation\Http\FormRequest;
use Cortex\Foundation\DataTables\LogsDataTable;
use Cortex\Foundation\Importers\DefaultImporter;
use Cortex\Foundation\DataTables\ImportLogsDataTable;
use Cortex\Foundation\Http\Requests\ImportFormRequest;
use Cortex\Tenants\DataTables\Adminarea\TenantsDataTable;
use Cortex\Foundation\Http\Controllers\AuthorizedController;
use Cortex\Tenants\Http\Requests\Adminarea\TenantFormRequest;

class TenantsController extends AuthorizedController
{
    /**
     * {@inheritdoc}
     */
    protected $resource = Tenant::class;

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
            'id' => "adminarea-tenants-{$tenant->getRouteKey()}-logs-table",
        ])->render('cortex/foundation::adminarea.pages.datatable-logs');
    }

    /**
     * Import tenants.
     *
     * @return \Illuminate\View\View
     */
    public function import()
    {
        return view('cortex/foundation::adminarea.pages.import', [
            'id' => 'adminarea-tenants-import',
            'tabs' => 'adminarea.tenants.tabs',
            'url' => route('adminarea.tenants.hoard'),
            'phrase' => trans('cortex/tenants::common.tenants'),
        ]);
    }

    /**
     * Hoard tenants.
     *
     * @param \Cortex\Foundation\Http\Requests\ImportFormRequest $request
     * @param \Cortex\Foundation\Importers\DefaultImporter       $importer
     *
     * @return void
     */
    public function hoard(ImportFormRequest $request, DefaultImporter $importer)
    {
        // Handle the import
        $importer->config['resource'] = $this->resource;
        $importer->handleImport();
    }

    /**
     * List tenant import logs.
     *
     * @param \Cortex\Foundation\DataTables\ImportLogsDataTable $importLogsDatatable
     *
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    public function importLogs(ImportLogsDataTable $importLogsDatatable)
    {
        return $importLogsDatatable->with([
            'resource' => 'tenant',
            'tabs' => 'adminarea.tenants.tabs',
            'id' => 'adminarea-tenants-import-logs-table',
            'phrase' => trans('cortex/tenants::common.tenants'),
        ])->render('cortex/foundation::adminarea.pages.datatable-import-logs');
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

        $tags = app('rinvex.tags.tag')->pluck('name', 'id');
        $languages = collect(languages())->pluck('name', 'iso_639_1');
        $owners = app('cortex.auth.manager')->all()->pluck('username', 'id');
        $groups = app('rinvex.tenants.tenant')->distinct()->get(['group'])->pluck('group', 'group')->toArray();

        return view('cortex/tenants::adminarea.pages.tenant', compact('tenant', 'owners', 'countries', 'languages', 'groups', 'tags'));
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

        ! $request->hasFile('profile_picture')
        || $tenant->addMediaFromRequest('profile_picture')
                       ->sanitizingFileName(function ($fileName) {
                           return md5($fileName).'.'.pathinfo($fileName, PATHINFO_EXTENSION);
                       })
                       ->toMediaCollection('profile_picture', config('cortex.auth.media.disk'));

        ! $request->hasFile('cover_photo')
        || $tenant->addMediaFromRequest('cover_photo')
                       ->sanitizingFileName(function ($fileName) {
                           return md5($fileName).'.'.pathinfo($fileName, PATHINFO_EXTENSION);
                       })
                       ->toMediaCollection('cover_photo', config('cortex.auth.media.disk'));

        // Save tenant
        $tenant->fill($data)->save();
        $tenant->owner->assign('owner');
        $tenant->owner->attachTenants($tenant);

        return intend([
            'url' => route('adminarea.tenants.index'),
            'with' => ['success' => trans('cortex/foundation::messages.resource_saved', ['resource' => 'tenant', 'identifier' => $tenant->name])],
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
            'with' => ['warning' => trans('cortex/foundation::messages.resource_deleted', ['resource' => 'tenant', 'identifier' => $tenant->name])],
        ]);
    }
}
