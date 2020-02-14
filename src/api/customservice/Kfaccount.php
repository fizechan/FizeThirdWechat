<?php


namespace fize\third\wechat\offiaccount\customservice;

use CURLFile;
use fize\third\wechat\Offiaccount;

/**
 * 客服账号
 */
class Kfaccount extends Offiaccount
{

    /**
     * 添加客服账号
     * @param string $account //完整客服账号，格式为：账号前缀@公众号微信号，账号前缀最多10个字符，必须是英文或者数字字符
     * @param string $nickname //客服昵称，最长6个汉字或12个英文字符
     * @param string $password //客服账号明文登录密码，会自动加密
     * @return bool
     */
    public function add($account, $nickname, $password)
    {
        $params = [
            "kf_account" => $account,
            "nickname"   => $nickname,
            "password"   => md5($password)
        ];
        $result = $this->httpPost("/customservice/kfaccount/add?access_token={$this->accessToken}", $params);
        return $result ? true : false;
    }

    /**
     * 修改客服账号信息
     * @param string $account //完整客服账号，格式为：账号前缀@公众号微信号，账号前缀最多10个字符，必须是英文或者数字字符
     * @param string $nickname //客服昵称，最长6个汉字或12个英文字符
     * @param string $password //客服账号明文登录密码，会自动加密
     * @return bool
     */
    public function update($account, $nickname, $password)
    {
        $params = [
            "kf_account" => $account,
            "nickname"   => $nickname,
            "password"   => md5($password)
        ];
        $result = $this->httpPost("/customservice/kfaccount/update?access_token={$this->accessToken}", $params);
        return $result ? true : false;
    }

    /**
     * 删除客服帐号
     * @param string $account //完整客服账号，格式为：账号前缀@公众号微信号，账号前缀最多10个字符，必须是英文或者数字字符
     * @param string $nickname //客服昵称，最长6个汉字或12个英文字符
     * @param string $password //客服账号明文登录密码，会自动加密
     * @return bool
     */
    public function del($account, $nickname, $password)
    {
        $params = [
            "kf_account" => $account,
            "nickname"   => $nickname,
            "password"   => md5($password)
        ];
        $result = $this->httpPost("/customservice/kfaccount/del?access_token={$this->accessToken}", $params);
        return $result ? true : false;
    }

    /**
     * 设置客服帐号的头像
     * @param string $kf_account //完整客服账号，格式为：账号前缀@公众号微信号，账号前缀最多10个字符，必须是英文或者数字字符
     * @param string $file //头像文件完整路径,如：'D:\user.jpg'。头像文件必须JPG格式，像素建议640*640
     * @return boolean|array
     */
    public function uploadheadimg($kf_account, $file)
    {
        $params = [
            'media' => new CURLFile(realpath($file))
        ];
        $result = $this->httpPost("/customservice/kfaccount/uploadheadimg?access_token={$this->accessToken}&kf_account={$kf_account}", $params, false);
        return $result ? true : false;
    }
}
