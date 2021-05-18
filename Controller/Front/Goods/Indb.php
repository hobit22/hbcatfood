<?php

namespace Controller\Front\Goods;

use App;
use Component\Exception\GoodsFrontException;
use Component\Exception\CartException;

/**
* 상품 상세 DB 처리
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
			
			switch ($in['mode']) {
				/** 장바구니 */
				case "cart" : 
					$result = $cart->data($in)
									   ->validator()
									   ->add();
					
					if (!$result) {
						throw new CartException("장바구니 추가 실패!");
					}
					
					// 추가 성공 했을 때는 장바구니 페이지로 이동
					go("order/cart", "parent");
					break;
				/** 바로구매 */
				case "order" : 
					$in['isDirect'] = 1; // 바로 구매 여부
					$result = $cart->data($in)
										->validator()
										->add();
					
					
					if (!$result) {
						throw new CartException("장바구니 추가 실패!");
					}
					
					// 추가 성공 한 경우 -> 주문하기 페이지로 이동 
					go("order/order", "parent");
					break;
			}
		} catch (GoodsFrontException $e) {
			echo $e;
		} catch (CartException $e) {
			echo $e;
		}
	}
}