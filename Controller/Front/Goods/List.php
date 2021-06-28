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
		$reqSub = request()->get("subCate");
		$reqBrand = request()->get("brandCate");
		$goodsNm = request()->get("goodsNm");
		
		$goods = App::load(\Component\Goods\Goods::class);
		$page = request()->get("page");
		if($goodsNm){
			$qs = "goodsNm=".$goodsNm;
			$where = [
							"goodsNm" => [$goodsNm , 'LIKE'] ,
							"isDisplay" => 1,
						];
			
			$data = $goods
				->addWhere($where)
				->getList($page,20,$qs);
			
			App::render("Goods/list", $data);
			exit;
		}
		
		/**
		if (!$cateCd) {
			msg("잘못된 접근입니다.", -1);
		}
		*/
		
		$subCate['cateCd']=$cateCd;
		
		$qs = "cateCd=".$cateCd; // 페이지 링크에 추가
		
		$where = [
						"cateCd" => $cateCd, 
						'isDisplay' => 1,
					];
		if ($reqSub) {
			$where['subCategory'] = $reqSub;
			$qs .= "&subCate=".$reqSub;
		}
		
		if ($reqBrand) {
			$where['brandCate'] = $reqBrand;
			$qs .= "&brandCate=".$reqBrand;
		}
		
		$data = $goods
						->addWhere($where)
						->getList($page,20,$qs);
		
		$subCategories = $goods->getCategoriesWithSub();
		
		$data['subCate']=$subCate?$subCate:[];
		$data['subCate']['reqSub'] = $reqSub;
		$data['subCate']['sub']= $subCategories[$cateCd]['subCategory']?$subCategories[$cateCd]['subCategory']:[];
		
		$data['subCate']['reqBrand'] = $reqBrand;
		$data['subCate']['brand']= $subCategories[$cateCd]['brandCate']?$subCategories[$cateCd]['brandCate']:[];
		
		
		App::render("Goods/list", $data);
	}
}