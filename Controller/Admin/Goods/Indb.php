<?php

namespace Controller\Admin\Goods;

use App;
use Component\Exception\GoodsAdminException;

/**
* 상품관리 DB 처리 
*
*/
class IndbController extends \Controller\Admin\Controller
{
	public function __construct()
	{
		parent::__construct();
		
		$this->layoutBlank = true;
	}
	
	public function index()
	{
		try {
			$in = request()->all(); 
			$goods = App::load(\Component\Goods\Goods::class);
			switch($in['mode']) {
				/** 상품 등록 */
				case "register" : 
					$result = $goods->data($in)
										   ->validator('register')
											->register();
					
					if ($result === false) { // 등록 실패 
						throw new GoodsAdminException("등록 실패!");
					}
					
					// 등록 성공 - 상품 목록 
					go("admin/goods/list", "parent");
					break;
			}
			
		} catch (GoodsAdminException $e) {
			echo $e;
		}
	}
}