<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Traits\GeneralMethods;
use App\Traits\JsonAPIMessages;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    use JsonAPIMessages, GeneralMethods;
    /**
     * Show Languages Use in App
     *
     * @return \Illuminate\Http\JsonResponse|string|void
     */
    public function ShowLanguages()
    {
        try {
            $languages = ['languages' => $this->LanguageApp()];

            return $this->SuccessMessageRetrunData($languages);
        } catch (\Exception $e) {
            return $this->ErrorException($e->getCode(), $e->getMessage());
        }
    }
    /**
     * Set Current Language
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\JsonResponse|string|void
     */
    public function SetLanguage(Request $request)
    {
        try {
            if (!in_array($request->input('lang'), array_keys($this->LanguageApp()))) {
                throw new \JsonException('this language not support', 500);
            } else if (is_null($request->input('lang'))) {
                throw new \JsonException('this field is required', 500);
            } else {
                $setlang = $request->input('lang');

                $oldline = 'APP_LOCALE=' . env('APP_LOCALE');

                $newline = 'APP_LOCALE=' . $setlang;

                file_put_contents(
                    app()->environmentFilePath(),
                    str_replace(
                        $oldline,
                        $newline,
                        file_get_contents(app()->environmentFilePath())
                    )
                );
                return $this->RequestSucessful('language set successfully');
            }
        } catch (\JsonException $e) {
            return $this->ErrorException($e->getCode(), $e->getMessage());
        }
    }
}
