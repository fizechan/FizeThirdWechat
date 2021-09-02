<?php


use fize\third\wechat\Api;
use fize\cache\CacheFactory;
use PHPUnit\Framework\TestCase;

class TestApi extends TestCase
{

    public function test__construct()
    {
        $appid = 'wx12078319bd1c19dd';
        $appsecret = '89212483aa60a23a74ab7a11d78019f0';
        $cache = CacheFactory::create('file', ['path' => dirname(__FILE__, 2) . '/temp/cache']);
        $options = [
            'debug' => true,
        ];

        $api = new Api($appid, $appsecret, $cache, $options);
        var_dump($api);
        self::assertIsObject($api);
    }

    public function testIsWechatBrowser()
    {
        //
    }

    public function testToken()
    {
        //
    }

    public function testGetcallbackip()
    {
        $appid = 'wx12078319bd1c19dd';
        $appsecret = '89212483aa60a23a74ab7a11d78019f0';
        $cache = CacheFactory::create('file', ['path' => dirname(__FILE__, 2) . '/temp/cache']);
        $options = [
            'debug' => true,
        ];

        $api = new Api($appid, $appsecret, $cache, $options);
        $ips = $api->getcallbackip();
        var_dump($ips);
        self::assertIsArray($ips);
        self::assertNotEmpty($ips);
    }
}
