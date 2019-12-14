<?php

namespace App\Repository;

use App\Models\Event;
use Prettus\Repository\Eloquent\BaseRepository;

class EventRepository extends BaseRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Event::class;
    }
}
