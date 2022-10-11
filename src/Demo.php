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
        $operationId = 'operationId'.$this->AvataLogic->getMillisecond();

        return $this->AvataLogic->CreateChainAccount($name,$operationId);

    }
}