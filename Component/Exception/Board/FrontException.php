<?php

namespace Component\Exception\Board;

use App;

/**
* 게시판 Front에서 발생하는 Exception 
*
*/
class BoardFrontException extends \Component\Exception\AlertException
{
	public function __construct($message, $action = 0, $target = 'self')
	{
		parent::__construct($message, $action, $target);
		
		App::log(__CLASS__ . " : {$message}", "error");
	}
}