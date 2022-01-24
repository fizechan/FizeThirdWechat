<?php

namespace Tests\Qyapi;

use Fize\Cache\CacheFactory;
use Fize\Third\Wechat\Qyapi\Appchat;
use PHPUnit\Framework\TestCase;

class TestAppchat extends TestCase
{

    public function testCreate()
    {
        $cache = CacheFactory::create('File', ['path' => dirname(__FILE__, 3) . '/temp/cache']);
        $apct = new Appchat('ww95e5454de22a0a2b', 'LgOlSladRtX8t6Jl6xbDUjUlaXgGdBXE4ZoaekULHrY', [], $cache);
        $result = $apct->create(['fzchen', 'chensw'], '测试群', 'fzchen', 'test1');
        var_dump($result);
        self::assertIsArray($result);
    }

    public function testSendText()
    {
        $cache = CacheFactory::create('File', ['path' => dirname(__FILE__, 3) . '/temp/cache']);
        $apct = new Appchat('ww95e5454de22a0a2b', 'LgOlSladRtX8t6Jl6xbDUjUlaXgGdBXE4ZoaekULHrY', [], $cache);
        $apct->sendText('test1', '这是一条由接口API群发出来的测试消息2，请忽略。');
        self::assertTrue(true);
    }
}
