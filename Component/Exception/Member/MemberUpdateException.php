<?php

namespace Component\Exception\Member;

use App;

/**
* 회원정보 수정 Exception 
*
*/
class MemberUpdateException extends \Component\Exception\AlertException
{
	public function __construct($message, $action = 0, $target = 'self')
	{
		parent::__construct($message, $action, $target);
		
		App::log(__CLASS__ . " : {$message}", "error");
	}
}