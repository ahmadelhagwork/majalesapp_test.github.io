<?php

namespace App\Repsitory\Classes;

use App\Models\UserLibary;
use App\Repsitory\InterFaces\IUserLibaryRepository;

class UserLibaryRepository extends BaseRepository implements IUserLibaryRepository
{
    /**
     * Create a new repository instance
     *
     * @return void
     */
    public function __construct(UserLibary $model)
    {
        parent::__construct($model);
    }
}
