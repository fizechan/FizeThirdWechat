<?php
namespace fize\third\wechat\api;


use fize\third\wechat\Api;
use fize\crypt\Json;
/**
 * 微信小店管理类
 */
class Shop extends Api{
	
	const URL_MERCHANT_CREATE = '/merchant/create?';
	const URL_MERCHANT_DEL = '/merchant/del?';
	const URL_MERCHANT_UPDATE = '/merchant/update?';
	const URL_MERCHANT_GET = '/merchant/get?';
	const URL_MERCHANT_GETBYSTATUS = '/merchant/getbystatus?';
	const URL_MERCHANT_MODPRODUCTSTATUS = '/merchant/modproductstatus?';
	
	const URL_CATEGORY_GETSUB = '/merchant/category/getsub?';
	const URL_CATEGORY_GETSKU = '/merchant/category/getsku?';
	const URL_CATEGORY_GETPROPERTY = '/merchant/category/getproperty?';
	
	const URL_STOCK_ADD = '/merchant/stock/add?';
	const URL_STOCK_REDUCE = '/merchant/stock/reduce?';
	
	const URL_EXPRESS_ADD = '/merchant/express/add?';
	const URL_EXPRESS_DEL = '/merchant/express/del?';
	const URL_EXPRESS_UPDATE = '/merchant/express/update?';
	const URL_EXPRESS_GETBYID = '/merchant/express/getbyid?';
	const URL_EXPRESS_GETALL = '/merchant/express/getall?';
	
	const URL_GROUP_ADD = '/merchant/group/add?';
	const URL_GROUP_DEL = '/merchant/group/del?';
	const URL_GROUP_PROPERTYMOD = '/merchant/group/propertymod?';
	const URL_GROUP_PRODUCTMOD = '/merchant/group/productmod?';
	const URL_GROUP_GETALL = '/merchant/group/getall?';
	const URL_GROUP_GETBYID = '/merchant/group/getbyid?';
	
	const URL_SHELF_ADD = '/merchant/shelf/add?';
	const URL_SHELF_DEL = '/merchant/shelf/del?';
	const URL_SHELF_MOD = '/merchant/shelf/mod?';
	const URL_SHELF_GETALL = '/merchant/shelf/getall?';
	const URL_SHELF_GETBYID = '/merchant/shelf/getbyid?';
	
	const URL_ORDER_GETBYID = '/merchant/order/getbyid?';
	const URL_ORDER_GETBYFILTER = '/merchant/order/getbyfilter?';
	const URL_ORDER_SETDELIVERY = '/merchant/order/setdelivery?';
	const URL_ORDER_CLOSE = '/merchant/order/close?';
	
	const URL_MERCHANT_COMMON_UPLOAD_IMG = '/merchant/common/upload_img?';
	
	/**
	 * 构造函数
	 * @param array $p_options 参数数组
	 */
	public function __construct($p_options){
		parent::__construct($p_options);
		//检测TOKEN
		$this->checkAccessToken();
	}
	
	/**
	 * 增加商品
	 * @param array $p_data
	 * @return array|boolean
	 */
	public function createMerchant($p_data){
		return $this->httpPost(self::PREFIX_API . self::URL_MERCHANT_CREATE . 'access_token=' . $this->access_token, Json::encode($p_data));
	}
	
	/**
	 * 删除商品
	 * @param string $p_productid 商品ID
	 * @return boolean
	 */
	public function delMerchant($p_productid){
		$data = array('product_id' => $p_productid);
		$result = $this->httpPost(self::PREFIX_API . self::URL_MERCHANT_DEL . 'access_token=' . $this->access_token, Json::encode($data));
		if ($result){
			return true;
		} else {
			return false;
		}
	}
	
	/**
	 * 更新商品
	 * @param array $p_data
	 * @return boolean
	 */
	public function updateMerchant($p_data){
		$result = $this->httpPost(self::PREFIX_API . self::URL_MERCHANT_UPDATE . 'access_token=' . $this->access_token, Json::encode($p_data));
		if ($result){
			return true;
		} else {
			return false;
		}
	}
	
	/**
	 * 查询商品,单个
	 * @param string $p_productid
	 * @return array|boolean
	 */
	public function getMerchant($p_productid){
		$data = array('product_id' => $p_productid);
		return $this->httpPost(self::PREFIX_API . self::URL_MERCHANT_GET . 'access_token=' . $this->access_token, Json::encode($data));
	}
	
	/**
	 * 获取指定状态的所有商品
	 * @param int $p_status 商品状态(0-全部, 1-上架, 2-下架)
	 * @return array|boolean
	 */
	public function getMerchantByStatus($p_status){
		$data = array('status' => $p_status);
		return $this->httpPost(self::PREFIX_API . self::URL_MERCHANT_GETBYSTATUS . 'access_token=' . $this->access_token, Json::encode($data));
	}
	
	/**
	 * 商品上下架
	 * @param string $p_productid 商品ID
	 * @param int $p_status 商品上下架标识(0-下架, 1-上架)
	 * @return boolean
	 */
	public function modMerchantProductStatus($p_productid, $p_status){
		$data = array(
			'product_id' => $p_productid,
			'status' => $p_status
		);
		$result = $this->httpPost(self::PREFIX_API . self::URL_MERCHANT_UPDATE . 'access_token=' . $this->access_token, Json::encode($data));
		if ($result){
			return true;
		} else {
			return false;
		}
	}
	
	/**
	 * 获取指定分类的所有子分类
	 * @param int $cate_id (根节点分类id为1,可省略)
	 * @return array|boolean
	 */
	public function getCategorySub($cate_id = 1){
		$data = array('cate_id' => $cate_id);
		return $this->httpPost(self::PREFIX_API . self::URL_CATEGORY_GETSUB . 'access_token=' . $this->access_token, Json::encode($data));
	}
	
	/**
	 * 1.8	获取指定子分类的所有SKU
	 * @param int $cate_id 根节点分类id
	 * @return array|boolean
	 */
	public function getCategorySKU($cate_id){
		$data = array('cate_id' => $cate_id);
		return $this->httpPost(self::PREFIX_API . self::URL_CATEGORY_GETSKU . 'access_token=' . $this->access_token, Json::encode($data));
	}
	
	/**
	 * 获取指定分类的所有属性
	 * @param int $cate_id 根节点分类id
	 * @return array|boolean
	 */
	public function getCategoryProperty($cate_id){
		$data = array('cate_id' => $cate_id);
		return $this->httpPost(self::PREFIX_API . self::URL_CATEGORY_GETPROPERTY . 'access_token=' . $this->access_token, Json::encode($data));
	}
	
	/**
	 * 增加库存
	 * @param array $p_data
	 * @return boolean
	 */
	public function addStock($p_data){
		$result = $this->httpPost(self::PREFIX_API . self::URL_STOCK_ADD . 'access_token=' . $this->access_token, Json::encode($p_data));
		if ($result){
			return true;
		} else {
			return false;
		}
	}
	
	/**
	 * 减少库存
	 * @param array $p_data
	 * @return boolean
	 */
	public function reduceStock($p_data){
		$result = $this->httpPost(self::PREFIX_API . self::URL_STOCK_REDUCE . 'access_token=' . $this->access_token, Json::encode($p_data));
		if ($result){
			return true;
		} else {
			return false;
		}
	}
	
	/**
	 * 增加邮费模板
	 * @param array $p_data
	 * @return array|boolean
	 */
	public function addExpress($p_data){
		return $this->httpPost(self::PREFIX_API . self::URL_EXPRESS_ADD . 'access_token=' . $this->access_token, Json::encode($p_data));
	}
	
	/**
	 * 删除邮费模板
	 * @param int $template_id
	 * @return boolean
	 */
	public function delExpress($template_id){
		$data = array('template_id' => $template_id);
		$result = $this->httpPost(self::PREFIX_API . self::URL_EXPRESS_DEL . 'access_token=' . $this->access_token, Json::encode($data));
		if ($result){
			return true;
		} else {
			return false;
		}
	}
	
	/**
	 * 修改邮费模板
	 * @param int $template_id
	 * @param array $delivery
	 * @return boolean
	 */
	public function updateExpress($template_id, $delivery){
		$data = array(
			'template_id' => $template_id,
			'delivery_template' => $delivery
		);
		$result = $this->httpPost(self::PREFIX_API . self::URL_EXPRESS_UPDATE . 'access_token=' . $this->access_token, Json::encode($data));
		if ($result){
			return true;
		} else {
			return false;
		}
	}
	
	/**
	 * 获取指定ID的邮费模板
	 * @param int $template_id
	 * @return array|boolean
	 */
	public function getExpressByID($template_id){
		$data = array('template_id' => $template_id);
		return $this->httpPost(self::PREFIX_API . self::URL_EXPRESS_GETBYID . 'access_token=' . $this->access_token, Json::encode($data));
	}
	
	/**
	 * 获取所有邮费模板
	 * @return array|boolean
	 */
	public function getExpressAll(){
		return $this->httpGet(self::PREFIX_API . self::URL_EXPRESS_GETALL . 'access_token=' . $this->access_token);
	}
	
	/**
	 * 增加分组
	 * @param array $p_data
	 * @return array|boolean
	 */
	public function addGroup($p_data){
		return $this->httpPost(self::PREFIX_API . self::URL_GROUP_ADD . 'access_token=' . $this->access_token, Json::encode($p_data));
	}
	
	/**
	 * 删除分组
	 * @param int $group_id
	 * @return boolean
	 */
	public function delGroup($group_id){
		$data = array('group_id' => $group_id);
		$result = $this->httpPost(self::PREFIX_API . self::URL_GROUP_DEL . 'access_token=' . $this->access_token, Json::encode($data));
		if ($result){
			return true;
		} else {
			return false;
		}
	}
	
	/**
	 * 修改分组属性
	 * @param int $group_id
	 * @param string $group_name
	 * @return boolean
	 */
	public function modGroupProperty($group_id, $group_name){
		$data = array(
			'group_id' => $group_id,
			'group_name' => $group_name
		);
		$result = $this->httpPost(self::PREFIX_API . self::URL_GROUP_PROPERTYMOD . 'access_token=' . $this->access_token, Json::encode($data));
		if ($result){
			return true;
		} else {
			return false;
		}
	}
	
	/**
	 * 修改分组商品
	 * @param int $group_id
	 * @param array $product_data
	 * @return boolean
	 */
	public function modGroupProduct($group_id, $product_data){
		$data = array(
			'group_id' => $group_id,
			'product' => $product_data
		);
		$result = $this->httpPost(self::PREFIX_API . self::URL_GROUP_PRODUCTMOD . 'access_token=' . $this->access_token, Json::encode($data));
		if ($result){
			return true;
		} else {
			return false;
		}
	}
	
	/**
	 * 获取所有分组
	 * @return array|boolean
	 */
	public function getGroupAll(){
		return $this->httpGet(self::PREFIX_API . self::URL_GROUP_GETALL . 'access_token=' . $this->access_token);
	}
	
	/**
	 * 获取指定ID的邮费模板
	 * @param int $group_id
	 * @return array|boolean
	 */
	public function getGroupByID($group_id){
		$data = array('group_id' => $group_id);
		return $this->httpPost(self::PREFIX_API . self::URL_GROUP_GETBYID . 'access_token=' . $this->access_token, Json::encode($data));
	}
	
	/**
	 * 增加货架
	 * @param array $p_data
	 * @return array|boolean
	 */
	public function addShelf($p_data){
		return $this->httpPost(self::PREFIX_API . self::URL_SHELF_ADD . 'access_token=' . $this->access_token, Json::encode($p_data));
	}
	
	/**
	 * 删除货架
	 * @param int $shelf_id
	 * @return boolean
	 */
	public function delShelf($shelf_id){
		$data = array('shelf_id' => $shelf_id);
		$result = $this->httpPost(self::PREFIX_API . self::URL_SHELF_DEL . 'access_token=' . $this->access_token, Json::encode($data));
		if ($result){
			return true;
		} else {
			return false;
		}
	}
	
	/**
	 * 修改货架
	 * @param string $shelf_id 货架ID
	 * @param array $shelf_data 货架详情
	 * @param type $shelf_banner
	 * @param type $shelf_name
	 * @return boolean
	 */
	public function modShelf($shelf_id, $shelf_data, $shelf_banner, $shelf_name){
		$data = array(
			'shelf_id' => $shelf_id,
			'shelf_data' => $shelf_data,
			'shelf_banner' => $shelf_banner,
			'shelf_name' => $shelf_name
		);
		$result = $this->httpPost(self::PREFIX_API . self::URL_SHELF_MOD . 'access_token=' . $this->access_token, Json::encode($data));
		if ($result){
			return true;
		} else {
			return false;
		}
	}
	
	/**
	 * 获取所有货架
	 * @return array|boolean
	 */
	public function getShelfAll(){
		return $this->httpGet(self::PREFIX_API . self::URL_SHELF_GETALL . 'access_token=' . $this->access_token);
	}
	
	/**
	 * 根据货架ID获取货架信息
	 * @param int $shelf_id
	 * @return array|boolean
	 */
	public function getShelfByID($shelf_id){
		$data = array('shelf_id' => $shelf_id);
		return $this->httpPost(self::PREFIX_API . self::URL_SHELF_GETBYID . 'access_token=' . $this->access_token, Json::encode($data));
	}
	
	/**
	 * 根据订单ID获取订单详情
	 * @param string $order_id
	 * @return array|boolean
	 */
	public function getOrderByID($order_id){
		$data = array('order_id' => $order_id);
		return $this->httpPost(self::PREFIX_API . self::URL_ORDER_GETBYID . 'access_token=' . $this->access_token, Json::encode($data));
	}
	
	/**
	 * 根据订单状态/创建时间获取订单详情
	 * @param string $p_status
	 * @param string $p_begintime
	 * @param string $endtime
	 * @return array|boolean
	 */
	public function getOrderByFilter($p_status='', $p_begintime='', $endtime=''){
		$data = array();
		if($p_status){
			$data['status'] = $p_status;
		}
		if($p_begintime){
			$data['begintime'] = $p_begintime;
		}
		if($endtime){
			$data['endtime'] = $endtime;
		}
		return $this->httpPost(self::PREFIX_API . self::URL_ORDER_GETBYFILTER . 'access_token=' . $this->access_token, Json::encode($data));
	}
	
	/**
	 * 设置订单发货信息
	 * @param type $p_data
	 * @return type
	 */
	public function setOrderDelivery($p_data){
		return $this->httpPost(self::PREFIX_API . self::URL_ORDER_SETDELIVERY . 'access_token=' . $this->access_token, Json::encode($p_data));
	}
	
	/**
	 * 关闭订单
	 * @param string $order_id
	 * @return boolean
	 */
	public function closeOrder($order_id){
		$data = array('order_id' => $order_id);
		$result = $this->httpPost(self::PREFIX_API . self::URL_ORDER_CLOSE . 'access_token=' . $this->access_token, Json::encode($data));
		if ($result){
			return true;
		} else {
			return false;
		}
	}
	
	/**
	 * 上传图片
	 * @param string $p_name 文件名称
	 * @param string $p_path 文件路径
	 * @return boolean|string
	 */
	public function uploadImg($p_name, $p_path){
		$data = array(0  => '@'.realpath($p_path));
		$json = $this->httpPost(self::PREFIX_API . self::URL_MERCHANT_COMMON_UPLOAD_IMG . 'access_token=' . $this->access_token . '&filename=' . $p_name, $data, true);
		if(json){
			return $json['image_url'];
		} else {
			return false;
		}
	}
}