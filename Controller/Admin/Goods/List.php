<?php

namespace Controller\Admin\Goods;

use App;
use Controller\Admin\Goods\Traits\SubMenu;

/**
* 상품 목록 
*
*/
class ListController extends \Controller\Admin\Controller
{
	protected $mainCode = "goods";
	private $subCode = "list";
	
	use SubMenu;
	
	public function index()
	{
		
	}
}