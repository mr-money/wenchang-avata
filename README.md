# 文昌链 Avata API快速接入 SDK
Avata 是一款由边界智能基于区块链底层核心技术以及支持复杂分布式商业应用的经验自主研发的多链和跨链 API 服务平台。可支持多元资产数字化、链上链下可信交互，为复杂异构系统跨链协作提供一键式对接，助力企业简便快捷的构建分布式商业应用，将更多精力专注于业务创新与推广。


### 安装
- PHP >= 7.2
- <a href="https://apis.avata.bianjie.ai/" target="_blank">文昌链API文档</a>

- <a href="https://getcomposer.org/doc/00-intro.md" target="_blank">Composer</a>

```shell
# 安装
composer require mr-money/wenchang-avata

# 更新
composer update mr-money/wenchang-avata
```

### 使用
```php
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
```