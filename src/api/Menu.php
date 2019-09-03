<?php


namespace fize\third\wechat\api;


use fize\third\wechat\Api;
use fize\crypt\Json;
use Exception;


/**
 * 微信自定义菜单管理类
 */
class Menu extends Api
{

    const URL_MENU_CREATE = '/menu/create?';
    const URL_MENU_GET = '/menu/get?';
    const URL_MENU_DELETE = '/menu/delete?';

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
     * 需要马上检测access_token
     * @param array $p_options 参数数组
     * @throws Exception
     */
    public function __construct(array $p_options)
    {
        parent::__construct($p_options);
        //检测TOKEN
        if(!$this->checkAccessToken()){
            throw new Exception($this->errMsg, $this->errCode);
        }
    }

    /**
     * 创建菜单(认证后的订阅号可用)
     * @param array $data 菜单数组数据
     * @return bool
     */
    public function create(array $data)
    {
        $result = $this->httpPost(self::PREFIX_CGI . self::URL_MENU_CREATE . 'access_token=' . $this->access_token, Json::encode($data, JSON_UNESCAPED_UNICODE));
        if ($result) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * 获取菜单(认证后的订阅号可用)
     * @return array
     */
    public function get()
    {
        return $this->httpGet(self::PREFIX_CGI . self::URL_MENU_GET . 'access_token=' . $this->access_token);
    }

    /**
     * 删除菜单(认证后的订阅号可用)
     * @return boolean
     */
    public function delete()
    {
        $result = $this->httpGet(self::PREFIX_CGI . self::URL_MENU_DELETE . 'access_token=' . $this->access_token);
        if ($result) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * 创建个性化菜单
     * @todo 待实现
     */
    public function addconditional()
    {

    }

    /**
     * 删除个性化菜单
     * @todo 待实现
     */
    public function delconditional()
    {

    }

    /**
     * 测试个性化菜单匹配结果
     * @todo 待实现
     */
    public function trymatch()
    {

    }
}