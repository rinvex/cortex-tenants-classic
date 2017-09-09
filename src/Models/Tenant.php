<?php

declare(strict_types=1);

namespace Cortex\Tenants\Models;

use Spatie\Activitylog\Traits\LogsActivity;
use Rinvex\Tenants\Models\Tenant as BaseTenant;

/**
 * Cortex\Tenants\Models\Tenant.
 *
 * @property int                                                                           $id
 * @property string                                                                        $slug
 * @property array                                                                         $name
 * @property array                                                                         $description
 * @property int                                                                           $owner_id
 * @property string                                                                        $email
 * @property string                                                                        $phone
 * @property string                                                                        $language_code
 * @property string                                                                        $country_code
 * @property string                                                                        $state
 * @property string                                                                        $city
 * @property string                                                                        $address
 * @property string                                                                        $postal_code
 * @property string                                                                        $launch_date
 * @property string                                                                        $group
 * @property bool                                                                          $is_active
 * @property \Carbon\Carbon                                                                $created_at
 * @property \Carbon\Carbon                                                                $updated_at
 * @property \Carbon\Carbon                                                                $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\Cortex\Foundation\Models\Log[] $activity
 * @property-read \Cortex\Fort\Models\User                                                 $owner
 *
 * @method static \Illuminate\Database\Eloquent\Builder|\Rinvex\Tenants\Models\Tenant active()
 * @method static \Illuminate\Database\Eloquent\Builder|\Rinvex\Tenants\Models\Tenant inactive()
 * @method static \Illuminate\Database\Eloquent\Builder|\Cortex\Tenants\Models\Tenant whereAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Cortex\Tenants\Models\Tenant whereCity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Cortex\Tenants\Models\Tenant whereCountryCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Cortex\Tenants\Models\Tenant whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Cortex\Tenants\Models\Tenant whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Cortex\Tenants\Models\Tenant whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Cortex\Tenants\Models\Tenant whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Cortex\Tenants\Models\Tenant whereGroup($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Cortex\Tenants\Models\Tenant whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Cortex\Tenants\Models\Tenant whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Cortex\Tenants\Models\Tenant whereLanguageCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Cortex\Tenants\Models\Tenant whereLaunchDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Cortex\Tenants\Models\Tenant whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Cortex\Tenants\Models\Tenant whereOwnerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Cortex\Tenants\Models\Tenant wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Cortex\Tenants\Models\Tenant wherePostalCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Cortex\Tenants\Models\Tenant whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Cortex\Tenants\Models\Tenant whereState($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Cortex\Tenants\Models\Tenant whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Rinvex\Tenants\Models\Tenant withGroup($group = null)
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

    /**
     * Get the route key for the model.
     *
     * @return string
     */
    public function getRouteKeyName()
    {
        return 'slug';
    }
}
