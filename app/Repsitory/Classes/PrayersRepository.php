<?php

namespace App\Repsitory\Classes;

use App\Models\Prayers;
use App\Repsitory\InterFaces\IPrayersRepository;

class PrayersRepository extends BaseRepository implements IPrayersRepository
{
    /**
     * Create a new repository instance
     *
     * @return void
     */
    public function __construct(Prayers $model)
    {
        parent::__construct($model);
    }
}
