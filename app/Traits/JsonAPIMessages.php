<?php

namespace App\Traits;

trait JsonAPIMessages
{
    /**
     * The request succeeded 200 ok
     *
     * @param array $arr
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function SuccessMessage($arr = '')
    {
        $data = ['status' => 200, 'error' => false, 'lang' => $this->GetLanguage(), 'user' => $this->GetUser(), 'message' => 'success', 'data' => $arr];

        return response()->json($data);
    }
    /**
     * Success Message Without User
     *
     * @param array $arr
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function SuccessMessageWithoutUser(array $arr)
    {
        $data = ['status' => 200, 'error' => false, 'lang' => $this->GetLanguage(), 'message' => 'success', 'data' => $arr];

        return response()->json($data);
    }
    /**
     * Success Message Without User
     *
     * @param array $arr
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function SuccessMessageRetrunData(array $arr)
    {
        $data = ['status' => 200, 'error' => false];

        $newdata = array_merge($data, $arr);

        return response()->json($newdata);
    }
    /**
     * The request succeeded 201
     *
     * @param array $arr
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function RequestSucessfulMessage(array $arr)
    {
        $data = ['status' => 201, 'error' => false, 'message' => 'The request succeeded', 'data' => $arr];

        return response()->json($data);
    }
    /**
     * The request succeeded 201 with write message
     *
     * @param array $arr
     *
     * @param string $message
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function RequestSucessfulWriteMessage(array $arr, $message)
    {
        $data = ['status' => 201, 'error' => false, 'message' => $message, 'data' => $arr];

        return response()->json($data);
    }
     /**
     * The request succeeded 201 with write message
     *
     * @param string $arr
     *
     * @param string $message
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function RequestSucessful($message)
    {
        $data = ['status' => 201, 'error' => false, 'message' => $message];

        return response()->json($data);
    }
    /**
     * BadRequestException 400
     *
     * @param string $e
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function ErrorMessage($e)
    {
        $data = ['status' => 400, 'error' => true, 'message' => $e];

        return response()->json($data);
    }
    /**
     * Internal Server Error 500
     *
     * @param string $e
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function Error505Message($e)
    {
        $data = ['status' => 505, 'error' => true, 'message' => $e];

        return response()->json($data);
    }
    /**
     * 404 Not Found
     *
     * @param string $e
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function Error404Message($e)
    {
        $data = ['status' => 404, 'error' => true, 'message' => $e];

        return response()->json($data);
    }
    /**
     * Create Validation Message
     *
     * @param array $arr
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function ValidationMessage($message)
    {
        $data = [
            'status' => 400,
            'error' => true,
            'message' => $message
        ];
        return response()->json($data);
    }
    /**
     * ErrorException
     *
     * @param mixed $code
     *
     * @param mixed $message
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function ErrorException($code, $message)
    {
        $data = ['code' => $code, 'message' => $message];

        return response()->json($data);
    }
    /**
     * Get Language Has User Login in App
     *
     * @return string
     */
    private function GetLanguage()
    {
        return app()->getLocale();
    }
    /**
     * Get Data User in App
     *
     * @return string
     */
    private function GetUser()
    {
        return auth()->user();
    }
}
