<?php

namespace Controller\Admin\Goods;

use App;

/**
* 상품관리 DB 처리 
*
*/
class IndbController extends \Controller\Admin\Controller
{
	public function __construct()
	{
		parent::__construct();
		
		$this->layoutBlank = true;
	}
	
	public function index()
	{
		
	}
}