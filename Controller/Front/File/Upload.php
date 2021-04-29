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
		$gid = request()->get("gid");
		$type = request()->get("type");
		if (!$gid) {
			return msg("잘못된 접근입니다.");
		}
		
		App::render("File/upload", ["gid" => $gid, 'type' => $type]);
	}
}