<?php


use fize\third\wechat\Api;
use PHPUnit\Framework\TestCase;

class TestApi extends TestCase
{

    public function test__construct()
    {
        $config = [
            'appid' => 'wx12078319bd1c19dd',
            'appsecret' => '89212483aa60a23a74ab7a11d78019f0',
            'debug' => true,
            'cache' => [
                'handler' => 'file',
                'config' => [
                    'path'    =>  __DIR__ . '/../temp/cache',
                ]
            ]
        ];

        $api = new Api($config);
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
        $config = [
            'appid' => 'wx12078319bd1c19dd',
            'appsecret' => '89212483aa60a23a74ab7a11d78019f0',
            'debug' => true,
            'cache' => [
                'handler' => 'file',
                'config' => [
                    'path'    =>  __DIR__ . '/../temp/cache',
                ]
            ]
        ];

        $api = new Api($config);
        $ips = $api->getcallbackip();
        var_dump($ips);
        self::assertIsArray($ips);
        self::assertNotEmpty($ips);
    }
}
