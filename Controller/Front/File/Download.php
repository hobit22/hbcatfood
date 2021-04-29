<?php

namespace Controller\Front\File;

use App;
use Component\Exception\File\FileDownloadException;

/**
* 파일 다운로드 처리 
*
*/
class DownloadController extends \Controller\Front\Controller
{
	public function __construct()
	{
		$this->layoutBlank = true;
	}
	
	public function index()
	{
		try {
			$idx = request()->get("idx");
			if (!$idx) {
				throw new FileDownloadException("잘못된 접근입니다.");
			}
			
			$file = App::load(\Component\File::class);
			$fileInfo = $file->get($idx);
			
			//if (!$fileInfo)
			
			
		} catch (FileDownloadException $e) {
			echo $e;
		}
	}
}