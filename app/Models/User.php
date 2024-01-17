<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = ['id', 'name', 'email', 'password', 'remember_token', 'facebook_id', 'google_id', 'email_verified_at'];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'password' => 'hashed',
    ];
    /**
     * Indicates if the IDs are auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = false;
    // Rest omitted for brevity

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }
    /**
     * Library
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function Library()
    {
        return $this->belongsToMany(Library::class, 'favourties', 'user_id', 'library_id');
    }
    /**
     * Council
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function Council()
    {
        return $this->hasMany(Council::class, 'user_id');
    }
    /**
     * UserListen
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function UserListen()
    {
        return $this->hasMany(UserListen::class, 'user_id');
    }
}
