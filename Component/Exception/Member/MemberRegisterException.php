<?php

namespace Component\Exception\Member;

use App;

/**
* 회원가입 Exception 
*
*/
class MemberRegisterException extends \Exception
{
	public function __construct($message)
	{
		parent::__construct($message);
		
		App::log(__CLASS__ . " : {$message}", "error");
	}
}