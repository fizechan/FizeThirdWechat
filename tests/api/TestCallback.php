<?php

namespace api;

use fize\third\wechat\api\Callback;
use PHPUnit\Framework\TestCase;

class TestCallback extends TestCase
{

    public function testCheck()
    {
        $config = [
            'appid' => 'wx12078319bd1c19dd',
            'appsecret' => '89212483aa60a23a74ab7a11d78019f0',
            'debug' => true,
            'cache' => [
                'handler' => 'file',
                'config' => [
                    'path'    =>  __DIR__ . '/../../temp/cache',
                ]
            ]
        ];

        $api = new Callback($config);
        $result = $api->check(Callback::ACTION_ALL, Callback::CHECK_OPERATOR_DEFAULT);
        var_dump($result);
        self::assertIsArray($result);
        self::assertNotEmpty($result);
    }
}
