<?php

declare(strict_types=1);

namespace Cortex\Tenantable\Models;

use Rinvex\Tenantable\Tenant as BaseTenant;

/**
 * Cortex\Tenantable\Models\Tenant.
 *
 * @property int                            $id
 * @property string                         $slug
 * @property array                          $name
 * @property array                          $description
 * @property int                            $owner_id
 * @property string                         $email
 * @property string|null                    $phone
 * @property string                         $language_code
 * @property string                         $country_code
 * @property string|null                    $state
 * @property string|null                    $city
 * @property string|null                    $address
 * @property string|null                    $postal_code
 * @property \Carbon\Carbon|null            $launch_date
 * @property string|null                    $website
 * @property string|null                    $twitter
 * @property string|null                    $facebook
 * @property string|null                    $linkedin
 * @property string|null                    $google_plus
 * @property string|null                    $skype
 * @property string|null                    $group
 * @property int                            $is_active
 * @property \Carbon\Carbon|null            $created_at
 * @property \Carbon\Carbon|null            $updated_at
 * @property \Carbon\Carbon|null            $deleted_at
 * @property-read \Rinvex\Country\Country   $country
 * @property-read \Rinvex\Language\Language $language
 * @property-read \Cortex\Fort\Models\User  $owner
 *
 * @method static \Illuminate\Database\Eloquent\Builder|\Cortex\Tenantable\Models\Tenant whereAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Cortex\Tenantable\Models\Tenant whereCity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Cortex\Tenantable\Models\Tenant whereCountryCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Cortex\Tenantable\Models\Tenant whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Cortex\Tenantable\Models\Tenant whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Cortex\Tenantable\Models\Tenant whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Cortex\Tenantable\Models\Tenant whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Cortex\Tenantable\Models\Tenant whereFacebook($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Cortex\Tenantable\Models\Tenant whereGooglePlus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Cortex\Tenantable\Models\Tenant whereGroup($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Cortex\Tenantable\Models\Tenant whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Cortex\Tenantable\Models\Tenant whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Cortex\Tenantable\Models\Tenant whereLanguageCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Cortex\Tenantable\Models\Tenant whereLaunchDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Cortex\Tenantable\Models\Tenant whereLinkedin($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Cortex\Tenantable\Models\Tenant whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Cortex\Tenantable\Models\Tenant whereOwnerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Cortex\Tenantable\Models\Tenant wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Cortex\Tenantable\Models\Tenant wherePostalCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Cortex\Tenantable\Models\Tenant whereSkype($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Cortex\Tenantable\Models\Tenant whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Cortex\Tenantable\Models\Tenant whereState($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Cortex\Tenantable\Models\Tenant whereTwitter($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Cortex\Tenantable\Models\Tenant whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Cortex\Tenantable\Models\Tenant whereWebsite($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Rinvex\Tenantable\Tenant withGroup($group = null)
 * @mixin \Eloquent
 */
class Tenant extends BaseTenant
{
    /**
     * Create a new Eloquent model instance.
     *
     * @param array $attributes
     */
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        $this->setRules([
            'name' => 'required|string|max:150',
            'description' => 'nullable|string',
            'slug' => 'required|alpha_dash|max:150|unique:'.config('rinvex.tenantable.tables.tenants').',slug',
            'owner_id' => 'required|integer|exists:'.config('rinvex.fort.tables.users').',id',
            'email' => 'required|email|min:3|max:150|unique:'.config('rinvex.tenantable.tables.tenants').',email',
            'phone' => 'nullable|numeric|min:4',
            'language_code' => 'required|string|size:2',
            'country_code' => 'required|string|size:2',
        ]);
    }

    /**
     * A tenant always belongs to an owner.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function owner()
    {
        $userModel = config('auth.providers.'.config('auth.guards.'.config('auth.defaults.guard').'.provider').'.model');

        return $this->belongsTo($userModel, 'owner_id', 'id');
    }
}
