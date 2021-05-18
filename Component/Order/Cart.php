<?php

namespace Component\Order;

use App;

/**
* 장바구니 관련 
*
*/
class Cart
{
	private $params = []; // 처리할 데이터 
	
	/**
	* 처리할 데이터 설정 
	*
	* @param Array $param 처리 데이터 
	* @return $this
	*/
	public function data($params = []) 
	{
		$this->params = $params;
		return $this;
	}
	
	/**
	* 장바구니 추가 유효성 검사 
	*
	* @return $this
	* @throw CartException 
	*/
	public function validator()
	{
		return $this;
	}
	
	/**
	* 장바구니 데이터 추가 
	*
	* @return Integer|Boolean 추가 되면 장바구니 추가 번호, 실패 false
	*/
	public function add()
	{
		
	}
}