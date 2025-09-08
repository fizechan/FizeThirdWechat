<?php

namespace Tests\SampleCode;

use Fize\Cache\CacheFactory;
use Fize\Third\Wechat\Api;
use PHPUnit\Framework\TestCase;

class TestOpenSSL extends TestCase
{

    public function test_get_md_methods()
    {
        $methods = openssl_get_md_methods(true);
        var_dump($methods);
        self::assertIsArray($methods);
    }

    public function testEncryptAES256_GCM()
    {
        $cipher = 'aes-256-gcm';

        $data = "这里是要加密的数据";

        // 生成密钥
        $key = openssl_random_pseudo_bytes(32); // 32字节密钥
        $key = base64_encode($key);
        $key = 'YzaL0s6762YzHL8q2GJpBVp7BgSFLBuWq7ogaQRUcD8=';
        $key = base64_decode($key);

        // 初始向量iv
        $iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length($cipher)); // 12字节IV
        $iv = base64_encode($iv);
        $iv = 'EGXpLfaeh+CflE6u';
        $iv = base64_decode($iv);
        print_r("--------iv1---------\r\n");
        print_r($iv);

        // 加密数据
        $ciphertext = openssl_encrypt($data, $cipher, $key, 0, $iv, $tag);
        print_r("--------iv2---------\r\n");
        print_r($iv);
        print_r("--------tag-------------\r\n");
        print_r($tag);
        $tag3 = bin2hex($tag);
        print_r("--------tag3-------------\r\n");
        print_r($tag3);
        $tag = base64_encode($tag);
        print_r("--------tag2-------------\r\n");
        print_r($tag);
        $ciphertext = base64_encode($ciphertext);  // 通常需要编码为base64以便安全传输或存储
        echo "加密后的数据: " . base64_encode($ciphertext) . "\n"; // 输出加密数据
        echo "Tag: " . $tag . "\n"; // 保存Tag用于解密
        self::assertEquals('YVp6TG1VN2RTSlovVkFWaGVZU1JacE91eFZNaGhFUWY4cCt4', $ciphertext);
    }

    public function testEncryptSM4_GCM()
    {
        $cipher = 'sm4-gcm';

        $data = "这里是要加密的数据";

        // 生成密钥
        $key = openssl_random_pseudo_bytes(32); // 32字节密钥
        $key = base64_encode($key);
        $key = 'Gie/B3QujuYnWwN5mRlIeg==';
        $key = base64_decode($key);

        // 初始向量iv
        $iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length($cipher)); // 12字节IV
        var_dump($iv);
        die();
        $iv = base64_encode($iv);
        $iv = 'EGXpLfaeh+CflE6u';
        $iv = base64_decode($iv);
        print_r("--------iv1---------\r\n");
        print_r($iv);

        // 加密数据
        $ciphertext = openssl_encrypt($data, $cipher, $key, 0, $iv, $tag);
        print_r("--------iv2---------\r\n");
        print_r($iv);
        print_r("--------tag-------------\r\n");
        print_r($tag);
        $tag3 = bin2hex($tag);
        print_r("--------tag3-------------\r\n");
        print_r($tag3);
        $tag = base64_encode($tag);
        print_r("--------tag2-------------\r\n");
        print_r($tag);
        $ciphertext = base64_encode($ciphertext);  // 通常需要编码为base64以便安全传输或存储
        echo "加密后的数据: " . base64_encode($ciphertext) . "\n"; // 输出加密数据
        echo "Tag: " . $tag . "\n"; // 保存Tag用于解密
        self::assertEquals('YVp6TG1VN2RTSlovVkFWaGVZU1JacE91eFZNaGhFUWY4cCt4', $ciphertext);
    }

    public function testDecryptAES256_GCM()
    {
        $cipher = 'aes-256-gcm';
        $ciphertext = 'YVp6TG1VN2RTSlovVkFWaGVZU1JacE91eFZNaGhFUWY4cCt4';
        $ciphertext = base64_decode($ciphertext);
        $key = 'YzaL0s6762YzHL8q2GJpBVp7BgSFLBuWq7ogaQRUcD8=';
        $key = base64_decode($key);
        $iv = 'EGXpLfaeh+CflE6u';
        $iv = base64_decode($iv);
        $tag = 'AHIDUYmd83gBzZ2cCSjTFg==';
        $tag = base64_decode($tag);
        $originalData = openssl_decrypt($ciphertext, $cipher, $key, 0, $iv, $tag);
        echo "解密后的数据: " . $originalData . "\n"; // 输出解密数据，应与原始数据相同
        $data = "这里是要加密的数据";
        self::assertEquals($data, $originalData);
    }

    public function testSign()
    {

    }

    public function testVerify()
    {

    }

    public function testToken()
    {
        $appid = 'wx12078319bd1c19dd';
        $appsecret = '89212483aa60a23a74ab7a11d78019f0';
        $cache = CacheFactory::create('file', ['path' => dirname(__FILE__, 2) . '/temp/cache']);
        $options = [
            'debug' => true,
        ];

        $api = new Api($appid, $appsecret, $options, $cache);
        $result = $api->token('client_credential');
        var_dump($result);
        self::assertIsArray($result);
    }

    public function testGetApiDomainIp()
    {
        $appid = 'wx12078319bd1c19dd';
        $appsecret = '89212483aa60a23a74ab7a11d78019f0';
        $cache = CacheFactory::create('file', ['path' => dirname(__FILE__, 2) . '/temp/cache']);
        $options = [
            'debug' => true,
        ];

        $api = new Api($appid, $appsecret, $options, $cache);
        $ips = $api->getApiDomainIp();
        var_dump($ips);
        self::assertIsArray($ips);
        self::assertNotEmpty($ips);
    }

    public function testGetcallbackip()
    {
        $appid = 'wx12078319bd1c19dd';
        $appsecret = '89212483aa60a23a74ab7a11d78019f0';
        $cache = CacheFactory::create('file', ['path' => dirname(__FILE__, 2) . '/temp/cache']);
        $options = [
            'debug' => true,
        ];

        $api = new Api($appid, $appsecret, $options, $cache);
        $ips = $api->getcallbackip();
        var_dump($ips);
        self::assertIsArray($ips);
        self::assertNotEmpty($ips);
    }

    public function testShorturl()
    {
        $appid = 'wx12078319bd1c19dd';
        $appsecret = '89212483aa60a23a74ab7a11d78019f0';
        $cache = CacheFactory::create('file', ['path' => dirname(__FILE__, 2) . '/temp/cache']);
        $options = [
            'debug' => true,
        ];

        $api = new Api($appid, $appsecret, $options, $cache);
        $long_url = 'https://www.baidu.com';
        $shorturl = $api->shorturl($long_url);
        self::assertIsString($shorturl);
    }

    public function testGetCurrentSelfmenuInfo()
    {
        $appid = 'wx12078319bd1c19dd';
        $appsecret = '89212483aa60a23a74ab7a11d78019f0';
        $cache = CacheFactory::create('file', ['path' => dirname(__FILE__, 2) . '/temp/cache']);
        $options = [
            'debug' => true,
        ];

        $api = new Api($appid, $appsecret, $options, $cache);
        $result = $api->getCurrentSelfmenuInfo();
        var_export($result);
        self::assertIsArray($result);
    }

    public function testClearQuota()
    {
        $appid = 'wx12078319bd1c19dd';
        $appsecret = '89212483aa60a23a74ab7a11d78019f0';
        $cache = CacheFactory::create('file', ['path' => dirname(__FILE__, 2) . '/temp/cache']);
        $options = [
            'debug' => true,
        ];

        $api = new Api($appid, $appsecret, $options, $cache);
        $api->clearQuota();
        self::assertTrue(true);
    }

    public function testGetCurrentAutoreplyInfo()
    {
        $appid = 'wx12078319bd1c19dd';
        $appsecret = '89212483aa60a23a74ab7a11d78019f0';
        $cache = CacheFactory::create('file', ['path' => dirname(__FILE__, 2) . '/temp/cache']);
        $options = [
            'debug' => true,
        ];

        $api = new Api($appid, $appsecret, $options, $cache);
        $result = $api->getCurrentAutoreplyInfo();
        var_export($result);
        self::assertIsArray($result);
    }
}
