<?php

namespace Controller\Front\Goods;

use App;

class ListController extends \Controller\Front\Controller 
{
	public function __construct()
	{
		$this->setHeader("custom")->setFooter("custom");

		//$this->layoutBlank = true; // 헤더, footer 출력 X
	}

	public function index()
	{
		App::render("Goods/list", ["test1" => 1, "test2" => 2]);
	}
}