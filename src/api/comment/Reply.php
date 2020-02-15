<?php


namespace fize\third\wechat\api\comment;

use fize\third\wechat\Api;

/**
 * 评论回复
 */
class Reply extends Api
{
    /**
     * 回复评论
     * @param int $msg_data_id 群发返回的msg_data_id
     * @param int $user_comment_id 用户评论id
     * @param string $content 回复内容
     * @param int $index 用来指定第几篇图文，从0开始
     */
    public function add($msg_data_id, $user_comment_id, $content, $index = null)
    {
        $params = [
            'msg_data_id'     => $msg_data_id,
            'user_comment_id' => $user_comment_id,
            'content'         => $content
        ];
        if (!is_null($index)) {
            $params['index'] = $index;
        }
        $this->httpPost("/comment/reply/add?access_token={$this->accessToken}", $params);
    }

    /**
     * 删除回复
     * @param int $msg_data_id 群发返回的msg_data_id
     * @param int $user_comment_id 用户评论id
     * @param int $index 用来指定第几篇图文，从0开始
     */
    public function delete($msg_data_id, $user_comment_id, $index = null)
    {
        $params = [
            'msg_data_id'     => $msg_data_id,
            'user_comment_id' => $user_comment_id,
        ];
        if (!is_null($index)) {
            $params['index'] = $index;
        }
        $this->httpPost("/comment/reply/delete?access_token={$this->accessToken}", $params);
    }
}
