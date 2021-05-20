<?php

namespace Controller\Front\Order; 

use App;
use Component\Exception\CartException;
use Component\Exception\OrderException;

/**
* 장바구니, 주문서 DB 처리 
*
*/
class IndbController extends \Controller\Front\Controller
{
	public function __construct()
	{
		$this->layoutBlank = true;
	}
	
	public function index()
	{
		try {
			$in = request()->all();
			$cart = App::load(\Component\Order\Cart::class);
			
			switch($in['mode']) {
				// 장바구니 수량 변경 
				case "update_goods_cnt" : 
					// 유효성 검사 
					if (!isset($in['cartNo']) || !$in['cartNo'] || !isset($in['goodsCnt']) || !$in['goodsCnt']) {
						throw new \Exception("잘못된 접근입니다.");
					}
					
					$result = $cart->updateGoodsCnt($in['cartNo'], $in['goodsCnt']);
					if (!$result) {
						throw new \Exception("구매수량 변경 실패하였습니다.");
					}
					
					// 수량 변경 성공
					$data = [
						'error' => 0,
					];
					
					header("Content-Type: application/json; charset=utf-8");
					echo json_encode($data);
					break;
			}
			
			
		} catch (CartException $e) {
			echo $e;
		} catch (OrderException $e) {
			
		} catch (\Exception $e) { // ajax 처리시 
			$data = [
				'error' => 1,
				'message' => $e->getMessage(),
			];
			
			header("Content-Type: application/json; charset=utf-8");
			echo json_encode($data);
		}
	}
}