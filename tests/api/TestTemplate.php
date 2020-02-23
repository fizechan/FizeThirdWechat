<?php

namespace api;

use fize\third\wechat\api\Template;
use PHPUnit\Framework\TestCase;

class TestTemplate extends TestCase
{

    public function testApiSetIndustry()
    {
        $config = [
            'appid' => 'wx12078319bd1c19dd',
            'appsecret' => '89212483aa60a23a74ab7a11d78019f0'
        ];
        $tpmsg = new Template($config);
        $rst = $tpmsg->apiSetIndustry(1, 4);
        var_dump($rst);
    }

    public function testApiAddTemplate()
    {
        $config = [
            'appid' => 'wx12078319bd1c19dd',
            'appsecret' => '89212483aa60a23a74ab7a11d78019f0'
        ];
        $tpmsg = new Template($config);
        $rst = $tpmsg->apiAddTemplate('TM00015');
        var_dump($rst);
    }

    public function testDelPrivateTemplate()
    {
        $config = [
            'appid' => 'wx12078319bd1c19dd',
            'appsecret' => '89212483aa60a23a74ab7a11d78019f0'
        ];
        $tpmsg = new Template($config);
        $rst = $tpmsg->delPrivateTemplate('TM00015');
        var_dump($rst);
    }

    public function testGetIndustry()
    {
        $config = [
            'appid' => 'wx12078319bd1c19dd',
            'appsecret' => '89212483aa60a23a74ab7a11d78019f0'
        ];
        $tpmsg = new Template($config);
        $rst = $tpmsg->getIndustry();
        var_dump($rst);
    }

    public function testSend()
    {
        $config = [
            'appid' => 'wx12078319bd1c19dd',
            'appsecret' => '89212483aa60a23a74ab7a11d78019f0'
        ];
        $tpmsg = new Template($config);
        $data = [
                "first" => [
                    "value" =>"恭喜你购买成功！",
                    "color" =>"#173177"
                ],
                "keynote1" => [
                    "value" => "巧克力",
                    "color" => "#173177"
                ],
                "keynote2" => [
                    "value" => "39.8元",
                    "color" => "#173177"
                ],
                "keynote3" => [
                    "value" => "2014年9月22日",
                    "color" => "#173177"
                ],
                "remark" => [
                    "value" => "欢迎再次购买！",
                    "color" => "#173177"
                ]
        ];

        $url = 'http://weixin.qq.com/download';
        $miniprogram = [
            "appid" => "xiaochengxuappid12345",
            "pagepath" => "index?foo=bar"
        ];
        $rst = $tpmsg->send('OPENID', 'ngqIpbwh8bUfcSsECmogfXcV14J0tQlEpBO27izEYtY', $data, $url, $miniprogram);
        var_dump($rst);
    }

    public function testGetAllPrivateTemplate()
    {
        $config = [
            'appid' => 'wx12078319bd1c19dd',
            'appsecret' => '89212483aa60a23a74ab7a11d78019f0'
        ];
        $tpmsg = new Template($config);
        $rst = $tpmsg->getAllPrivateTemplate();
        var_dump($rst);
    }
}
