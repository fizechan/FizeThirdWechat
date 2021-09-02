<?php


namespace fize\third\wechat\api\message;

use fize\third\wechat\Api;

/**
 * 模板消息
 */
class Template extends Api
{

    /**
     * 发送模板消息
     * @param string       $touser      接收者openid
     * @param string       $template_id 模板ID
     * @param array        $data        模板数据
     * @param string|null  $url         模板跳转链接
     * @param string|array $miniprogram 小程序
     * @param string|null  $color       字体颜色
     * @return int 返回消息id
     */
    public function send(string $touser, string $template_id, array $data, string $url = null, $miniprogram = null, string $color = null): int
    {
        $params = [
            'touser'      => $touser,
            'template_id' => $template_id,
            'data'        => $data
        ];
        if (!is_null($url)) {
            $params['url'] = $url;
        }
        if (is_string($miniprogram)) {
            $miniprogram = [
                'appid' => $miniprogram
            ];
            $params['miniprogram'] = $miniprogram;
        }
        if (!is_null($color)) {
            $params['color'] = $color;
        }

        $result = $this->httpPost("/message/template/send?access_token=$this->accessToken", $params);
        return $result['msgid'];
    }

    /**
     * 推送订阅模板消息
     * @param string       $touser      接收消息的用户openid
     * @param int          $scene       订阅场景值
     * @param string       $template_id 订阅消息模板ID
     * @param string       $title       消息标题
     * @param array        $data        消息正文
     * @param string|null  $url         点击消息跳转的链接
     * @param string|array $miniprogram 小程序
     */
    public function subscribe(string $touser, int $scene, string $template_id, string $title, array $data, string $url = null, $miniprogram = null)
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
        if (is_string($miniprogram)) {
            $miniprogram = [
                'appid' => $miniprogram
            ];
            $params['miniprogram'] = $miniprogram;
        }
        $this->httpPost("/message/template/subscribe?access_token=$this->accessToken", $params);
    }
}
