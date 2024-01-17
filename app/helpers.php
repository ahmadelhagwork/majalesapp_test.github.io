<?php

use Carbon\Carbon;
use App\Models\User;
use GuzzleHttp\Client;
use Illuminate\Support\Str;
use GuzzleHttp\Psr7\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

/*---------------------------------
| Create Custom Helper Function
------------------------------------*/

if (!function_exists('GetCurrentLanguage')) {

    /**
     * get current language use in appliaction
     *
     * @return string
     */
    function GetCurrentLanguage()
    {
        $lang = LaravelLocalization::getCurrentLocale();

        return $lang;
    }
}
if (!function_exists('GetIPAddress')) {

    /**
     * get ip address
     *
     * @return string
     */
    function GetIPAddress()
    {
        if (isset($_SERVER['SERVER_ADDR'])) {
            $clientIP = $_SERVER['SERVER_ADDR'];
        }
        return $clientIP;
    }
}
if (!function_exists('GetCurrentTime')) {

    /**
     * get currenttime
     *
     * @return string
     */
    function GetCurrentTime()
    {
        $Carbon = new Carbon();

        $time = $Carbon->toTimeString();

        return $time;
    }
}
if (!function_exists('GetCurrentDate')) {
    /**
     * get currentdate
     *
     * @return string
     */
    function GetCurrentDate()
    {
        $Carbon = new Carbon();

        $date = $Carbon->toDateString();

        return $date;
    }
}
if (!function_exists('GetURLLocalization')) {

    /**
     * GetURLLocalization
     *
     * @return string
     */
    function GetURLLocalization($lang)
    {
        $route = LaravelLocalization::getLocalizedURL($lang);

        return $route;
    }
}
if (!function_exists('GetAttributesWithCurrentLanguage')) {
    /**
     * get attributes with currentLanguage
     *
     * @return array
     */
    function GetAttributesWithCurrentLanguage(array $fillable)
    {
        $result = [];

        $dash = '_';

        $lang = app()->getLocale();

        $array = array_filter($fillable, function ($value) {
            $result = strpos($value, '_ar');

            $result .= strpos($value, '_en');

            return $result == false;
        });

        foreach ($fillable as $value) {
            if (strstr($value, $dash . $lang)) {
                $replace_value = substr($value, 0, -3);

                $getvaluewithlang = $replace_value . $dash . $lang . ' as ' . $replace_value;

                $result[] = $getvaluewithlang;

                $select = array_merge($array, $result);
            }
        }
        return $select;
    }
}
if (!function_exists('Uploads')) {
    /**
     * upload file to Storage
     *
     * @param $file , $path , $name is null
     *
     * return file name
     */
    function Uploads($file, $path, $name = null)
    {
        $fileName = uniqid() . '-' . str_replace(' ', '-', $name) . '.' . $file->extension();

        Storage::disk('public')->put($path . $fileName, File::get($file));

        return $fileName;
    }
}
if (!function_exists('UpdateUpload')) {
    /**
     * upload file with update to Storage
     *
     * @param $file , $path , $filename
     *
     * return file name
     */
    function UpdateUpload($file, $fileName, $path)
    {
        Storage::disk('public')->put($path . $fileName, File::get($file));

        return $fileName;
    }
}

if (!function_exists('DeleteFile')) {
    /**
     * delete file to Storage
     *
     * @param $file , $path
     *
     * return file name
     */
    function DeleteFile($path, $fileName)
    {
        Storage::delete('public/images/' . $path . $fileName);
    }
}

if (!function_exists('FileSize')) {

    /**
     * get filesize
     *
     * @param $file , $precision
     *
     * return size
     */
    function FileSize($file, $precision = 2)
    {
        $size = $file->getSize();

        if ($size > 0) {
            $size = (int) $size;

            $base = log($size) / log(1024);

            $suffixes = array(' bytes', ' KB', ' MB', ' GB', ' TB');

            return round(pow(1024, $base - floor($base)), $precision) . $suffixes[floor($base)];
        }

        return $size;
    }
}

if (!function_exists('UploadWithOutStorage')) {
    /**
     * upload file WithOut Storage
     *
     * @param $file , $path , $name is null
     *
     * return file name
     */
    function UploadWithOutStorage($exe, $file)
    {

        $file_name = 'file-' . time() . uniqid() . '.' . $file->getClientOriginalExtension();

        $route = public_path($exe);

        $file->move($route, $file_name);

        return $file_name;
    }
}
if (!function_exists('UploadFile')) {
    /**
     * Method UploadFile
     *
     * @param mixed $input
     *
     * @param $request
     *
     * @param string $file_name
     *
     * @return mixed
     */
    function UploadFile($input, $request, $file_name = null)
    {
        $file_name = ($request->file($input) != '') ? UploadWithOutStorage('img/', $request->file($input)) : $file_name;

        return $file_name;
    }
}
if (!function_exists('RediectToPage')) {
    /**
     * rediect to page
     *
     * @return void
     */
    function RediectToPage($routename)
    {
        $provider = ['done' => 1, 'success' => 1, 'message'];

        return redirect()->route($routename)->withErrors($provider) ?? null;
    }
}
if (!function_exists('DateFormat')) {
    /**
     * Method DateFormat
     *
     * @param mixed $date
     *
     * @return string
     */
    function DateFormat($date)
    {
        $newdate = date("d/m/Y", strtotime($date));

        return $newdate;
    }
}
if (!function_exists('TimeFormat')) {
    /**
     * Method TimeFormat
     *
     * @param mixed $time
     *
     * @return string
     */
    function TimeFormat($time)
    {
        $time = date('h:i A', strtotime($time));

        $arrEn = ['AM', 'PM'];

        $arrAr = ['صباحا', 'مساءأ'];

        if (GetCurrentLanguage() == 'ar') {
            $time = str_replace($arrEn, $arrAr, $time);
        }
        return $time;
    }
}
if (!function_exists('DurationTime')) {
    /**
     * Method DurationTime
     *
     * @param mixed $time1
     *
     * @param mixed $time2
     *
     * @return string
     */
    function DurationTime($time1, $time2)
    {
        $time1 = new DateTime($time1);

        $time2 = new DateTime($time2);

        $interval = $time1->diff($time2);

        if (GetCurrentLanguage() == 'ar') {
            $duration = $interval->format('%h ساعات %i دقيقة');

            $duration = str_replace("1 ساعات", "ساعة", $duration);

            $duration = str_replace("2 ساعات", "ساعتين", $duration);

            $duration = str_replace("0 ساعات", "", $duration);

            $duration = str_replace(" 2 دقيقة", "دقيتين", $duration);

            $duration = str_replace(" 1 دقيقة", "دقيقة", $duration);

            $duration = str_replace(" 4 دقيقة", "4 دقائق", $duration);

            $duration = str_replace(" 5 دقيقة", "5 دقائق", $duration);

            $duration = str_replace(" 6 دقيقة", "6 دقائق", $duration);

            $duration = str_replace(" 7 دقيقة", "7 دقائق", $duration);

            $duration = str_replace(" 8 دقيقة", "8 دقائق", $duration);

            $duration = str_replace(" 9 دقيقة", "9 دقائق", $duration);

            $duration = str_replace(" 10 دقيقة", "10 دقائق", $duration);

            $duration = str_replace(" 0 دقيقة", "", $duration);
        } else {
            $duration = $interval->format('%h hour %i min');

            $duration = str_replace(" 0 min", "", $duration);

            $duration = str_replace("0 hour", "", $duration);
        }
        return $duration;
    }
}
if (!function_exists('GeneratorId')) {
    /**
     * Generator Id
     *
     * @return string
     */
    function GeneratorId()
    {
        return md5(uniqid(rand(), true));
    }
}
if (!function_exists('User')) {
    /**
     * Method User
     *
     * @return object
     */
    function User()
    {
        return new User();
    }
}
if (!function_exists('ClientRequest')) {
    /**
     * PSR-7 request implementation.
     *
     * @param string                               $method  HTTP method
     *
     * @param string                  $uri     URI
     *
     * @param array<string, string|string[]>       $headers Request headers
     *
     * @param string|resource|null $body    Request body
     *
     * @param string                               $version Protocol version
     *
     * retrun object
     */
    function ClientRequest(string $method, $uri, array $headers = [], $body = null, string $version = '1.1')
    {
        return (new Request($method, $uri, $headers, $body));
    }
}
if (!function_exists('Client')) {
    /**
     * Method Client
     *
     * @return object
     */
    function Client(array $config = [])
    {
        return (new Client($config));
    }
}
if (!function_exists('CreateToken')) {
    /**
     * Gentrate Token
     *
     * @param $length $length [explicite description]
     *
     * @return string
     */
    function CreateToken($length)
    {
        return Str::random($length);
    }
}
if (!function_exists('GeneratorId')) {
    /**
     * Generator Id
     *
     * @return string
     */
    function GeneratorId()
    {
        return md5(uniqid(rand(), true));
    }
}
if (!function_exists('CreateHash')) {
    /**
     * Create Hash Password
     *
     * @param mixed $value
     *
     * @return string
     */
    function CreateHash($value)
    {
        return Hash::make($value);
    }
}
if (!function_exists('CreateInstanceWithoutConstructor')) {
    /**
     * Method CreateInstanceWithoutConstructor
     *
     * @param mixed $class
     *
     * @return mixed
     */
    function CreateInstanceWithoutConstructor($class)
    {
        $object = new \ReflectionClass($class);

        return $object->newInstanceWithoutConstructor();
    }
}
if (!function_exists('APIToken')) {
    /**
     * Generate JWT Token
     *
     * @return string;
     */
    function APIToken()
    {
        return bin2hex(openssl_random_pseudo_bytes(64));
    }
}
if (!function_exists('CreateId')) {
    /**
     * CreateId
     *
     * @param  string $name
     *
     * @return string
     */
    function CreateId($name)
    {
        return $name . time();
    }
}
