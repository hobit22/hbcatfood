<?php

namespace Controller\Admin\Goods;

use App;
use Controller\Admin\Goods\Traits\SubMenu;

/**
* 상품 수정 
*
*/
class UpdateController extends \Controller\Admin\Controller 
{
	protected $mainCode = "goods";
	private $subCode = "update";
	
	use SubMenu;
	
	public function __construct()
	{
		parent::__construct();
		
		$this->addScript(["goods_register"])
			   ->addCss(["goods"]);
	}
}