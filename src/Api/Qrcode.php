<?php


namespace Fize\Third\Wechat\Api;

use Fize\Third\Wechat\ApiAbstract;

/**
 * 二维码
 */
class Qrcode extends ApiAbstract
{

    /**
     * 二维码类型：临时的整型参数值
     */
    const ACTION_NAME_QR_SCENE = 'QR_SCENE';

    /**
     * 二维码类型：临时的字符串参数值
     */
    const ACTION_NAME_QR_STR_SCENE = 'QR_STR_SCENE';

    /**
     * 二维码类型：永久的整型参数值
     */
    const ACTION_NAME_QR_LIMIT_SCENE = 'QR_LIMIT_SCENE';

    /**
     * 二维码类型：永久的字符串参数值
     */
    const ACTION_NAME_QR_LIMIT_STR_SCENE = 'QR_LIMIT_STR_SCENE';

    /**
     * 创建二维码ticket
     * @param string           $action_name    二维码类型
     * @param array|int|string $scene          场景值
     * @param int              $expire_seconds 该二维码有效时间，以秒为单位
     * @return array
     */
    public function create($action_name, $scene, $expire_seconds = null)
    {
        if (is_int($scene)) {
            $scene = [
                'scene_id' => $scene
            ];
        } elseif (is_string($scene)) {
            $scene = [
                'scene_str' => $scene
            ];
        }
        $params = [
            'action_name' => $action_name,
            'action_info' => [
                'scene' => $scene
            ]
        ];
        if (!is_null($expire_seconds)) {
            $params['expire_seconds'] = $expire_seconds;
        }
        return $this->httpPost("/qrcode/create?access_token={$this->accessToken}", $params);
    }
}
