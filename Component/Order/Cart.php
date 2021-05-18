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
	* @return Array|Integer|Boolean 추가 되면 장바구니 추가 번호, 실패 false
	*/
	public function add()
	{
		$isDirect = isset($this->params['isDirect'])?$this->params['isDirect']:0;
		if (isset($this->params['optNo'])) { // 옵션 상품 
			$cartNos = [];
			foreach ($this->params['optNo'] as $k => $optNo) {
				$goodsCnt = $this->params['goodsCnt'][$optNo]?$this->params['goodsCnt'][$optNo]:1;
				$inData = [
					'memNo' => isLogin()?$_SESSION['memNo']:0,
					'goodsNo' => $this->params['goodsNo'],
					'optNo' => $optNo,
					'goodsCnt' => $goodsCnt,
					'isDirect' => $isDirect,
				];
				
				$cartNo = db()->table("cart")->data($inData)->insert();
				if ($cartNo !== false) {
					$cartNos[] = $cartNo;
				}
			}
			
			return $cartNos;
			
		} else { // 단품 
			$inData = [
				'memNo' => isLogin()?$_SESSION['memNo']:0,
				'goodsNo' => $this->params['goodsNo'],
				'goodsCnt' => $this->params['goodsCnt']?$this->params['goodsCnt']:1,
				'isDirect' => $isDirect,
			];
			
			$cartNo = db()->table("cart")->data($inData)->insert();
			
			return $cartNo;
		}
		
		return false;
	}
}