<?php

declare(strict_types=1);

namespace Cortex\Tenantable\Http\Requests\Backend;

use Cortex\Tenantable\Models\Tenant;
use Rinvex\Support\Http\Requests\FormRequest;

class TenantFormRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $tenant = $this->route('tenant') ?? app('rinvex.tenantable.tenant');
        $tenant->updateRulesUniques();

        return $tenant->getRules();
    }
}
