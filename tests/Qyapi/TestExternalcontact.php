<?php

namespace Tests\Qyapi;

use Fize\Cache\CacheFactory;
use Fize\Third\Wechat\Qyapi\Externalcontact;
use PHPUnit\Framework\TestCase;

class TestExternalcontact extends TestCase
{

    public function testGetFollowUserList()
    {
        $cache = CacheFactory::create('File', ['path' => dirname(__FILE__, 3) . '/temp/cache']);
        $etc = new Externalcontact('ww95e5454de22a0a2b', 'LgOlSladRtX8t6Jl6xbDUjUlaXgGdBXE4ZoaekULHrY', [], $cache);
        $user = $etc->getFollowUserList();
        var_dump($user);
        self::assertIsArray($user);
    }
}
