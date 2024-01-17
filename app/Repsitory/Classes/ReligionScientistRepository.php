<?php

namespace App\Repsitory\Classes;

use App\Models\ReligionScientist;
use App\Repsitory\InterFaces\IReligionScientistRepository;

class ReligionScientistRepository extends BaseRepository implements IReligionScientistRepository
{
    /**
     * Create a new repository instance
     *
     * @return void
     */
    public function __construct(ReligionScientist $model)
    {
        parent::__construct($model);
    }
}
