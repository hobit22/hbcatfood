<?php

namespace Component\Goods;

use App;
use Component\Exception\GoodsAdminException;
use Component\Exception\GoodsFrontException;

/**
* 상품 Component
*
*/
class Goods
{
	private $params = []; // 처리 데이터 
	private $requiredColumns = [  // 필수 컬럼 
		'goodsNm' => '상품명',
	];
	
	/**
	* 처리데이터 설정 
	* 
	* @param Array $params - 처리 데이터 
	* @return $this
	*/
	public function data($params)
	{
		$this->params = $params;
		
		return $this;
	}
	
	/**
	* 상품 등록, 수정 유효성 검사 
	*
	* @param String $mode 등록(register), 수정(update)
	* @return $this
	*/
	public function validator($mode = "register")
	{
		
		return $this;
	}
	
	/**
	* 상품 등록 
	*
	* @return Integer|Boolean 등록 성공 - 상품번호 반환(goodsNo), 실패 - false
	*/
	public function register()
	{
		
	}
}