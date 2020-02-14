<?php


namespace fize\third\wechat\api\message;

use fize\third\wechat\Api;

/**
 * 订阅模板消息
 */
class Template extends Api
{

    /**
     * 推送订阅模板消息
     * @param string $touser 接收消息的用户openid
     * @param int $scene 订阅场景值
     * @param string $template_id 订阅消息模板ID
     * @param string $title 消息标题
     * @param array $data 消息正文
     * @param string $url 点击消息跳转的链接
     * @param string|array $miniprogram 小程序
     */
    public function subscribe($touser, $scene, $template_id, $title, array $data, $url = null, $miniprogram = null)
    {
        $params = [
            'touser'      => $touser,
            'scene'       => $scene,
            'template_id' => $template_id,
            'title'       => $title,
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
        $this->httpPost("/message/template/subscribe?access_token={$this->accessToken}", $params);
    }
}
