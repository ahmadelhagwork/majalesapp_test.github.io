<?php

namespace App\Repsitory\Classes;

use App\Models\Council;
use App\Repsitory\InterFaces\ICouncilRepository;

class CouncilRepository extends BaseRepository implements ICouncilRepository
{
    /**
     * Create a new repository instance
     *
     * @return void
     */
    public function __construct(Council $model)
    {
        parent::__construct($model);
    }
}
