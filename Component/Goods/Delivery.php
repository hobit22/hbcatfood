<?php

namespace Component\Goods;

use App;
use Component\Exception\GoodsAdminException;

/**
* 배송관련 Component
*
*/
class Delivery
{
	private $params = []; // 처리 데이터 
	
	/**
	* 처리 데이터 설정 
	*
	* @param Array $param - 처리할 데이터 
	* @return $this
	*/
	public function data($params) 
	{
		$this->params = $params;
		
		return $this;
	}
	
	/**
	* 등록/수정 유효성 검사 
	*
	* @param String $mode 등록(register), 수정(update)
	* @return $this
	*/
	public function validator($mode = "register")
	{
		if (!$this->params) {
			throw new GoodsAdminException("유효성 검사를 처리할 데이터가 없습니다.");
		}
		
		switch($mode) {
			/** 설정 등록 */
			case "register" :
				if (!$this->params['deliveryName']) {
					throw new GoodsAdminException("설정이름을 입력해 주세요.");
				}
				break;
			/** 설정 수정 */
			case "update" : 
			
				break;
		}
		
		return $this;
	}
	
	/**
	* 설정 등록 
	*
	* @return Integer|Boolean 성공시 배송비설정번호(deliveryNo), 실패 false
	*/
	public function register()
	{
		$this->params['isDefault'] = isset($this->params['isDefault'])?$this->params['isDefault']:0;
		$inData = [
			'deliveryName' => $this->params['deliveryName'],
			'deliveryPrice' => $this->params['deliveryPrice']?$this->params['deliveryPrice']:0,
			'isTogether' => $this->params['isTogether']?1:0,
			'isDefault' => $this->params['isDefault']?1:0,
		];
		
		$result = db()->table("delivery")->data($inData)->insert();
		
		return $result;
	}
	
	/**
	* 배송비 설정 목록 
	*
	* @return Array
	*/
	public function getList()
	{
		$list = db()->table("delivery")->orderBy([["regDt", "desc"]])->rows();
		
		return $list;
	}
}