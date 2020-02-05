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
        $token_ok = $api->checkAccessToken();
        var_dump($token_ok);

        if($token_ok){
            var_dump($api->getAccessToken());
        }
        self::assertIsObject($api);
    }

    public function testGetLastErrCode()
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
        $errcode = $api->getLastErrCode();
        var_dump($errcode);
        self::assertIsInt($errcode);
    }

    public function testGetLastErrMsg()
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
        $errmsg = $api->getLastErrMsg();
        var_dump($errmsg);
        self::assertIsString($errmsg);
    }

    public function testCheckAccessToken()
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
        $bool = $api->checkAccessToken();
        self::assertTrue($bool);
    }

    public function testResetAccessToken()
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
        $api->resetAccessToken();
        $token = $api->getAccessToken();
        self::assertEmpty($token);
    }

    public function testGetAccessToken()
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
        $api->checkAccessToken();
        $token = $api->getAccessToken();
        self::assertNotEmpty($token);
    }

    public function testIsWechatBrowser()
    {
        //
    }

    public function testGetCallBackIp()
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
        $ips = $api->getCallBackIp();
        var_dump($ips);
        self::assertIsArray($ips);
        self::assertNotEmpty($ips);
    }

    public function testCallbackCheck()
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
        $result = $api->callbackCheck(Api::ACTION_ALL, Api::CHECK_OPERATOR_DEFAULT);
        var_dump($result);
        self::assertIsArray($result);
        self::assertNotEmpty($result);
    }
}
