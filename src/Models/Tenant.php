<?php

declare(strict_types=1);

namespace Cortex\Tenantable\Models;

use Rinvex\Tenantable\Tenant as BaseTenant;
use Spatie\Activitylog\Traits\LogsActivity;

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
 * @method static \Illuminate\Database\Eloquent\Builder|\Cortex\Tenantable\Models\Tenant whereGroup($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Cortex\Tenantable\Models\Tenant whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Cortex\Tenantable\Models\Tenant whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Cortex\Tenantable\Models\Tenant whereLanguageCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Cortex\Tenantable\Models\Tenant whereLaunchDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Cortex\Tenantable\Models\Tenant whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Cortex\Tenantable\Models\Tenant whereOwnerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Cortex\Tenantable\Models\Tenant wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Cortex\Tenantable\Models\Tenant wherePostalCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Cortex\Tenantable\Models\Tenant whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Cortex\Tenantable\Models\Tenant whereState($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Cortex\Tenantable\Models\Tenant whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Rinvex\Tenantable\Tenant withGroup($group = null)
 * @mixin \Eloquent
 */
class Tenant extends BaseTenant
{
    use LogsActivity;

    /**
     * Indicates whether to log only dirty attributes or all.
     *
     * @var bool
     */
    protected static $logOnlyDirty = true;

    /**
     * The attributes that are logged on change.
     *
     * @var array
     */
    protected static $logAttributes = [
        'slug',
        'name',
        'description',
        'owner_id',
        'email',
        'phone',
        'language_code',
        'country_code',
        'state',
        'city',
        'address',
        'postal_code',
        'launch_date',
        'group',
        'is_active',
    ];

    /**
     * The attributes that are ignored on change.
     *
     * @var array
     */
    protected static $ignoreChangedAttributes = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];
}
