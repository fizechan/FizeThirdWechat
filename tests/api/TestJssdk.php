<?php

namespace api;

use fize\third\wechat\api\Jssdk;
use PHPUnit\Framework\TestCase;

class TestJssdk extends TestCase
{

    public function testGetConfig()
    {
        $config = [
            'appid' => 'wx12078319bd1c19dd',
            'appsecret' => '89212483aa60a23a74ab7a11d78019f0'
        ];
        $jssdk = new JsSdk($config);
        $sign = $jssdk->getConfig();
        var_dump($sign);
    }
}
