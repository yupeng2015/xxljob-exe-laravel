<?php
namespace Soen\XxlExecutor;

use Illuminate\Support\Facades\Config;
use Illuminate\Support\ServiceProvider;
use Soen\XxlExecutor\Commands\RegisterCommand;

class XxlExecutorProvider extends ServiceProvider
{
    public function register()
    {
//        $this->mergeConfigFrom(
//            __DIR__.'/../config/xxl.php', 'xxl'
//        );
    }

    public function boot(){
        $configPath = __DIR__ . '/../config/xxl.php';
        $this->publishes([$configPath => config_path('xxl.php')],['xxl']);
        //把xxl-job日志配置合并logging
        $channels = Config::get("logging.channels");
        $xxlLogging = [
            'xxljob' => [
                'driver' => 'daily',
                'log_max_files' => 30,
                'path' => storage_path('logs/xxljob/exe.log'),
            ]
        ];
        $channels = array_merge($channels,$xxlLogging);
        Config::set("logging.channels",$channels);
        //合并 路由和 中间件
        $this->loadRoutesFrom(__DIR__.'/../routes/api.php');
    }

}
