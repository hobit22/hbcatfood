<?php

namespace Controller\Front\File;

use App;

/**
* 파일 업로드 
*
*/
class UploadController extends \Controller\Front\Controller
{
	public function __construct()
	{
		$this->setHeader("popup")
			  ->setFooter("popup")
			  ->addScript(["upload"]);
	}
	
	public function index()
	{
		App::render("File/upload");
	}
}