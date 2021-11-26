<?php


namespace Fize\Third\Wechat\Api;

use Fize\Third\Wechat\ApiAbstract;

/**
 * 导购助手
 */
class Guide extends ApiAbstract
{

    /**
     * 获取导购信息
     * @param string $guide 导购微信号/openid
     * @param string $type  $guide参数类型
     * @return array
     */
    public function getguideacct($guide, $type = 'account')
    {
        $params = [
            "guide_{$type}" => $guide
        ];
        return $this->httpPost("/guide/getguideacct?access_token={$this->accessToken}", $params);
    }

    /**
     * 更新导购昵称或者头像
     * @param string $guide 导购微信号/openid
     * @param string $guide_headimgurl
     * @param string $guide_nickname
     * @param string $type  $guide参数类型
     * @return array
     */
    public function updateguideacct($guide, $guide_headimgurl = null, $guide_nickname = null, $type = 'account')
    {
        $params = [
            "guide_{$type}" => $guide
        ];
        if (is_null($guide_headimgurl)) {
            $params['guide_headimgurl'] = $guide_headimgurl;
        }
        if (is_null($guide_nickname)) {
            $params['guide_nickname'] = $guide_nickname;
        }
        return $this->httpPost("/guide/updateguideacct?access_token={$this->accessToken}", $params);
    }

    /**
     * 为服务号添加导购
     * @param string $guide 导购微信号/openid
     * @param string $guide_headimgurl
     * @param string $guide_nickname
     * @param string $type  $guide参数类型
     * @return array
     */
    public function addguideacct($guide, $guide_headimgurl = null, $guide_nickname = null, $type = 'account')
    {
        $params = [
            "guide_{$type}" => $guide
        ];
        if (is_null($guide_headimgurl)) {
            $params['guide_headimgurl'] = $guide_headimgurl;
        }
        if (is_null($guide_nickname)) {
            $params['guide_nickname'] = $guide_nickname;
        }
        return $this->httpPost("/guide/addguideacct?access_token={$this->accessToken}", $params);
    }

    /**
     * 删除导购
     * @param string $guide 导购微信号/openid
     * @param string $type  $guide参数类型
     * @return array|string
     */
    public function delguideacct($guide, $type = 'account')
    {
        $params = [
            "guide_{$type}" => $guide
        ];
        return $this->httpPost("/guide/delguideacct?access_token={$this->accessToken}", $params);
    }

    /**
     * 拉取导购列表
     * @param int $page 分页页数，从0开始
     * @param int $num  每页数量
     * @return array
     */
    public function getguideacctlist($page, $num)
    {
        $params = [
            'page' => $page,
            'num'  => $num
        ];
        return $this->httpPost("/guide/getguideacctlist?access_token={$this->accessToken}", $params);
    }

    /**
     * 生成导购二维码
     * @param string $guide       导购微信号/openid
     * @param string $qrcode_info 额外参数
     * @param string $type        $guide参数类型
     * @return array
     */
    public function guidecreateqrcode($guide, $qrcode_info = null, $type = 'account')
    {
        $params = [
            "guide_{$type}" => $guide
        ];
        if (is_null($qrcode_info)) {
            $params['qrcode_info'] = $qrcode_info;
        }
        return $this->httpPost("/guide/guidecreateqrcode?access_token={$this->accessToken}", $params);
    }

    /**
     * 获取导购聊天记录
     * @param string $guide      导购微信号/openid
     * @param int    $page       分页页数，从0开始
     * @param int    $num        每页数量
     * @param string $openid     粉丝openid
     * @param int    $begin_time 消息的起始UNIX时间戳
     * @param int    $end_time   消息的截止UNIX时间戳
     * @param string $type       $guide参数类型
     * @return array
     */
    public function getguidebuyerchatrecord($guide, $page, $num, $openid = null, $begin_time = null, $end_time = null, $type = 'account')
    {
        $params = [
            "guide_{$type}" => $guide,
            'page'          => $page,
            'num'           => $num
        ];
        if (is_null($openid)) {
            $params['openid'] = $openid;
        }
        if (is_null($begin_time)) {
            $params['begin_time'] = $begin_time;
        }
        if (is_null($end_time)) {
            $params['end_time'] = $end_time;
        }
        return $this->httpPost("/guide/getguidebuyerchatrecord?access_token={$this->accessToken}", $params);
    }

    /**
     * 获取导购快捷回复信息
     * @param string $guide 导购微信号/openid
     * @param string $type  $guide参数类型
     * @return array
     */
    public function getguideconfig($guide, $type = 'account')
    {
        $params = [
            "guide_{$type}" => $guide
        ];
        return $this->httpPost("/guide/getguideconfig?access_token={$this->accessToken}", $params);
    }

    /**
     * 设置导购快捷回复信息
     * @param string $guide                 导购微信号/openid
     * @param bool   $is_delete             操作类型
     * @param array  $guide_fast_reply_list 快捷回复列表
     * @param string $type                  $guide参数类型
     * @return array
     */
    public function setguideconfig($guide, $is_delete, array $guide_fast_reply_list, $type = 'account')
    {
        $params = [
            "guide_{$type}"         => $guide,
            'is_delete'             => $is_delete,
            'guide_fast_reply_list' => $guide_fast_reply_list
        ];
        return $this->httpPost("/guide/setguideconfig?access_token={$this->accessToken}", $params);
    }

    /**
     * 获取服务号的敏感词信息与自动回复信息
     * @return array
     */
    public function getguideacctconfig()
    {
        return $this->httpPost("/guide/getguideacctconfig?access_token={$this->accessToken}", '{}', false);
    }

    /**
     * 为服务号设置敏感词与自动回复
     * @param bool  $is_delete                操作类型
     * @param array $black_keyword_values     敏感词
     * @param null  $guide_auto_reply_content 自动回复
     * @return array
     */
    public function setguideacctconfig($is_delete, $black_keyword_values = null, $guide_auto_reply_content = null)
    {
        $params = [
            'is_delete' => $is_delete
        ];
        if (!is_null($black_keyword_values)) {
            $params['black_keyword']['values'] = $black_keyword_values;
        }
        if (!is_null($guide_auto_reply_content)) {
            $params['guide_auto_reply']['content'] = $guide_auto_reply_content;
        }
        return $this->httpPost("/guide/setguideacctconfig?access_token={$this->accessToken}", $params);
    }

    /**
     * 复制小程序页面路径开关
     * @param string $wxa_appid   小程序appid
     * @param string $wx_username 关注该公众号的微信号
     * @return array
     */
    public function pushshowwxapathmenu($wxa_appid, $wx_username)
    {

        $params = [
            'wxa_appid'   => $wxa_appid,
            'wx_username' => $wx_username
        ];
        return $this->httpPost("/guide/pushshowwxapathmenu?access_token={$this->accessToken}", $params);
    }

    /**
     * 拉取导购的粉丝列表
     * @param string $guide 导购微信号/openid
     * @param int    $page  分页页数，从0开始
     * @param int    $num   每页数量
     * @param string $type  $guide参数类型
     * @return array|string
     */
    public function getguidebuyerrelationlist($guide, $page, $num, $type = 'account')
    {
        $params = [
            "guide_{$type}" => $guide,
            'page'          => $page,
            'num'           => $num
        ];
        return $this->httpPost("/guide/getguidebuyerrelationlist?access_token={$this->accessToken}", $params);
    }

    /**
     * 查询某一个粉丝与导购的绑定关系
     * @param string $guide  导购微信号/openid
     * @param string $openid 粉丝openid
     * @param string $type   $guide参数类型
     * @return array
     */
    public function getguidebuyerrelation($guide, $openid, $type = 'account')
    {
        $params = [
            "guide_{$type}" => $guide,
            'openid'        => $openid
        ];
        return $this->httpPost("/guide/getguidebuyerrelation?access_token={$this->accessToken}", $params);
    }

    /**
     * 通过粉丝信息查询该粉丝与导购的绑定关系
     * @param string $openid 粉丝openid
     * @return array
     */
    public function getguidebuyerrelationbybuyer($openid)
    {
        $params = [
            'openid' => $openid
        ];
        return $this->httpPost("/guide/getguidebuyerrelationbybuyer?access_token={$this->accessToken}", $params);
    }

    /**
     * 更新粉丝昵称
     * @param string $guide          导购微信号/openid
     * @param string $openid         粉丝openid
     * @param string $buyer_nickname 粉丝昵称
     * @param string $type           $guide参数类型
     * @return array
     */
    public function updateguidebuyerrelation($guide, $openid, $buyer_nickname, $type = 'account')
    {
        $params = [
            "guide_{$type}"  => $guide,
            'openid'         => $openid,
            'buyer_nickname' => $buyer_nickname
        ];
        return $this->httpPost("/guide/updateguidebuyerrelation?access_token={$this->accessToken}", $params);
    }

    /**
     * 将粉丝从一个导购迁移到另外一个导购下
     * @param string $old_guide 原导购微信号/openid
     * @param string $new_guide 新导购微信号/openid
     * @param string $openid    粉丝openid
     * @param string $old_type  $old_guide 参数类型
     * @param string $new_type  $new_guide 参数类型
     * @return array
     */
    public function rebindguideacctforbuyer($old_guide, $new_guide, $openid, $old_type = 'account', $new_type = 'account')
    {
        $params = [
            "old_guide_{$old_type}" => $old_guide,
            "new_guide_{$new_type}" => $new_guide,
            'openid'                => $openid
        ];
        return $this->httpPost("/guide/rebindguideacctforbuyer?access_token={$this->accessToken}", $params);
    }

    /**
     * 删除导购的粉丝
     * @param string $guide  导购微信号/openid
     * @param string $openid 粉丝openid
     * @param string $type   $guide参数类型
     * @return array
     */
    public function delguidebuyerrelation($guide, $openid, $type = 'account')
    {
        $params = [
            "guide_{$type}" => $guide,
            'openid'        => $openid
        ];
        return $this->httpPost("/guide/delguidebuyerrelation?access_token={$this->accessToken}", $params);
    }

    /**
     * 为服务号导购添加粉丝
     * @param string $guide          导购微信号/openid
     * @param string $openid         粉丝openid
     * @param string $buyer_nickname 粉丝昵称
     * @param string $type           $guide参数类型
     * @return array
     */
    public function addguidebuyerrelation($guide, $openid, $buyer_nickname, $type = 'account')
    {
        $params = [
            "guide_{$type}"  => $guide,
            'openid'         => $openid,
            'buyer_nickname' => $buyer_nickname
        ];
        return $this->httpPost("/guide/addguidebuyerrelation?access_token={$this->accessToken}", $params);
    }

    /**
     * 新建标签类型
     * @param string $tag_name   标签类型的名字
     * @param array  $tag_values 标签可选值列表
     * @return array
     */
    public function newguidetagoption($tag_name, array $tag_values)
    {
        $params = [
            'tag_name'   => $tag_name,
            'tag_values' => $tag_values
        ];
        return $this->httpPost("/guide/newguidetagoption?access_token={$this->accessToken}", $params);
    }

    /**
     * 添加标签可选值
     * @param string $tag_name   标签类型的名字
     * @param array  $tag_values 标签可选值列表
     * @return array
     */
    public function addguidetagoption($tag_name, array $tag_values)
    {
        $params = [
            'tag_name'   => $tag_name,
            'tag_values' => $tag_values
        ];
        return $this->httpPost("/guide/addguidetagoption?access_token={$this->accessToken}", $params);
    }

    /**
     * 获取标签信息
     * @return array
     */
    public function getguidetagoption()
    {
        return $this->httpPost("/guide/getguidetagoption?access_token={$this->accessToken}", '{}', false);
    }

    /**
     * 给粉丝设置标签
     * @param string $guide     导购微信号/openid
     * @param string $openid    粉丝openid
     * @param string $tag_value 标签值
     * @param string $type      $guide 参数类型
     * @return array
     */
    public function addguidebuyertag($guide, $openid, $tag_value, $type = 'account')
    {
        $params = [
            "guide_{$type}" => $guide,
            'openid'        => $openid,
            'tag_value'     => $tag_value
        ];
        return $this->httpPost("/guide/addguidebuyertag?access_token={$this->accessToken}", $params);
    }

    /**
     * 查询粉丝标签
     * @param string $guide  导购微信号/openid
     * @param string $openid 粉丝openid
     * @param string $type   $guide 参数类型
     * @return array
     */
    public function getguidebuyertag($guide, $openid, $type = 'account')
    {
        $params = [
            "guide_{$type}" => $guide,
            'openid'        => $openid
        ];
        return $this->httpPost("/guide/getguidebuyertag?access_token={$this->accessToken}", $params);
    }

    /**
     * 根据标签筛选粉丝
     * @param string $guide      导购微信号/openid
     * @param int    $push_count 已主动下发消息的次数
     * @param array  $tag_values 标签值
     * @param string $type       $guide 参数类型
     * @return array
     */
    public function queryguidebuyerbytag($guide, $push_count = null, $tag_values = null, $type = 'account')
    {
        $params = [
            "guide_{$type}" => $guide
        ];
        if (!is_null($push_count)) {
            $params['push_count'] = $push_count;
        }
        if (!is_null($tag_values)) {
            $params['tag_values'] = $tag_values;
        }
        return $this->httpPost("/guide/queryguidebuyerbytag?access_token={$this->accessToken}", $params);
    }

    /**
     * 删除粉丝标签
     * @param string $guide     导购微信号/openid
     * @param string $openid    粉丝openid
     * @param string $tag_value 标签值
     * @param string $type      $guide 参数类型
     * @return array
     */
    public function delguidebuyertag($guide, $openid, $tag_value, $type = 'account')
    {
        $params = [
            "guide_{$type}" => $guide,
            'openid'        => $openid,
            'tag_value'     => $tag_value
        ];
        return $this->httpPost("/guide/delguidebuyertag?access_token={$this->accessToken}", $params);
    }

    /**
     * 获取展示标签信息
     * @param string $guide  导购微信号/openid
     * @param string $openid 粉丝openid
     * @param string $type   $guide 参数类型
     * @return array
     */
    public function getguidebuyerdisplaytag($guide, $openid, $type = 'account')
    {
        $params = [
            "guide_{$type}" => $guide,
            'openid'        => $openid
        ];
        return $this->httpPost("/guide/getguidebuyerdisplaytag?access_token={$this->accessToken}", $params);
    }

    /**
     * 添加展示标签信息
     * @param string $guide            导购微信号/openid
     * @param string $openid           粉丝openid
     * @param array  $display_tag_list 展示标签信息
     * @param string $type             $guide 参数类型
     * @return array|string
     */
    public function addguidebuyerdisplaytag($guide, $openid, array $display_tag_list, $type = 'account')
    {
        $params = [
            "guide_{$type}"    => $guide,
            'openid'           => $openid,
            'display_tag_list' => $display_tag_list
        ];
        return $this->httpPost("/guide/addguidebuyerdisplaytag?access_token={$this->accessToken}", $params);
    }

    /**
     * 添加小程序卡片
     * @param string $media_id 图片素材
     * @param string $title    小程序卡片名字
     * @param string $path     小程序路径
     * @param string $appid    小程序的appid
     * @param int    $type     操作类型
     * @return array
     */
    public function setguidecardmaterial($media_id, $title, $path, $appid, $type = 0)
    {
        $params = [
            'media_id' => $media_id,
            'type'     => $type,
            'title'    => $title,
            'path'     => $path,
            'appid'    => $appid
        ];
        return $this->httpPost("/guide/setguidecardmaterial?access_token={$this->accessToken}", $params);
    }

    /**
     * 查询小程序卡片
     * @param int $type 操作类型
     * @return array
     */
    public function getguidecardmaterial($type = 0)
    {
        $params = [
            'type' => $type
        ];
        return $this->httpPost("/guide/getguidecardmaterial?access_token={$this->accessToken}", $params);
    }

    /**
     * 删除小程序卡片
     * @param string $title 小程序卡片名字
     * @param string $path  小程序路径
     * @param string $appid 小程序的appid
     * @param int    $type  操作类型
     * @return array
     */
    public function delguidecardmaterial($title, $path, $appid, $type = 0)
    {
        $params = [
            'type'  => $type,
            'title' => $title,
            'path'  => $path,
            'appid' => $appid
        ];
        return $this->httpPost("/guide/delguidecardmaterial?access_token={$this->accessToken}", $params);
    }

    /**
     * 添加图片素材
     * @param string $media_id 图片素材
     * @param int    $type     操作类型
     * @return array
     */
    public function setguideimagematerial($media_id, $type = 0)
    {
        $params = [
            'media_id' => $media_id,
            'type'     => $type
        ];
        return $this->httpPost("/guide/setguideimagematerial?access_token={$this->accessToken}", $params);
    }

    /**
     * 查询图片素材
     * @param int $start 分页查询，起始位置
     * @param int $num   分页查询，查询个数
     * @param int $type  操作类型
     * @return array
     */
    public function getguideimagematerial($start, $num, $type = 0)
    {
        $params = [
            'type'  => $type,
            'start' => $start,
            'num'   => $num
        ];
        return $this->httpPost("/guide/getguideimagematerial?access_token={$this->accessToken}", $params);
    }

    /**
     * 删除图片素材
     * @param string $picurl 图片素材内容
     * @param int    $type   操作类型
     * @return array
     */
    public function delguideimagematerial($picurl, $type = 0)
    {
        $params = [
            'type'   => $type,
            'picurl' => $picurl
        ];
        return $this->httpPost("/guide/delguideimagematerial?access_token={$this->accessToken}", $params);
    }

    /**
     * 添加文字素材
     * @param string $word 文字素材内容
     * @param int    $type 操作类型
     * @return array
     */
    public function setguidewordmaterial($word, $type = 0)
    {
        $params = [
            'type' => $type,
            'word' => $word
        ];
        return $this->httpPost("/guide/setguidewordmaterial?access_token={$this->accessToken}", $params);
    }

    /**
     * 查询文字素材
     * @param int $start 分页查询，起始位置
     * @param int $num   分页查询，查询个数
     * @param int $type  操作类型
     * @return array
     */
    public function getguidewordmaterial($start, $num, $type = 0)
    {
        $params = [
            'type'  => $type,
            'start' => $start,
            'num'   => $num
        ];
        return $this->httpPost("/guide/getguidewordmaterial?access_token={$this->accessToken}", $params);
    }

    /**
     * 删除文字素材
     * @param string $word 文字素材内容
     * @param int    $type 操作类型
     * @return array
     */
    public function delguidewordmaterial($word, $type = 0)
    {
        $params = [
            'type' => $type,
            'word' => $word
        ];
        return $this->httpPost("/guide/delguidewordmaterial?access_token={$this->accessToken}", $params);
    }
}
