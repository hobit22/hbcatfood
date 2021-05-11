<?php

namespace Controller\Admin\Goods;

class IndexController extends \Controller\Admin\Controller
{
	public function __construct()
	{
		$url = siteUrl("admin/goods/list");
		header("Location: {$url}");
		exit;
	}
}