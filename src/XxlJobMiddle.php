<?php
namespace Soen\XxlExecutor;
use Closure;
use Illuminate\Support\Facades\Log;

class XxlJobMiddle
{
    public function handle(\Illuminate\Http\Request $request, Closure $next)
    {
        $token = $request->header("XXL-JOB-ACCESS-TOKEN");
        //检查token
        if(config("xxl.token") != $token){
            Log::channel("xxljob")->info("token验证失败！" . $token);
            return Utils::fail("token验证失败！");
        }
        $response = $next($request);
        // 执行操作
        return $response;
    }

}
