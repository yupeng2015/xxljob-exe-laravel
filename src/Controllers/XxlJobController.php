<?php

namespace Soen\XxlExecutor\Controllers;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Storage;
use Soen\XxlExecutor\Utils;

class XxlJobController
{
    /**
     * 执行器心跳
     * @return array
     */
    public function beat(){
        return Utils::success();
    }


    /**
     * 执行任务 api
         {
            "jobId":1,                                  // 任务ID
            "executorHandler":"demoJobHandler",         // 任务标识
            "executorParams":"demoJobHandler",          // 任务参数
            "executorBlockStrategy":"COVER_EARLY",      // 任务阻塞策略，可选值参考 com.xxl.job.core.enums.ExecutorBlockStrategyEnum
            "executorTimeout":0,                        // 任务超时时间，单位秒，大于零时生效
            "logId":1,                                  // 本次调度日志ID
            "logDateTime":1586629003729,                // 本次调度日志时间
            "glueType":"BEAN",                          // 任务模式，可选值参考 com.xxl.job.core.glue.GlueTypeEnum
            "glueSource":"xxx",                         // GLUE脚本代码
            "glueUpdatetime":1586629003727,             // GLUE脚本更新时间，用于判定脚本是否变更以及是否需要刷新
            "broadcastIndex":0,                         // 分片参数：当前分片
            "broadcastTotal":0                          // 分片参数：总分片
        }
     * @return array
     */
    public function run()
    {
        //请求数据
        $request = Request::post();
        Log::channel("xxljob")->info("执行任务参数:", $request);
        $jobArr = config('xxl')['jobs'];
        /**
         * @var callable $objCall
         */
        $executorHandler = $request["executorHandler"];

        /**
         * 任务ID
         * @var integer $jobId
         */
        $jobId = $request['jobId'];
        //创建 任务标识 文件名称
        $jobIdPath = 'jobs';
        $jobIdFileName =  $jobId . '.job';
        $jobIdFile = $jobIdPath . '/' . $jobIdFileName;
        $storage = Storage::disk('local');
        $has = $storage->put($jobIdFile,$jobId);

        if(!isset($jobArr[$executorHandler])){
            $storage->delete($jobIdFile);
            return Utils::fail("未找到执行任务！--" . $executorHandler);
        }
        $objCall = $jobArr[$executorHandler];
        if(!$objCall){
            $storage->delete($jobIdFile);
            return Utils::fail("未找到执行任务！--" . $executorHandler);
        }

        $success = call_user_func($objCall,$request['executorParams']);

        Log::channel("xxljob")->info();
        if($success){
            $storage->delete($jobIdFile);
            return Utils::jobExeCallback(200,"执行成功！");
        } else {
            $storage->delete($jobIdFile);
            return Utils::jobExeCallback(500,"执行失败！");
        }
    }


    /**
     说明：终止任务
     ------
     地址格式：{执行器内嵌服务跟地址}/kill
        Header：
        XXL-JOB-ACCESS-TOKEN : {请求令牌}
     请求数据格式如下，放置在 RequestBody 中，JSON格式：
        {
        "jobId":1       // 任务ID
        }
     响应数据格式：
        {
        "code": 200,      // 200 表示正常、其他失败
        "msg": null       // 错误提示消息
        }
     */
    public function kill()
    {

    }



}
