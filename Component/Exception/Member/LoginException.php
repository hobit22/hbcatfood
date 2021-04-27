<?php

namespace Component\Exception\Member;

use App;

/**
* 로그인 Exception 
*
*/
class LoginException extends \Component\Exception\AlertException
{
	public function __construct($message, $action = 0, $target = 'self')
	{
		parent::__construct($message, $action, $target);
		
		App::log(__CLASS__ . " : {$message}", "error");
	}
}