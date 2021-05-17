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
					$result = $delivery->data($in)
											 ->validator("register")
											 ->register();
					if ($result === false) {
						throw new GoodsAdminException("등록 실패!");
					}
					
					// 등록 성공시 새로고침 
					reload("parent");
					break;
				/** 배송설정 수정 */
				case "update_delivery" : 
					if (!isset($in['deliveryNo'])) {
						throw new GoodsAdminException("수정할 설정을 선택해 주세요.");
					}
					
					// 설정 정보 수정 
					foreach ($in['deliveryNo'] as $deliveryNo) {
						$upData = [
							'deliveryNo' => $deliveryNo,
							'deliveryName' => $in['deliveryName'][$deliveryNo],
							'deliveryPrice' => $in['deliveryPrice'][$deliveryNo],
							'isTogether' => $in['isTogether'][$deliveryNo],
						];
						
						$delivery->data($upData)
									->validator("update")
									->update();
					}
					
					// 기본 배송 설정 
					if (isset($in['isDefault'])) {
						$delivery->setDefault($in['isDefault']);
					}
					
					// 설정 완료 -> 새로고침
					reload("parent");
					break;
				/** 배송설정 삭제 */
				case "delete_delivery" : 
					if (!isset($in['deliveryNo'])) {
						throw new GoodsAdminException("삭제할 설정을 선택하세요.");
					}
					
					foreach ($in['deliveryNo'] as $deliveryNo) {
						$delivery->delete($deliveryNo);
					}
					
					// 삭제완료 -> 새로고침
					reload("parent");
					break;
				/** 분류 등록 */
				case "register_category" : 
					if (!$in['cateCd']) {
						throw new GoodsAdminException("분류코드를 입력해 주세요.");
					}
					
					if (!$in['cateNm']) {
						throw new GoodsAdminException("분류명을 입력해 주세요.");
					}
					
					
					$result = $goods->registerCategory($in['cateCd'], $in['cateNm']);
					if ($result === false) {
						throw new GoodsAdminException("분류등록 실패!");
					}
					
					// 등록 성공 -> 새로고침
					reload("parent");
					break;
				/** 분류 수정 */
				case "update_category" :
					if (!isset($in['cateCd'])) {
						throw new GoodsAdminException("수정할 분류를 선택하세요.");
					}
					
					foreach ($in['cateCd'] as $cateCd) {
						$upData = [
							'cateCd' => $cateCd,
							'cateNm' => $in['cateNm'][$cateCd],
							'isDisplay' => $in['isDisplay'][$cateCd],
							'listOrder' => $in['listOrder'][$cateCd],
						];
						
						$goods->data($upData)->updateCategory();		
					}
					
					// 수정이 완료되면 -> 새로고침
					reload("parent");
					
					break;
				/** 분류 삭제 */
				case "delete_category" : 
					if (!isset($this->params['cateCd'])) {
						throw new GoodsAdminException("삭제할 분류를 선택해 주세요.");
					}
					
					foreach ($this->params['cateCd'] as $cateCd) {
						$goods->deleteCategory($cateCd);
					}
					
					// 삭제 완료 -> 새로고침
					reload("parent");
					break;
			}
			
		} catch (GoodsAdminException $e) {
			echo $e;
		}
	}
}