<?php

namespace Controller\Front\Goods;

use App;
use Component\Exception\GoodsFrontException;

/**
* 상품관련 Ajax 처리 
*
*/
class AjaxController extends \Controller\Front\Controller
{
	public function __construct()
	{
		$this->layoutBlank = true;
		header("Content-Type: application/json; charset=utf-8");
	}
	
	public function index()
	{
		try {
			$in = request()->all();
			$goods = App::load(\Component\Goods\Goods::class);
			switch ($in['mode']) {
				/** 옵션 정보 추출 */
				case "get_options" : 
					if (!isset($in['optNo']) || !$in['optNo']) {
						throw new GoodsFrontException("잘못된 접근입니다.");
					}
					
					$opt = $goods->getOption($in['optNo']);
					$data = [
						'error' => 0,
						'data' => $opt,
					];
					echo json_encode($data);
					break;
			}
		
		} catch (GoodsFrontException $e) {
			$data = [
				'error' => 1,
				'message' => $e->getMessage(),
			];
			
			echo json_encode($data);
		}
	}
}