<?php

namespace App\Scopes;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;
use Illuminate\Database\Eloquent\Builder;

class LanguageScope implements Scope
{
    /**
     * Apply the scope to a given Eloquent query builder.
     * this scope use to colums with user use language
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $builder
     * @param  \Illuminate\Database\Eloquent\Model  $model
     * @return void
     */
    public function apply(Builder $builder, Model $model)
    {
        $fillable = $model->getFillable();

        $select = GetAttributesWithCurrentLanguage($fillable);

        $builder->select($select);
    }
}
