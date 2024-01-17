<?php

namespace App\Traits;

trait ApiIntegration
{
 /**
     * HTTP Header Authorization , Content-Type
     *
     * @var array
     */
    protected $header;
    /**
     * API Gateway Intgration
     *
     * @var string
     */
    protected $url;
    /**
     * create request
     *
     * @param array $body
     *
     * @param string $url
     *
     * @param array $body
     *
     * @return false|mixed
     */
    protected function BulidRequest($request_method, $url, $body = [])
    {
        try {
            if ($this->header['Content-Type'] == 'application/x-www-form-urlencoded') {
                $type = 'form_params';
            } else {
                $type = 'json';
            }
            $request = ClientRequest($request_method, $this->url . $url, $this->header, json_encode($body));

            $data = [$type => $body];

            $response = Client()->send($request, $data);

            $response = json_decode($response->getBody(), true);

            return $response;
        } catch (\Exception $e) {
            return $this->ErrorException($e->getCode(), $e->getMessage());
        }
    }
}
