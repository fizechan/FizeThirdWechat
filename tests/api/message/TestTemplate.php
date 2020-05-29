<?php

namespace api\message;

use fize\third\wechat\api\message\Template;
use PHPUnit\Framework\TestCase;

class TestTemplate extends TestCase
{

    public function testSend()
    {
        $config = [
            'appid' => 'wx12078319bd1c19dd',
            'appsecret' => '89212483aa60a23a74ab7a11d78019f0',
            'debug' => true,
            'cache' => [
                'handler' => 'file',
                'config' => [
                    'path'    =>  __DIR__ . '/../../../temp/cache',
                ]
            ]
        ];
        $tpmsg = new Template($config);
        $data = [
            "first" => [
                "value" =>"恭喜你购买成功！",
                "color" =>"#173177"
            ],
            "orderMoneySum" => [
                "value" => "39.8元",
                "color" => "#173177"
            ],
            "orderProductName" => [
                "value" => "巧克力",
                "color" => "#173177"
            ],
            "Remark" => [
                "value" => "欢迎再次购买！",
                "color" => "#173177"
            ]
        ];

        $url = 'http://weixin.qq.com/download';
        $miniprogram = [
            "appid" => "xiaochengxuappid12345",
            "pagepath" => "index?foo=bar"
        ];
        $msgid = $tpmsg->send('oFwwFt6U0H4bY4PNSAyX2_KpZs8A', 'oNoxm4kW4VHSdQ6474mVe-wIesEMwzgTk1Nk6aVHO8A', $data, $url, $miniprogram);
        var_dump($msgid);
        self::assertIsInt($msgid);
    }

    public function testSubscribe()
    {

    }
}
