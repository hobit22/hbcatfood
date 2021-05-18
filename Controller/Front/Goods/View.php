<?php

namespace Controller\Front\Goods;

use App;

/**
* 상품 상세 페이지 
*
*/ 
class ViewController extends \Controller\Front\Controller
{
	public function __construct() 
	{
		$this->addCss(["goods"])
			  ->addScript(["goods_view"]);
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
		
		App::render("Goods/view", $data);
	}
}