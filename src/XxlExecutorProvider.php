<?php
namespace Soen\XxlExecutor;

use Illuminate\Support\ServiceProvider;
use Soen\XxlExecutor\Commands\RegisterCommand;

class XxlExecutorProvider extends ServiceProvider
{
    public function register()
    {
        $this->mergeConfigFrom(
            __DIR__.'/../config/xxl.php', 'xxl'
        );
    }

    public function boot(){
        $configPath = __DIR__ . '/../config/xxl.php';
        $this->publishes([$configPath => config_path('xxl.php')],['xxl']);
        //合并命令行
//        if ($this->app->runningInConsole()) {
//            $this->commands([
//                RegisterCommand::class
//            ]);
//        }
        //合并 路由和 中间件
        $this->loadRoutesFrom(__DIR__.'/../routes/api.php');
    }

}
