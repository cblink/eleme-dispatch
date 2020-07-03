<?php

/*
 * This file is part of the cblink/eleme-dispatch.
 *
 * (c) jinjun <757258777@qq.com>
 *
 * This source file is subject to the MIT license that is bundled.
 */

namespace Cblink\ElemeDispatch;

class Order extends Api
{
    /**
     * 创建订单.
     *
     * @param $url
     * @param $data
     *
     * @return mixed|\Psr\Http\Message\ResponseInterface
     *
     * @throws Exceptions\InvalidConfigException
     */
    public function createOrder($data)
    {
        return $this->setPrefix('anubis-webapi/v2')->request('order', $data);
    }

    /**
     * 取消.
     *
     * @param $urle
     * @param $data
     *
     * @return mixed|\Psr\Http\Message\ResponseInterface
     *
     * @throws Exceptions\InvalidConfigException
     */
    public function cancelOrder($data)
    {
        return $this->setPrefix('anubis-webapi/v2')->request('order/cancel', $data);
    }

    /**
     * 订单查询.
     *
     * @param $data
     *
     * @return mixed|\Psr\Http\Message\ResponseInterface
     *
     * @throws Exceptions\InvalidConfigException
     */
    public function queryOrder($data)
    {
        return $this->setPrefix('anubis-webapi/v2')->request('order/query', $data);
    }

    /**
     * 订单投诉.
     *
     * @param $data
     *
     * @return mixed|\Psr\Http\Message\ResponseInterface
     *
     * @throws Exceptions\InvalidConfigException
     */
    public function complaint($data)
    {
        return $this->setPrefix('anubis-webapi/v2')->request('order/complaint', $data);
    }
}
