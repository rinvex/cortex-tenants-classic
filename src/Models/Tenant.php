<?php

declare(strict_types=1);

namespace Cortex\Tenants\Models;

use Rinvex\Tags\Traits\Taggable;
use Vinkla\Hashids\Facades\Hashids;
use Cortex\Foundation\Traits\Auditable;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Spatie\Activitylog\Traits\LogsActivity;
use Rinvex\Tenants\Models\Tenant as BaseTenant;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

/**
 * Cortex\Tenants\Models\Tenant.
 *
 * @property int                                                                           $id
 * @property string                                                                        $name
 * @property array                                                                         $title
 * @property array                                                                         $description
 * @property int                                                                           $owner_id
 * @property string                                                                        $owner_type
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
 * @property-read \Illuminate\Database\Eloquent\Model|\Eloquent                            $owner
 *
 * @method static \Illuminate\Database\Eloquent\Builder|\Cortex\Tenants\Models\Tenant ofOwner(\Illuminate\Database\Eloquent\Model $owner)
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
 * @method static \Illuminate\Database\Eloquent\Builder|\Cortex\Tenants\Models\Tenant whereOwnerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Cortex\Tenants\Models\Tenant whereOwnerType($value)
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
    use Taggable;
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
        'owner_id',
        'owner_type',
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
        'owner_id' => 'integer',
        'owner_type' => 'string',
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
            'owner_id' => 'required|integer',
            'owner_type' => 'required|string',
            'email' => 'required|email|min:3|max:150|unique:'.config('rinvex.tenants.tables.tenants').',email',
            'website' => 'nullable|string|max:150',
            'phone' => 'nullable|numeric|phone',
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
            'tags' => 'nullable|array',
        ]);
    }

    /**
     * Get the value of the model's route key.
     *
     * @return mixed
     */
    public function getRouteKey()
    {
        return Hashids::encode($this->getAttribute($this->getRouteKeyName()));
    }

    /**
     * Retrieve the model for a bound value.
     *
     * @param mixed $value
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function resolveRouteBinding($value)
    {
        $value = Hashids::decode($value)[0];

        return $this->where($this->getRouteKeyName(), $value)->first();
    }

    /**
     * Register media collections.
     *
     * @return void
     */
    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('profile_picture')->singleFile();
        $this->addMediaCollection('cover_photo')->singleFile();
    }

    /**
     * Get all attached managers to tenant.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphToMany
     */
    public function managers(): MorphToMany
    {
        return $this->entries(config('cortex.auth.models.manager'));
    }
}
