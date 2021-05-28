<?php

namespace Component\Order;

use App;
use Component\Exception\OrderException;

/**
* 주문관련 Component
*
*/
class Order
{
	private $params = []; // 처리할 데이터 
	
	/**
	* 처리할 데이터 설정
	*
	* @return $this
	*/
	public function data($params = [])
	{
		$this->params = $params;
		
		return $this;
	}
	
	/**
	* 주문서 유효성 검사 
	*
	* @return $this
	* @throw OrderException
	*/
	public function validator()
	{
		$required = [
			'nameOrder' => '주문자명을 입력하세요',
			'cellPhoneOrder' => '주문자 휴대전화번호를 입력하세요.',
			'emailOrder' => '주문자 이메일을 입력하세요.',
			'receiverName' => '받는분 이름을 입력하세요.',
			'receiverCellphone' => '받는분 휴대전화번호를 입력하세요.',
			'zipcode' => '받는분 주소를 입력하세요',
			'receiverAddress' => '받는분 주소를 입력하세요.',
			'receiverAddressSub' => '받는분 나머지 주소를 입력하세요.',
		];
		
		if (!isset($this->params)) {
			throw new OrderException("처리할 데이터가 없습니다.");
		}
		
		foreach ($required as $k => $msg) {
			if (!isset($this->params[$k]) || !$this->params[$k]) {
				throw new OrderException($msg);
			}
		}
		
		return $this;
	}
	
	/**
	* 주문서 등록 처리 
	*
	* @return Integer|Boolean 성공시 주문번호(orderNo), 실패시는 false 반환
	*/
	public function register()
	{
		$cart = App::load(\Component\Order\Cart::class);
		$data = $this->params;

		$goodsList = $cart->getGoods($data['isDirect'], $data['cartNo']);
		if (!$goodsList) return false; // 상품 데이터가 있는 경우만 처리 
		
		/**
		 주문테이블 -> 추가 -> orderNo 
		 -> 주문상품을 저장
		*/
		
		try {
			db()->beginTransaction();
			// 주문 데이터(주문자정보, 배송지 정보)
			$inData = [
				'memNo' => isLogin()?$_SESSION['memNo']:0,
				'nameOrder' => $this->params['nameOrder'],
				'cellPhoneOrder' => $this->params['cellPhoneOrder'],
				'emailOrder' => $this->params['emailOrder'],
				'receiverName' => $this->params['receiverName'],
				'receiverCellphone' => $this->params['receiverCellphone'],
				'zipcode' => $this->params['zipcode'],
				'receiverAddress' => $this->params['receiverAddress'],
				'receiverAddressSub' => $this->params['receiverAddressSub'],
				'settleKind' => $this->params['settleKind'],
				'bankAccount' => $this->params['bankAccount'],
				'bankDepositor' => $this->params['bankDepositor'],	
			];
			$orderNo = db()->table("order")->data($inData)->insert();
			if ($orderNo) { // 상품 데이터 추가 
				foreach ($goodsList['list'] as $li) {
					if ($li['optName'] && $li['optItem']) {
						$opts = $li['optName'] . ":" . $li['optItem'];
					}
					$inData = [
						'orderNo' => $orderNo,
						'goodsNo' => $li['goodsNo'],
						'optNo' => $li['optNo'],
						'goodsCnt' => $li['goodsCnt'],
						'goodsNm' => $li['goodsNm'],
						'opts' => $opts,
						'salePrice' => $li['salePrice'],
						'addPrice' => $li['addPrice'],
						'totalGoodsPrice' => $li['totalGoodsPrice'],
						'deliveryNo' => $li['deliveryNo'],
					];
					
					db()->table("orderGoods")->data($inData)->insert();
				} // endforeach 
			} // endif 
			
			return $orderNo;
			
			db()->commit();
		} catch (\PDOException $e) {
			db()->rollback();
			return false;
		}
	}
}