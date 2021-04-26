<?php

namespace Component;

/**
* Pagination 
*
* @author Lee, Yonggyo
* @date  2021.04.06
* @version 0.0.1
*/

class Pagination 
{
	private $page;
	private $limit;
	private $total;
	private $pageLinks = 5; // 페이지 갯수(기본 10개씩)
	private $startNo;
	private $lastNo;
	private $lastPage;
	private $prevNo = 0; // 이전페이지 시작 번호 
	private $nextNo = 0; // 다음페이지 시작 번호 
	private $url;  // 페이징 기본 url 
	private $num; // 페이지 번호 생성 기준번호
	
	/**
	* Pagination 생성자 
	* 
	* @param Integer $page 현재 페이지번호 
	* @param Integer $limit 1페이지에 출력하는 레코드 수 
	* @param Integer $total 전체 레코드 수 
	*
	*/
	public function __construct($page = 1, $limit = 20, $total = 0, $url = null) 
	{
		$this->page = $page = $page?$page:1;
		$this->limit = $limit?$limit:20;
		$this->total = $total;
		
		$this->lastPage = ceil($this->total / $this->limit); // 레코드 기준 마지막 페이지 
			
		/**
		* 현재 page가 마지막 페이지보다 크다면 
		* 마지막 페이지 - 1을 한 페이지로 교체
		*/
		if ($page > $this->lastPage) {
			$page = $this->lastPage;
		}
		
		$this->num = $num = floor(($page - 1) / $this->pageLinks); // 페이지 생성 기준번호
		$this->startNo = $this->pageLinks * $num + 1; // 현재 page 기준의 시작 번호
		$this->lastNo = $this->startNo + $this->pageLinks  - 1; // 현재 page 기준의 마지막 번호 	
		
		// 현재 page 기준 마지막 번호가 마지막 페이지 번호보다 크다면 
		if ($this->lastNo > $this->lastPage) {
			$this->lastNo = $this->lastPage;
		}
		
		/*
		* 이전 페이지 시작 번호
		* 
		* 첫 페이지 구간(1~ pageLinks 번호 까지)이 아닌 경우는 이전 페이지 번호 생성 
		* 첫페이지라면 가장 첫 페이지 번호로 
		*/
		if ($num > 0) {
			$this->prevNo = $this->pageLinks * ($num - 1) + 1;
		}
		
		/*
		* 다음 페이지 시작 번호
		* 
		* 마지막 페이지 구간이 아니라면 다음 페이지 번호 생성 
		*/
		$lastNum = floor(($this->lastPage - 1) / $this->pageLinks);
		if ($num < $lastNum) {
			$this->nextNo = $this->pageLinks * ($num + 1) + 1;
		}
		
		/**
		* 페이징 URL 처리 
		*
		* ?가 없다면 끝에 ?를 추가해 주고 ?가 있다면 끝에 &를 추가해 준다
		* 그런 다음 하기 getPages()에서 page를 추가하여 쿼리스트링에서 정상 인식되도록 
		* 처리 
		*/
		if ($url) {
			if (strpos($url, '?')) {
				$url .= "&";
			} else {
				$url .= "?";
			}
		} else {
			$url = "?";
		}
		
		$this->url = $url;
	}
	
	/**
	* 페이지 갯수 설정
	* 
	* 설정 후 연달아 페이징 HTML을 호출하기 위해 메서드 체이닝 방식 사용 
	* 
	* @param Integer $no 페이지 갯수
	* @return $this;
	*/
	public function setPageLinks($no = 5)
	{
		$no = $no?$no:5;
		
		$this->pageLinks = $no;
		
		return $this;
	}
	
	/**
	* Pagination HTML 생성 
	*
	* @return String 페이징 HTML 
	*/
	public function getPages()
	{
		$html = "<ul class='pagination'>";
		
		// 처음 페이지
		if ($this->num > 0) {
			$html .= "<li class='page first'><a href='{$this->url}page=1'>First</a></li>";
		}
		
		// 이전 페이지 
		if ($this->prevNo > 0) {
			$prevUrl = $this->url . "page=".$this->prevNo;
			$html .= "<li class='page prev'><a href='{$prevUrl}'>Prev</a></li>";
		}
		
		for ($i = $this->startNo; $i <= $this->lastNo; $i++) {
			$url = $this->url . "page={$i}";
			
			$addClass = ($i == $this->page)?" on":"";
			
			$html .= "<li class='page{$addClass}'><a href='{$url}'>{$i}</a></li>";
		}
		
		// 다음페이지 
		if ($this->nextNo > 0) {
			$nextUrl = $this->url . "page=".$this->nextNo;
			$html .= "<li class='page next'><a href='{$nextUrl}'>Next</a></li>";
		}
		
		// 마지막 페이지
		if ($this->page < $this->lastPage) {
			$html .= "<li class='page last'><a href='{$this->url}page={$this->lastPage}'>Last</a></li>";
		}
		$html .= "</ul>";
		
		return $html;
	}
}
