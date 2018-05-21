<?php

declare(strict_types=1);

namespace Cortex\Tenants\Http\Controllers\Adminarea;

use Exception;
use Cortex\Tenants\Models\Tenant;
use Illuminate\Foundation\Http\FormRequest;
use Cortex\Foundation\DataTables\LogsDataTable;
use Cortex\Foundation\Importers\DefaultImporter;
use Cortex\Foundation\DataTables\ImportLogsDataTable;
use Cortex\Foundation\Http\Requests\ImportFormRequest;
use Cortex\Foundation\DataTables\ImportRecordsDataTable;
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
            'tabs' => 'adminarea.tenants.tabs',
            'id' => "adminarea-tenants-{$tenant->getRouteKey()}-logs-table",
        ])->render('cortex/foundation::adminarea.pages.datatable-tab');
    }

    /**
     * Import tenants.
     *
     * @param \Cortex\Tenants\Models\Tenant                        $tenant
     * @param \Cortex\Foundation\DataTables\ImportRecordsDataTable $importRecordsDataTable
     *
     * @return \Illuminate\View\View
     */
    public function import(Tenant $tenant, ImportRecordsDataTable $importRecordsDataTable)
    {
        return $importRecordsDataTable->with([
            'resource' => $tenant,
            'tabs' => 'adminarea.tenants.tabs',
            'url' => route('adminarea.tenants.stash'),
            'id' => "adminarea-tenants-{$tenant->getRouteKey()}-import-table",
        ])->render('cortex/foundation::adminarea.pages.datatable-dropzone');
    }

    /**
     * Stash tenants.
     *
     * @param \Cortex\Foundation\Http\Requests\ImportFormRequest $request
     * @param \Cortex\Foundation\Importers\DefaultImporter       $importer
     *
     * @return void
     */
    public function stash(ImportFormRequest $request, DefaultImporter $importer)
    {
        // Handle the import
        $importer->config['resource'] = $this->resource;
        $importer->handleImport();
    }

    /**
     * Hoard tenants.
     *
     * @param \Cortex\Foundation\Http\Requests\ImportFormRequest $request
     *
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    public function hoard(ImportFormRequest $request)
    {
        foreach ((array) $request->get('selected_ids') as $recordId) {
            $record = app('cortex.foundation.import_record')->find($recordId);

            try {
                $fillable = collect($record['data'])->intersectByKeys(array_flip(app('rinvex.tenants.tenant')->getFillable()))->toArray();

                tap(app('rinvex.tenants.tenant')->firstOrNew($fillable), function ($instance) use ($record) {
                    $instance->save() && $record->delete();
                });
            } catch (Exception $exception) {
                $record->notes = $exception->getMessage().(method_exists($exception, 'getMessageBag') ? "\n".json_encode($exception->getMessageBag())."\n\n" : '');
                $record->status = 'fail';
                $record->save();
            }
        }

        return intend([
            'back' => true,
            'with' => ['success' => trans('cortex/foundation::messages.import_complete')],
        ]);
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
            'resource' => trans('cortex/tenants::common.tenant'),
            'tabs' => 'adminarea.tenants.tabs',
            'id' => 'adminarea-tenants-import-logs-table',
        ])->render('cortex/foundation::adminarea.pages.datatable-tab');
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

        return view('cortex/tenants::adminarea.pages.tenant', compact('tenant', 'owners', 'countries', 'languages', 'tags'));
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
            'with' => ['success' => trans('cortex/foundation::messages.resource_saved', ['resource' => trans('cortex/tenants::common.tenant'), 'identifier' => $tenant->name])],
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
            'with' => ['warning' => trans('cortex/foundation::messages.resource_deleted', ['resource' => trans('cortex/tenants::common.tenant'), 'identifier' => $tenant->name])],
        ]);
    }
}
