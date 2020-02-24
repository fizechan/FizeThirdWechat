<?php


namespace fize\third\wechat\api\card\invoice;

use CURLFile;
use fize\third\wechat\Api;

/**
 * 开票平台
 */
class Platform extends Api
{

    /**
     * 创建发票卡券模板
     * @param array $base_info 发票卡券模板基础信息
     * @param string $payee 收款方（开票方）全称
     * @param string $type 发票类型
     * @return array
     */
    public function createcard(array $base_info, $payee, $type)
    {
        $params = [
            'invoice_info' => [
                'base_info' => $base_info,
                'payee' => $payee,
                'type' => $type
            ]
        ];
        return $this->httpPost("/card/invoice/platform/createcard?access_token={$this->accessToken}", $params);
    }

    /**
     * 上传PDF
     * @param string $pdf PDF文件
     * @return array
     */
    public function setpdf($pdf)
    {
        $params = [
            'pdf' => new CURLFile(realpath($pdf))
        ];
        return $this->httpPost("/card/invoice/platform/setpdf?access_token={$this->accessToken}", $params, false);
    }

    /**
     * 查询已上传的PDF文件
     * @param string $s_media_id 发票s_media_id
     * @param string $action 动作
     * @return array
     */
    public function getpdf($s_media_id, $action = 'get_url')
    {
        $params =[
            's_media_id' => $s_media_id
        ];
        return $this->httpPost("/card/invoice/platform/getpdf?action={$action}&access_token={$this->accessToken}", $params);
    }

    /**
     * 更新发票卡券状态
     * @param string $card_id 发票 id
     * @param string $code 发票 code
     * @param string $reimburse_status 发票报销状态
     * @return array
     */
    public function updatestatus($card_id, $code, $reimburse_status)
    {
        $params = [
            'card_id' => $card_id,
            'code' => $code,
            'reimburse_status' => $reimburse_status
        ];
        return $this->httpPost("/card/invoice/platform/updatestatus?access_token={$this->accessToken}", $params);
    }
}
