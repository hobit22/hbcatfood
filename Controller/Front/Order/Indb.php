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
					print_r($in);
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