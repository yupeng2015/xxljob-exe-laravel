<?php
return [
    "admin_address"   =>  'http://localhost:8080/xxl-job-admin/',
    "local_ip"  =>  "http://127.0.0.1:8000/",
    "token" =>  "aa",
    'jobs'  =>  [
        "getFlowDataAndInsert" => [\App\XxlJob\GetDataJob::class,"getTest"]
    ]
];
