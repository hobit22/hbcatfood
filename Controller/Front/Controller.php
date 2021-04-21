<?php

namespace Controller\Front;

/**
* Front 페이지 메인 Controller 
*
*/
class Controller extends \Controller 
{	
	// front header
	public function header()
	{
		echo "헤더";
	}
	// front 메인 
	public function index()
	{

	}
	// front footer
	public function footer()
	{
		echo "footer";
	}
}