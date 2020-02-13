<?php


namespace fize\third\wechat\api;


use fize\third\wechat\Api;
use fize\crypt\Json;


/**
 * 微信其他相关类
 */
class Other extends Api
{

    const QR_SCENE = 0;
    const QR_LIMIT_SCENE = 1;

    const URL_QRCODE_CREATE = '/qrcode/create?';

    const URL_SHORTURL = '/shorturl?';

    const URL_SEMANTIC_SEMPROXY_SEARCH = '/semantic/semproxy/search?'; //语义理解

    /**
     * 构造函数
     * @param array $options 参数数组
     */
    public function __construct($options)
    {
        parent::__construct($options);
    }

    /**
     * 创建二维码ticket
     * @param int|string $scene_id 自定义追踪id,临时二维码只能用数值型
     * @param int $type 0:临时二维码；1:永久二维码(此时expire参数无效)；2:永久二维码(此时expire参数无效)
     * @param int $expire 临时二维码有效期，最大为1800秒
     * @return array('ticket'=>'qrcode字串','expire_seconds'=>1800,'url'=>'二维码图片解析后的地址')
     */
    public function getQRCodeTicket($scene_id, $type = 0, $expire = 1800)
    {
        //检测TOKEN
        $this->checkAccessToken();
        $type = ($type && is_string($scene_id)) ? 2 : $type;
        $data = array(
            'action_name' => $type ? ($type == 2 ? "QR_LIMIT_STR_SCENE" : "QR_LIMIT_SCENE") : "QR_SCENE",
            'expire_seconds' => $expire,
            'action_info' => array('scene' => ($type == 2 ? array('scene_str' => $scene_id) : array('scene_id' => $scene_id)))
        );
        if ($type == 1) {
            unset($data['expire_seconds']);
        }
        return $this->httpPost(self::PREFIX_API . self::URL_QRCODE_CREATE . 'access_token=' . $this->accessToken, Json::encode($data, JSON_UNESCAPED_UNICODE));
    }

    /**
     * 获取二维码图片
     * @param string $ticket 传入由getQRCode方法生成的ticket参数
     * @return string url 返回http地址
     */
    public function getQRCodeUrl($ticket)
    {
        return self::QRCODE_IMG_URL . urlencode($ticket);
    }

    /**
     * 长链接转短链接接口
     * @param string $long_url 传入要转换的长url
     * @return boolean|string url 成功则返回转换后的短url
     */
    public function getShortUrl($long_url)
    {
        //检测TOKEN
        $this->checkAccessToken();

        $data = array(
            'action' => 'long2short',
            'long_url' => $long_url
        );
        $json = $this->httpPost(self::PREFIX_API . self::URL_SHORTURL . 'access_token=' . $this->accessToken, Json::encode($data, JSON_UNESCAPED_UNICODE));
        if ($json) {
            return $json['short_url'];
        } else {
            return false;
        }
    }

    /**
     * 语义理解接口
     * @param String $query 输入文本串
     * @param String $category 需要使用的服务类型，多个用“，”隔开，不能为空
     * @param Float $latitude 纬度坐标，与经度同时传入；与城市二选一传入
     * @param Float $longitude 经度坐标，与纬度同时传入；与城市二选一传入
     * @param String $city 城市名称，与经纬度二选一传入
     * @param String $region 区域名称，在城市存在的情况下可省略；与经纬度二选一传入
     * @param String $uid 用户唯一id（非开发者id），用户区分公众号下的不同用户（建议填入用户openid）
     * @return boolean|array
     */
    public function querySemantic($query, $category, $latitude = 0.0, $longitude = 0.0, $city = "", $region = "", $uid = '')
    {
        //检测TOKEN
        $this->checkAccessToken();
        $data = array(
            'query' => $query,
            'category' => $category,
            'appid' => $this->appid,
            'uid' => $uid
        );
        //地理坐标或城市名称二选一
        if ($latitude) {
            $data['latitude'] = $latitude;
            $data['longitude'] = $longitude;
        } elseif ($city) {
            $data['city'] = $city;
        } elseif ($region) {
            $data['region'] = $region;
        }
        return $this->httpPost(self::PREFIX_API . self::URL_SEMANTIC_SEMPROXY_SEARCH . 'access_token=' . $this->accessToken, Json::encode($data, JSON_UNESCAPED_UNICODE));
    }
}
