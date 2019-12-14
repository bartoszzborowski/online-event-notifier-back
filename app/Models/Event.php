<?php

namespace App\Models;

use App\Constants\Database;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * App\Models\Event
 *
 * @property int $id
 * @property int $user_id
 * @property int $event_type
 * @property int $city_id
 * @property string $address
 * @property string $name
 * @property string $description
 * @property float $fee
 * @property string $event_date
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Event newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Event newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Event query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Event whereAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Event whereCityId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Event whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Event whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Event whereEventDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Event whereEventType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Event whereFee($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Event whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Event whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Event whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Event whereUserId($value)
 * @mixin \Eloquent
 */
class Event extends Model
{
    protected $table = Database::EVENTS;

    protected $casts = [
        'event_date' => 'datetime',
        'fee' => 'float',
    ];

    protected $fillable =[
        'user_id',
        'event_type',
        'city_id',
        'address',
        'name',
        'description',
        'fee',
        'event_date',
        'lat',
        'lng',
    ];

    public function user(): HasOne
    {
        return $this->hasOne(Database::USERS);
    }

    public function eventType() :HasOne
    {
        return $this->hasOne(Database::EVENT_TYPES);
    }

    public function members(): HasMany
    {
        return $this->hasMany(EventMember::class);
    }

    public function userMembers(): HasManyThrough
    {
        return $this->hasManyThrough(EventMember::class, User::class);
    }
}
