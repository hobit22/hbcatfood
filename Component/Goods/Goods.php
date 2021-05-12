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
	* @throw GoodsAdminException 
	*/
	public function validator($mode = "register")
	{
		
		/** 필수 데이터 체크 */
		$missing = [];
		foreach($this->requiredColumns as $column => $colNm) {
			if (!$this->params[$column]) {
				$missing[] = $colNm;
			}
		}
		
		if ($missing) {
			throw new GoodsAdminException("필수 입력 항목 누락 - ".implode(",", $missing));
		}
		
		/**
			판매가, 소비자가 데이터 형식(숫자) 체크 
			숫자가 아니면 0
		*/
		if (!is_numeric($this->params['salePrice'])) $this->params['salePrice'] = 0;
		if (!is_numeric($this->params['consumerPrice'])) $this->params['consumerPrice'] = 0;
		
		return $this;
	}
	
	/**
	* 상품 등록 
	*
	* @return Integer|Boolean 등록 성공 - 상품번호 반환(goodsNo), 실패 - false
	*/
	public function register()
	{
		$inData = $this->getCommonColumns($this->params);
	}
	
	/**
	* 상품 등록, 수정 공통 컬럼 
	*
	* @param Array $params 
	* @return Array
	*/
	public function getCommonColumns($params)
	{
		$columns = [
			'goodsNm' => isset($params['goodsNm'])?$params['goodsNm']:"",
			'shortDescription' => isset($params['shortDescription'])?$params['shortDescription']:"",
			'salePrice' => isset($params['salePrice'])?$params['salePrice']:0,
			'consumerPrice' => isset($params['consumerPrice'])?$params['consumerPrice']:0,
			'description' => isset($params['description'])?$params['description']:"",
		];
	}
}