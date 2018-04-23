<?php

namespace Green\Exceptions;

use Symfony\Component\HttpFoundation\JsonResponse;
use Green\Exceptions\{InvalidTokenException,ValidationException};
use League\Route\Http\Exception\{MethodNotAllowedException,NotFoundException};
use League\Route\Http\Exception as HttpException;

class Handler
{
    public function render($e)
    {
        $this->writeLog($e);
        $response = $this->prepareErrorResponse($e);
        
        return $response->send();
    }

    protected function writeLog($e)
    {
        app('log')->writeLog("error",$e->getMessage(),[
            'exception' => get_class($e),
            'file' => $e->getFile(),
            'line' => $e->getLine(),
            'status_code' => 500
        ]);
    }

    public function prepareErrorResponse($e)
    {
        $response = null;

        if($e instanceof InvalidTokenException){
            $response = new JsonResponse([ 
                'reason_phrase' => $e->getMessage(),
                'status_code' => 401
            ],401);

            return $response;
        }

        if($e instanceof ValidationException){
            logging("info",$e);
            $response = new JsonResponse([ 
                'reason_phrase' => $e->getMessage(),
                'status_code' => 422,
                'errors' => $e->getErrors()
            ],420);

            return $response;
        }

        if($e instanceof MethodNotAllowedException){
            logging("info",$e);
            $response = new JsonResponse([ 
                'reason_phrase' => $e->getMessage(),
                'status_code' => 403
            ],403);

            return $response;
        }

        if($e instanceof NotFoundException){
            logging("info",$e);
            $response = new JsonResponse([ 
                'reason_phrase' => $e->getMessage(),
                'status_code' => 404
            ],404);

            return $response;
        }
        
        if($e instanceof HttpException){
            logging("info",$e);
            $response = new JsonResponse([ 
                'reason_phrase' => $e->getMessage(),
                'status_code' => $e->getCode()
            ],420);

            return $response;
        }

        if(config('app.debug')===true){
            $response = new JsonResponse([ 
                'reason_phrase' => $e->getMessage(),
                'exception' => get_class($e),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'status_code' => 500
            ],500);
        } else {
            $response = new JsonResponse([ 
                'reason_phrase' => "Server Error",
                'status_code' => 500
            ],500);
        }
        return $response;
    }
}
