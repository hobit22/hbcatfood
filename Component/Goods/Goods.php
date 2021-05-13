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
		
		if ($mode == 'update') { // 상품 정보 수정 
			$this->requiredColumns['goodsNo'] = '상품번호';
		}
		
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
		
		$goodsNo = db()->table("goods")->data($inData)->insert();
		
		return $goodsNo;
	}
	
	/**
	* 상품 수정 
	*
	* @return Boolean 
	*/
	public function update()
	{
		$upData = $this->getCommonColumns($this->params);
		$upData['modDt'] = date("Y-m-d H:i:s");
		
		$result = db()->table("goods")
						  ->data($upData)
						  ->where(["goodsNo" => $this->params['goodsNo']])
						  ->update();
						  
		return $result !== false;
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
			'gid' => isset($params['gid'])?$params['gid']:gid(),
			'goodsNm' => isset($params['goodsNm'])?$params['goodsNm']:"",
			'shortDescription' => isset($params['shortDescription'])?$params['shortDescription']:"",
			'salePrice' => isset($params['salePrice'])?$params['salePrice']:0,
			'consumerPrice' => isset($params['consumerPrice'])?$params['consumerPrice']:0,
			'description' => isset($params['description'])?$params['description']:"",
			'totalStock' => isset($params['totalStock'])?$params['totalStock']:0,
			'stockOut' => isset($params['stockOut'])?$params['stockOut']:0,
			'isDisplay' => isset($params['isDisplay'])?$params['isDisplay']:1,
		];
		
		return $columns;
	}
	
	/**
	* 상품 정보 조회 
	*
	* @param Integer $goodsNo 상품 등록번호 '
	* @return Array
	*/
	public function get($goodsNo)
	{
		$data = db()->table("goods")
						->where(["goodsNo" => $goodsNo])
						->row();
		
		if ($data) {
			$file = App::load(\Component\File::class);
			$description = $file->getGroupFiles($data['gid'], 'description');
			$main = $file->getGroupFiles($data['gid'], 'main');
			$list = $file->getGroupFiles($data['gid'], 'list');
		
			
			$data['images'] = [
				'description' => isset($description['images'])?$description['images']:[],
				'main' => isset($main['images'])?$main['images']:[],
				'list' => isset($list['images'])?$list['images']:[],
			];
		}

		return $data;
	}
	
	/**
	* 상품 목록 
	*
	* @param Integer $page 페이지번호
	* @param Integer $limit - 1페이지당 출력 레코드 수 
	* @parma String $qs 페이지 링크 추가용 검색 쿼리 스트링
	*
	* @return Array
	*					list - 상품목록
	*					pagination - 페이지번호
	*					total - 전체 레코드 수 
	*					offset - 현재 레코드 시작점 
	*/
	public function getList($page = 1, $limit = 20, $qs = "")
	{
		$page = $page?$page:1;
		$offset = ($page - 1) * $limit;
		
		// 총 레코드 갯수 
		$total = db()->table("goods")->count();
		
		$list = db()->table("goods")
					  ->orderBy([["regDt", "desc"]])
					  ->limit($limit, $offset)
					  ->rows();
		
		foreach ($list as $k => $li) {
			// 상품 이미지 
			$li['images'] = $this->getImages($li['goodsNo']);
			
			$list[$k] = $li;
		}
		
		$paginator = App::load(\Component\Pagination::class, $page, $limit, $total, $qs);
		
		$pagination = $paginator->getPages();
		
		$data = [
			'list' => $list,
			'pagination' => $pagination,
			'total' => $total,
			'offset' => $offset,
		];
		
		return $data;
	}
	
	/**
	* 상품 삭제 
	*
	* @param Integer $goodsNo 상품 번호 
	* @return Boolean 
	*/
	public function delete($goodsNo)
	{
		/**
			1. 상품 데이터 가져온 후 - O 
			2. 업로드된 이미지 파일 삭제(gid) - O 
			3. 상품 데이터를 데이터베이스에서 삭제 - O
		*/
		
		$data = $this->get($goodsNo);
		if (!$data) return false; // 상품이 존재 X -> false
		
		// 파일 삭제 gid 
		$file = App::load(\Component\File::class);
		$file->deleteByGid($data['gid']);
		
		$result = db()->table("goods")->where(["goodsNo" => $goodsNo])->delete();
		
		return $result;
	}
	
	/**
	* 상품 이미지 추출 
	* 
	* @param Integer|String $goodsNo
	*					숫자 -> 상품번호(goodsNo)
	*					문자 -> 그룹 ID(gid)
	* @return Array
	*/
	public function getImages($goodsNo)
	{
		if (is_numeric($goodsNo)) { // 숫자이면 상품번호
			// gid -> 
			$row = db()->table("goods")
						   ->select("gid")
						   ->where(['goodsNo' => $goodsNo])
						   ->row();
			
			if (!$row) return [];
			$gid = $row['gid'];
			
		} else { // goodsNo가 gid인 경우 
			$gid = $goodsNo;
		}
		
		
	}
}