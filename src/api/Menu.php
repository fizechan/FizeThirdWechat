<?php


namespace fize\third\wechat\api;


use fize\third\wechat\Api;


/**
 * 自定义菜单
 */
class Menu extends Api
{

    const URI_MENU_CREATE = '/menu/create';
    const URI_MENU_GET_CURRENT_SELFMENU_INFO = '/get_current_selfmenu_info';
    const URI_MENU_DELETE = '/menu/delete';
    const URI_MENU_ADDCONDITIONAL = '/menu/addconditional';
    const URI_MENU_DELCONDITIONAL = '/menu/delconditional';
    const URI_MENU_TRYMATCH = '/menu/trymatch';
    const URI_MENU_GET = '/menu/get';

    const BUTTON_TYPE_CLICK = 'click';
    const BUTTON_TYPE_VIEW = 'view';
    const BUTTON_TYPE_SCANCODE_PUSH = 'scancode_push';
    const BUTTON_TYPE_SCANCODE_WAITMSG = 'scancode_waitmsg';
    const BUTTON_TYPE_PIC_SYSPHOTO = 'pic_sysphoto';
    const BUTTON_TYPE_PIC_PHOTO_OR_ALBUM = 'pic_photo_or_album';
    const BUTTON_TYPE_PIC_WEIXIN = 'pic_weixin';
    const BUTTON_TYPE_LOCATION_SELECT = 'location_select';
    const BUTTON_TYPE_MEDIA_ID = 'media_id';
    const BUTTON_TYPE_VIEW_LIMITED = 'view_limited';
    const BUTTON_TYPE_MINIPROGRAM = 'miniprogram';

    /**
     * 构造函数
     * @param array $options 参数数组
     */
    public function __construct(array $options)
    {
        parent::__construct($options);
        $this->checkAccessToken();  //检测TOKEN以便于URI中的token字段马上有效
    }

    /**
     * 创建接口
     * @param array $buttons 菜单数组数据
     * @return bool
     */
    public function create(array $buttons)
    {
        $body = [
            'button' => $buttons
        ];
        $result = $this->httpPost(self::URI_MENU_CREATE . '?access_token=' . $this->accessToken, $body);
        if (!$result) {
            return false;
        }
        return true;
    }

    /**
     * 查询接口
     * @return array
     */
    public function getCurrentSelfmenuInfo()
    {
        return $this->httpGet(self::URI_MENU_GET_CURRENT_SELFMENU_INFO . '?access_token=' . $this->accessToken);
    }

    /**
     * 删除接口
     * @return bool
     */
    public function delete()
    {
        $result = $this->httpGet(self::URI_MENU_DELETE . '?access_token=' . $this->accessToken);
        if ($result) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * 获取自定义菜单配置菜单
     * @return array
     */
    public function get()
    {
        return $this->httpGet(self::URI_MENU_GET . '?access_token=' . $this->accessToken);
    }



    /**
     * 创建个性化菜单
     * @param array $buttons 菜单
     * @param array $matchrule 匹配规则
     * @return mixed 成功返回menuid，失败返回false
     */
    public function addconditional(array $buttons, array $matchrule)
    {
        $body = [
            'button' => $buttons,
            'matchrule' => $matchrule
        ];
        $json = $this->httpPost(self::URI_MENU_ADDCONDITIONAL . '?access_token=' . $this->accessToken, $body);
        if (!$json) {
            return false;
        }
        return $json['menuid'];
    }

    /**
     * 删除个性化菜单
     * @param string $menuid 菜单ID
     * @return bool
     */
    public function delconditional($menuid)
    {
        $body = [
            'menuid' => $menuid
        ];
        $json = $this->httpPost(self::URI_MENU_DELCONDITIONAL . '?access_token=' . $this->accessToken, $body);
        if (!$json) {
            return false;
        }
        return true;
    }

    /**
     * 测试个性化菜单匹配结果
     * @param string $user_id 可以是粉丝的OpenID，也可以是粉丝的微信号。
     * @return mixed 成功返回结果数组，失败返回false
     */
    public function trymatch($user_id)
    {
        $body = [
            'user_id' => $user_id
        ];
        return $this->httpPost(self::URI_MENU_TRYMATCH . '?access_token=' . $this->accessToken, $body);
    }
}
