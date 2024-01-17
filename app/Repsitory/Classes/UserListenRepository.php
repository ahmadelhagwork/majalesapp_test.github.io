<?php

namespace App\Repsitory\Classes;

use App\Models\UserListen;
use App\Repsitory\InterFaces\IUserListenRepository;

class UserListenRepository extends BaseRepository implements IUserListenRepository
{
    /**
     * Create a new repository instance
     *
     * @return void
     */
    public function __construct(UserListen $model)
    {
        parent::__construct($model);
    }
}
