<?php


namespace fize\third\wechat\api;


use fize\third\wechat\Api;
use fize\crypt\Json;
use CURLFile;


/**
 * 微信客服管理类
 */
class KfAccount extends Api
{

    const URL_CS_KFACCOUNT_ADD = '/customservice/kfaccount/add?';
    const URL_CS_KFACCOUNT_UPDATE = '/customservice/kfaccount/update?';
    const URL_CS_KFACCOUNT_DEL = '/customservice/kfaccount/del?';
    const URL_CS_KFACCOUNT_UPLOAD_HEADIMG = '/customservice/kfaccount/uploadheadimg?';


    const URL_CS_GETKFLIST = '/customservice/getkflist?';
    const URL_CS_GETONLINEKFLIST = '/customservice/getonlinekflist?';

    const URL_CS_GETRECORD = '/customservice/getrecord?';

    /**
     * 构造函数
     * @param array $options 参数数组
     */
    public function __construct($options)
    {
        parent::__construct($options);
        //检测TOKEN
        $this->checkAccessToken();
    }

    /**
     * 添加客服账号
     *
     * @param string $account //完整客服账号，格式为：账号前缀@公众号微信号，账号前缀最多10个字符，必须是英文或者数字字符
     * @param string $nickname //客服昵称，最长6个汉字或12个英文字符
     * @param string $password //客服账号明文登录密码，会自动加密
     * @return boolean
     */
    public function addKfAccount($account, $nickname, $password)
    {
        $data = array(
            "kf_account" => $account,
            "nickname"   => $nickname,
            "password"   => md5($password)
        );
        $result = $this->httpPost(self::PREFIX_API . self::URL_CS_KFACCOUNT_ADD . 'access_token=' . $this->accessToken, Json::encode($data, JSON_UNESCAPED_UNICODE));
        if ($result) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * 修改客服账号信息
     *
     * @param string $account //完整客服账号，格式为：账号前缀@公众号微信号，账号前缀最多10个字符，必须是英文或者数字字符
     * @param string $nickname //客服昵称，最长6个汉字或12个英文字符
     * @param string $password //客服账号明文登录密码，会自动加密
     * @return boolean
     */
    public function updateKfAccount($account, $nickname, $password)
    {
        $data = array(
            "kf_account" => $account,
            "nickname"   => $nickname,
            "password"   => md5($password)
        );
        $result = $this->httpPost(self::PREFIX_API . self::URL_CS_KFACCOUNT_UPDATE . 'access_token=' . $this->accessToken, Json::encode($data, JSON_UNESCAPED_UNICODE));
        if ($result) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * 删除客服账号
     *
     * @param string $account //完整客服账号，格式为：账号前缀@公众号微信号，账号前缀最多10个字符，必须是英文或者数字字符
     * @return boolean
     */
    public function deleteKfAccount($account)
    {
        $result = $this->httpGet(self::PREFIX_API . self::URL_CS_KFACCOUNT_DEL . 'access_token=' . $this->accessToken . '&kf_account=' . $account);
        if ($result) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * 上传客服头像
     *
     * @param string $account //完整客服账号，格式为：账号前缀@公众号微信号，账号前缀最多10个字符，必须是英文或者数字字符
     * @param string $path //头像文件完整路径,如：'D:\user.jpg'。头像文件必须JPG格式，像素建议640*640
     * @return boolean|array
     */
    public function setKfHeadImg($account, $path)
    {
        $data = [
            'media' => new CURLFile(realpath($path))
        ];
        $result = $this->httpPost(self::PREFIX_API . self::URL_CS_KFACCOUNT_UPLOAD_HEADIMG . 'access_token=' . $this->accessToken . '&kf_account=' . $account, $data, true);
        if ($result) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * 获取所有客服账号
     *
     * @return boolean|array
     */
    public function getCustomServiceKfList()
    {
        return $this->httpGet(self::PREFIX_CGI . self::URL_CS_GETKFLIST . 'access_token=' . $this->accessToken);
    }

    /**
     * 获取在线客服接待信息
     * @return boolean|array
     */
    public function getCustomServiceOnlineKfList()
    {
        $t_json = $this->httpGet(self::PREFIX_CGI . self::URL_CS_GETONLINEKFLIST . 'access_token=' . $this->accessToken);
        if ($t_json) {
            return $t_json['kf_online_list'];
        } else {
            return false;
        }
    }

    /**
     * 获取客服聊天记录
     * @param array $data 数据结构{"starttime":123456789,"endtime":987654321,"openid":"OPENID","pagesize":10,"pageindex":1,}
     * @return boolean|array
     */
    public function getRecord($data)
    {
        return $this->httpPost(self::PREFIX_CGI . self::URL_CS_GETRECORD . 'access_token=' . $this->accessToken, Json::encode($data, JSON_UNESCAPED_UNICODE));
    }
}
