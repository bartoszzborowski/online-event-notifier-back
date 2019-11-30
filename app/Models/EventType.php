<?php

namespace App\Models;

use App\Constants\Database;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\EventType
 *
 * @property int $id
 * @property string $name
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\EventType newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\EventType newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\EventType query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\EventType whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\EventType whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\EventType whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\EventType whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class EventType extends Model
{
    protected $table = Database::EVENT_TYPES;

    protected $fillable = [
      'name'
    ];
}
