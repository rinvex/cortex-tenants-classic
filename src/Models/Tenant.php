<?php

declare(strict_types=1);

namespace Cortex\Tenants\Models;

use Cortex\Foundation\Traits\Auditable;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Spatie\Activitylog\Traits\LogsActivity;
use Rinvex\Tenants\Models\Tenant as BaseTenant;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;

/**
 * Cortex\Tenants\Models\Tenant.
 *
 * @property int                                                                           $id
 * @property string                                                                        $name
 * @property array                                                                         $title
 * @property array                                                                         $description
 * @property int                                                                           $user_id
 * @property string                                                                        $user_type
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
 * @property string                                                                        $style
 * @property \Carbon\Carbon|null                                                           $created_at
 * @property \Carbon\Carbon|null                                                           $updated_at
 * @property \Carbon\Carbon|null                                                           $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\Cortex\Foundation\Models\Log[] $activity
 * @property-read \Illuminate\Database\Eloquent\Model|\Eloquent                            $user
 *
 * @method static \Illuminate\Database\Eloquent\Builder|\Rinvex\Tenants\Models\Tenant ofUser(\Illuminate\Database\Eloquent\Model $user)
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
 * @method static \Illuminate\Database\Eloquent\Builder|\Cortex\Tenants\Models\Tenant whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Cortex\Tenants\Models\Tenant whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Cortex\Tenants\Models\Tenant whereUserType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Cortex\Tenants\Models\Tenant wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Cortex\Tenants\Models\Tenant wherePostalCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Cortex\Tenants\Models\Tenant whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Cortex\Tenants\Models\Tenant whereState($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Cortex\Tenants\Models\Tenant whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Cortex\Tenants\Models\Tenant whereStyle($value)
 * @mixin \Eloquent
 */
class Tenant extends BaseTenant implements HasMedia
{
    use Auditable;
    use LogsActivity;
    use HasMediaTrait;

    /**
     * {@inheritdoc}
     */
    protected $fillable = [
        'name',
        'title',
        'description',
        'user_id',
        'user_type',
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
        'name' => 'string',
        'user_id' => 'integer',
        'user_type' => 'string',
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
    protected static $logFillable = true;

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

        $this->setTable(config('rinvex.tenants.tables.tenants'));
        $this->setRules([
            'name' => 'required|alpha_dash|max:150|unique:'.config('rinvex.tenants.tables.tenants').',name',
            'title' => 'required|string|max:150',
            'description' => 'nullable|string|max:10000',
            'user_id' => 'required|integer',
            'user_type' => 'required|string',
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
        ]);
    }

    /**
     * Get the route key for the model.
     *
     * @return string
     */
    public function getRouteKeyName(): string
    {
        return 'name';
    }
}
