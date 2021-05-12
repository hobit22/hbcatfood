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
	
	public function index()
	{
		$goodsNo = request()->get("goodsNo");
		if (!$goodsNo) {
			msg("잘못된 접근입니다.", -1);
		}
		
		$goods = App::load(\Component\Goods\Goods::class);
		$data = $goods->get($goodsNo);
		
		if (!$data) {
			msg("존재하지 않는 상품입니다.", -1);
		}
		debug($data);
		App::render("Goods/form", $data);
	}
}