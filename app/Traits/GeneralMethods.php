<?php

namespace App\Traits;

trait GeneralMethods
{
    /**
     * Show Language Use in App
     *
     * @return array
     */
    public function LanguageApp()
    {
        $arr_values = [];

        $arr = config('laravellocalization.supportedLocales');

        $arr_keys = array_keys($arr);

        foreach ($arr as $value) {
            $langname = $value['native'];

            array_push($arr_values, $langname);
        }
        $finalarr = array_combine($arr_keys, $arr_values);

        return $finalarr;
    }
    /**
     *  The attributes of request register
     *
     * @param $request
     *
     * @return array
     */
    private function UserModel($request)
    {
        return [
            'id' => CreateId('U'),
            'name' => $request->name,
            'email' => $request->email,
            'password' => CreateHash($request->password),
            'remember_token' => CreateToken(64),
            'email_verified_at' => 0
        ];
    }
    /**
     * UserResponseAfterRegister
     *
     * @param mixed $name
     *
     * @param mixed $email
     *
     * @param mixed $password
     *
     * @param mixed $phone
     *
     * @param mixed $code
     *
     * @return array
     */
    public function UserResponseAfterRegister($name, $email, $password, $email_verified_at, $code)
    {
        return [
            'name' => $name,
            'email' => $email,
            'password' => $password,
            'email_verified_at' => $email_verified_at,
            'verfication-code' => $code
        ];
    }
}
