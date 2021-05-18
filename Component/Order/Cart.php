<?php

namespace Component\Order;

use App;
use Component\Exception\CartException;

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
		if (!isset($this->params['goodsNo']) || !$this->params['goodsNo']) {
			throw new CartException("잘못된 접근입니다.");
		}
		
		return $this;
	}
	
	/**
	* 장바구니 데이터 추가 
	*	
	*	 optNo 있는 경우 -> 옵션 상품 
	* 	           없는 경우 -> 단품 상품
	* 
	* @return Integer|Boolean 추가 되면 장바구니 추가 번호, 실패 false
	*/
	public function add()
	{
		if (isset($this->params['optNo'])) { // 옵션 상품 
			$cartNos = [];
			foreach ($this->params['optNo'] as $k => $optNo) {
				$goodsCnt = $this->params['goodsCnt'][$optNo]?$this->params['goodsCnt'][$optNo]:1;
				$isDirect = isset($this->params['isDirect'])?$this->params['isDirect']:0;
				$inData = [
					'memNo' => isset($_SESSION['memNo'])?$_SESSION['memNo']:0,
					'goodsNo' => $this->params['goodsNo'],
					'optNo' => $optNo,
					'goodsCnt' => $goodsCnt,
					'isDirect' => $isDirect,
				];
			}
			
		} else { // 단품 
			
		}
	}
}