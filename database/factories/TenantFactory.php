<?php

declare(strict_types=1);

namespace Cortex\Tenants\Database\Factories;

use Cortex\Tenants\Models\Tenant;
use Illuminate\Database\Eloquent\Factories\Factory;

class TenantFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Tenant::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->company,
            'slug' => $this->faker->slug,
            'email' => $this->faker->companyEmail,
            'language_code' => $this->faker->languageCode,
            'country_code' => $this->faker->countryCode,
        ];
    }
}
