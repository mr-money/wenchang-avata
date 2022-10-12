<?php

namespace Demo;

use MrMoney\AvataLogic\AvataLogic;

class Demo
{
    public $AvataLogic;

    public function __construct()
    {
        $initData = [
            'apiKey' => 'apiKey',
            'apiSecret' => 'apiSecret',
            'domain' => 'https://stage.apis.avata.bianjie.ai', //测试地址
        ];
        $this->AvataLogic = new AvataLogic($initData);

    }


    /**
     * @description 创建链账户
     * @return array
     */
    public function createAccount(): array
    {
        $name = 'account_name';
        $operationId = 'operationId'.rand(1000,9999);

        //创建账户
        $createRes = $this->AvataLogic->CreateChainAccount($name,$operationId);

        //覆盖operation_id
        $operationId = $createRes['result']['data']['operation_id'];

        //查询账户信息
        $accountRes = $this->AvataLogic->QueryAccountByOperationId($operationId);

        //判断用户授权状态
        if($accountRes['result']['data']['accounts'][0]['status']){
            sleep(3);
            //重新查询用户信息
            $accountRes = $this->AvataLogic->QueryAccountByOperationId($operationId);
        }

        return [
            'name' => $name,
            'operationId' => $operationId,
            'res' => $accountRes,
        ];

    }
}