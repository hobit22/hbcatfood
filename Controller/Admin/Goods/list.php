<?php

namespace Controller\Admin\Goods;

use App;

class ListController extends \Controller\Admin\Controller 
{
	public function index()
	{
		App::render("Goods/list");
	}
}