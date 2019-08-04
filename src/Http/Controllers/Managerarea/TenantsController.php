<?php

declare(strict_types=1);

namespace Cortex\Tenants\Http\Controllers\Managerarea;

use Exception;
use Cortex\Tenants\Models\Tenant;
use Illuminate\Foundation\Http\FormRequest;
use Cortex\Foundation\Http\Controllers\AuthenticatedController;

class TenantsController extends AuthenticatedController
{
    /**
     * {@inheritdoc}
     */
    protected $resource = Tenant::class;
    /**
     * Show tenant create/edit form.
     *
     * @param \Cortex\Tenants\Models\Tenant $tenant
     *
     * @return \Illuminate\View\View
     */
    protected function form()
    {
        $tenant = config('rinvex.tenants.active');
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
     * Process stored/updated tenant.
     *
     * @param \Cortex\Tenants\Http\Requests\Managerarea\TenantFormRequest $request
     * @param \Cortex\Tenants\Models\Tenant                               $tenant
     *
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    protected function process(TenantFormRequest $request)
    {
        $tenant = config('rinvex.tenants.active');
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
            'with' => ['success' => trans('cortex/foundation::messages.resource_saved', ['resource' => trans('cortex/tenants::common.tenant'), 'identifier' => $tenant->name])],
        ]);
    }

}
