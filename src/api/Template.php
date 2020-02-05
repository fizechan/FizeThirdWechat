<?php


namespace fize\third\wechat\api;


use fize\third\wechat\Api;
use fize\crypt\Json;


/**
 * 微信模版消息类
 */
class Template extends Api
{

    const URL_TEMPLATE_API_SET_INDUSTRY = '/template/api_set_industry?';
    const URL_TEMPLATE_GET_INDUSTRY = '/template/get_industry?';
    const URL_TEMPLATE_API_ADD_TEMPLATE = '/template/api_add_template?';
    const URL_TEMPLATE_GET_ALL_PRIVATE_TEMPLATE = '/template/get_all_private_template?';
    const URL_TEMPLATE_DEL_PRIVATE_TEMPLATE = '/template/del_private_template?';
    const URL_TEMPLATE_SEND = '/template/send?';

    /**
     * 构造函数
     * @param array $options 参数数组
     */
    public function __construct(array $options)
    {
        parent::__construct($options);
        //检测TOKEN
        $this->checkAccessToken();
    }

    /**
     * 模板消息 设置所属行业
     * @see https://mp.weixin.qq.com/wiki?t=resource/res_main&id=mp1433751277
     * @param string $industry_id1 公众号模板消息所属行业编号，参看官方开发文档 行业代码
     * @param string $industry_id2 公众号模板消息所属行业编号，参看官方开发文档 行业代码
     * @return bool
     */
    public function apiSetIndustry($industry_id1, $industry_id2)
    {
        $data = [
            'industry_id1' => $industry_id1,
            'industry_id2' => $industry_id2
        ];
        $json = $this->httpPost(self::PREFIX_CGI . self::URL_TEMPLATE_API_SET_INDUSTRY . 'access_token=' . $this->accessToken, Json::encode($data, JSON_UNESCAPED_UNICODE));
        if ($json) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * 获取设置的行业信息
     * @return mixed
     */
    public function getIndustry()
    {
        $json = $this->httpGet(self::PREFIX_CGI . self::URL_TEMPLATE_GET_INDUSTRY . 'access_token=' . $this->accessToken);
        return $json;
    }

    /**
     * 模板消息 获得模板ID
     * 成功返回消息模板的调用id
     * @param string $tpl_id 模板库中模板的编号，有“TM**”和“OPENTMTM**”等形式
     * @return mixed
     */
    public function apiAddTemplate($tpl_id)
    {
        $data = ['template_id_short' => $tpl_id];
        $json = $this->httpPost(self::PREFIX_CGI . self::URL_TEMPLATE_API_ADD_TEMPLATE . 'access_token=' . $this->accessToken, Json::encode($data, JSON_UNESCAPED_UNICODE));
        if ($json && isset($json['template_id'])) {
            return $json['template_id'];
        } else {
            return false;
        }
    }

    /**
     * 获取模板列表
     * @return mixed
     */
    public function getAllPrivateTemplate()
    {
        $json = $this->httpGet(self::PREFIX_CGI . self::URL_TEMPLATE_GET_ALL_PRIVATE_TEMPLATE . 'access_token=' . $this->accessToken);
        return $json;
    }

    /**
     * 删除模板
     * @param string $tpl_id 公众帐号下模板消息ID
     * @return bool
     */
    public function delPrivateTemplate($tpl_id)
    {
        $data = ['template_id' => $tpl_id];
        $json = $this->httpPost(self::PREFIX_CGI . self::URL_TEMPLATE_DEL_PRIVATE_TEMPLATE . 'access_token=' . $this->accessToken, Json::encode($data, JSON_UNESCAPED_UNICODE));
        if($json){
            return true;
        }
        return false;
    }

    /**
     * 发送模板消息
     * @see https://mp.weixin.qq.com/wiki?t=resource/res_main&id=mp1433751277
     * @param array $data 消息结构
     * @return mixed 成功时返回消息id，失败时返回false
     */
    public function send(array $data)
    {
        $json = $this->httpPost(self::PREFIX_CGI . self::URL_TEMPLATE_SEND . 'access_token=' . $this->accessToken, Json::encode($data, JSON_UNESCAPED_UNICODE));
        if ($json && isset($json['msgid'])) {
            return $json['msgid'];
        } else {
            return false;
        }
    }
}
