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
			$files = request()->files();
			if (!$gid) {
				throw new FileUploadException("잘못된 접근입니다.");
			}
			
			if (!isset($files['file']['tmp_name']) || !$files['file']['tmp_name']) {
				throw new FileUploadException("파일을 업로드해 주세요.");
			}
			
			if (isset($files['file']['error']) && $files['file']['error']) {
				throw new FileUploadException("파일 업로드 실패!");
			}
			
			/**
				1. file 태그 name 
				2. 파일 형식제한(이미지, 이미지외 파일)
			*/
			
			
		} catch (FileUploadException $e) {
			echo $e;
		}
	}
}