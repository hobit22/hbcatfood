<?php

namespace Controller\Front\Order;

use App;

class EndController extends \Controller\Front\Controller
{
	public function index()
	{
		$orderNo = request()->get("orderNo");
		if (!$orderNo) {
			msg("잘못된 접근입니다", "main/index");
		}
		
		$data = [
			'orderNo' => $orderNo,
		];
		
		App::render("Order/end", $data);
	}
}