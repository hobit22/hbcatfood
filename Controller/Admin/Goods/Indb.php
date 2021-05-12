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
					break;
			}
			
		} catch (GoodsAdminException $e) {
			echo $e;
		}
	}
}