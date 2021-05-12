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
	
	public function __construct() 
	{
		parent::__construct(); // 관리자 페이지 접근 제한을 위해 
		$this->addScript(["goods_register"])
			   ->addCss(["goods"]);
		
	}
	
	public function index()
	{
		$gid = gid();
		$data = [
			'gid' => $gid,
		];
		App::render("Goods/form", $data);
	}
}