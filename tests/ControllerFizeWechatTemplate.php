<?php

/*
 * 测试适配器模式
 */

namespace app\controller;

use fize\cache\Cache;
use fize\loger\Log;
use fize\third\wechat\api\Template;


class ControllerFizeWechatTemplate
{
    private $wxconfig;

    public function __construct()
    {
        //CACHE初始化
        Cache::init('file');
        //Loger初始化
        Log::init('file');

        $this->wxconfig = [
            'appid' => 'wx12078319bd1c19dd',
            'appsecret' => '89212483aa60a23a74ab7a11d78019f0',
            'debug' => true
        ];
    }

    public function actionIndex()
    {
        $tpmsg = new Template($this->wxconfig);
        $rst = $tpmsg->apiSetIndustry(1, 4);
        var_dump($rst);
        var_dump($tpmsg->errCode);
        var_dump($tpmsg->errMsg);
	}

    public function actionGetIndustry()
    {
        $tpmsg = new Template($this->wxconfig);
        $rst = $tpmsg->getIndustry();
        var_dump($rst);
        var_dump($tpmsg->errCode);
        var_dump($tpmsg->errMsg);
    }

    public function actionApiAddTemplate()
    {
        $tpmsg = new Template($this->wxconfig);
        $rst = $tpmsg->apiAddTemplate('TM00015');
        var_dump($rst);
        var_dump($tpmsg->errCode);
        var_dump($tpmsg->errMsg);
    }

    public function actionGetAllPrivateTemplate()
    {
        $tpmsg = new Template($this->wxconfig);
        $rst = $tpmsg->getAllPrivateTemplate();
        var_dump($rst);
        var_dump($tpmsg->errCode);
        var_dump($tpmsg->errMsg);
    }

    public function actionDelPrivateTemplate()
    {
        $tpmsg = new Template($this->wxconfig);
        $rst = $tpmsg->delPrivateTemplate('TM00015');
        var_dump($rst);
        var_dump($tpmsg->errCode);
        var_dump($tpmsg->errMsg);
    }

    public function actionSend()
    {
        $tpmsg = new Template($this->wxconfig);
        $data = [
            "touser" => "OPENID",
            "template_id" => "ngqIpbwh8bUfcSsECmogfXcV14J0tQlEpBO27izEYtY",
            "url" => "http://weixin.qq.com/download",
            "miniprogram" => [
                "appid" => "xiaochengxuappid12345",
                "pagepath" => "index?foo=bar"
           ],
           "data" => [
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
           ]
        ];
        $rst = $tpmsg->send($data);
        var_dump($rst);
        var_dump($tpmsg->errCode);
        var_dump($tpmsg->errMsg);
    }
}
