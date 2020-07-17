<?php

class Response
{
    public static function sendResponse($success, $details, $status, $additional)
    {
        $msg = $success ? "operation successful!" : "operation not successful: " . $details;

        $responseArr = [
            "message" => $msg,
            "status" => $status
        ];

        if($additional)
        {
            foreach ($additional as $key => $value)
            {
                $responseArr[$key] = $value;
            }
        }

        //send response
        http_response_code($status);

        echo json_encode($responseArr);
    }
}