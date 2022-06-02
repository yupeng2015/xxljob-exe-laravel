# xxljob-exe-laravel
适配xxl-job的php执行器，基于laravel开发的组件，内测阶段
## 安装
composer require soen/xxl-executor
## 发布
php artisan vendor:publish --tag=xxl
会在配置文件目录(config)中生成xxl.php配置文件
## 配置
### 任务对应函数
````
<?php
return [
    "admin_address"   =>  'http://localhost:8080/xxl-job-admin/', //调度中心xxljob地址（必填）
    "local_ip"  =>  "http://127.0.0.1:8000/",  //当前laravel项目地址（非必填）
    "token" =>  "aa",//token(必填，默认可以为空，看你调度中心的token配置)
    'jobs'  =>  [ 
        "getFlowDataAndInsert" => [\App\XxlJob\GetDataJob::class,"getTest"] //（主要，任务要执行的函数）
    ]
];
````

