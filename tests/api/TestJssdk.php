<?php

namespace api;

use fize\cache\CacheFactory;
use fize\third\wechat\api\Jssdk;
use PHPUnit\Framework\TestCase;

class TestJssdk extends TestCase
{

    public function testGetConfig()
    {
        $appid = 'wx12078319bd1c19dd';
        $appsecret = '89212483aa60a23a74ab7a11d78019f0';
        $cache = CacheFactory::create('file', ['path' => dirname(__FILE__, 4) . '/temp/cache']);
        $options = [
            'debug' => true,
        ];
        $jssdk = new JsSdk($appid, $appsecret, null, $cache, $options);
        $config = $jssdk->getConfig();
        var_dump($config);
        self::assertIsArray($config);
    }
}
