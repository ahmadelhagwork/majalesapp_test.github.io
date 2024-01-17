<?php

namespace App\Models;

use App\Scopes\LanguageScope;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Prayers extends Model
{
    use HasFactory, SoftDeletes;
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'prayers';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['id', 'name_ar', 'name_en', 'deleted_at', 'created_at', 'updated_at'];
    /**
     * Indicates if the IDs are auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = false;
    /**
     * The "booting" method of the model.
     *
     * @return void
     */
    protected static function booted()
    {
        parent::boot();

        static::addGlobalScope(new LanguageScope);
    }
    /**
     * ReligionScientist
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function ReligionScientist()
    {
        return $this->belongsToMany(ReligionScientist::class, 'libraries', 'religion_scientist_id', 'prayer_id');
    }
}
