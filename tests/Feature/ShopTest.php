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
use Cblink\ElemeDispatch\Shop;
use PHPUnit\Framework\TestCase;

class ShopTest extends TestCase
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

        $fileName = __DIR__ . '/../../config/baseConfig1.php';

        if (file_exists($fileName)){
            $config = include $fileName;
        }

        $this->elemeDispatch = new ElemeDispatch($config);
    }

    public function testCreateShop()
    {
        // 参数
        $data = [
            'chain_store_code' => 'test0002',
            'chain_store_name' => '测试门店 2',
            'chain_store_type' => 2,
            'merchant_code' => 'merchant001',
            'contact_phone' => '13611581190',
            'address' => '上海市',
            'position_source' => 3,
            'longitude' => '109.690773',
            'latitude' => '19.91243',
            'service_code' => '1',
        ];

        $client = \Mockery::mock(Shop::class, [$this->elemeDispatch]);

        $client->expects()
            ->createShop($data)
            ->andReturn([
                'code' => '200',
                'msg' => 'success',
                'data' => null,
            ]);

        $ApiClient = \Mockery::mock(Api::class, [$this->elemeDispatch]);
        $ApiClient->expects()->request('chain_store', $data)->andReturn([
            'code' => '200',
            'msg' => 'success',
            'data' => null,
        ]);


        $this->assertSame(
            $ApiClient->request('chain_store', $data),
            $client->createShop($data)
        );

    }

    /**
     * 查询订单
     *
     * @throws \Cblink\ElemeDispatch\Exceptions\InvalidConfigException\
     */
    public function testQueryShop()
    {
        $data = [
            "chain_store_code" => ["test0001"]
        ];

        $client = \Mockery::mock(Shop::class, [$this->elemeDispatch]);

        $client->expects()
            ->queryShop($data)
            ->andReturn([
                'code' => '200',
                'msg' => 'success',
                'data' => [
                    'chain_store_code' => 'A001',
                    'chain_store_name' => '饿了么BOD7',
                    'address' => '300弄亚都国际名园5号楼2003室',
                    'latitude' => '30.6865430000',
                    'longitude' => '104.0280600000',
                    'position_source' => 3,
                    'city' => '上海',
                    'contact_phone' => '13900000000',
                    'service_code' => 1,
                    'status' => 1
                ],
            ]);

        $ApiClient = \Mockery::mock(Api::class, [$this->elemeDispatch]);
        $ApiClient->expects()->request('chain_store/query', $data)->andReturn([
            'code' => '200',
            'msg' => 'success',
            'data' => [
                'chain_store_code' => 'A001',
                'chain_store_name' => '饿了么BOD7',
                'address' => '300弄亚都国际名园5号楼2003室',
                'latitude' => '30.6865430000',
                'longitude' => '104.0280600000',
                'position_source' => 3,
                'city' => '上海',
                'contact_phone' => '13900000000',
                'service_code' => 1,
                'status' => 1
            ],
        ]);

        $this->assertSame(
            $ApiClient->request('chain_store/query', $data),
            $client->queryShop($data)
        );
    }

    /**
     * 修改门店
     */
    public function testUpdateShop()
    {
        $data = [
            'chain_store_code' => 'test0001',
            'chain_store_name' => '门店一',
            'contact_phone' => '13611581190',
            'address' => '上海市',
            'position_source' => 3,
            'longitude' => '109.690773',
            'latitude' => '19.91243',
            'service_code' => '1'
        ];

        $client = \Mockery::mock(Shop::class, [$this->elemeDispatch]);

        $client->expects()
            ->updateShop($data)
            ->andReturn([
                'code' => '200',
                'msg' => 'success',
                'data' => null,
            ]);

        $ApiClient = \Mockery::mock(Api::class, [$this->elemeDispatch]);
        $ApiClient->expects()->request('chain_store/update', $data)->andReturn([
            'code' => '200',
            'msg' => 'success',
            'data' => null,
        ]);

        $this->assertSame(
            $ApiClient->request('chain_store/update', $data),
            $client->updateShop($data)
        );
    }

    public function testChainStoreDeliveryArea()
    {
        $data = [
            'chain_store_code' => 'A001'
        ];

        $client = \Mockery::mock(Shop::class, [$this->elemeDispatch]);

        $client->expects()
            ->chainStoreDeliveryArea($data)
            ->andReturn([
                'code' => '200',
                'msg' => 'success',
                'data' => [
                    'status' => 0,
                    'range_list' => [
                        [
                            'range_id' => 45,
                            'ranges' => [
                                [
                                    'longitude' => '121.384439361627',
                                    'latitude' => '31.2390864288288'
                                ]
                            ]
                        ]
                    ],
                ]
            ]);

        $ApiClient = \Mockery::mock(Api::class, [$this->elemeDispatch]);
        $ApiClient->expects()->request('chain_store/delivery_area', $data)->andReturn([
            'code' => '200',
            'msg' => 'success',
            'data' => [
                'status' => 0,
                'range_list' => [
                    [
                        'range_id' => 45,
                        'ranges' => [
                            [
                                'longitude' => '121.384439361627',
                                'latitude' => '31.2390864288288'
                            ]
                        ]
                    ]
                ],
            ]
        ]);

        $this->assertSame(
            $ApiClient->request('chain_store/delivery_area', $data),
            $client->chainStoreDeliveryArea($data)
        );
    }
}
