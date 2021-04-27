<?php

namespace Component\Exception\Board;

use App;

/**
* 게시판 관리 Exception 
*
*/
class BoardAdminException extends \Component\Exception\AlertException
{
	public function __construct($message, $action = 0, $target = 'self')
	{
		parent::__construct($message, $action, $target);
		
		App::log(__CLASS__ . " : {$message}", "error");
	}
}