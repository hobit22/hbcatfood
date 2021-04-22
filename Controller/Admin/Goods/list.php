<?php

namespace Controller\Admin\Goods;

use App;

class ListController extends \Controller\Admin\Controller 
{
	public function __construct()
	{
		$css = ["style2", "style3"];
		$script = ["js1", "js2"];
		$this->addCss($css)
			  ->addScript($script);
	}
	
	public function index()
	{
		App::render("Goods/list", ['test1' => 1, 'test2' => 2]);
	}
}