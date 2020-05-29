<?php


namespace fize\third\wechat\api;

use fize\third\wechat\Api;


/**
 * 微信卡券
 */
class Card extends Api
{

    /**
     * 场景值：附近
     */
    const SCENE_NEAR_BY = 'SCENE_NEAR_BY';

    /**
     * 场景值：自定义菜单
     */
    const SCENE_MENU = 'SCENE_MENU';

    /**
     * 场景值：二维码
     */
    const SCENE_QRCODE = 'SCENE_QRCODE';

    /**
     * 场景值：公众号文章
     */
    const SCENE_ARTICLE = 'SCENE_ARTICLE';

    /**
     * 场景值：H5页面
     */
    const SCENE_H5 = 'SCENE_H5';

    /**
     * 场景值：自动回复
     */
    const SCENE_IVR = 'SCENE_IVR';

    /**
     * 场景值：卡券自定义列
     */
    const SCENE_CARD_CUSTOM_CELL = 'SCENE_CARD_CUSTOM_CELL';

    /**
     * 卡券状态：待审核
     */
    const CARD_STATUS_NOT_VERIFY = 'CARD_STATUS_NOT_VERIFY';

    /**
     * 卡券状态：审核失败
     */
    const CARD_STATUS_VERIFY_FAIL = 'CARD_STATUS_VERIFY_FAIL';

    /**
     * 卡券状态：通过审核
     */
    const CARD_STATUS_VERIFY_OK = 'CARD_STATUS_VERIFY_OK';

    /**
     * 卡券状态：卡券被商户删除
     */
    const CARD_STATUS_DELETE = 'CARD_STATUS_DELETE';

    /**
     * 卡券状态：在公众平台投放过的卡券
     */
    const CARD_STATUS_DISPATCH = 'CARD_STATUS_DISPATCH';

    /**
     * 创建卡券
     * @param array $card 卡券数据
     * @return array 返回数组中card_id为卡券ID
     * @see https://developers.weixin.qq.com/doc/offiaccount/Cards_and_Offer/Create_a_Coupon_Voucher_or_Card.html
     */
    public function create(array $card)
    {
        $params = [
            'card' => $card
        ];
        return $this->httpPost("/card/create?access_token={$this->accessToken}", $params);
    }

    /**
     * 查看卡券详情
     * @param string $card_id 卡券ID
     * @return array
     */
    public function get($card_id)
    {
        $params = [
            'card_id' => $card_id
        ];
        $result = $this->httpPost("/card/get?access_token={$this->accessToken}", $params);
        return $result['code'];
    }

    /**
     * 批量查询卡券列表
     * @param int   $offset      查询卡列表的起始偏移量
     * @param int   $count       需要查询的卡片的数量
     * @param array $status_list 拉出指定状态的卡券列表
     * @return array
     */
    public function batchget($offset, $count, $status_list = null)
    {
        $params = [
            'offset' => $offset,
            'count'  => $count
        ];
        if (!is_null($status_list)) {
            $params['status_list'] = $status_list;
        }
        return $this->httpPost("/card/batchget?access_token={$this->accessToken}", $params);
    }

    /**
     * 更改卡券信息
     * @param string $card_id   卡券ID
     * @param string $card_type 卡券类型
     * @param array  $data      卡券信息
     * @return array
     */
    public function update($card_id, $card_type, array $data)
    {
        $params = [
            'card_id'  => $card_id,
            $card_type => $data
        ];
        return $this->httpPost("/card/update?access_token={$this->accessToken}", $params);
    }

    /**
     * 修改库存
     * @param string $card_id              卡券ID
     * @param int    $increase_stock_value 增加多少库存
     * @param int    $reduce_stock_value   减少多少库存
     */
    public function modifystock($card_id, $increase_stock_value = null, $reduce_stock_value = null)
    {
        $params = [
            'card_id' => $card_id
        ];
        if (!is_null($increase_stock_value)) {
            $params['increase_stock_value'] = $increase_stock_value;
        }
        if (!is_null($reduce_stock_value)) {
            $params['reduce_stock_value'] = $reduce_stock_value;
        }
        $this->httpPost("/card/modifystock?access_token={$this->accessToken}", $params);
    }

    /**
     * 删除卡券
     * @param string $card_id 卡券ID
     */
    public function delete($card_id)
    {
        $params = [
            'card_id' => $card_id
        ];
        $this->httpPost("/card/delete?access_token={$this->accessToken}", $params);
    }

    /**
     * 卡券开放类目查询
     * @return array
     */
    public function getapplyprotocol()
    {
        return $this->httpGet("/card/getapplyprotocol?access_token={$this->accessToken}");
    }
}
