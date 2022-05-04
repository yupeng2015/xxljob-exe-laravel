<?php


namespace Soen\XxlExecutor;


use Illuminate\Support\Facades\Log;

class Utils
{
    public static function success()
    {
        return ["code"=>200,"mag" => null];
    }

    public static function fail(string $msg)
    {
        Log::channel("xxljob")->error($msg);
        return ["code"=>500,"mag" => $msg];
    }

    public static function jobExeCallback(int $code,string $msg = "")
    {
        return [
            "logId" =>  1,
            "logDateTim" => time(),
            "executeResult" =>  [
                "code"  =>  $code,
                "msg"   =>  $msg
            ]
        ];
    }
}
