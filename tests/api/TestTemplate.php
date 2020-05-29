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
            'appsecret' => '89212483aa60a23a74ab7a11d78019f0',
            'debug' => true,
            'cache' => [
                'handler' => 'file',
                'config' => [
                    'path'    =>  __DIR__ . '/../../temp/cache',
                ]
            ]
        ];
        $tpmsg = new Template($config);
        $tpmsg->apiSetIndustry(1, 4);
        self::assertIsObject($tpmsg);
    }

    public function testGetIndustry()
    {
        $config = [
            'appid' => 'wx12078319bd1c19dd',
            'appsecret' => '89212483aa60a23a74ab7a11d78019f0',
            'debug' => true,
            'cache' => [
                'handler' => 'file',
                'config' => [
                    'path'    =>  __DIR__ . '/../../temp/cache',
                ]
            ]
        ];
        $tpmsg = new Template($config);
        $rst = $tpmsg->getIndustry();
        var_dump($rst);
        self::assertIsArray($rst);
    }

    public function testApiAddTemplate()
    {
        $config = [
            'appid' => 'wx12078319bd1c19dd',
            'appsecret' => '89212483aa60a23a74ab7a11d78019f0',
            'debug' => true,
            'cache' => [
                'handler' => 'file',
                'config' => [
                    'path'    =>  __DIR__ . '/../../temp/cache',
                ]
            ]
        ];
        $tpmsg = new Template($config);
        $template_id = $tpmsg->apiAddTemplate('TM00015');
        var_dump($template_id);
        self::assertIsString($template_id);
    }

    public function testGetAllPrivateTemplate()
    {
        $config = [
            'appid' => 'wx12078319bd1c19dd',
            'appsecret' => '89212483aa60a23a74ab7a11d78019f0',
            'debug' => true,
            'cache' => [
                'handler' => 'file',
                'config' => [
                    'path'    =>  __DIR__ . '/../../temp/cache',
                ]
            ]
        ];
        $tpmsg = new Template($config);
        $templates = $tpmsg->getAllPrivateTemplate();
        var_dump($templates);
        self::assertIsArray($templates);
    }

    public function testDelPrivateTemplate()
    {
        $config = [
            'appid' => 'wx12078319bd1c19dd',
            'appsecret' => '89212483aa60a23a74ab7a11d78019f0'
        ];
        $tpmsg = new Template($config);
        $tpmsg->delPrivateTemplate('TM00015');
        self::assertIsObject($tpmsg);
    }
}
