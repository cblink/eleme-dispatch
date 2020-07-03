<?php

/*
 * This file is part of the cblink/eleme-dispatch.
 *
 * (c) jinjun <757258777@qq.com>
 *
 * This source file is subject to the MIT license that is bundled.
 */

namespace Cblink\ElemeDispatch\Providers;

use Cblink\ElemeDispatch\Order;
use Pimple\Container;
use Pimple\ServiceProviderInterface;

class OrderService implements ServiceProviderInterface
{
    public function register(Container $pimple)
    {
        $pimple['order'] = function (Container $app) {
            return new Order($app);
        };
    }
}
