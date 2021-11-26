<?php


namespace Fize\Third\Wechat\Api\Card\Invoice;

use Fize\Third\Wechat\Api;

/**
 * 报销方
 */
class Reimburse extends Api
{

    /**
     * 查询报销发票信息
     * @param string $card_id 发票卡券的 card_id
     * @param string $encrypt_code 发票卡券的加密 code
     * @return array
     */
    public function getinvoiceinfo($card_id, $encrypt_code)
    {
        $params = [
            'card_id' => $card_id,
            'encrypt_code' => $encrypt_code
        ];
        return $this->httpPost("/card/invoice/reimburse/getinvoiceinfo?access_token={$this->accessToken}", $params);
    }

    /**
     * 批量查询报销发票信息
     * @param array $item_list 发票列表
     * @return array
     */
    public function getinvoicebatch(array $item_list)
    {
        $params = [
            'item_list' => $item_list
        ];
        return $this->httpPost("/card/invoice/reimburse/getinvoicebatch?access_token={$this->accessToken}", $params);
    }

    /**
     * 报销方更新发票状态
     * @param string $card_id 发票卡券的 card_id
     * @param string $encrypt_code 发票卡券的加密 code
     * @param string $reimburse_status 发票报销状态
     * @return array
     */
    public function updateinvoicestatus($card_id, $encrypt_code, $reimburse_status)
    {
        $params = [
            'card_id' => $card_id,
            'encrypt_code' => $encrypt_code,
            'reimburse_status' => $reimburse_status
        ];
        return $this->httpPost("/card/invoice/reimburse/updateinvoicestatus?access_token={$this->accessToken}", $params);
    }

    /**
     * 报销方批量更新发票状态
     * @param string $openid 用户openid
     * @param string $reimburse_status 发票报销状态
     * @param array $invoice_list 发票列表
     * @return array|string
     */
    public function updatestatusbatch($openid, $reimburse_status, array $invoice_list)
    {
        $params = [
            'openid' => $openid,
            'reimburse_status' => $reimburse_status,
            'invoice_list' => $invoice_list
        ];
        return $this->httpPost("/card/invoice/reimburse/updatestatusbatch?access_token={$this->accessToken}", $params);
    }
}
