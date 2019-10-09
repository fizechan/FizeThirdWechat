<?php

/*
 * 测试适配器模式
 */

namespace app\controller;

use fize\cache\Cache;
use fize\third\wechat\Api;


class ControllerFizeWechat
{

    public function __construct()
    {
        //CACHE初始化
        Cache::init('file');
    }

    public function actionIndex()
    {
        $config = [
            'appid' => 'wx12078319bd1c19dd',
            'appsecret' => '89212483aa60a23a74ab7a11d78019f0',
            'debug' => true
        ];

        $api = new Api($config);
        $token_ok = $api->checkAccessToken();
        var_dump($token_ok);

        if($token_ok){
            var_dump($api->getAccessToken());
        }
	}

	public function actionGetCallBackIp()
    {
        $config = [
            'appid' => 'wx12078319bd1c19dd',
            'appsecret' => '89212483aa60a23a74ab7a11d78019f0',
            'debug' => true
        ];

        $api = new Api($config);
        $ips = $api->getCallBackIp();
        var_dump($ips);
    }

    public function actionGetCurrentSelfmenuInfo()
    {
        $config = [
            'appid' => 'wx12078319bd1c19dd',
            'appsecret' => '89212483aa60a23a74ab7a11d78019f0',
            'debug' => true
        ];

        $api = new Api($config);
        $menu_info = $api->getCurrentSelfmenuInfo();
        var_dump($menu_info);
    }
}
