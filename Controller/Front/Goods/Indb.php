<?php

namespace Controller\Front\Goods;

use App;
use Component\Exception\GoodsFrontException;

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
					
					break;
				/** 바로구매 */
				case "order" : 
				
					break;
			}
		} catch (GoodsFrontException $e) {
			echo $e;
		}
	}
}