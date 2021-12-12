<?php

namespace Tests\Api\Openapi;

use Fize\Cache\CacheFactory;
use Fize\Third\Wechat\Api\Openapi\Rid;
use PHPUnit\Framework\TestCase;

class TestRid extends TestCase
{

    public function testGet()
    {
        $appid = 'wx12078319bd1c19dd';
        $appsecret = '89212483aa60a23a74ab7a11d78019f0';
        $cache = CacheFactory::create('file', ['path' => dirname(__FILE__, 4) . '/temp/cache']);
        $options = [
            'debug' => true,
        ];

        $api = new Rid($appid, $appsecret, $options, $cache);
        $request = $api->get('61b57fec-043c4db6-7ca8caea');
        var_export($request);
        self::assertIsArray($request);
    }
}
