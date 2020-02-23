<?php


namespace fize\third\wechat\api\shakearound;

use fize\third\wechat\Api;

/**
 * 申请开通
 */
class Account extends Api
{

    /**
     * 申请开通功能
     * @param string $name 联系人姓名
     * @param string $phone_number 联系人电话
     * @param string $email 联系人邮箱
     * @param string $industry_id 行业代号
     * @param array $qualification_cert_urls 相关资质文件的图片url
     * @param string $apply_reason 申请理由
     * @return array
     */
    public function register($name, $phone_number, $email, $industry_id, array $qualification_cert_urls, $apply_reason = null)
    {
        $params = [
            'name' => $name,
            '$phone_number' => $phone_number,
            'email' => $email,
            'industry_id' => $industry_id,
            'qualification_cert_urls' => $qualification_cert_urls
        ];
        if (is_null($apply_reason)) {
            $params['apply_reason'] = $apply_reason;
        }
        return $this->httpPost("/shakearound/account/register?access_token={$this->accessToken}", $params);
    }

    /**
     * 查询审核状态
     * @return array
     */
    public function auditstatus()
    {
        return $this->httpPost("/shakearound/account/auditstatus?access_token={$this->accessToken}", '{}', false);
    }
}
