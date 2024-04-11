<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Symfony\Component\HttpFoundation\Response;

abstract class Controller
{

    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    protected function response($status, $data = null, $message = null, $logIt = false, $log = null)
    {

        $response = [
            'message' => is_null($message) ? Response::$statusTexts[$status] : $message
        ];
        
        $response = !empty($data) ? array_merge($response, ["data" => $data]) : $response;
        return response()->json($response, $status);
    }
    public function errorResponse($message, $code, $logIt = false, $log = null)
    {
        return response()->json(['error' => $message, 'code' => $code], $code);
    }
}
