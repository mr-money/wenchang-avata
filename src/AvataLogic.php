<?php

/**
 *
 * @description 文昌链Avata API 快速接入SDK
 * 参考开发文档PHP
 * 语言版本：https://github.com/bianjieai/avata-demos/tree/main/php
 * 以上示例来自文昌链技术交流群「河北曼象无限科技发展有限公司」0307，感谢 @0307 的技术贡献
 *
 * @author Mr_money
 *
 * https://apis.avata.bianjie.ai/
 */

namespace MrMoney\AvataLogic;

use Exception;

class AvataLogic
{
    private $apiKey;
    private $apiSecret;
    private $domain;

    public function __construct(array $initData)
    {
        $this->apiKey = $initData['apiKey'] ?? '';
        $this->apiSecret = $initData['apiSecret'] ?? '';
        $this->domain = $initData['domain'] ?? 'https://stage.apis.avata.bianjie.ai'; //测试地址
    }

    /**
     * @description 创建链账户
     *
     * @api https://apis.avata.bianjie.ai/#tag/%E9%93%BE%E8%B4%A6%E6%88%B7%E6%8E%A5%E5%8F%A3/paths/~1v1beta1~1account/post
     *
     * @param string $name 链账户名称，支持 1-20 位汉字、大小写字母及数字组成的字符串
     * @param string $operationId 操作ID
     *
     * @return array
     * @throws Exception
     */
    public function CreateChainAccount(string $name, string $operationId): array
    {
        if (!$name) {
            throw new Exception('必传参数为空');
        }
        $body = [
            'name' => $name,
            'operation_id' => $operationId,
        ];
        return $this->request('/v1beta1/account', [], $body, 'POST');
    }


    /**
     * @description 根据账户操作id 查询单个创建会员状态
     *
     * @api https://apis.avata.bianjie.ai/#tag/%E9%93%BE%E8%B4%A6%E6%88%B7%E6%8E%A5%E5%8F%A3/paths/~1v1beta1~1accounts/get
     *
     * @param string $operationId 操作ID
     *
     * @return array
     */
    public function QueryAccountByOperationId(string $operationId): array
    {
        $query = [
            'operation_id' => $operationId,
        ];
        return $this->request('/v1beta1/accounts', $query, [], 'GET');
    }

    /**
     * @description 根据链账户名称 查询单个创建会员状态
     *
     * @api https://apis.avata.bianjie.ai/#tag/%E9%93%BE%E8%B4%A6%E6%88%B7%E6%8E%A5%E5%8F%A3/paths/~1v1beta1~1accounts/get
     *
     * @param string $name 链账户名称，支持模糊查询
     *
     * @return array
     */
    public function QueryAccountByName(string $name = ''): array
    {
        $query = [
            'name' => $name,
        ];
        return $this->request('/v1beta1/accounts', $query, [], 'GET');
    }

    /**
     * @description 根据条件查询链账户信息
     *
     * @api https://apis.avata.bianjie.ai/#tag/%E9%93%BE%E8%B4%A6%E6%88%B7%E6%8E%A5%E5%8F%A3/paths/~1v1beta1~1accounts/get
     *
     * @param array $data
     *
     * @return array
     */
    public function QueryAccounts(array $data): array
    {
        $query = [
            'offset' => $data['offset'],
            'limit' => $data['limit'],
            'account' => $data['account'],
            'name' => $data['name'],
            'operation_id' => $data['operation_id'],
            'start_date' => $data['start_date'],
            'end_date' => $data['end_date'],
            'sort_by' => $data['sort_by'],
        ];
        return $this->request('/v1beta1/accounts', $query, [], 'GET');
    }


    /**
     * @description 上链交易结果查询
     *
     * @api https://apis.avata.bianjie.ai/#tag/%E4%BA%A4%E6%98%93%E7%BB%93%E6%9E%9C%E6%9F%A5%E8%AF%A2%E6%8E%A5%E5%8F%A3/paths/~1v1beta1~1tx~1{operation_id}/get
     *
     * @param string $operationId 操作ID
     *
     * @return array
     */
    public function OperationResult(string $operationId): array
    {
        return $this->request('/v1beta1/tx/' . $operationId, [], [], 'GET');
    }

    //

    /**
     * @description 创建NFT类别
     *
     * @api https://apis.avata.bianjie.ai/#tag/NFT/paths/~1v1beta1~1nft~1classes/post
     *
     * @param array $data
     * @param string $operationId
     *
     * @return array
     * @throws Exception
     */
    public function CreateClasses(array $data, string $operationId): array
    {
        if (!$data['name'] || !$data['owner']) {
            throw new Exception('必传参数为空');
        }

        $body = [
            'name' => $data['name'],
            'class_id' => $data['class_id'] ?? '',
            'symbol' => $data['symbol'] ?? '',
            'description' => $data['description'] ?? '',
            'uri' => $data['uri'] ?? '',
            'uri_hash' => $data['uri_hash'] ?? '',
            'data' => $data['data'] ?? '',
            'owner' => $data['owner'],
            'tag' => $data['tag'] ?? [],
            'operation_id' => $operationId,
        ];
        return $this->request('/v1beta1/nft/classes', [], $body, 'POST');
    }


    /**
     * @description 查询NFT类别详情
     *
     * @api https://apis.avata.bianjie.ai/#tag/NFT/paths/~1v1beta1~1nft~1classes~1{id}/get
     *
     * @param string $classId
     *
     * @return array
     * @throws Exception
     */
    public function QueryClassesDetailById(string $classId): array
    {
        if (!$classId) {
            throw new Exception('必传参数为空');
        }
        $query = [
            'id' => $classId,
        ];
        return $this->request('/v1beta1/nft/classes', $query, [], 'GET');
    }


    /**
     * @description 转让NFT类别
     *
     * @api https://apis.avata.bianjie.ai/#tag/NFT/paths/~1v1beta1~1nft~1class-transfers~1{class_id}~1{owner}/post
     *
     * @param array $data
     * @param string $operationId
     *
     * @return array
     * @throws Exception
     */
    public function TransfersClasses(array $data, string $operationId): array
    {
        if (!$data['recipient']) {
            throw new Exception('必传参数为空');
        }
        $body = [
            'recipient' => $data['recipient'],
            'operation_id' => $operationId,
            'tag' => $data['tag'] ?? [],
        ];
        return $this->request('/v1beta1/nft/class-transfers/' . $data['class_id'] . '/' . $data['owner'], [], $body, 'POST');
    }

    /**
     * @description 发行NFT
     *
     * @api https://apis.avata.bianjie.ai/#tag/NFT/paths/~1v1beta1~1nft~1nfts~1{class_id}/post
     *
     * @param array $data
     * @param string $operationId
     *
     * @return array
     * @throws Exception
     */
    public function CreateNft(array $data, string $operationId): array
    {
        if (!$data['name'] || !$data['class_id']) {
            throw new Exception('必传参数为空');
        }

        $body = [
            'name' => $data['name'],
            'uri' => $data['uri'] ?? '',
            'recipient' => $data['recipient'] ?? '',
            'operation_id' => $operationId,
        ];
        if (!empty($data['uri_hash'])) {
            $body['uri_hash'] = $data['uri_hash'];
        }
        if (!empty($data['data'])) {
            $body['data'] = $data['data'];
        }
        if (!empty($data['tag'])) {
            $body['tag'] = $data['tag'];
        }

        return $this->request('/v1beta1/nft/nfts/' . $data['class_id'], [], $body, 'POST');
    }

    /**
     * @description 转让NFT
     *
     * @api https://apis.avata.bianjie.ai/#tag/NFT/paths/~1v1beta1~1nft~1nft-transfers~1{class_id}~1{owner}~1{nft_id}/post
     *
     * @param array $data
     * @param string $operationId
     *
     * @return array
     */
    public function TransfersNft(array $data, string $operationId): array
    {
        $body = [
            'recipient' => $data['recipient'],
            'operation_id' => $operationId,
            'tag' => !empty($data['tag']) ? $data['tag'] : '',
        ];
        return $this->request('/v1beta1/nft/nft-transfers/' . $data['class_id'] . '/' . $data['owner'] . '/' . $data['nft_id'], [], $body, 'POST');
    }


    /**
     * @description 编辑NFT
     *
     * @api  https://apis.avata.bianjie.ai/#tag/NFT/paths/~1v1beta1~1nft~1nfts~1{class_id}~1{owner}~1{nft_id}/patch
     *
     * @param array $data
     * @param string $operationId
     *
     * @return array
     */
    public function EditNft(array $data, string $operationId): array
    {
        $body = [
            'name' => $data['name'],
            'uri' => !empty($data['uri']) ? $data['uri'] : '',
            'data' => !empty($data['data']) ? $data['data'] : '',
            'operation_id' => $operationId,
            'tag' => !empty($data['tag']) ? $data['tag'] : '',
        ];

        return $this->request('/v1beta1/nft/class-transfers/' . $data['class_id'] . '/' . $data['owner'] . '/' . $data['nft_id'], [], $body, 'PATCH');
    }


    /**
     * @description 销毁NFT
     *
     * @api https://apis.avata.bianjie.ai/#tag/NFT/paths/~1v1beta1~1nft~1nfts~1{class_id}~1{owner}~1{nft_id}/delete
     *
     * @param array $data
     * @param string $operationId
     *
     * @return array
     */
    public function DeleteNft(array $data, string $operationId): array
    {
        $body = [
            'operation_id' => $operationId,
            'tag' => !empty($data['tag']) ? $data['tag'] : '',
        ];

        return $this->request('/v1beta1/nft/class-transfers/' . $data['class_id'] . '/' . $data['owner'] . '/' . $data['nft_id'], [], $body, 'DELETE');
    }

    /**
     * @description 查询NFT列表
     *
     * @api https://apis.avata.bianjie.ai/#tag/NFT/paths/~1v1beta1~1nft~1nfts/get
     *
     * @param array $data
     *
     * @return array
     */
    public function QueryNftList(array $data): array
    {
        $query = [
            'class_id' => $data['class_id'],
            'owner' => $data['owner'],
            'name' => $data['name'],
            'status' => $data['status'],
        ];
        return $this->request('/v1beta1/nft/nfts/', $query, [], 'GET');
    }

    /**
     * @description 查询NFT详情
     *
     * @api https://apis.avata.bianjie.ai/#tag/NFT/paths/~1v1beta1~1nft~1nfts~1{class_id}~1{nft_id}/get
     *
     * @param array $data
     *
     * @return array
     */
    public function QueryNftDetail(array $data): array
    {
        $query = [
            'class_id' => $data['class_id'],
            'nft_id' => $data['nft_id'],
        ];
        return $this->request('/v1beta1/nft/nfts/' . $data['class_id'] . '/' . $data['nft_id'], $query, [], 'GET');
    }



    ///////////////////////////////////////
    /// function

    /**
     * @description 发送请求
     *
     * @param string $path
     * @param array $query
     * @param array $body
     * @param string $method
     *
     * @return array
     */
    private function request(string $path, array $query = [], array $body = [], string $method = 'GET')
    {
        $method = strtoupper($method);
        $apiGateway = rtrim($this->domain, '/') . '/' . ltrim($path,
                '/') . ($query ? '?' . http_build_query($query) : '');
        $timestamp = $this->getMillisecond();
        $params = ['path_url' => $path];
        if ($query) {
            foreach ($query as $k => $v) {
                $params['query_' . $k] = $v;
            }
        }
        if ($body) {
            foreach ($body as $k => $v) {
                $params['body_' . $k] = $v;
            }
        }
        ksort($params);
        $hexHash = hash('sha256', $timestamp . $this->apiSecret);
        if (count($params) > 0) {
            $s = json_encode($params, JSON_UNESCAPED_UNICODE);
            $hexHash = hash('sha256', stripcslashes($s . $timestamp . $this->apiSecret));
        }
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $apiGateway);
        $header = [
            'Content-Type:application/json',
            'X-Api-Key:' . $this->apiKey,
            'X-Signature:' . $hexHash,
            'X-Timestamp:' . $timestamp,
        ];
        curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

        $jsonStr = $body ? json_encode($body) : ''; //转换为json格式
        if ($method == 'POST') {
            curl_setopt($ch, CURLOPT_POST, 1);
            if ($jsonStr) {
                curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonStr);
            }
        } elseif ($method == 'PATCH') {
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PATCH');
            if ($jsonStr) {
                curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonStr);
            }
        } elseif ($method == 'PUT') {
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT');
            if ($jsonStr) {
                curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonStr);
            }
        } elseif ($method == 'DELETE') {
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'DELETE');
            if ($jsonStr) {
                curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonStr);
            }
        }
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $response = curl_exec($ch);

        //$err = curl_error($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        $response = json_decode($response, true);

        return [
            'code' => $httpCode,
            'result' => $response,
        ];
    }

    /** get timestamp
     *
     * @return float
     */
    private function getMillisecond(): float
    {
        list($t1, $t2) = explode(' ', microtime());
        return (float)sprintf('%.0f', (floatval($t1) + floatval($t2)));
    }

}