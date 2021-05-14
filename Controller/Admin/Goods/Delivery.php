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
		App::render("Goods/delivery");
	}
}