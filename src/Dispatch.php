<?php

/*
 * This file is part of the cblink/eleme-dispatch.
 *
 * (c) jinjun <757258777@qq.com>
 *
 * This source file is subject to the MIT license that is bundled.
 */

namespace Cblink\ElemeDispatch;

class Dispatch extends Api
{
    /**
     * 查询配送服务.
     *
     * @param $data
     *
     * @return mixed|\Psr\Http\Message\ResponseInterface
     *
     * @throws Exceptions\InvalidConfigException
     */
    public function deliveryQuery($data)
    {
        return $this->setPrefix('anubis-webapi/v2')->request('chain_store/delivery/query', $data);
    }

    /**
     * 骑手位置.
     *
     * @param $data
     *
     * @return mixed|\Psr\Http\Message\ResponseInterface
     *
     * @throws Exceptions\InvalidConfigException
     */
    public function carrierOrder($data)
    {
        return $this->setPrefix('anubis-webapi/v2')->request('order/carrier', $data);
    }

    /**
     * 查询配送轨迹.
     *
     * @param $data
     *
     * @return mixed|\Psr\Http\Message\ResponseInterface
     *
     * @throws Exceptions\InvalidConfigException
     */
    public function carrierRouteOrder($data)
    {
        return $this->setPrefix('anubis-webapi/v2')->request('order/carrier_route', $data);
    }

    /**
     * 获取 token 信息
     */
    public function getToken()
    {
        return $this->getAccessToken();
    }

}
