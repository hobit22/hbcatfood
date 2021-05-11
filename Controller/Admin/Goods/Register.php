<?php

namespace Controller\Admin\Goods;

use App;
use Controller\Admin\Goods\Traits\SubMenu;

/**
* 상품 등록
*
*/
class RegisterController extends \Controller\Admin\Controller
{
	protected $mainCode = "goods";
	private $subCode = "register";
	
	use SubMenu;
	
	public function index()
	{
		App::render("Goods/form");
	}
}