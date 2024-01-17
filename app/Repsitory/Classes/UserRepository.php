<?php

namespace App\Repsitory\Classes;

use App\Models\User;
use App\Repsitory\InterFaces\IUserRepository;

class UserRepository extends BaseRepository implements IUserRepository
{
    /**
     * Create a new repository instance
     *
     * @return void
     */
    public function __construct(User $model)
    {
        parent::__construct($model);
    }
}
