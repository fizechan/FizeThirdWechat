<?php

namespace Tests\Qyapi;

use Fize\Third\Wechat\Qyapi\User;
use PHPUnit\Framework\TestCase;

class TestUser extends TestCase
{

    public function testSimplelist()
    {
        $user = new User('ww95e5454de22a0a2b', 'LgOlSladRtX8t6Jl6xbDUjUlaXgGdBXE4ZoaekULHrY');
        $result = $user->simplelist(7);
        var_export($result);
        self::assertIsArray($result);
    }
}
