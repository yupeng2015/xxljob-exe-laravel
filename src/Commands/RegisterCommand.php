<?php
namespace Soen\XxlExecutor\Commands;

use GuzzleHttp\Client;
use Illuminate\Console\Command;

class RegisterCommand extends Command
{
    /**
     * 命令名称及签名.
     *
     * @var string
     */
    protected $signature = 'xxljob:register';
    /**
     * 命令描述.
     *
     * @var string
     */
    protected $description = '任务执行器，注册到调度中心';

    /**
     * http客户端
     * @var Client
     */
    protected Client $httpClient;

    /**
     * xxljob-admin 地址
     * @var string
     */
    protected string $xxljobAdminUrl;

    /**
     * 本机IP
     * @var string
     */
    protected string $localIp;

    /**
     * 创建命令.
     *
     * @return void
     */
    public function __construct()
    {
        $this->httpClient = new Client();
        $this->xxljobAdminUrl = config("xxl.admin_address");
        $this->localIp = config("xxl.local_ip");
        parent::__construct();
    }

    /**
     * 执行命令.
     *
     * @return mixed
     */
    public function handle()
    {
        $uri = $this->xxljobAdminUrl . "api/registry";
        $response = $this->httpClient->post($uri,[
            "headers"   =>  [
                "XXL-JOB-ACCESS-TOKEN"  =>  'aa'
            ],
            "json"  =>  [
                "registryGroup" =>  "EXECUTOR",
                "registryKey"   =>  "dataExecutor",
                "registryValue" =>  $this->localIp
            ]
        ]);
        var_dump($response->getBody()->getContents());
    }


}
