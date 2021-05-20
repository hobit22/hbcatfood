<?php

namespace Controller\Front\Order;

use App;
use Component\Exception\OrderException;

/**
* 주문서
*
*/
class OrderController extends \Controller\Front\Controller
{
	public function index()
	{
		try {
			/**
				장바구니 번호가 있으면 -> 장바구니 -> 주문서로 유입
				장바구니 번호가 없으면 -> 상품상세 -> 주문서로 유입
				
				$isDirect - 1 - 바로구매
				$isDirect - 0 - 장바구니에서 구매
			*/
			$cartNo = request()->get("cartNo");
			$isDirect = $cartNo?0:1;
			$cartNo = $cartNo?$cartNo:[];
			
			$cart = App::load(\Component\Order\Cart::class);
			
			$data = $cart->getGoods($isDirect, $cartNo);
			debug($data);
		} catch (OrderException $e) {
			echo $e;
		}
		
		App::render("Order/order");
	}
}