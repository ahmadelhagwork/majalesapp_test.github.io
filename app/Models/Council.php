<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Council extends Model
{
    use HasFactory, SoftDeletes;
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'councils';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['id', 'name', 'photo', 'user_id', 'deleted_at', 'created_at', 'updated_at'];
    /**
     * Indicates if the IDs are auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = false;
    /**
     * User
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function User()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    /**
     * Libary
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function Libary()
    {
        return $this->belongsToMany(Library::class, 'user_libaries', 'council_id', 'library_id');
    }
}
