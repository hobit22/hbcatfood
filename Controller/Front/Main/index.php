<?php

namespace Controller\Front\Main;
use App;
class IndexController extends \Controller\Front\Controller
{
	public function index()
	{
		App::render("Main/main");
	}
}