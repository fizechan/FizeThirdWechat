<?php

namespace Tests\SampleCode;

use Fize\Cache\CacheFactory;
use Fize\Third\Wechat\Api;
use PHPUnit\Framework\TestCase;

class TestOpenSSL extends TestCase
{

    public function test_get_md_methods()
    {
        $methods = openssl_get_md_methods(true);
        var_dump($methods);
        self::assertIsArray($methods);
    }

    public function testToken()
    {
        $appid = 'wx12078319bd1c19dd';
        $appsecret = '89212483aa60a23a74ab7a11d78019f0';
        $cache = CacheFactory::create('file', ['path' => dirname(__FILE__, 2) . '/temp/cache']);
        $options = [
            'debug' => true,
        ];

        $api = new Api($appid, $appsecret, $options, $cache);
        $result = $api->token('client_credential');
        var_dump($result);
        self::assertIsArray($result);
    }

    public function testGetApiDomainIp()
    {
        $appid = 'wx12078319bd1c19dd';
        $appsecret = '89212483aa60a23a74ab7a11d78019f0';
        $cache = CacheFactory::create('file', ['path' => dirname(__FILE__, 2) . '/temp/cache']);
        $options = [
            'debug' => true,
        ];

        $api = new Api($appid, $appsecret, $options, $cache);
        $ips = $api->getApiDomainIp();
        var_dump($ips);
        self::assertIsArray($ips);
        self::assertNotEmpty($ips);
    }

    public function testGetcallbackip()
    {
        $appid = 'wx12078319bd1c19dd';
        $appsecret = '89212483aa60a23a74ab7a11d78019f0';
        $cache = CacheFactory::create('file', ['path' => dirname(__FILE__, 2) . '/temp/cache']);
        $options = [
            'debug' => true,
        ];

        $api = new Api($appid, $appsecret, $options, $cache);
        $ips = $api->getcallbackip();
        var_dump($ips);
        self::assertIsArray($ips);
        self::assertNotEmpty($ips);
    }

    public function testShorturl()
    {
        $appid = 'wx12078319bd1c19dd';
        $appsecret = '89212483aa60a23a74ab7a11d78019f0';
        $cache = CacheFactory::create('file', ['path' => dirname(__FILE__, 2) . '/temp/cache']);
        $options = [
            'debug' => true,
        ];

        $api = new Api($appid, $appsecret, $options, $cache);
        $long_url = 'https://www.baidu.com';
        $shorturl = $api->shorturl($long_url);
        self::assertIsString($shorturl);
    }

    public function testGetCurrentSelfmenuInfo()
    {
        $appid = 'wx12078319bd1c19dd';
        $appsecret = '89212483aa60a23a74ab7a11d78019f0';
        $cache = CacheFactory::create('file', ['path' => dirname(__FILE__, 2) . '/temp/cache']);
        $options = [
            'debug' => true,
        ];

        $api = new Api($appid, $appsecret, $options, $cache);
        $result = $api->getCurrentSelfmenuInfo();
        var_export($result);
        self::assertIsArray($result);
    }

    public function testClearQuota()
    {
        $appid = 'wx12078319bd1c19dd';
        $appsecret = '89212483aa60a23a74ab7a11d78019f0';
        $cache = CacheFactory::create('file', ['path' => dirname(__FILE__, 2) . '/temp/cache']);
        $options = [
            'debug' => true,
        ];

        $api = new Api($appid, $appsecret, $options, $cache);
        $api->clearQuota();
        self::assertTrue(true);
    }

    public function testGetCurrentAutoreplyInfo()
    {
        $appid = 'wx12078319bd1c19dd';
        $appsecret = '89212483aa60a23a74ab7a11d78019f0';
        $cache = CacheFactory::create('file', ['path' => dirname(__FILE__, 2) . '/temp/cache']);
        $options = [
            'debug' => true,
        ];

        $api = new Api($appid, $appsecret, $options, $cache);
        $result = $api->getCurrentAutoreplyInfo();
        var_export($result);
        self::assertIsArray($result);
    }
}
