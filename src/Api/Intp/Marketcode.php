<?php


namespace Fize\Third\Wechat\Api\Intp;

use Fize\Third\Wechat\Api;

/**
 * 一物一码
 */
class Marketcode extends Api
{

    /**
     * 申请二维码
     * @param int $code_count 申请码的数量
     * @param string $isv_application_id 外部单号
     * @return array
     */
    public function applycode($code_count, $isv_application_id)
    {
        $params = [
            'code_count'         => $code_count,
            'isv_application_id' => $isv_application_id
        ];
        return $this->httpPost("/intp/marketcode/applycode?access_token={$this->accessToken}", $params);
    }

    /**
     * 查询二维码申请单
     * @param int $code_count 申请码的数量
     * @param string $isv_application_id 外部单号
     * @return array
     */
    public function applycodequery($code_count, $isv_application_id)
    {
        $params = [
            'code_count'         => $code_count,
            'isv_application_id' => $isv_application_id
        ];
        return $this->httpPost("/intp/marketcode/applycodequery?access_token={$this->accessToken}", $params);
    }

    /**
     * 下载二维码包
     * @param int $application_id 申请单号
     * @param int $code_start 开始位置
     * @param int $code_end 结束位置
     * @return array
     */
    public function applycodedownload($application_id, $code_start, $code_end)
    {
        $params = [
            'application_id'         => $application_id,
            'code_start' => $code_start,
            'code_end' => $code_end
        ];
        return $this->httpPost("/intp/marketcode/applycodedownload?access_token={$this->accessToken}", $params);
    }

    /**
     * 激活二维码
     * @param int $application_id 申请单号
     * @param string $activity_name 活动名称
     * @param string $product_brand 商品品牌
     * @param string $product_title 商品标题
     * @param string $product_code 商品条码
     * @param string $wxa_appid 小程序的appid
     * @param string $wxa_path 小程序的path
     * @param int $code_start 激活码段的起始位
     * @param int $code_end 激活码段的结束位
     * @param int $wxa_type 小程序版本
     * @return array
     */
    public function codeactive($application_id, $activity_name, $product_brand, $product_title, $product_code, $wxa_appid, $wxa_path, $code_start, $code_end, $wxa_type = null)
    {
        $params = [
            'application_id' => $application_id,
            'activity_name' => $activity_name,
            'product_brand' => $product_brand,
            'product_title' => $product_title,
            'product_code' => $product_code,
            'wxa_appid' => $wxa_appid,
            'wxa_path' => $wxa_path,
            'code_start' => $code_start,
            'code_end' => $code_end
        ];
        if (!is_null($wxa_type)) {
            $params['wxa_type'] = $wxa_type;
        }
        return $this->httpPost("/intp/marketcode/codeactive?access_token={$this->accessToken}", $params);
    }

    /**
     * 查询二维码激活状态
     * @param array $params 参数
     * @return array
     */
    public function codeactivequery(array $params)
    {
        return $this->httpPost("/intp/marketcode/codeactivequery?access_token={$this->accessToken}", $params);
    }

    /**
     * code_ticket换code
     * @param string $openid 用户的openid
     * @param string $code_ticket 跳转时带上的code_ticket参数
     * @return array
     */
    public function tickettocode($openid, $code_ticket)
    {
        $params = [
            'openid' => $openid,
            'code_ticket' => $code_ticket
        ];
        return $this->httpPost("/intp/marketcode/tickettocode?access_token={$this->accessToken}", $params);
    }
}
