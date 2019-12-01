<?php

namespace App\Models;

use App\Constants\Database;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * App\Models\EventMember
 *
 * @property int $id
 * @property int $user_id
 * @property int $event_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\EventMember newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\EventMember newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\EventMember query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\EventMember whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\EventMember whereEventId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\EventMember whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\EventMember whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\EventMember whereUserId($value)
 * @mixin \Eloquent
 */
class EventMember extends Model
{
    protected $table = Database::EVENT_MEMBERS;

    protected $fillable = [
        'user_id',
        'event_id'
    ];

    public function event(): HasOne
    {
        return  $this->hasOne(Database::EVENTS);
    }
}
