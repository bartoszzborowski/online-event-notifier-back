<?php

namespace App\Repository;

use App\Models\User;
use Prettus\Repository\Eloquent\BaseRepository;

class EventMemberRepository extends BaseRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return User::class;
    }
}
