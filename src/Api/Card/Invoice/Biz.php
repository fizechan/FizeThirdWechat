<?php


namespace Fize\Third\Wechat\Api\Card\Invoice;

use Fize\Third\Wechat\Api;

/**
 * 极速开发票
 */
class Biz extends Api
{
    /**
     * 将发票抬头信息录入到用户微信中
     * @param array $params 参数
     * @return array
     */
    public function getusertitleurl(array $params)
    {
        return $this->httpPost("/card/invoice/biz/getusertitleurl?access_token={$this->accessToken}", $params);
    }

    /**
     * 获取商户专属二维码连接
     * @param string $attach 附加字段
     * @param string $biz_name 商户名称
     * @return array
     */
    public function getselecttitleurl($attach, $biz_name)
    {
        $params = [
            'attach' => $attach,
            'biz_name' => $biz_name
        ];
        return $this->httpPost("/card/invoice/biz/getselecttitleurl?access_token={$this->accessToken}", $params);
    }
}
