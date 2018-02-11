<?php

declare(strict_types=1);

namespace Cortex\Tenants\Http\Controllers\Frontarea;

use Cortex\Fort\Models\User;
use Rinvex\Tenants\Models\Tenant;
use Illuminate\Auth\Events\Registered;
use Cortex\Foundation\Http\Controllers\AbstractController;
use Cortex\Tenants\Http\Requests\Frontarea\RegistrationRequest;
use Cortex\Tenants\Http\Requests\Frontarea\RegistrationProcessRequest;

class RegistrationController extends AbstractController
{
    /**
     * Create a new registration controller instance.
     */
    public function __construct()
    {
        parent::__construct();

        $this->middleware($this->getGuestMiddleware(), ['except' => $this->middlewareWhitelist]);
    }

    /**
     * Show the registration form.
     *
     * @param \Cortex\Fort\Http\Requests\Frontarea\RegistrationRequest $request
     *
     * @return \Illuminate\View\View
     */
    public function form(RegistrationRequest $request)
    {
        $countries = collect(countries())->map(function ($country, $code) {
            return [
                'id' => $code,
                'text' => $country['name'],
                'emoji' => $country['emoji'],
            ];
        })->values();
        $languages = collect(languages())->pluck('name', 'iso_639_1');

        return view('cortex/tenants::frontarea.pages.registration', compact('countries', 'languages'));
    }

    /**
     * Process the registration form.
     *
     * @param \Cortex\Fort\Http\Requests\Frontarea\RegistrationProcessRequest $request
     * @param \Cortex\Fort\Models\User                                        $user
     * @param \Cortex\Tenants\Models\Tenant                                   $tenant
     *
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    public function register(RegistrationProcessRequest $request, User $user, Tenant $tenant)
    {
        // Prepare registration data
        $userInput = $request->get('user');

        $user->fill($userInput)->save();

        // Save tenant
        $tenantInput = $request->get('tenant') + ['owner_id' => $user->getKey()];
        $tenant->fill($tenantInput)->save();
        $user->attachTenants($tenant);

        // Fire the register success event
        event(new Registered($user));

        // Send verification if required
        ! config('cortex.fort.emails.verification')
        || app('rinvex.fort.emailverification')->broker()->sendVerificationLink(['email' => $user->email]);

        // Registration completed successfully
        return view('cortex/tenants::frontarea.pages.registration_success', compact('user', 'tenant'));
    }
}
