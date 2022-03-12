<?php

declare(strict_types=1);

namespace Cortex\Tenants\Http\Controllers\Adminarea;

use Illuminate\Http\Request;
use Cortex\Tenants\Models\Tenant;
use Cortex\Foundation\Http\FormRequest;
use Cortex\Foundation\DataTables\LogsDataTable;
use Cortex\Foundation\Importers\InsertImporter;
use Cortex\Foundation\Http\Requests\ImportFormRequest;
use Cortex\Tenants\DataTables\Adminarea\TenantsDataTable;
use Cortex\Foundation\Http\Controllers\AuthorizedController;
use Cortex\Tenants\Http\Requests\Adminarea\TenantFormRequest;

class TenantsController extends AuthorizedController
{
    /**
     * {@inheritdoc}
     */
    protected $resource = 'rinvex.tenants.models.tenant';

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
            'id' => 'adminarea-cortex-tenants-tenants-index',
            'routePrefix' => 'adminarea.cortex.tenants.tenants',
            'pusher' => ['entity' => 'tenant', 'channel' => 'cortex.tenants.tenants.index'],
        ])->render('cortex/foundation::adminarea.pages.datatable-index');
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
            'tabs' => 'adminarea.cortex.tenants.tenants.tabs',
            'id' => "adminarea-cortex-tenants-tenants-{$tenant->getRouteKey()}-logs",
        ])->render('cortex/foundation::adminarea.pages.datatable-tab');
    }

    /**
     * Import pages.
     *
     * @param \Cortex\Foundation\Http\Requests\ImportFormRequest $request
     * @param \Cortex\Foundation\Importers\InsertImporter        $importer
     * @param \Cortex\Tenants\Models\Tenant                      $tenant
     *
     * @return void
     */
    public function import(ImportFormRequest $request, InsertImporter $importer, Tenant $tenant)
    {
        $importer->withModel($tenant)->import($request->file('file'));
    }

    /**
     * Create new tenant.
     *
     * @param \Illuminate\Http\Request      $request
     * @param \Cortex\Tenants\Models\Tenant $tenant
     *
     * @return \Illuminate\View\View
     */
    public function create(Request $request, Tenant $tenant)
    {
        return $this->form($request, $tenant);
    }

    /**
     * Edit given tenant.
     *
     * @param \Illuminate\Http\Request      $request
     * @param \Cortex\Tenants\Models\Tenant $tenant
     *
     * @return \Illuminate\View\View
     */
    public function edit(Request $request, Tenant $tenant)
    {
        return $this->form($request, $tenant);
    }

    /**
     * Show tenant create/edit form.
     *
     * @param \Illuminate\Http\Request      $request
     * @param \Cortex\Tenants\Models\Tenant $tenant
     *
     * @return \Illuminate\View\View
     */
    protected function form(Request $request, Tenant $tenant)
    {
        if (! $tenant->exists && $request->has('replicate') && $replicated = $tenant->resolveRouteBinding($request->input('replicate'))) {
            $tenant = $replicated->replicate();
        }

        $countries = collect(countries())->map(function ($country, $code) {
            return [
                'id' => $code,
                'text' => $country['name'],
                'emoji' => $country['emoji'],
            ];
        })->values();

        $tags = app('rinvex.tags.tag')->pluck('name', 'id');
        $languages = collect(languages())->pluck('name', 'iso_639_1');

        return view('cortex/tenants::adminarea.pages.tenant', compact('tenant', 'countries', 'languages', 'tags'));
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
     * @param \Cortex\Foundation\Http\FormRequest $request
     * @param \Cortex\Tenants\Models\Tenant       $tenant
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
                       ->toMediaCollection('profile_picture', config('cortex.foundation.media.disk'));

        ! $request->hasFile('cover_photo')
        || $tenant->addMediaFromRequest('cover_photo')
                       ->sanitizingFileName(function ($fileName) {
                           return md5($fileName).'.'.pathinfo($fileName, PATHINFO_EXTENSION);
                       })
                       ->toMediaCollection('cover_photo', config('cortex.foundation.media.disk'));

        // Save tenant
        $tenant->fill($data)->save();

        return intend([
            'url' => route('adminarea.cortex.tenants.tenants.index'),
            'with' => ['success' => trans('cortex/foundation::messages.resource_saved', ['resource' => trans('cortex/tenants::common.tenant'), 'identifier' => $tenant->name])],
        ]);
    }

    /**
     * Destroy given tenant.
     *
     * @param \Cortex\Tenants\Models\Tenant $tenant
     *
     * @throws \Exception
     *
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    public function destroy(Tenant $tenant)
    {
        $tenant->delete();

        return intend([
            'url' => route('adminarea.cortex.tenants.tenants.index'),
            'with' => ['warning' => trans('cortex/foundation::messages.resource_deleted', ['resource' => trans('cortex/tenants::common.tenant'), 'identifier' => $tenant->name])],
        ]);
    }
}
