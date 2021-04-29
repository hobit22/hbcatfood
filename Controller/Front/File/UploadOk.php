<?php

namespace Controller\Front\File;

use App;
use Component\Exception\File\FileUploadException;

/**
* 파일 업로드 처리 
*
*/
class UploadOkController extends \Controller\Front\Controller
{
	public function __construct()
	{
		$this->layoutBlank = true;
	}
	
	public function index()
	{
		try {
			$gid = request()->post("gid");
			$type = request()->post("type");
			$files = request()->files();
			if (!$gid) {
				throw new FileUploadException("잘못된 접근입니다.");
			}
			
			/**
				0. gid
				1. file 태그 name 
				2. 파일 형식제한(이미지, 이미지외 파일)
			*/
			$file = App::load(\Component\File::class);
			$idx = $file->upload($gid, "file", $type, true);
			if ($idx === false) {
				throw new FileUploadException("파일 업로드 실패!");
			}
			
			// 서버에 업로드된 URL 
			$fileUrl = $file->getUploadedUrl($idx);
			
			
			
		} catch (FileUploadException $e) {
			echo $e;
		}
	}
}