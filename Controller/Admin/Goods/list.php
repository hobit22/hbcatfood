<?php

namespace Controller\Admin\Goods;

use App;

class ListController extends \Controller\Admin\Controller 
{
	public function index()
	{
		$db = App::load(\Component\Core\DB::class);
		$db->table("shop")->rows();
		App::render("Goods/list", ['test1' => 1, 'test2' => 2]);
	}
}