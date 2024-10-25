<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Response;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;
    
    public function apiReturns($status, $message='', $data=array()){
        if(is_array($message) || is_object($message)){
            $data = $message;
            $message = "";
        }
        switch($status){
            case 'success':
                $responseCode = Response::HTTP_OK;
                break;
            
            case 'invalid':
                $responseCode = Response::HTTP_UNPROCESSABLE_ENTITY;
                break;
            
            case 'unauthorised':
                $responseCode = Response::HTTP_UNAUTHORIZED;
                break;
            
            case 'error':
                $responseCode = Response::HTTP_INTERNAL_SERVER_ERROR;
                break;
        }
        $returnArray['status'] = ucwords($status);
        if(!empty($message)){
            $returnArray['message'] = $message;
        }
        if(count($data) > 0){
            $returnArray['data'] = $data;
        }
        return response()->JSON($returnArray, $responseCode);
    }
}
