<?php

namespace Tests\Api;

use Fize\Cache\CacheFactory;
use Fize\Third\Wechat\Api\Template;
use PHPUnit\Framework\TestCase;

class TestTemplate extends TestCase
{

    public function testApiSetIndustry()
    {
        $appid = 'wx12078319bd1c19dd';
        $appsecret = '89212483aa60a23a74ab7a11d78019f0';
        $cache = CacheFactory::create('file', ['path' => dirname(__FILE__, 3) . '/temp/cache']);
        $options = [
            'debug' => true,
        ];
        $tpmsg = new Template($appid, $appsecret, $options, $cache);
        $tpmsg->apiSetIndustry(1, 4);
        self::assertIsObject($tpmsg);
    }

    public function testGetIndustry()
    {
        $appid = 'wx12078319bd1c19dd';
        $appsecret = '89212483aa60a23a74ab7a11d78019f0';
        $cache = CacheFactory::create('file', ['path' => dirname(__FILE__, 3) . '/temp/cache']);
        $options = [
            'debug' => true,
        ];
        $tpmsg = new Template($appid, $appsecret, $options, $cache);
        $rst = $tpmsg->getIndustry();
        var_dump($rst);
        self::assertIsArray($rst);
    }

    public function testApiAddTemplate()
    {
        $appid = 'wx12078319bd1c19dd';
        $appsecret = '89212483aa60a23a74ab7a11d78019f0';
        $cache = CacheFactory::create('file', ['path' => dirname(__FILE__, 3) . '/temp/cache']);
        $options = [
            'debug' => true,
        ];
        $tpmsg = new Template($appid, $appsecret, $options, $cache);
        $template_id = $tpmsg->apiAddTemplate('TM00015');
        var_dump($template_id);
        self::assertIsString($template_id);
    }

    public function testGetAllPrivateTemplate()
    {
        $appid = 'wx12078319bd1c19dd';
        $appsecret = '89212483aa60a23a74ab7a11d78019f0';
        $cache = CacheFactory::create('file', ['path' => dirname(__FILE__, 3) . '/temp/cache']);
        $options = [
            'debug' => true,
        ];
        $tpmsg = new Template($appid, $appsecret, $options, $cache);
        $templates = $tpmsg->getAllPrivateTemplate();
        var_dump($templates);
        self::assertIsArray($templates);
    }

    public function testDelPrivateTemplate()
    {
        $appid = 'wx12078319bd1c19dd';
        $appsecret = '89212483aa60a23a74ab7a11d78019f0';
        $cache = CacheFactory::create('file', ['path' => dirname(__FILE__, 3) . '/temp/cache']);
        $options = [
            'debug' => true,
        ];
        $tpmsg = new Template($appid, $appsecret, $options, $cache);
        $tpmsg->delPrivateTemplate('TM00015');
        self::assertIsObject($tpmsg);
    }
}
