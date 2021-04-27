<?php

namespace Controller\Admin\Board;

class IndexController extends \Controller\Admin\Controller
{
	public function __construct()
	{
		$url = siteUrl("admin/board/list");
		header("Location: {$url}");
		exit;
	}
}