<?php

declare(strict_types=1);

namespace Cortex\Tenants\Http\Controllers\Managerarea;

use Illuminate\Http\Request;
use Cortex\Tenants\Models\Tenant;
use Cortex\Foundation\Http\Controllers\AuthorizedController;
use Cortex\Tenants\Http\Requests\Managerarea\TenantFormRequest;

class TenantsController extends AuthorizedController
{
    /**
     * {@inheritdoc}
     */
    protected $resource = 'update-tenant';

    /**
     * Edit given tenant.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\View\View
     */
    public function edit(Request $request)
    {
        $tenant = app('request.tenant');

        return $this->form($request, $tenant);
    }

    /**
     * Show tenant edit form.
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

        return view('cortex/tenants::managerarea.pages.tenant', compact('tenant', 'countries', 'languages', 'tags'));
    }

    /**
     * Update given tenant.
     *
     * @param \Cortex\Tenants\Http\Requests\Managerarea\TenantFormRequest $request
     *
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    public function update(TenantFormRequest $request)
    {
        $tenant = app('request.tenant');

        return $this->process($request, $tenant);
    }

    /**
     * Process stored/updated tenant.
     *
     * @param \Illuminate\Http\Request      $request
     * @param \Cortex\Tenants\Models\Tenant $tenant
     *
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    protected function process(Request $request, Tenant $tenant)
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

        return intend([
            'back' => true,
            'with' => ['success' => trans('cortex/foundation::messages.resource_saved', ['resource' => trans('cortex/tenants::common.tenant'), 'identifier' => $tenant->getRouteKey()])],
        ]);
    }
}
