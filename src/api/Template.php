<?php


namespace fize\third\wechat\api;


use fize\third\wechat\Api;


/**
 * 模版消息
 */
class Template extends Api
{

    /**
     * 设置所属行业
     * @param string $industry_id1 公众号模板消息所属行业编号
     * @param string $industry_id2 公众号模板消息所属行业编号
     * @see https://developers.weixin.qq.com/doc/offiaccount/Message_Management/Template_Message_Interface.html#0
     */
    public function apiSetIndustry($industry_id1, $industry_id2)
    {
        $params = [
            'industry_id1' => $industry_id1,
            'industry_id2' => $industry_id2
        ];
        $this->httpPost("/template/api_set_industry?access_token={$this->accessToken}", $params);
    }

    /**
     * 获取设置的行业信息
     * @return array
     */
    public function getIndustry()
    {
        return $this->httpGet("/template/get_industry?access_token={$this->accessToken}");
    }

    /**
     * 获得模板ID
     * 成功返回消息模板的调用id
     * @param string $template_id_short 模板库中模板的编号
     * @return string
     */
    public function apiAddTemplate($template_id_short)
    {
        $params = ['template_id_short' => $template_id_short];
        $result = $this->httpPost("/template/api_add_template?access_token={$this->accessToken}", $params);
        return $result['template_id'];
    }

    /**
     * 获取模板列表
     * @return array
     */
    public function getAllPrivateTemplate()
    {
        $result = $this->httpGet("/template/get_all_private_template?access_token={$this->accessToken}");
        return $result['template_list'];
    }

    /**
     * 删除模板
     * @param string $template_id 公众帐号下模板消息ID
     */
    public function delPrivateTemplate($template_id)
    {
        $params = ['template_id' => $template_id];
        $this->httpPost("/template/del_private_template?access_token={$this->accessToken}", $params);
    }

    /**
     * 发送模板消息
     * @param string $touser 接收者openid
     * @param string $template_id 模板ID
     * @param array $data 模板数据
     * @param string $url 模板跳转链接
     * @param string|array $miniprogram 小程序
     * @param string $color 字体颜色
     * @return string 返回消息id
     */
    public function send($touser, $template_id, array $data, $url = null, $miniprogram = null, $color = null)
    {
        $params = [
            'touser'      => $touser,
            'template_id' => $template_id,
            'data'        => $data
        ];
        if (!is_null($url)) {
            $params['url'] = $url;
        }
        if (is_null($miniprogram)) {
            if (is_string($miniprogram)) {
                $miniprogram = [
                    'appid' => $miniprogram
                ];
                $params['miniprogram'] = $miniprogram;
            }
        }
        if (!is_null($color)) {
            $params['color'] = $color;
        }

        $result = $this->httpPost("/message/template/send?access_token={$this->accessToken}", $params);
        return $result['msgid'];
    }
}
