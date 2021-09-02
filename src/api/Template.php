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
    public function apiSetIndustry(string $industry_id1, string $industry_id2)
    {
        $params = [
            'industry_id1' => $industry_id1,
            'industry_id2' => $industry_id2
        ];
        $this->httpPost("/template/api_set_industry?access_token=$this->accessToken", $params);
    }

    /**
     * 获取设置的行业信息
     * @return array
     */
    public function getIndustry(): array
    {
        return $this->httpGet("/template/get_industry?access_token=$this->accessToken");
    }

    /**
     * 获得模板ID
     * 成功返回消息模板的调用id
     * @param string $template_id_short 模板库中模板的编号
     * @return string
     */
    public function apiAddTemplate(string $template_id_short): string
    {
        $params = ['template_id_short' => $template_id_short];
        $result = $this->httpPost("/template/api_add_template?access_token=$this->accessToken", $params);
        return $result['template_id'];
    }

    /**
     * 获取模板列表
     * @return array
     */
    public function getAllPrivateTemplate(): array
    {
        $result = $this->httpGet("/template/get_all_private_template?access_token=$this->accessToken");
        return $result['template_list'];
    }

    /**
     * 删除模板
     * @param string $template_id 公众帐号下模板消息ID
     */
    public function delPrivateTemplate(string $template_id)
    {
        $params = ['template_id' => $template_id];
        $this->httpPost("/template/del_private_template?access_token=$this->accessToken", $params);
    }
}
