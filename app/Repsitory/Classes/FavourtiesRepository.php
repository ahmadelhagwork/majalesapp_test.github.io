<?php

namespace App\Repsitory\Classes;

use App\Models\Favourties;
use App\Repsitory\InterFaces\IFavourtiesRepository;

class FavourtiesRepository extends BaseRepository implements IFavourtiesRepository
{

    /**
     * Create a new repository instance
     *
     * @return void
     */
    public function __construct(Favourties $model)
    {
        parent::__construct($model);
    }
}
