<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Traits\GeneralMethods;
use App\Traits\JsonAPIMessages;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Http\Controllers\Controller;
use App\Http\Requests\API\LoginRequest;
use Illuminate\Support\Facades\Mail;
use App\Http\Requests\API\RegisterRequest;
use App\Mail\VerfiyAccount;
use App\Repsitory\InterFaces\IUserRepository;

class AuthController extends Controller
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
     * generates an authorization token if the user is found in the database
     *
     * @param \App\Http\Requests\API\LoginRequest $request
     *
     * @return \Illuminate\Http\JsonResponse|string
     */
    public function AuthLogin(LoginRequest $request)
    {
        try {
            $credentials = $request->only('email', 'password');

            try {
                if (!$token = JWTAuth::attempt($credentials)) {
                    return $this->ErrorMessage('invalid_credentials');
                }
            } catch (\Tymon\JWTAuth\Exceptions\JWTException $e) {
                return $this->Error505Message('could_not_create_token');
            }
            $arr = ['token' => $token];

            return $this->RequestSucessfulMessage($arr);
        } catch (\JsonException $e) {
            return $this->ErrorMessage($e->getMessage());
        }
    }
    /**
     * creates a user if the user credentials are validated
     *
     * @param \App\Http\Requests\API\RegisterRequest $request
     *
     * @return \Illuminate\Http\JsonResponse|string|void
     */
    public function AuthRegister(RegisterRequest $request)
    {
        try {
            $create = $this->UserModel($request);

            if (!$request) {
                $message = $request->errors()->toJson();

                return $this->ValidationMessage($message);
            }
            $user = (object) $this->user->Create($create);

            $token = JWTAuth::fromUser($user);

            $code = mt_rand(10, 100) . mt_rand(10, 100);

            $userArr = $this->UserResponseAfterRegister($create['name'], $create['email'], $create['password'], $create['email_verified_at'], $code);

            $msg = __('Your verification code is') . ' ' . $code;

            Mail::to($create['email'])->locale(app()->getLocale())->send(new VerfiyAccount($msg));

            $arr = ['user' => $userArr, 'token' => $token];

            return $this->RequestSucessfulWriteMessage($arr, 'A verification code has been sent to your email. Please review it and enter it to activate your account');
        } catch (\JsonException $e) {
            return $this->ErrorException($e->getCode(), $e->getMessage());
        }
    }
    /**
     * Done Verfiy
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\JsonResponse|string|void
     */
    public function VerficationAccount(Request $request)
    {
        try {
            $code = $request->code;

            $headercode = $request->header('X-verficationcode');

            if ($code != $headercode) {
                throw new \JsonException('Code Not Found', 404);
            }
            $this->user->update(['email_verified_at' => 1], auth()->user()->id);

            try {
                if (!$user = JWTAuth::parseToken()->authenticate()) {
                    return $this->Error404Message('user_not_found');
                }
            } catch (\Tymon\JWTAuth\Exceptions\TokenExpiredException $e) {
                return $this->ErrorMessage($e->getCode());
            } catch (\Tymon\JWTAuth\Exceptions\TokenInvalidException $e) {
                return $this->ErrorMessage($e->getCode());
            } catch (\Tymon\JWTAuth\Exceptions\JWTException $e) {
                return $this->ErrorMessage($e->getCode());
            }
            $arr = ['user' => $user];

            return $this->RequestSucessfulMessage($arr);
        } catch (\JsonException $e) {
            return $this->ErrorException($e->getCode(), $e->getMessage());
        }
    }
    /**
     *  returns the user object based on the authorization token that is passed
     *
     * @return \Illuminate\Http\Response|string
     */
    public function GetAuthenticatedUser()
    {
        try {
            if (!$user = JWTAuth::parseToken()->authenticate()) {
                return $this->Error404Message('user_not_found');
            }
        } catch (\Tymon\JWTAuth\Exceptions\TokenExpiredException $e) {
            return $this->ErrorMessage($e->getCode());
        } catch (\Tymon\JWTAuth\Exceptions\TokenInvalidException $e) {
            return $this->ErrorMessage($e->getCode());
        } catch (\Tymon\JWTAuth\Exceptions\JWTException $e) {
            return $this->ErrorMessage($e->getCode());
        }
        $arr = ['user' => $user];

        return $this->RequestSucessfulMessage($arr);
    }
    /**
     * User Logout
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response|string
     */
    public function AuthLogout(Request $request)
    {
        $token = $request->header('auth-token');

        if ($token) {
            try {
                JWTAuth::setToken($token)->invalidate();
            } catch (\Tymon\JWTAuth\Exceptions\TokenInvalidException $e) {
                return $this->ErrorMessage($e->getCode());
            }
            return $this->RequestSucessfulMessage(['message' => 'Logged out successfully']);
        } else {
            return $this->ErrorMessage('some thing went wrongs');
        }
    }
    /**
     * Resend Email To Reset Password
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\JsonResponse|string|void
     */
    public function ConfirmEmail(Request $request)
    {
        try {
            $email = $request->email;

            $users_email = collect($this->user->All())->pluck('email')->all();

            if (!in_array($email, $users_email)) {
                throw new \JsonException('This Email Is Not Sign Up', 404);
            }
            $arr = ['email' => $email];

            return $this->RequestSucessfulWriteMessage($arr, __('Please go to the new password set end point'));
        } catch (\JsonException $e) {
            return $this->ErrorException($e->getCode(), $e->getMessage());
        }
    }
    /**
     * Reset Password
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\JsonResponse|string|void
     */
    public function ResetPassword(Request $request)
    {
        try {
            $email = $request->header('x-email');

            $password = $request->password;

            $confirmpassord = $request->confirmpassword;

            if ($password != $confirmpassord) {
                throw new \JsonException('Please enter the same password as above', 404);
            }
            $update = (object) $this->user->UpdateSelectKey(['password' => CreateHash($password)], 'email', $email);

            if ($update) {
                $arr = ['password' => $password,'message'=> 'please go to login endpoint'];

                return $this->RequestSucessfulMessage($arr);
            }
        } catch (\JsonException $e) {
            return $this->ErrorException($e->getCode(), $e->getMessage());
        }
    }
}
