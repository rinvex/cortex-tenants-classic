<?php

declare(strict_types=1);

namespace Cortex\Tenants\Http\Controllers\Frontarea;

use Rinvex\Fort\Contracts\UserContract;
use Cortex\Foundation\Http\Controllers\AbstractController;
use Cortex\Tenants\Http\Requests\Frontarea\RegistrationRequest;
use Cortex\Tenants\Http\Requests\Frontarea\RegistrationProcessRequest;
use Rinvex\Tenants\Contracts\TenantContract;

class RegistrationController extends AbstractController
{
    /**
     * Create a new registration controller instance.
     */
    public function __construct()
    {
        $this->middleware($this->getGuestMiddleware(), ['except' => $this->middlewareWhitelist]);
    }

    /**
     * Show the registration form.
     *
     * @param \Cortex\Fort\Http\Requests\Frontarea\RegistrationRequest $request
     *
     * @return \Illuminate\Http\Response|\Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    public function form(RegistrationRequest $request)
    {
        $countries = countries();
        $languages = collect(languages())->pluck('name', 'iso_639_1');

        return view('cortex/tenants::frontarea.pages.registration', compact('countries', 'languages'));
    }

    /**
     * Process the registration form.
     *
     * @param \Cortex\Fort\Http\Requests\Frontarea\RegistrationProcessRequest $request
     * @param \Rinvex\Fort\Contracts\UserContract                             $user
     * @param \Rinvex\Tenants\Contracts\TenantContract                        $tenant
     *
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    public function register(RegistrationProcessRequest $request, UserContract $user, TenantContract $tenant)
    {
        // Prepare registration data
        $userInput = $request->get('user');

        // Fire the register start event
        event('rinvex.fort.register.start', [$userInput]);

        $user->fill($userInput)->save();

        // Save hub
        $tenantInput = $request->get('tenant') + ['owner_id' => $user->id];
        $tenant->fill($tenantInput)->save();

        // Fire the register success event
        event('rinvex.fort.register.success', [$user]);

        // Send verification if required
        ! config('rinvex.fort.emailverification.required')
        || app('rinvex.fort.emailverification')->broker()->sendVerificationLink(['email' => $user->email]);

        // Registration completed successfully
        return view('cortex/tenants::frontarea.pages.registration_success', compact('user', 'tenant'));
    }
}
