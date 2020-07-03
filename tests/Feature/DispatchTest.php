<?php

/*
 * This file is part of the cblink/eleme-dispatch.
 *
 * (c) jinjun <757258777@qq.com>
 *
 * This source file is subject to the MIT license that is bundled.
 */

namespace Cblink\Service\Wechat\OpenPlatform\Tests\Feature;

use Cblink\ElemeDispatch\Api;
use Cblink\ElemeDispatch\Dispatch;
use Cblink\ElemeDispatch\ElemeDispatch;
use Cblink\ElemeDispatch\Order;
use PHPUnit\Framework\TestCase;

class DispatchTest extends TestCase
{
    protected $elemeDispatch;

    protected function setUp(): void
    {
        $config = [
            'app_id' => 'app_id',
            'secret_key' => 'secret_key',
            'debug' => true,
            'cache' => null,
        ];

        $fileName = __DIR__ . '/../../baseConfig1.php';

        if (file_exists($fileName)){
            $config = include $fileName;
        }

        $this->elemeDispatch = new ElemeDispatch($config);
    }

    /**
     * 查询配送服务
     */
    public function testDelivery()
    {
        // 参数
        $data = [
            'chain_store_code' => 'test0001',
            'position_source' => 3,
            'receiver_longitude' => '113.93029',
            'receiver_latitude' => '22.53291'
        ];

        // 模拟类
        $client = \Mockery::mock(Dispatch::class, [$this->elemeDispatch]);

        $client->expects()
            ->deliveryQuery($data)
            ->andReturn([
                'code' => '200',
                'data' => null,
                'msg' => 'success',
            ]);

        $ApiClient = \Mockery::mock(Api::class, [$this->elemeDispatch]);
        $ApiClient->expects()->request('chain_store/delivery/query', $data)->andReturn([
            'code' => '200',
            'data' => null,
            'msg' => 'success',
        ]);

        $this->assertSame(
            $ApiClient->request('chain_store/delivery/query', $data),
            $client->deliveryQuery($data)
        );
    }

    /**
     * 查询骑手位置
     *
     * @throws \Cblink\ElemeDispatch\Exceptions\InvalidConfigException\
     */
    public function testOrderCarrier()
    {
        $data = [
            "partner_order_code" => "1234567890xx124"
        ];

        $client = \Mockery::mock(Dispatch::class, [$this->elemeDispatch]);

        $client->expects()
            ->orderCarrier($data)
            ->andReturn([
                'code' => '200',
                'msg' => '接收成功',
                'data' => [
                    'carrierPhone' => '18810585023',
                    'carrierName' => '张路',
                    'latitude' => '30.31432',
                    'longitude' => '120.32434'
                ],
            ]);

        $ApiClient = \Mockery::mock(Api::class, [$this->elemeDispatch]);
        $ApiClient->expects()->request('order/carrier', $data)->andReturn([
            'code' => '200',
            'msg' => '接收成功',
            'data' => [
                'carrierPhone' => '18810585023',
                'carrierName' => '张路',
                'latitude' => '30.31432',
                'longitude' => '120.32434'
            ],
        ]);

        $this->assertSame(
            $ApiClient->request('order/carrier', $data),
            $client->orderCarrier($data)
        );
    }

    /**
     * 查询配送轨迹
     */
    public function testOrderCarrierRoute()
    {
        $data = [
            'partner_order_code' => '1234567890xx124',
        ];

        $client = \Mockery::mock(Dispatch::class, [$this->elemeDispatch]);

        $client->expects()
            ->carrierRouteOrder($data)
            ->andReturn([
                'code' => 200,
                'msg' => '接收成功',
                'data' => [
                    [
                        'carrierDriverPhone' => '18810585023',
                        'carrierDriverName' => '张路',
                        'locations' => [
                            'latitude' => 30.31432,
                            'longitude' => 120.32434,
                            'status' => 10,
                            'occurredAt' => 1561088972000
                        ],
                    ],
                ],
            ]);

        $ApiClient = \Mockery::mock(Api::class, [$this->elemeDispatch]);
        $ApiClient->expects()->request('order/carrier_route', $data)->andReturn([
            'code' => 200,
            'msg' => '接收成功',
            'data' => [
                [
                    'carrierDriverPhone' => '18810585023',
                    'carrierDriverName' => '张路',
                    'locations' => [
                        'latitude' => 30.31432,
                        'longitude' => 120.32434,
                        'status' => 10,
                        'occurredAt' => 1561088972000
                    ],
                ],
            ],
        ]);

        $this->assertSame(
            $ApiClient->request('order/carrier_route', $data),
            $client->carrierRouteOrder($data)
        );

    }

}
