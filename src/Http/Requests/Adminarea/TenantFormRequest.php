<?php

declare(strict_types=1);

namespace Cortex\Tenants\Http\Requests\Adminarea;

use Illuminate\Foundation\Http\FormRequest;

class TenantFormRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Prepare the data for validation.
     *
     * @return void
     */
    protected function prepareForValidation(): void
    {
        $data = $this->all();

        $data['owner_type'] = 'manager';

        $this->replace($data);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        $tenant = $this->route('tenant') ?? app('rinvex.tenants.tenant');
        $tenant->updateRulesUniques();

        return $tenant->getRules();
    }
}
