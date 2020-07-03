<?php

/*
 * This file is part of the cblink/eleme-dispatch.
 *
 * (c) jinjun <757258777@qq.com>
 *
 * This source file is subject to the MIT license that is bundled.
 */

namespace Cblink\ElemeDispatch;

class Shop extends Api
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
    public function createShop($data)
    {
        return $this->setPrefix('anubis-webapi/v2')->request('chain_store', $data);
    }

    /**
     * 编辑门店.
     *
     * @param $urle
     * @param $data
     *
     * @return mixed|\Psr\Http\Message\ResponseInterface
     *
     * @throws Exceptions\InvalidConfigException
     */
    public function updateShop($data)
    {
        return $this->setPrefix('anubis-webapi/v2')->request('chain_store/update', $data);
    }

    /**
     * 查询门店信息.
     *
     * @param $data
     *
     * @return mixed|\Psr\Http\Message\ResponseInterface
     *
     * @throws Exceptions\InvalidConfigException
     */
    public function queryShop($data)
    {
        return $this->setPrefix('anubis-webapi/v2')->request('chain_store/query', $data);
    }

    /**
     * 查询门店可查询范围
     *
     * @param $data
     * @return mixed|\Psr\Http\Message\ResponseInterface
     * @throws Exceptions\InvalidConfigException
     */
    public function chainStoreDeliveryArea($data)
    {
        return $this->setPrefix('anubis-webapi/v2')->request('chain_store/delivery_area', $data);
    }

}
