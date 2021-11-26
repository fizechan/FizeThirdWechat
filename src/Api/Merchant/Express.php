<?php


namespace Fize\Third\Wechat\Api\Merchant;

use Fize\Third\Wechat\Api;

/**
 * 邮费模板管理
 */
class Express extends Api
{

    /**
     * 增加邮费模板
     * @param $name
     * @param $assumer
     * @param $valuation
     * @param array $topfee
     * @return array
     */
    public function add($name, $assumer, $valuation, array $topfee)
    {
        $params = [
            'delivery_template' => [
                'Name' => $name,
                'Assumer' => $assumer,
                'Valuation' => $valuation,
                'TopFee' => $topfee
            ]
        ];
        return $this->httpPost("/merchant/express/add?access_token={$this->accessToken}", $params);
    }

    /**
     * 删除邮费模板
     * @param int $template_id
     * @return bool
     */
    public function del($template_id)
    {
        $params = [
            'template_id' => $template_id
        ];
        return $this->httpPost("/merchant/express/del?access_token={$this->accessToken}", $params);
    }

    /**
     * 修改邮费模板
     * @param $template_id
     * @param null $name
     * @param null $assumer
     * @param null $valuation
     * @param array|null $topfee
     * @return array|string
     */
    public function update($template_id, $name = null, $assumer = null, $valuation = null, array $topfee = null)
    {
        $params = [
            'template_id' => $template_id
        ];
        if (!is_null($name)) {
            $params['delivery_template']['Name'] = $name;
        }
        if (!is_null($assumer)) {
            $params['delivery_template']['Assumer'] = $assumer;
        }
        if (!is_null($valuation)) {
            $params['delivery_template']['Valuation'] = $valuation;
        }
        if (!is_null($topfee)) {
            $params['delivery_template']['TopFee'] = $topfee;
        }
        return $this->httpPost("/merchant/express/update?access_token={$this->accessToken}", $params);
    }

    /**
     * 获取指定ID的邮费模板
     * @param $template_id
     * @return array
     */
    public function getbyid($template_id)
    {
        $params = [
            'template_id' => $template_id
        ];
        return $this->httpPost("/merchant/express/getbyid?access_token={$this->accessToken}", $params);
    }

    /**
     * 获取所有邮费模板
     * @return array
     */
    public function getall()
    {
        return $this->httpGet("/merchant/express/getall?access_token={$this->accessToken}");
    }
}
