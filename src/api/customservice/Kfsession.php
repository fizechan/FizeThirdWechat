<?php


namespace fize\third\wechat\api;


use fize\third\wechat\Api;


/**
 * 会话控制
 */
class Kfsession extends Api
{

    /**
     * 创建会话
     * @param string $kf_account //客服账号
     * @param string $openid //用户openid
     */
    public function create($kf_account, $openid)
    {
        $params = [
            "kf_account" => $kf_account,
            "openid"     => $openid
        ];
        $this->httpPost("/customservice/kfsession/create?access_token={$this->accessToken}", $params);
    }

    /**
     * 关闭会话
     * @param string $kf_account //客服账号
     * @param string $openid //用户openid
     */
    public function close($kf_account, $openid)
    {
        $params = [
            "kf_account" => $kf_account,
            "openid"     => $openid
        ];
        $this->httpPost("/customservice/kfsession/close?access_token={$this->accessToken}", $params);
    }

    /**
     * 获取客户会话状态
     * @param string $openid 用户openid
     * @return array
     */
    public function getsession($openid)
    {
        return $this->httpGet("/customservice/kfsession/getsession?access_token={$this->accessToken}&openid={$openid}");
    }

    /**
     * 获取客服会话列表
     * @param string $kf_account 完整客服账号
     * @return array
     */
    public function getsessionlist($kf_account)
    {
        return $this->httpGet("/customservice/kfsession/getsessionlist?access_token={$this->accessToken}&kf_account={$kf_account}");
    }

    /**
     * 获取未接入会话列表
     * @return array
     */
    public function getwaitcase()
    {
        return $this->httpGet("/customservice/kfsession/getwaitcase?access_token={$this->accessToken}");
    }
}
