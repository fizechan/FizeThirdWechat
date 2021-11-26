<?php


namespace Fize\Third\Wechat\Api\Customservice;

use CURLFile;
use Fize\Third\Wechat\Api;

/**
 * 客服账号
 */
class Kfaccount extends Api
{

    /**
     * 添加客服账号
     * @param string $kf_account 完整客服账号，格式为：账号前缀@公众号微信号，账号前缀最多10个字符，必须是英文或者数字字符
     * @param string $nickname 客服昵称，最长6个汉字或12个英文字符
     * @param string $password 客服账号明文登录密码，会自动加密
     */
    public function add($kf_account, $nickname, $password)
    {
        $params = [
            "kf_account" => $kf_account,
            "nickname"   => $nickname,
            "password"   => md5($password)
        ];
        $this->httpPost("/customservice/kfaccount/add?access_token={$this->accessToken}", $params);
    }

    /**
     * 邀请绑定客服帐号
     * @param string $kf_account 完整客服帐号
     * @param string $invite_wx 接收绑定邀请的客服微信号
     */
    public function inviteworker($kf_account, $invite_wx)
    {
        $params = [
            "kf_account" => $kf_account,
            "invite_wx"   => $invite_wx
        ];
        $this->httpPost("/customservice/kfaccount/inviteworker?access_token={$this->accessToken}", $params);
    }

    /**
     * 设置客服信息
     * @param string $account 完整客服账号，格式为：账号前缀@公众号微信号，账号前缀最多10个字符，必须是英文或者数字字符
     * @param string $nickname 客服昵称，最长6个汉字或12个英文字符
     */
    public function update($account, $nickname)
    {
        $params = [
            "kf_account" => $account,
            "nickname"   => $nickname
        ];
        $this->httpPost("/customservice/kfaccount/update?access_token={$this->accessToken}", $params);
    }

    /**
     * 上传客服头像
     * @param string $kf_account 完整客服账号，格式为：账号前缀@公众号微信号，账号前缀最多10个字符，必须是英文或者数字字符
     * @param string $file 头像文件完整路径,如：'D:\user.jpg'。头像文件必须JPG格式，像素建议640*640
     */
    public function uploadheadimg($kf_account, $file)
    {
        $params = [
            'media' => new CURLFile(realpath($file))
        ];
        $this->httpPost("/customservice/kfaccount/uploadheadimg?access_token={$this->accessToken}&kf_account={$kf_account}", $params, false);
    }

    /**
     * 删除客服帐号
     * @param string $kf_account 完整客服账号
     */
    public function del($kf_account)
    {
        $params = [
            "kf_account" => $kf_account
        ];
        $this->httpPost("/customservice/kfaccount/del?access_token={$this->accessToken}", $params);
    }
}
