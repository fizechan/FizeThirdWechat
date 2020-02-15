<?php


namespace fize\third\wechat\api\card;

use fize\third\wechat\Api;

/**
 * 自定义CODE
 */
class Code extends Api
{

    /**
     * 导入code
     * @param string $card_id 需要进行导入code的卡券ID
     * @param array $code 需导入微信卡券后台的自定义code
     */
    public function deposit($card_id, array $code)
    {
        $params = [
            'card_id' => $card_id,
            'code'    => $code
        ];
        $this->httpPost("/card/code/deposit?access_token={$this->accessToken}", $params);
    }

    /**
     * 查询导入code数目
     * @param string $card_id 进行导入code的卡券ID
     * @return int
     */
    public function getdepositcount($card_id)
    {
        $params = [
            'card_id' => $card_id
        ];
        $result = $this->httpPost("/card/code/getdepositcount?access_token={$this->accessToken}", $params);
        return $result['count'];
    }

    /**
     * 核查code
     * @param string $card_id 需要进行导入code的卡券ID
     * @param array $code 需导入微信卡券后台的自定义code
     * @return array
     */
    public function checkcode($card_id, array $code)
    {
        $params = [
            'card_id' => $card_id,
            'code'    => $code
        ];
        return $this->httpPost("/card/code/checkcode?access_token={$this->accessToken}", $params);
    }

    /**
     * 查询Code
     * @param string $code 单张卡券的唯一标准
     * @param string $card_id 卡券ID代表一类卡券
     * @param bool $check_consume 是否校验code核销状态
     * @return array
     */
    public function get($code, $card_id = null, $check_consume = null)
    {
        $params = [
            'code' => $code
        ];
        if (!is_null($card_id)) {
            $params['card_id'] = $card_id;
        }
        if (!is_null($check_consume)) {
            $params['check_consume'] = $check_consume;
        }
        return $this->httpPost("/card/code/get?access_token={$this->accessToken}", $params);
    }

    /**
     * 核销Code
     * @param string $code 单张卡券的唯一标准
     * @param string $card_id 卡券ID代表一类卡券
     * @return array
     */
    public function consume($code, $card_id = null)
    {
        $params = [
            'code' => $code
        ];
        if (!is_null($card_id)) {
            $params['card_id'] = $card_id;
        }
        return $this->httpPost("/card/code/consume?access_token={$this->accessToken}", $params);
    }

    /**
     * Code解码
     * @param string $encrypt_code 经过加密的Code码
     * @return string
     */
    public function decrypt($encrypt_code)
    {
        $params = [
            'encrypt_code' => $encrypt_code
        ];
        $result = $this->httpPost("/card/code/decrypt?access_token={$this->accessToken}", $params);
        return $result['code'];
    }

    /**
     * 更改Code
     * @param string $code 需变更的Code码
     * @param string $new_code 变更后的有效Code码
     * @param string $card_id 卡券ID
     */
    public function update($code, $new_code, $card_id = null)
    {
        $params = [
            'code'     => $code,
            'new_code' => $new_code
        ];
        if (!is_null($card_id)) {
            $params['card_id'] = $card_id;
        }
        $this->httpPost("/card/code/update?access_token={$this->accessToken}", $params);
    }

    /**
     * 设置卡券失效
     * @param string $card_id 卡券ID
     * @param string $code 设置失效的Code码
     * @param string $reason 失效理由
     */
    public function unavailable($card_id, $code, $reason = null)
    {
        $params = [
            'card_id' => $card_id,
            'code'    => $code,
        ];
        if (!is_null($reason)) {
            $params['reason'] = $reason;
        }
        $this->httpPost("/card/code/unavailable?access_token={$this->accessToken}", $params);
    }
}
