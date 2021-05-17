<?php

namespace Controller\Admin\Goods;

use App;
use Controller\Admin\Goods\Traits\SubMenu;

/**
* 분류 설정 
*
*/
class CategoryController extends \Controller\Admin\Controller
{
	use SubMenu;
	
	protected $mainCode = "goods";
	private $subCode = "category";
	
	public function index()
	{
		App::render("Goods/category");
	}
}