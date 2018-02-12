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
    protected function prepareForValidation(): void
    {
        $data = $this->all();

        $role = app('cortex.fort.role')->where('slug', 'manager')->first();
        $data['user']['is_active'] = ! config('cortex.fort.registration.moderated');
        ! $role || $data['user']['roles'] = [$role->getKey()];

        $this->replace($data);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        $userRules = app('cortex.fort.user')->getRules();
        $userRules['password'] = 'required|confirmed|min:'.config('cortex.fort.password_min_chars');
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

        // We set user_id and user_type fields in the controller
        unset($tenantRules['tenant.user_id'], $tenantRules['tenant.user_type']);

        return array_merge($userRules, $tenantRules);
    }
}
