<?php

namespace App\Helpers;

use Exception;
use App\Exceptions\SuccessException;
use Illuminate\Database\QueryException;

class ExceptionHelper
{
    // Public helper functions

    /**
     * Transforms exception to response
     *
     * @param Exception $exception
     * @param $data
     * @return array|string
     */
    public static function exception(Exception $exception, $data = null)
    {
        $response = ['code' => $exception->getCode(), 'status' => 'error', 'message' => $exception->getMessage()];
        if($exception instanceof SuccessException)
        {
            $response['code'] = 200;
            $response['status'] = 'success';
            if(!(strlen($response['message']) > 0)){ $response['message'] = 'Operation is successful'; }
        }
        if($exception instanceof QueryException)
        {
            $response['code'] = 500;
            $response['message'] = 'Operation is not possible';
        }
        if(!is_null($data)){ $response['data'] = $data; }
        return $response;
    }

    /**
     * Transforms exception to response
     *
     * @param $exception
     * @param bool $json
     * @param $data
     * @return array|string
     */
    public static function toResponse(Exception $exception, bool $json = false, $data = null)
    {
        $response = ['code' => $exception->getCode(), 'status' => 'error', 'message' => $exception->getMessage()];
        if($exception instanceof SuccessException)
        {
            $response['code'] = 200;
            $response['status'] = 'success';
            if(!(strlen($response['message']) > 0)){ $response['message'] = 'Operation is successful'; }
        }
        if($exception instanceof QueryException)
        {
            $response['code'] = 500;
            $response['message'] = 'Operation is not possible';
        }
        if(!is_null($data)){ $response['data'] = $data; }
        return $json ? json_encode($response) : $response;
    }
}
