<?php

/*
 * 测试适配器模式
 */

namespace app\controller;

use fize\cache\Cache;
use fize\loger\Log;
use fize\third\wechat\api\JsSdk;


class ControllerFizeWechatJsSdk
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
        $jssdk = new JsSdk($this->wxconfig);
        $sign = $jssdk->getJsSign();
        var_dump($sign);
	}

	public function actionBase64()
    {
        $str = 'd2VjaGF0X2pzYXBpX3RpY2tldHd4MTIwNzgzMTliZDFjMTlkZA==';
        $str = base64_decode($str);
        echo $str;
        echo '<br/>';
        echo "\r\n";
        $str = 'X1dFSVhJTl9BQ0NFU1NfVE9LRU5f';
        $str = base64_decode($str);
        echo $str;
    }
}
