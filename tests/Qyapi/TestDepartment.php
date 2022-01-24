<?php

namespace Tests\Qyapi;

use Fize\Third\Wechat\Qyapi\Department;
use PHPUnit\Framework\TestCase;

class TestDepartment extends TestCase
{

    public function testSimplelist()
    {
        $dpt = new Department('ww95e5454de22a0a2b', 'LgOlSladRtX8t6Jl6xbDUhmQu1bj0lLx96vZUxTHYi8');
        $result = $dpt->simplelist();
        var_dump($result);
        self::assertIsArray($result);
    }
}
