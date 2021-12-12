<?php

namespace Tests\Api;

use Fize\Cache\CacheFactory;
use Fize\Third\Wechat\Api\Callback;
use PHPUnit\Framework\TestCase;

class TestCallback extends TestCase
{

    public function testCheck()
    {
        $appid = 'wx12078319bd1c19dd';
        $appsecret = '89212483aa60a23a74ab7a11d78019f0';
        $cache = CacheFactory::create('file', ['path' => dirname(__FILE__, 3) . '/temp/cache']);
        $options = [
            'debug' => true,
        ];

        $api = new Callback($appid, $appsecret, $options, $cache);

        $result = $api->check(Callback::ACTION_ALL, Callback::CHECK_OPERATOR_DEFAULT);
        var_dump($result);
        self::assertIsArray($result);

        sleep(20);  // 由于接口间隔时间限制，暂停一定时间。

        $result = $api->check(Callback::ACTION_DNS, Callback::CHECK_OPERATOR_CHINANET);
        var_dump($result);
        self::assertNotEmpty($result);

        sleep(60);  // 由于接口间隔时间限制，暂停一定时间。

        $result = $api->check(Callback::ACTION_PING, Callback::CHECK_OPERATOR_UNICOM);
        var_dump($result);
        self::assertIsArray($result);

        sleep(60);  // 由于接口间隔时间限制，暂停一定时间。

        $result = $api->check(Callback::ACTION_ALL, Callback::CHECK_OPERATOR_CAP);
        var_dump($result);
        self::assertIsArray($result);
    }
}
