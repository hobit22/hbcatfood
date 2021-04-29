<?php

namespace Controller\Front\File;

use App;

/**
* 파일 삭제 
*
*/
class DeleteController extends \Controller\Front\Controller
{
	public function __construct()
	{
		$this->layoutBlank = true;
	}
	
	public function index()
	{
		$idx = request()->post("idx");
		$file = App::load(\Component\File::class);
		if ($idx) {
			$result = $file->delete($idx);
			if ($result) {
				echo 1; // 파일 삭제 성공시 1
				exit;
			}
		} // endif
		
		echo 0; // 파일 삭제 실패시 0 
	}
}