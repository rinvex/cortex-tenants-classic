<?php

declare(strict_types=1);

namespace Cortex\Tenants\Http\Requests\Managerarea;

use Rinvex\Support\Traits\Escaper;
use Cortex\Foundation\Http\FormRequest;

class TenantFormRequest extends FormRequest
{
    use Escaper;

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
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        $tenant = app('request.tenant');
        $tenant->updateRulesUniques();

        return $tenant->getRules();
    }
}
