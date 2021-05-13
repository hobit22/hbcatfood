<?php

namespace Controller\Front\File;

use App;
use Component\Exception\AlertException;

/**
* 이미지 확대 보기 
*
*/
class ViewController extends \Controller\Front\Controller 
{
	public function __construct()
	{
		// 팝업 전용 헤더, 푸터 
		$this->setHeader("popup")
			  ->setFooter("popup");
	}
	
	public function index()
	{
		try {
			$idx = request()->get("idx"); // 파일 번호
			if (!$idx) {
				throw new AlertException("잘못된 접근입니다.");
			}
			
			$file = App::load(\Component\File::class);
			$data = $file->get($idx);
			if (!$data) {
				throw new AlertException("이미지가 없습니다.");
			}
			
			
		} catch (AlertException $e) {
			echo $e;
			// 예외 발생하면 메세지 출력 후 팝업 닫기 
			echo "<script>parent.layer.close();</script>";
		}
	}
}