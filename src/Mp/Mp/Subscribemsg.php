<?php


namespace Fize\Third\Wechat\Mp\Mp;

use Fize\Third\Wechat\MpAbstract;

/**
 * 一次性订阅信息
 */
class Subscribemsg extends MpAbstract
{

    /**
     * 获取授权链接
     * @param int         $scene        订阅场景值
     * @param string      $template_id  模板ID
     * @param string      $redirect_url 跳转URI
     * @param string|null $reserved     原样返回
     * @return string
     */
    public function getConfirm(int $scene, string $template_id, string $redirect_url, string $reserved = null): string
    {
        $redirect_url = urlencode($redirect_url);
        $uri = "/mp/subscribemsg?action=get_confirm&appid=$this->appid&scene=$scene&template_id=$template_id&redirect_url=$redirect_url";
        if (!is_null($reserved)) {
            $uri .= "&reserved=$reserved";
        }
        $uri .= "#wechat_redirect";
        return $this->getUri($uri);
    }
}
