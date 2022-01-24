<?php


namespace Fize\Third\Wechat\Qyapi;

use Fize\Third\Wechat\QyapiAbstract;

/**
 * 群聊会话
 */
class Appchat extends QyapiAbstract
{

    /**
     * 创建群聊会话
     * @param array       $userlist 群成员id列表
     * @param string|null $name     群聊名
     * @param string|null $owner    指定群主的id
     * @param string|null $chatid   群聊的唯一标志
     * @return string 群聊的唯一标志
     */
    public function create(array $userlist, string $name = null, string $owner = null, string $chatid = null): string
    {
        $params = [
            'userlist' => $userlist
        ];
        if (!is_null($name)) {
            $params['name'] = $name;
        }
        if (!is_null($owner)) {
            $params['owner'] = $owner;
        }
        if (!is_null($chatid)) {
            $params['chatid'] = $chatid;
        }
        $result = $this->httpPost("/appchat/create?access_token=$this->accessToken", $params);
        return $result['chatid'];
    }

    /**
     * 发消息
     * @param string   $chatid  群聊的唯一标志
     * @param string   $msgtype 消息类型
     * @param array    $extend  扩展字段
     * @param int|null $safe    是否是保密消息
     */
    public function send(string $chatid, string $msgtype, array $extend, int $safe = null)
    {
        $params = [
            'chatid'  => $chatid,
            'msgtype' => $msgtype,
        ];
        $params = array_merge($params, $extend);
        if (!is_null($safe)) {
            $params['safe'] = $safe;
        }
        $this->httpPost("/appchat/send?access_token=$this->accessToken", $params);
    }

    /**
     * 发送文本信息
     * @param string   $chatid  群聊id
     * @param string   $content 消息内容
     * @param int|null $safe    是否是保密消息
     */
    public function sendText(string $chatid, string $content, int $safe = null)
    {
        $extend = [
            'text' => ['content' => $content]
        ];
        $this->send($chatid, 'text', $extend, $safe);
    }
}
