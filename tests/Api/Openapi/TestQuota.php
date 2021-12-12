<?php

namespace Tests\Api\Openapi;

use Fize\Cache\CacheFactory;
use Fize\Third\Wechat\Api\Openapi\Quota;
use PHPUnit\Framework\TestCase;

class TestQuota extends TestCase
{

    public function testGet()
    {
        $appid = 'wx12078319bd1c19dd';
        $appsecret = '89212483aa60a23a74ab7a11d78019f0';
        $cache = CacheFactory::create('file', ['path' => dirname(__FILE__, 3) . '/temp/cache']);
        $options = [
            'debug' => true,
        ];

        $api = new Quota($appid, $appsecret, $options, $cache);
        $quota = $api->get('/cgi-bin/message/custom/send');
        var_dump($quota);
        self::assertIsArray($quota);
    }
}
