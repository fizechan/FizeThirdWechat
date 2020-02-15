<?php


namespace fize\third\wechat\api\card;


use fize\third\wechat\Api;

/**
 * 货架
 */
class Landingpage extends Api
{

    /**
     * 创建货架
     * @param string $banner 页面的banner图片链接
     * @param string $title 页面的title
     * @param bool $can_share 页面是否可以分享
     * @param string $scene 投放页面的场景值
     * @param array $card_list 卡券列表
     * @return array
     * @see https://developers.weixin.qq.com/doc/offiaccount/Cards_and_Offer/Distributing_Coupons_Vouchers_and_Cards.html#3
     */
    public function create($banner, $title, $can_share, $scene, array $card_list)
    {
        $params = [
            'banner'    => $banner,
            'title'     => $title,
            'can_share' => $can_share,
            'scene'     => $scene,
            'card_list' => $card_list
        ];
        return $this->httpPost("/card/landingpage/create?access_token={$this->accessToken}", $params);
    }
}
