<?php 
/**
* 최 상위 Controller 
*
*/
abstract class Controller
{
	// 헤더 
	abstract public function header();
	// 본문
	abstract public function index();
	// footer
	abstract public function footer();
}