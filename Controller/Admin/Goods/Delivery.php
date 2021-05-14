<?php

namespace Controller\Admin\Goods;

use App;
use Controller\Admin\Goods\Traits\SubMenu;

/**
* 배송설정 
*
*/
class DeliveryController extends \Controller\Admin\Controller
{
	use SubMenu;
	
	protected $mainCode = "goods";
	private $subCode = "delivery";
	
	public function index()
	{
		$delivery = App::load(\Component\Goods\Delivery::class);
		$list = $delivery->getList(); // 배송비 설정 
		App::render("Goods/delivery", ["list" => $list]);
	}
}