<?php

declare(strict_types=1);

namespace Cortex\Tenants\Http\Requests\Frontarea;

class RegistrationProcessRequest extends RegistrationRequest
{
    /**
     * Prepare the data for validation.
     *
     * @return void
     */
    protected function prepareForValidation()
    {
        $data = $this->all();

        $role = app('rinvex.fort.role')->where('slug', 'manager')->first();
        $data['user']['is_active'] = ! config('rinvex.fort.registration.moderated');
        ! $role || $data['user']['roles'] = [$role->getKey()];

        $this->replace($data);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $userRules = app('rinvex.fort.user')->getRules();
        $userRules['password'] = 'required|confirmed|min:'.config('rinvex.fort.password_min_chars');
        $userRules = array_combine(
            array_map(function ($key) {
                return 'user.'.$key;
            }, array_keys($userRules)), $userRules
        );

        $tenantRules = app('rinvex.tenants.tenant')->getRules();
        $tenantRules = array_combine(
            array_map(function ($key) {
                return 'tenant.'.$key;
            }, array_keys($tenantRules)), $tenantRules
        );

        // We set owner_id in the controller
        unset($tenantRules['tenant.owner_id']);

        return array_merge($userRules, $tenantRules);
    }
}
