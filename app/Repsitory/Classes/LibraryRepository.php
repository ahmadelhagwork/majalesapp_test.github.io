<?php

namespace App\Repsitory\Classes;

use App\Models\Library;
use App\Repsitory\InterFaces\ILibraryRepository;

class LibraryRepository extends BaseRepository implements ILibraryRepository
{
    /**
     * Create a new repository instance
     *
     * @return void
     */
    public function __construct(Library $model)
    {
        parent::__construct($model);
    }
}
