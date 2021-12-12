<?php


namespace Fize\Third\Wechat\Api\Message;

use Fize\Third\Wechat\Api;

/**
 * 客服发消息
 */
class Custom extends Api
{

    const COMMAND_TYPING = 'Typing';
    const COMMAND_CANCEL_TYPING = 'CancelTyping';

    /**
     * 发消息
     * @param string $touser 接收用户OPENID
     * @param string $msgtype 消息类型
     * @param array $extend 扩展字段
     * @param string $kf_account 指定客服帐号
     */
    public function send($touser, $msgtype, array $extend, $kf_account = null)
    {
        $params = [
            'touser'  => $touser,
            'msgtype' => $msgtype,
        ];
        $params = array_merge($params, $extend);
        if (!is_null($kf_account)) {
            $params['customservice'] = [
                'kf_account' => $kf_account
            ];
        }
        $this->httpPost("/message/custom/send?access_token={$this->accessToken}", $params);
    }

    /**
     * 客服输入状态
     * @param string $touser 接收用户OPENID
     * @param string $command 输入状态
     */
    public function typing($touser, $command)
    {
        $params = [
            'touser'  => $touser,
            'command' => $command
        ];
        $this->httpPost("/message/custom/typing?access_token={$this->accessToken}", $params);
    }
}
