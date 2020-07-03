<?php

/*
 * This file is part of the cblink/eleme-dispatch.
 *
 * (c) jinjun <757258777@qq.com>
 *
 * This source file is subject to the MIT license that is bundled.
 */

namespace Cblink\ElemeDispatch;

use Cblink\ElemeDispatch\Providers\DispatchService;
use Cblink\ElemeDispatch\Providers\LoggerService;
use Cblink\ElemeDispatch\Providers\OrderService;
use Cblink\ElemeDispatch\Providers\ShopService;
use Hanson\Foundation\Foundation;
use Hanson\Foundation\Log;
use Monolog\Handler\HandlerInterface;
use Monolog\Handler\NullHandler;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;

class ElemeDispatch extends Foundation
{
    protected $providers = [
        LoggerService::class,
        OrderService::class,
        DispatchService::class,
        ShopService::class,
    ];

    public function __construct($config)
    {
        parent::__construct($config);
        // 主动重新初始化日志
        $this->initializeLogger();
    }

    /**
     * 获取配置.
     *
     * @param null $key
     *
     * @return mixed
     */
    public function getConfig($key = null)
    {
        return $key ? $this->config[$key] : $this->config;
    }

    /**
     * @throws \Exception
     */
    protected function initializeLogger()
    {
        if ($this->foundationVersion() >= 3) {
            return;
        }

        // 当 foundation 小于 3 的时候，无法正常读取 config 的配置，需要主动重新获取
        // 以下进行 logger 的重新初始化
        $logger = new Logger($this['config']['log']['name'] ?? 'order');

        if (!($this['config']['debug'] ?? false) || defined('PHPUNIT_RUNNING')) {
            $logger->pushHandler(new NullHandler());
        } elseif (($this['config']['log']['handler'] ?? null) instanceof HandlerInterface) {
            $logger->pushHandler($this['config']['log']['handler']);
        } elseif ($logFile = ($this['config']['log']['file'] ?? null)) {
            $logger->pushHandler(new StreamHandler(
                $logFile,
                $this['config']['log']['level'] ?? Logger::WARNING,
                true,
                $this['config']['log']['permission'] ?? null
            ));
        }

        Log::setLogger($logger);
    }

    public function foundationVersion()
    {
        if (method_exists(parent::class, 'getConfig')) {
            return 3;
        }

        return 2;
    }
}
