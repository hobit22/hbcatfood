<?php

namespace Controller\Front\Board;

use App;

/**
* 게시글 작성 
*
*/
class WriteController extends \Controller\Front\Controller
{
	public function index()
	{
		App::render("Board/form", ["boardSkin" => "Default"]);
	}
}