<?php


namespace fize\third\wechat\mp\mp;

use fize\third\wechat\Offiaccount;

/**
 * 一次性订阅信息
 */
class Subscribemsg extends Offiaccount
{

    /**
     * 获取授权链接
     * @param int $scene 订阅场景值
     * @param string $template_id 模板ID
     * @param string $redirect_url 跳转URI
     * @param string $reserved 原样返回
     * @return string
     */
    public function getConfirm($scene, $template_id, $redirect_url, $reserved = null)
    {
        $redirect_url = urlencode($redirect_url);
        $uri = "https://mp.weixin.qq.com/mp/subscribemsg?action=get_confirm&appid={$this->appid}&scene={$scene}&template_id={$template_id}&redirect_url={$redirect_url}";
        if (!is_null($reserved)) {
            $uri .= "&reserved={$reserved}";
        }
        $uri .= "#wechat_redirect";
        return $uri;
    }
}
