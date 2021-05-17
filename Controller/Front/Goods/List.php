<?php

namespace Controller\Front\Goods;

use App;

/**
* 상품목록 
*
*/
class ListController extends \Controller\Front\Controller
{
	public function index()
	{
		$cateCd = request()->get("cateCd");
		if (!$cateCd) {
			msg("잘못된 접근입니다.", -1);
		}
		
		$goods = App::load(\Component\Goods\Goods::class);
		
		$page = request()->get("page");
		$qs = "cateCd=".$cateCd; // 페이지 링크에 추가
		$data = $goods
						->addWhere(["cateCd" => $cateCd, 'isDisplay' => 1])
						->getList($page,20,$qs);
		
		App::render("Goods/list", $data);
	}
}