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
 * @property string                                                                        $website
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
 * @property string                                                                        $thumbnail
 * @property string                                                                        $cover_photo
 * @property string                                                                        $style
 * @property \Carbon\Carbon|null                                                           $created_at
 * @property \Carbon\Carbon|null                                                           $updated_at
 * @property \Carbon\Carbon|null                                                           $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\Cortex\Foundation\Models\Log[] $activity
 * @property-read \Cortex\Fort\Models\User                                                 $owner
 *
 * @method static \Illuminate\Database\Eloquent\Builder|\Cortex\Tenants\Models\Tenant active()
 * @method static \Illuminate\Database\Eloquent\Builder|\Cortex\Tenants\Models\Tenant inactive()
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
 * @method static \Illuminate\Database\Eloquent\Builder|\Cortex\Tenants\Models\Tenant whereStyle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Cortex\Tenants\Models\Tenant withGroup($group)
 * @mixin \Eloquent
 */
class Tenant extends BaseTenant
{
    use LogsActivity;

    /**
     * {@inheritdoc}
     */
    protected $fillable = [
        'slug',
        'name',
        'description',
        'owner_id',
        'email',
        'website',
        'phone',
        'language_code',
        'country_code',
        'state',
        'city',
        'address',
        'postal_code',
        'launch_date',
        'group',
        'style',
        'is_active',
    ];

    /**
     * {@inheritdoc}
     */
    protected $casts = [
        'slug' => 'string',
        'owner_id' => 'integer',
        'email' => 'string',
        'website' => 'string',
        'phone' => 'string',
        'country_code' => 'string',
        'language_code' => 'string',
        'state' => 'string',
        'city' => 'string',
        'address' => 'string',
        'postal_code' => 'string',
        'launch_date' => 'string',
        'group' => 'string',
        'style' => 'string',
        'is_active' => 'boolean',
        'thumbnail' => 'string',
        'cover_photo' => 'string',
        'deleted_at' => 'datetime',
    ];

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
        'website',
        'phone',
        'language_code',
        'country_code',
        'state',
        'city',
        'address',
        'postal_code',
        'launch_date',
        'group',
        'style',
        'is_active',
        'thumbnail',
        'cover_photo',
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
     * Create a new Eloquent model instance.
     *
     * @param array $attributes
     */
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        // Get users model
        $userModel = config('auth.providers.'.config('auth.guards.'.config('auth.defaults.guard').'.provider').'.model');

        $this->setTable(config('rinvex.tenants.tables.tenants'));
        $this->setRules([
            'slug' => 'required|alpha_dash|max:150|unique:'.config('rinvex.tenants.tables.tenants').',slug',
            'name' => 'required|string|max:150',
            'description' => 'nullable|string|max:10000',
            'owner_id' => 'required|integer|exists:'.(new $userModel())->getTable().',id',
            'email' => 'required|email|min:3|max:150|unique:'.config('rinvex.tenants.tables.tenants').',email',
            'website' => 'nullable|string|max:150',
            'phone' => 'nullable|numeric|min:4',
            'country_code' => 'required|alpha|size:2|country',
            'language_code' => 'required|alpha|size:2|language',
            'state' => 'nullable|string',
            'city' => 'nullable|string',
            'address' => 'nullable|string',
            'postal_code' => 'nullable|string',
            'launch_date' => 'nullable|date_format:Y-m-d',
            'group' => 'nullable|string|max:150',
            'style' => 'nullable|string|max:150',
            'is_active' => 'sometimes|boolean',
            'thumbnail' => 'nullable|string|max:150',
            'cover_photo' => 'nullable|string|max:150',
        ]);
    }

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
