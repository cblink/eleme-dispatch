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
use Cblink\ElemeDispatch\ElemeDispatch;
use Cblink\ElemeDispatch\Order;
use PHPUnit\Framework\TestCase;

class OrderTest extends TestCase
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

        $fileName = __DIR__ . '/../../config/baseConfig.php';

        if (file_exists($fileName)){
            $config = include $fileName;
        }

        $this->elemeDispatch = new ElemeDispatch($config);
    }

    public function testOrderCreate()
    {
        // 参数
        $data = [
            'transport_info' => [
                'transport_name' => 'test0001',
                'transport_address' => '上海市普陀区近铁城市广场5楼',
                'transport_longitude' => 121.5156496362,
                'transport_latitude' => 31.2331643501,
                'position_source' => 1,
                'transport_tel' => '13900000000',
                'transport_remark' => '备注',
            ],
            'receiver_info' => [
                'receiver_name' => 'jiabuchong',
                'receiver_primary_phone' => '13900000000',
                'receiver_second_phone' => '13911111111',
                'receiver_address' => '太阳',
                'receiver_longitude' => 121.5156496362,
                'position_source' => 3,
                'receiver_latitude' => 31.2331643501,
            ],
            'items_json' => [
                [
                    'item_name' => '苹果',
                    'item_quantity' => 5,
                    'item_price' => 9.50,
                    'item_actual_price' => 10.00,
                    'is_need_package' => 1,
                    'is_agent_purchase' => 1,
                    'agent_purchase_price' => '10',
                ],
                [
                    'item_name' => '香蕉',
                    'item_quantity' => 20,
                    'item_price' => 100.00,
                    'item_actual_price' => 300.59,
                    'is_need_package' => 1,
                    'is_agent_purchase' => 1,
                    'agent_purchase_price' => '10',
                ],
            ],
            'partner_remark' => '天下萨拉',
            'partner_order_code' => '1234567890xx124',     // 第三方订单号, 需唯一
            'notify_url' => 'http://www.test/testjin',     //第三方回调 url地址
            'order_type' => 2,
            'order_total_amount' => 50.00,
            'order_actual_amount' => 48.00,
            'order_weight' => 12.0,
            'is_invoiced' => 1,
            'invoice' => '饿了么',
            'order_payment_status' => 1,
            'order_payment_method' => 1,
            'require_payment_pay' => 50.00,
            'goods_count' => 4,
            'is_agent_payment' => 1,
            'require_receive_time' => strtotime('+1 day') * 1000,  //注意这是毫秒数
        ];

        // 模拟类
        $client = \Mockery::mock(Order::class, [$this->elemeDispatch]);

        $client->expects()
            ->createOrder($data)
            ->andReturn([
                'code' => '200',
                'data' => null,
                'msg' => '接收成功',
            ]);

        $ApiClient = \Mockery::mock(Api::class, [$this->elemeDispatch]);
        $ApiClient->expects()->request('order', $data)->andReturn([
            'code' => '200',
            'data' => null,
            'msg' => '接收成功',
        ]);

        $this->assertSame(
            $ApiClient->request('order', $data),
            $client->createOrder($data)
        );

    }

    /**
     * 查询订单
     *
     * @throws \Cblink\ElemeDispatch\Exceptions\InvalidConfigException\
     */
    public function testQueryOrder()
    {
        $data = [
            "partner_order_code" => "1234567890xx124"
        ];

        $client = \Mockery::mock(Order::class, [$this->elemeDispatch]);

        $client->expects()
            ->queryOrder($data)
            ->andReturn([
                'code' => '200',
                'msg' => 'success',
                'data' => [
                    'transport_station_id' => 1234,
                    'transport_station_tel' => '13112345678',
                    'tracking_id' => 1111111111,
                    'carrier_driver_id' => 1,
                    'carrier_driver_name' => '张三',
                    'carrier_driver_phone' => '13112345678',
                    'estimate_arrive_time' => 1469088084266,
                    'order_total_delivery_cost' => 0,
                    'order_total_delivery_discount' => 0,
                    'order_status' => 1,
                    'abnormal_code' => 'ORDER_OUT_OF_DISTANCE_ERROR',
                    'abnormal_desc' => '订单超区',
                    'handle_id' => '2733977',
                    'complaint_status' => '1',
                    'complaint_description' => '提前点击送达',
                    'event_log_details' => [
                        [
                            'order_status' => 1,
                            'occur_time' => 1469088084269,
                            'carrier_driver_name' => '张三',
                            'carrier_driver_phone' => '13112345678'
                        ],
                    ]

                ],
            ]);

        $ApiClient = \Mockery::mock(Api::class, [$this->elemeDispatch]);
        $ApiClient->expects()->request('order/query', $data)->andReturn([
            'code' => '200',
            'msg' => 'success',
            'data' => [
                'transport_station_id' => 1234,
                'transport_station_tel' => '13112345678',
                'tracking_id' => 1111111111,
                'carrier_driver_id' => 1,
                'carrier_driver_name' => '张三',
                'carrier_driver_phone' => '13112345678',
                'estimate_arrive_time' => 1469088084266,
                'order_total_delivery_cost' => 0,
                'order_total_delivery_discount' => 0,
                'order_status' => 1,
                'abnormal_code' => 'ORDER_OUT_OF_DISTANCE_ERROR',
                'abnormal_desc' => '订单超区',
                'handle_id' => '2733977',
                'complaint_status' => '1',
                'complaint_description' => '提前点击送达',
                'event_log_details' => [
                    [
                        'order_status' => 1,
                        'occur_time' => 1469088084269,
                        'carrier_driver_name' => '张三',
                        'carrier_driver_phone' => '13112345678'
                    ],
                ]

            ],
        ]);

        $this->assertSame(
            $ApiClient->request('order/query', $data),
            $client->queryOrder($data)
        );
    }

    /**
     * 取消订单
     */
    public function testCancelOrder()
    {
        $data = [
            'partner_order_code' => '1234567890xx124',
            'order_cancel_reason_code' => 2,
            'order_cancel_code' => 1,
            'order_cancel_description' => '货品不新鲜',
            'order_cancel_time' => 1452570728594
        ];

        // 模拟类
        $client = \Mockery::mock(Order::class, [$this->elemeDispatch]);

        $client->expects()
            ->cancelOrder($data)
            ->andReturn([
                'code' => '200',
                'data' => null,
                'msg' => '接收成功',
            ]);

        $ApiClient = \Mockery::mock(Api::class, [$this->elemeDispatch]);
        $ApiClient->expects()->request('order/cancel', $data)->andReturn([
            'code' => '200',
            'data' => null,
            'msg' => '接收成功',
        ]);

        $this->assertSame(
            $ApiClient->request('order/cancel', $data),
            $client->cancelOrder($data)
        );
    }

    /**
     * 订单投诉
     */
    public function testComplaint()
    {
        $data = [
            'partner_order_code' => '1234567890xx124',
            'order_complaint_code' => 150,
            'order_complaint_desc' => '未保持餐品完整',
            'order_complaint_time' => 1452570728594
        ];

        // 模拟类
        $client = \Mockery::mock(Order::class, [$this->elemeDispatch]);

        $client->expects()
            ->complaint($data)
            ->andReturn([
                'code' => '200',
                'data' => null,
                'msg' => '接收成功',
            ]);

        $ApiClient = \Mockery::mock(Api::class, [$this->elemeDispatch]);
        $ApiClient->expects()->request('order/complaint', $data)->andReturn([
            'code' => '200',
            'data' => null,
            'msg' => '接收成功',
        ]);

        $this->assertSame(
            $ApiClient->request('order/complaint', $data),
            $client->complaint($data)
        );
    }
}
