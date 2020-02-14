<?php


namespace fize\third\wechat\offiaccount;

use fize\third\wechat\Offiaccount;

/**
 * 图文消息留言管理
 */
class Comment extends Offiaccount
{

    /**
     * 打开已群发文章评论
     * @param int $msg_data_id 群发返回的msg_data_id
     * @param int $index 用来指定第几篇图文，从0开始
     * @return array|false
     */
    public function open($msg_data_id, $index = null)
    {
        $params = [
            'msg_data_id' => $msg_data_id
        ];
        if (!is_null($index)) {
            $params['index'] = $index;
        }
        return $this->httpPost("/comment/open?access_token={$this->accessToken}", $params);
    }

    /**
     * 关闭已群发文章评论
     * @param int $msg_data_id 群发返回的msg_data_id
     * @param int $index 用来指定第几篇图文，从0开始
     * @return array|false
     */
    public function close($msg_data_id, $index = null)
    {
        $params = [
            'msg_data_id' => $msg_data_id
        ];
        if (!is_null($index)) {
            $params['index'] = $index;
        }
        return $this->httpPost("/comment/close?access_token={$this->accessToken}", $params);
    }

    /**
     * 查看指定文章的评论数据
     * @param int $msg_data_id 群发返回的msg_data_id
     * @param int $begin 起始位置
     * @param int $count 获取数目（>=50会被拒绝）
     * @param int $type type=0 普通评论&精选评论 type=1 普通评论 type=2 精选评论
     * @param int $index 用来指定第几篇图文，从0开始
     * @return array|false
     */
    public function list($msg_data_id, $begin, $count, $type, $index = null)
    {
        $params = [
            'msg_data_id' => $msg_data_id,
            'begin'       => $begin,
            'count'       => $count,
            'type'        => $type
        ];
        if (!is_null($index)) {
            $params['index'] = $index;
        }
        return $this->httpPost("/comment/list?access_token={$this->accessToken}", $params);
    }

    /**
     * 将评论标记精选
     * @param int $msg_data_id 群发返回的msg_data_id
     * @param int $user_comment_id 用户评论id
     * @param int $index 用来指定第几篇图文，从0开始
     * @return bool
     */
    public function markelect($msg_data_id, $user_comment_id, $index = null)
    {
        $params = [
            'msg_data_id'     => $msg_data_id,
            'user_comment_id' => $user_comment_id,
        ];
        if (!is_null($index)) {
            $params['index'] = $index;
        }
        $result = $this->httpPost("/comment/markelect?access_token={$this->accessToken}", $params);
        return $result ? true : false;
    }

    /**
     * 将评论取消精选
     * @param int $msg_data_id 群发返回的msg_data_id
     * @param int $user_comment_id 用户评论id
     * @param int $index 用来指定第几篇图文，从0开始
     * @return bool
     */
    public function unmarkelect($msg_data_id, $user_comment_id, $index = null)
    {
        $params = [
            'msg_data_id'     => $msg_data_id,
            'user_comment_id' => $user_comment_id,
        ];
        if (!is_null($index)) {
            $params['index'] = $index;
        }
        $result = $this->httpPost("/comment/unmarkelect?access_token={$this->accessToken}", $params);
        return $result ? true : false;
    }

    /**
     * 删除评论
     * @param int $msg_data_id 群发返回的msg_data_id
     * @param int $user_comment_id 用户评论id
     * @param int $index 用来指定第几篇图文，从0开始
     * @return bool
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
        $result = $this->httpPost("/comment/delete?access_token={$this->accessToken}", $params);
        return $result ? true : false;
    }
}
