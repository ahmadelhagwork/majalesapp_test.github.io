<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Library extends Model
{
    use HasFactory, SoftDeletes;
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'libraries';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['id', 'file', 'religion_scientist_id', 'prayer_id', 'deleted_at', 'created_at', 'updated_at'];
    /**
     * Indicates if the IDs are auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = false;
    /**
     * User
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function User()
    {
        return $this->belongsToMany(User::class, 'favourties', 'user_id', 'library_id');
    }
    /**
     * Council
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function Council()
    {
        return $this->belongsToMany(Council::class, 'user_libaries', 'council_id', 'library_id');
    }
}
