<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Repsitory\Classes\BaseRepository;
use App\Repsitory\Classes\CouncilRepository;
use App\Repsitory\Classes\FavourtiesRepository;
use App\Repsitory\Classes\LibraryRepository;
use App\Repsitory\Classes\PrayersRepository;
use App\Repsitory\Classes\ReligionScientistRepository;
use App\Repsitory\Classes\UserLibaryRepository;
use App\Repsitory\Classes\UserListenRepository;
use App\Repsitory\Classes\UserRepository;
use App\Repsitory\InterFaces\IBaseRepository;
use App\Repsitory\InterFaces\ICouncilRepository;
use App\Repsitory\InterFaces\IFavourtiesRepository;
use App\Repsitory\InterFaces\ILibraryRepository;
use App\Repsitory\InterFaces\IPrayersRepository;
use App\Repsitory\InterFaces\IReligionScientistRepository;
use App\Repsitory\InterFaces\IUserLibaryRepository;
use App\Repsitory\InterFaces\IUserListenRepository;
use App\Repsitory\InterFaces\IUserRepository;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $binds =
            [
                IBaseRepository::class => BaseRepository::class,
                IUserRepository::class => UserRepository::class,
                IReligionScientistRepository::class => ReligionScientistRepository::class,
                IPrayersRepository::class => PrayersRepository::class,
                ILibraryRepository::class => LibraryRepository::class,
                IFavourtiesRepository::class => FavourtiesRepository::class,
                ICouncilRepository::class => CouncilRepository::class,
                IUserLibaryRepository::class => UserLibaryRepository::class,
                IUserListenRepository::class => UserListenRepository::class
            ];
        foreach ($binds as $key => $value) {
            $this->app->bind($key, $value);
        }
    }
}
