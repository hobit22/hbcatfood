<?php

namespace Controller\Front\Goods;

use App;

class ListController extends \Controller\Front\Controller 
{
	public function index()
	{
		App::render("Goods/list", ["test1" => 1, "test2" => 2]);
	}
}