<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Traits\GeneralMethods;
use App\Traits\JsonAPIMessages;
use App\Http\Controllers\Controller;
use Laravel\Socialite\Facades\Socialite;
use App\Repsitory\InterFaces\IUserRepository;

class SocialiteController extends Controller
{
    use JsonAPIMessages, GeneralMethods;
    /**
     * class object
     *
     * @var object
     */
    protected $user;
    /**
     *  Create a new controller instance
     *
     * @param \App\Repsitory\InterFaces\IUserRepository $user
     *
     * @return void
     */
    public function __construct(IUserRepository $user)
    {
        $this->user = $user;
    }
    /**
     * Get Link of login Social
     *
     * @param  \Illuminate\Http\Request $request
     *
     * @param  string $provider
     *
     * @return \Illuminate\Http\JsonResponse|string|void
     */
    public function LoginSocial(Request $request, string $provider)
    {
        try {
            //
        } catch (\Exception $e) {
            return $this->ErrorException($e->getcode(), $e->getMessage());
        }
    }
}
