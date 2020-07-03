<?php

/*
 * This file is part of the cblink/eleme-dispatch.
 *
 * (c) jinjun <757258777@qq.com>
 *
 * This source file is subject to the MIT license that is bundled.
 */

namespace Cblink\ElemeDispatch;

use Cblink\ElemeDispatch\Exceptions\InvalidConfigException;
use Doctrine\Common\Cache\Cache;
use Doctrine\Common\Cache\FilesystemCache;
use Exception;
use Hanson\Foundation\AbstractAPI;

class Api extends AbstractAPI
{
    /** @var ElemeDispatch */
    protected $app;

    /**
     * 域名.
     *
     * @var string
     */
    protected $host;

    /**
     * 缓存
     *
     * @var FilesystemCache|mixed
     */
    protected $cache;

    /**
     * access_token.
     *
     * @var string
     */
    protected $token;

    /**
     * 获取 token 的地址
     *
     * @var string
     */
    protected $tokenUrl;

    /**
     * 参数处理.
     *
     * @var array
     */
    private $data;

    /**
     * 前缀
     *
     * @var string
     */
    protected $prefix;

    /**
     * 签名.
     *
     * @var string
     */
    protected $sign;

    public function __construct($app)
    {
        $this->app = $app;

        $this->host = $this->app->getConfig('debug') ? 'https://exam-anubis.ele.me' : 'https://exam-anubis.ele.me';

        $this->tokenUrl = $this->host.'/anubis-webapi/get_access_token';

        $this->cache = ($this->app->getConfig('cache') && $this->app->getConfig('cache') instanceof Cache) ?
            $this->app->getConfig('cache') :
            (new FilesystemCache(sys_get_temp_dir()));
    }

    /**
     * 请求
     *
     * @param $url
     * @param $data
     *
     * @return mixed|\Psr\Http\Message\ResponseInterface
     *
     * @throws Exception
     * @throws InvalidConfigException
     */
    public function request($url, $data)
    {
        // 1. 获取 access_token
        $this->getAccessToken();

        // 2. 处理参数
        $this->setData($data);

        // 获取 url 地址
        $url = $this->getRequestUrl($url);

        $http = $this->getHttp();

        $http->addMiddleware($this->headerMiddleware([
            'Content-Type' => 'application/json',
        ]));

        $response = $http->json($url, $this->data);

        $response = json_decode(strval($response->getBody()), true);

        return $response;
    }

    /**
     * 设置 url.
     *
     * @param $url
     *
     * @return string
     *
     * @throws Exception
     * @throws InvalidConfigException
     */
    public function getRequestUrl($url)
    {
        return sprintf('%s/%s/%s', $this->host, $this->prefix, $url);
    }

    /**
     * token 签名.
     *
     * @return string
     */
    public function generateTokenSign($salt)
    {
        // 2. 拼接字符传
        $seed = sprintf(
            'app_id=%s&salt=%s&secret_key=%s',
            $this->app->getConfig('app_id'),
            $salt,
            $this->app->getConfig('secret_key')
        );

        return md5(urlencode($seed));
    }

    /**
     * 请求接口 签名.
     *
     * @return string
     */
    public function generateSign($urlencodeData, $salt)
    {
        // 2. 拼接字符传
        $seed = sprintf(
            'app_id=%s&access_token=%s&data=%s&salt=%s',
            $this->app->getConfig('app_id'),
            $this->token,
            $urlencodeData,
            $salt
        );

        return md5($seed);
    }

    /**
     * 格式化数据.
     *
     * @param $data
     *
     * @throws Exception
     */
    public function setData($data)
    {
        $salt = mt_rand(1000, 9999);

        $dataJson = json_encode($data, JSON_UNESCAPED_UNICODE);

        $urlencodeData = urlencode($dataJson);

        $sig = $this->generateSign($urlencodeData, $salt);

        $this->data = [
            'app_id' => $this->app->getConfig('app_id'),
            'salt' => $salt,
            'data' => $urlencodeData,
            'signature' => $sig,
        ];
    }

    /**
     *  token.
     */
    public function getAccessToken()
    {
        // 如果缓存存在
        if ($this->cache->fetch($this->app->getConfig('app_id').'_token')) {
            $this->token = $this->cache->fetch($this->app->getConfig('app_id').'_token');
        } else {
            $salt = mt_rand(1000, 9999);

            $http = $this->getHttp();

            $http->addMiddleware($this->headerMiddleware([
                'Content-Type' => 'application/json',
            ]));

            $sign = $this->generateTokenSign($salt);

            $response = $http->get($this->tokenUrl, [
                'app_id' => $this->app->getConfig('app_id'),
                'salt' => $salt,
                'signature' => $sign,
            ]);

            $this->token = json_decode(strval($response->getBody()), true)['data']['access_token'];

            $this->setCache(json_decode(strval($response->getBody()), true)['data']['expire_time']);
        }
    }

    /**
     * 缓存.
     *
     * @param $expireTime
     */
    public function setCache($expireTime)
    {
        $lifeTime = intval(floor($expireTime / 1000) - time());

        $this->cache->save($this->app->getConfig('app_id').'_token', $this->token, $lifeTime);
    }

    /**
     * 请求接口模块.
     *
     * @param $prefix
     *
     * @return $this
     */
    public function setPrefix($prefix)
    {
        $this->prefix = $prefix;

        return $this;
    }
}
