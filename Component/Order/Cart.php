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
		// 바로 구매인 경우는 기존 바로구매 데이터 삭제 후 새로 추가 
		if ($isDirect) {
			$where = [
				'isDirect' => 1,
			];
			if (isLogin()) { // 회원 
				$where['memNo'] = $_SESSION['memNo'];
			} else {
				
			}
			
			db()->table("cart")->where($where)->delete();
		}
		
		
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
			
			// 장바구니 중복 상품 처리 
			$this->adjustCart($isDirect); 
			
			return $cartNos;
			
		} else { // 단품 
			$inData = [
				'memNo' => isLogin()?$_SESSION['memNo']:0,
				'goodsNo' => $this->params['goodsNo'],
				'goodsCnt' => $this->params['goodsCnt']?$this->params['goodsCnt']:1,
				'isDirect' => $isDirect,
			];
			
			$cartNo = db()->table("cart")->data($inData)->insert();
			
			// 장바구니 중복 상품 처리 
			$this->adjustCart($isDirect);
			
			return $cartNo;
		}
		
		return false;
	}
	
	/**
	* 장바구니 중복상품 처리 
	*
	* @param Integer $isDirect  1 - 바로구매, 0 - 장바구니 
	* @return $this
	*/
	public function adjustCart($isDirect = 0) 
	{
		
		/**
		1. 중복 상품을 묶어서 수량을 재 계산  - O 
		2. 장바구니를 모두 비운 후 
		3. 재계산한 상품을 다시 장바구니 추가
		*/
		
		$where = ["isDirect" => $isDirect];
		if (isLogin()) { // 회원
			$where['memNo'] = $_SESSION['memNo'];
		} else { // 비회원 
			
		}
		
		$rows = db()->table("cart")->where($where)->rows();
		
		$goodsCnts = [];
		foreach ($rows as $row) {
			$key = $row['goodsNo']."_".$row['optNo'];
			if (!isset($goodsCnts[$key])) $goodsCnts[$key] = 0;
			
			$goodsCnts[$key] += $row['goodsCnt'];
		}
				
		$list = [];
		foreach ($rows as $row) {
			$key = $row['goodsNo']."_".$row['optNo'];
			
			$row['goodsCnt'] = $goodsCnts[$key];
			$list[$key] = $row;
		}
		
		$list = array_values($list);
		
		try {
			db()->beginTransaction();
			
			$where = ["isDirect" => $isDirect];
			if (isLogin()) { // 회원 
				$where['memNo'] = $_SESSION['memNo'];
			} else { // 비회원 
				
			}
			
			db()->table("cart")->where($where)->delete();
			
			foreach ($list as $li) {
				db()->table("cart")->data($li)->insert();
			}
			
			db()->commit();
		} catch (\PDOException $e) {
			db()->rollBack();
		}
		
		
		return $this;
	}
	
	/**
	* 장바구니 상품 조회
	*
	* @param Integer $isDirect 
	*									0 - 장바구니에 담은 상품
	* 									1 - 바로구매 상품 
	* @return Array
	*/
	public function getGoods($isDirect = 0)
	{
		$config = getConfig();
		$px = $config['prefix'];
		
		$joinTable = [
			'goods' => ["{$px}cart.goodsNo", "{$px}goods.goodsNo", "left"],
			'goodsOption' => ["{$px}cart.optNo", "{$px}goodsOption.optNo", "left"],
		];
		
		$column = "{$px}cart.*, {$px}goods.goodsNm, {$px}goods.salePrice, {$px}goodsOption.optName, {$px}goodsOption.optItem, {$px}goodsOption.addPrice";
		$table = db()->table("cart", $joinTable)
						  ->select($column);
	
		$where = [];
		if (isLogin()) { // 회원일때 
			 $where["{$px}cart.memNo"] = $_SESSION['memNo'];
		} else { // 비회원일때 
			
		}
		
		$list = $table->where($where)
						  ->orderBy([["{$px}cart.regDt", "desc"]])
						  ->rows();
		
	}
}