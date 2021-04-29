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
			$uploadedPath = $file->getUploadedPath($idx); // 업로드된 파일 경로
			if (!$fileInfo || !file_exists($uploadedPath)) {
				throw new FileDownloadException("파일이 존재하지 않습니다.");
			}
			
			header("Content-Type: application/octet-stream");
			header("Content-Disposition: attachment; filename={$fileInfo['fileName']}");
			header("Content-Length: ". filesize($uploadedPath));
			readFile($uploadedPath);
			
		} catch (FileDownloadException $e) {
			echo $e;
		}
	}
}