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
			$delivery = App::load(\Component\Goods\Delivery::class);
			
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
				/** 상품 수정 */
				case "update" : 
					$result = $goods->data($in)
										  ->validator("update")
										  ->update();
										  
					if ($result === false) { // 수정 실패 
						throw new GoodsAdminException("수정 실패!");
					}
					
					// 수정 성공 -> 상품 목록 
					go("admin/goods/list", "parent");
					break;
				/** 상품 삭제(목록) */
				case "delete_list" : 
					if (!isset($in['goodsNo'])) {
						throw new GoodsAdminException("삭제할 상품을 선택해 주세요.");
					}
					
					foreach ($in['goodsNo'] as $goodsNo) {
						$goods->delete($goodsNo);
					}
					
					reload("parent");
					break;
				/** 옵션 전체 삭제 */
				case "delete_options" : 
					$goodsNo = request()->post("goodsNo");
					if ($goodsNo) {
						$result = $goods->deleteOptions($goodsNo);
						if ($result) {
							echo 1; // 성공 
							exit;
						}
					}
					echo 0; // 실패 
					break;
				/** 배송 설정 등록 */
				case "register_delivery" : 
				
					break;
			}
			
		} catch (GoodsAdminException $e) {
			echo $e;
		}
	}
}