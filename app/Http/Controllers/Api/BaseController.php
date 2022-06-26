<?php


namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller as Controller;
use Log;

class BaseController extends Controller
{
    /**
     * success response method.
     *
     * @return \Illuminate\Http\Response
     */
    public function sendResponse($result, $message)
    {
    	$response = [
            'success' => true,
            'data'    => $result,
            'message' => $message //." TimeTaken: ".round( (microtime(true) - LARAVEL_START)* 1000 ,5),
        ];

        Log::info( "=====Response_sendResponse_START=====" );
        Log::info( json_encode($response) );
        Log::info( "End_time: ".round(microtime(true) * 1000 ,5) );
        Log::info( "LARAVEL_START: ".round(LARAVEL_START * 1000 ,5) );
        Log::info( "TimeTaken: ".round( (microtime(true) - LARAVEL_START) * 1000,5) );
        Log::info( "=====Response_sendResponse_END=====" );

        return response()->json($response, 200);
    }

    public function sendResponseWithNoData( $message)
    {
        $response = [
            'success' => true,
            'data'    => ['data'=>'no data'],
            'message' => $message //." TimeTaken: ".round( (microtime(true) - LARAVEL_START)* 1000 ,5),
        ];

        Log::info( "=====Response_sendResponseWithNoData_START=====" );
        // Log::info( $response );
        Log::info( json_encode($response) );
        Log::info( "End_time: ".round(microtime(true) * 1000 ,5) );
        Log::info( "LARAVEL_START: ".round(LARAVEL_START * 1000 ,5) );
        Log::info( "TimeTaken: ".round( (microtime(true) - LARAVEL_START) * 1000,5) );
        Log::info( "=====Response_sendResponseWithNoData_END=====" );

        return response()->json($response, 200);
    }


    /**
     * return error response.
     *
     * @return \Illuminate\Http\Response
     */
    public function sendError($error, $errorMessages = [], $code = 200)
    {
    	$response = [
            'success' => false,
            'data'    => ['data'=>'no data'],
            'message' => $error //." TimeTaken: ".round( (microtime(true) - LARAVEL_START)* 1000 ,5),
        ];

        if(!empty($errorMessages)){
            $response['data'] = $errorMessages;
        }

        Log::info( "=====Response_sendError_START=====" );
        // Log::info( $response );
        Log::info( json_encode($response) );
        Log::info( "End_time: ".round(microtime(true) * 1000 ,5) );
        Log::info( "LARAVEL_START: ".round(LARAVEL_START * 1000 ,5) );
        Log::info( "TimeTaken: ".round( (microtime(true) - LARAVEL_START) * 1000,5) );
        Log::info( "=====Response_sendError_END=====" );

        return response()->json($response, $code);
    }

    public function sendErrorWithData( $data=[], $error, $errorMessages = [], $code = 200)
    {
        $response = [
            'success' => false,
            'data'    => $data,
            // 'message' => $error,
            'message' => $error //." TimeTaken: ".round( (microtime(true) - LARAVEL_START)* 1000 ,5),
        ];

        if(!empty($errorMessages)){
            $response['data'] = $errorMessages;
        }

        Log::info( "=====Response_sendErrorWithData_START=====" );
        // Log::info( $response );
        Log::info( json_encode($response) );
        Log::info( "End_time: ".round(microtime(true) * 1000 ,5) );
        Log::info( "LARAVEL_START: ".round(LARAVEL_START * 1000 ,5) );
        Log::info( "TimeTaken: ".round( (microtime(true) - LARAVEL_START) * 1000,5) );
        Log::info( "=====Response_sendErrorWithData_END=====" );

        return response()->json($response, $code);
    }



    public function logExpection($api_name, $exception_msg)
    {
        Log::error("=====".$api_name."_API_Exception_START=====");
        Log::error( $exception_msg );
        Log::error("=====".$api_name."_API_Exception_END=====");
    }


}

