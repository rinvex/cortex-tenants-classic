<?php

declare(strict_types=1);

namespace Cortex\Tenantable\Models;

use Rinvex\Tenantable\Tenant as BaseTenant;

/**
 * Rinvex\Tenantable\Tenant.
 *
 * @property int                            $id
 * @property string                         $slug
 * @property array                          $name
 * @property array                          $description
 * @property int                            $owner_id
 * @property string                         $email
 * @property string                         $phone
 * @property string                         $language_code
 * @property string                         $country_code
 * @property string                         $state
 * @property string                         $city
 * @property string                         $address
 * @property string                         $postal_code
 * @property \Carbon\Carbon                 $launch_date
 * @property string                         $website
 * @property string                         $twitter
 * @property string                         $facebook
 * @property string                         $linkedin
 * @property string                         $google_plus
 * @property string                         $skype
 * @property bool                           $active
 * @property string                         $group
 * @property \Carbon\Carbon                 $created_at
 * @property \Carbon\Carbon                 $updated_at
 * @property \Carbon\Carbon                 $deleted_at
 * @property-read \Rinvex\Country\Country   $country
 * @property-read \Rinvex\Language\Language $language
 * @property-read \Cortex\Fort\Models\User  $owner
 *
 * @method static \Illuminate\Database\Query\Builder|\Rinvex\Tenantable\Tenant whereActive($value)
 * @method static \Illuminate\Database\Query\Builder|\Rinvex\Tenantable\Tenant whereAddress($value)
 * @method static \Illuminate\Database\Query\Builder|\Rinvex\Tenantable\Tenant whereCity($value)
 * @method static \Illuminate\Database\Query\Builder|\Rinvex\Tenantable\Tenant whereCountryCode($value)
 * @method static \Illuminate\Database\Query\Builder|\Rinvex\Tenantable\Tenant whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\Rinvex\Tenantable\Tenant whereDeletedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\Rinvex\Tenantable\Tenant whereDescription($value)
 * @method static \Illuminate\Database\Query\Builder|\Rinvex\Tenantable\Tenant whereEmail($value)
 * @method static \Illuminate\Database\Query\Builder|\Rinvex\Tenantable\Tenant whereFacebook($value)
 * @method static \Illuminate\Database\Query\Builder|\Rinvex\Tenantable\Tenant whereGooglePlus($value)
 * @method static \Illuminate\Database\Query\Builder|\Rinvex\Tenantable\Tenant whereGroup($value)
 * @method static \Illuminate\Database\Query\Builder|\Rinvex\Tenantable\Tenant whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\Rinvex\Tenantable\Tenant whereLanguageCode($value)
 * @method static \Illuminate\Database\Query\Builder|\Rinvex\Tenantable\Tenant whereLaunchDate($value)
 * @method static \Illuminate\Database\Query\Builder|\Rinvex\Tenantable\Tenant whereLinkedin($value)
 * @method static \Illuminate\Database\Query\Builder|\Rinvex\Tenantable\Tenant whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\Rinvex\Tenantable\Tenant whereOwnerId($value)
 * @method static \Illuminate\Database\Query\Builder|\Rinvex\Tenantable\Tenant wherePhone($value)
 * @method static \Illuminate\Database\Query\Builder|\Rinvex\Tenantable\Tenant wherePostalCode($value)
 * @method static \Illuminate\Database\Query\Builder|\Rinvex\Tenantable\Tenant whereSkype($value)
 * @method static \Illuminate\Database\Query\Builder|\Rinvex\Tenantable\Tenant whereSlug($value)
 * @method static \Illuminate\Database\Query\Builder|\Rinvex\Tenantable\Tenant whereState($value)
 * @method static \Illuminate\Database\Query\Builder|\Rinvex\Tenantable\Tenant whereTwitter($value)
 * @method static \Illuminate\Database\Query\Builder|\Rinvex\Tenantable\Tenant whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\Rinvex\Tenantable\Tenant whereWebsite($value)
 * @method static \Illuminate\Database\Query\Builder|\Rinvex\Tenantable\Tenant withGroup($group = null)
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
            'name' => 'required|string|max:250',
            'description' => 'nullable|string',
            'slug' => 'required|alpha_dash|max:250|unique:'.config('rinvex.tenantable.tables.tenants').',slug',
            'owner_id' => 'required|integer|exists:'.config('rinvex.fort.tables.users').',id',
            'email' => 'required|email|max:250|unique:'.config('rinvex.tenantable.tables.tenants').',email',
            'phone' => 'nullable|string',
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
