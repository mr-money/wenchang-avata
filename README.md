# 文昌链 Avata API快速接入 SDK
Avata 是一款由边界智能基于区块链底层核心技术以及支持复杂分布式商业应用的经验自主研发的多链和跨链 API 服务平台。可支持多元资产数字化、链上链下可信交互，为复杂异构系统跨链协作提供一键式对接，助力企业简便快捷的构建分布式商业应用，将更多精力专注于业务创新与推广。


### 安装
- PHP >= 7.2
- <a href="https://getcomposer.org/doc/00-intro.md" target="_blank">Composer</a>

```shell
# 安装
composer require mr-money/wenchang-avata

# 更新
composer update mr-money/wenchang-avata
```

### 使用
```php
//构建对象
$initData = [
    'apiKey' => 'apiKey',
    'apiSecret' => 'apiSecret',
    'domain' => 'https://stage.apis.avata.bianjie.ai', //测试地址
];
$avataLogic = new MrMoney\AvataLogic\AvataLogic($initData);

//创建链账户demo
$name = 'account_name';
$operationId = 'operationId'.rand(1000,9999);

$createRes = $avataLogic->CreateChainAccount($name,$operationId);

```

### 技术文档

- <a href="https://apis.avata.bianjie.ai/" target="_blank">文昌链门户</a>
- <a href="https://console.avata.bianjie.ai" target="_blank">Avata控制台</a>
- <a href="https://wenchang.bianjie.ai/wenchangchain.html" target="_blank">文昌链开发配置文档</a>
- <a href="https://irita.bianjie.ai/docs/" target="_blank">IRITA 技术文档</a>
- <a href="https://bsnbase.com/static/tmpFile/bzsc/openper/7-3-1.html" target="_blank">BSN用户手册-文昌链网关接入说明</a>
- <a href="https://apis.avata.bianjie.ai" target="_blank">Avata API 技术文档（生产环境）</a>
- <a href="https://stage.apis.avata.bianjie.ai" target="_blank">Avata API 技术文档（测试环境）</a>
- <a href="https://explorer.wenchang.bianjie.ai/" target="_blank">文昌链浏览器（生产环境）</a>
- <a href="https://explorer.testnet.bianjie.ai" target="_blank">文昌链测试网浏览器（测试测试环境）</a>

