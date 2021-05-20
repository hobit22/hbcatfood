<?php

namespace Controller\Front\Order;

use App;

/**
* 장바구니 
*
*/
class CartController extends \Controller\Front\Controller
{
	public function index()
	{
		$cart = App::load(\Component\Order\Cart::class);
		$list = $cart->getGoods(); // 장바구니 상품
		App::render("Order/cart");
	}
}