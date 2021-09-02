<?php


namespace fize\third\wechat\api;


use fize\third\wechat\Api;


/**
 * 自定义菜单
 */
class Menu extends Api
{

    /**
     * 按钮类型：点击事件
     */
    const BUTTON_TYPE_CLICK = 'click';

    /**
     * 按钮类型：跳转URL
     */
    const BUTTON_TYPE_VIEW = 'view';

    /**
     * 按钮类型：扫一扫推送
     */
    const BUTTON_TYPE_SCANCODE_PUSH = 'scancode_push';

    /**
     * 按钮类型：扫一扫回调
     */
    const BUTTON_TYPE_SCANCODE_WAITMSG = 'scancode_waitmsg';

    /**
     * 按钮类型：系统相机
     */
    const BUTTON_TYPE_PIC_SYSPHOTO = 'pic_sysphoto';

    /**
     * 按钮类型：系统相机或者相册
     */
    const BUTTON_TYPE_PIC_PHOTO_OR_ALBUM = 'pic_photo_or_album';

    /**
     * 按钮类型：微信相册
     */
    const BUTTON_TYPE_PIC_WEIXIN = 'pic_weixin';

    /**
     * 按钮类型：地理位置选择器
     */
    const BUTTON_TYPE_LOCATION_SELECT = 'location_select';

    /**
     * 按钮类型：永久素材
     */
    const BUTTON_TYPE_MEDIA_ID = 'media_id';

    /**
     * 按钮类型：跳转图文消息URL
     */
    const BUTTON_TYPE_VIEW_LIMITED = 'view_limited';

    /**
     * 按钮类型：小程序
     */
    const BUTTON_TYPE_MINIPROGRAM = 'miniprogram';

    /**
     * 创建
     * @param array $buttons 菜单数组
     */
    public function create(array $buttons)
    {
        $params = [
            'button' => $buttons
        ];
        $this->httpPost("/menu/create?access_token=$this->accessToken", $params);
    }

    /**
     * 删除
     */
    public function delete()
    {
        $this->httpGet("/menu/delete?access_token=$this->accessToken");
    }

    /**
     * 获取自定义菜单配置菜单
     * @return array
     */
    public function get(): array
    {
        return $this->httpGet("/menu/get?access_token=$this->accessToken");
    }

    /**
     * 创建个性化菜单
     * @param array $buttons   菜单
     * @param array $matchrule 匹配规则
     * @return string 返回menuid
     */
    public function addconditional(array $buttons, array $matchrule): string
    {
        $params = [
            'button'    => $buttons,
            'matchrule' => $matchrule
        ];
        $result = $this->httpPost("/menu/addconditional?access_token=$this->accessToken", $params);
        return $result['menuid'];
    }

    /**
     * 删除个性化菜单
     * @param string $menuid 菜单ID
     */
    public function delconditional(string $menuid)
    {
        $params = [
            'menuid' => $menuid
        ];
        $this->httpPost("/menu/delconditional?access_token=$this->accessToken", $params);
    }

    /**
     * 测试个性化菜单匹配结果
     * @param string $user_id 可以是粉丝的OpenID，也可以是粉丝的微信号。
     * @return array
     */
    public function trymatch(string $user_id): array
    {
        $params = [
            'user_id' => $user_id
        ];
        return $this->httpPost("/menu/trymatch?access_token=$this->accessToken", $params);
    }
}
