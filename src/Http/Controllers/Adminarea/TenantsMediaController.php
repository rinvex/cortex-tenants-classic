<?php

declare(strict_types=1);

namespace Cortex\Tenants\Http\Controllers\Adminarea;

use Illuminate\Support\Str;
use Cortex\Tenants\Models\Tenant;
use Cortex\Foundation\DataTables\MediaDataTable;
use Cortex\Foundation\Http\Requests\ImageFormRequest;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Cortex\Foundation\Http\Controllers\AuthorizedController;

class TenantsMediaController extends AuthorizedController
{
    /**
     * {@inheritdoc}
     */
    protected $resource = Tenant::class;

    /**
     * {@inheritdoc}
     */
    public function authorizeResource($model, $parameter = null, array $options = [], $request = null): void
    {
        $middleware = [];
        $parameter = $parameter ?: Str::snake(class_basename($model));

        foreach ($this->mapResourceAbilities() as $method => $ability) {
            $modelName = in_array($method, $this->resourceMethodsWithoutModels()) ? $model : $parameter;

            $middleware["can:update,{$modelName}"][] = $method;
            $middleware["can:{$ability},media"][] = $method;
        }

        foreach ($middleware as $middlewareName => $methods) {
            $this->middleware($middlewareName, $options)->only($methods);
        }
    }

    /**
     * List tenant media.
     *
     * @param \Cortex\Tenants\Models\Tenant                $tenant
     * @param \Cortex\Foundation\DataTables\MediaDataTable $mediaDataTable
     *
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    public function index(Tenant $tenant, MediaDataTable $mediaDataTable)
    {
        return $mediaDataTable->with([
            'resource' => $tenant,
            'tabs' => 'adminarea.cortex.tenants.tenants.tabs',
            'id' => "adminarea-cortex-tenants-tenants-{$tenant->getRouteKey()}-media",
            'url' => route('adminarea.cortex.tenants.tenants.media.store', ['tenant' => $tenant]),
        ])->render('cortex/foundation::adminarea.pages.datatable-dropzone');
    }

    /**
     * Store new tenant media.
     *
     * @param \Cortex\Foundation\Http\Requests\ImageFormRequest $request
     * @param \Cortex\Tenants\Models\Tenant                     $tenant
     *
     * @return void
     */
    public function store(ImageFormRequest $request, Tenant $tenant): void
    {
        $tenant->addMediaFromRequest('file')
               ->sanitizingFileName(function ($fileName) {
                   return md5($fileName).'.'.pathinfo($fileName, PATHINFO_EXTENSION);
               })
               ->toMediaCollection('default', config('cortex.tenants.media.disk'));
    }

    /**
     * Destroy given tenant media.
     *
     * @param \Cortex\Tenants\Models\Tenant                      $tenant
     * @param \Spatie\MediaLibrary\MediaCollections\Models\Media $media
     *
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    public function destroy(Tenant $tenant, Media $media)
    {
        $tenant->media()->where($media->getKeyName(), $media->getKey())->first()->delete();

        return intend([
            'url' => route('adminarea.cortex.tenants.tenants.media.index', ['tenant' => $tenant]),
            'with' => ['warning' => trans('cortex/foundation::messages.resource_deleted', ['resource' => trans('cortex/foundation::common.media'), 'identifier' => $media->getRouteKey()])],
        ]);
    }
}
