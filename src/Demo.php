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

    /**
     * @description 创建nft类别
     * @return array
     */
    public function createClass()
    {
        $operationId = 'create_class_' . rand(1000, 9999);
        $uri = 'https://dev.changaosports.com/web/statics/img/common/balance-ad.png';

        $classData = [
            'name' => '测试NFT分类',
            'owner' => 'iaa1np4fd6zgyy3l4a4ccqxh7pjwwr6huzngaq6nnv', //account
            'class_id' => 'testclass' . rand(1000, 9999),
            'symbol' => 'test',
            'description' => '测试NFT分类',
            'uri' => $uri,
            'uri_hash' => hash('sha256', $uri),
            'data' => '测试NFT分类测试NFT分类测试NFT分类',
            'tag' => [
                'tagName' => 'test',
            ]
        ];
        try {
            $createRes = $this->AvataLogic->CreateClasses($classData, $operationId);

        } catch (\Exception $exception) {
            return [
                'data' => $classData,
                'res' => $exception->getMessage(),
            ];
        }

        //todo 保存类别信息

        return [
            'data' => $classData,
            'res' => $createRes,
        ];

    }


    /**
     * @description 发行NFT
     * @return array
     */
    public function dataOnChain()
    {
        $operationId = 'data_on_chain_' . rand(1000, 9999);
        $uri = 'https://dev.changaosports.com/web/statics/img/common/balance-ad.png';

        $nftData = [
            'class_id' => 'testclass2891',
            'name' => '测试图片1',
            'uri' => $uri,
            'uri_hash' => hash('sha256', $uri),
            'data' => '测试图片上链1测试图片上链1测试图片上链1',
            'recipient' => 'iaa1np4fd6zgyy3l4a4ccqxh7pjwwr6huzngaq6nnv',
            'tag' => [
                'tagName' => 'test'
            ],
        ];

        try {
            $createRes = $this->AvataLogic->CreateNft($nftData,$operationId);

        } catch (\Exception $exception) {
            return [
                'data' => $nftData,
                'res' => $exception->getMessage(),
            ];
        }

        $operationId = $createRes['result']['data']['operation_id'];

        Log::channel('avata')->info(
            '发行NFT', [
            'data' => $nftData,
            'res' => $createRes,
        ]);

        //查询nft交易结果
        sleep(2);
        $operationRes = $this->AvataLogic->OperationResult($operationId);

        //todo 保存nft信息

        return [
            'data' => $nftData,
            'res' => $operationRes,
        ];
    }
}