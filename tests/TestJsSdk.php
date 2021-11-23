<?php

use fize\cache\CacheFactory;
use fize\third\wechat\JsSdk;
use PHPUnit\Framework\TestCase;

class TestJsSdk extends TestCase
{

    public function testGetConfig()
    {
        $appid = 'wx12078319bd1c19dd';
        $appsecret = '89212483aa60a23a74ab7a11d78019f0';
        $cache = CacheFactory::create('file', ['path' => dirname(__FILE__, 2) . '/temp/cache']);
        $options = [
            'debug' => true,
        ];
        $jssdk = new JsSdk($appid, $appsecret, $options, $cache);
        $url = 'https://www.baidu.com';
        $config = $jssdk->getConfig($url);
        var_dump($config);
        self::assertIsArray($config);
    }

    public function testIsWechatBrowser()
    {
        $is = JsSdk::isWechatBrowser();
        var_dump($is);
        self::assertIsBool($is);
    }
}
