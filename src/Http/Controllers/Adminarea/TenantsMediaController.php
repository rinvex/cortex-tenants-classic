<?php

declare(strict_types=1);

namespace Cortex\Tenants\Http\Controllers\Adminarea;

use Spatie\MediaLibrary\Models\Media;
use Rinvex\Tenants\Contracts\TenantContract;
use Cortex\Foundation\DataTables\MediaDataTable;
use Cortex\Foundation\Http\Requests\ImageFormRequest;
use Cortex\Foundation\Http\Controllers\AuthorizedController;

class TenantsMediaController extends AuthorizedController
{
    /**
     * {@inheritdoc}
     */
    protected $resource = 'tenants';

    /**
     * {@inheritdoc}
     */
    protected $resourceAbilityMap = [
        'index' => 'list-media',
        'store' => 'create-media',
        'delete' => 'delete-media',
    ];

    /**
     * Get a listing of the resource media.
     *
     * @param \Rinvex\Tenants\Contracts\TenantContract $tenant
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\JsonResponse
     */
    public function index(TenantContract $tenant)
    {
        return request()->ajax() && request()->wantsJson()
            ? app(MediaDataTable::class)->with(['resource' => $tenant])->ajax()
            : intend(['url' => route('adminarea.tenants.edit', ['tenant' => $tenant]).'#media-tab']);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Cortex\Foundation\Http\Requests\ImageFormRequest $request
     * @param \Rinvex\Tenants\Contracts\TenantContract          $tenant
     *
     * @return void
     */
    public function store(ImageFormRequest $request, TenantContract $tenant)
    {
        $tenant->addMediaFromRequest('file')
               ->sanitizingFileName(function ($fileName) {
                   return md5($fileName).'.'.pathinfo($fileName, PATHINFO_EXTENSION);
               })
               ->toMediaCollection('default', config('cortex.tenants.media.disk'));
    }

    /**
     * Delete the given resource from storage.
     *
     * @param \Rinvex\Tenants\Contracts\TenantContract $tenant
     * @param \Spatie\MediaLibrary\Models\Media        $media
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\JsonResponse
     */
    public function delete(TenantContract $tenant, Media $media)
    {
        $tenant->media()->where('id', $media->id)->first()->delete();

        return intend([
            'url' => route('adminarea.tenants.media.index', ['tenant' => $tenant]),
            'with' => ['warning' => trans('cortex/tenants::messages.tenant.media_deleted')],
        ]);
    }
}
