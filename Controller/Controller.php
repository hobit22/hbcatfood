<?php 
/**
* 최상위 Controller 
*
*/
abstract class Controller
{
	abstract public function header();
	abstract public function index();
	abstract public function footer();
}