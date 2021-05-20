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
		App:render("Order/order");
	}
}