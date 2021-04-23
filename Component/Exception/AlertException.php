<?php

namespace Component\Exception;

use App;

/**
* 알림 메세지 전용 Exception 
*
*/
class AlertException extends \Exception
{	
	private $action = 0;
	private $target = 'self';
	
	/**
	* action 값이 숫자 -> history.go
	* action 값이 문자 -> URL 이동
	* target - 이동할 창 - self, parent 
	*/
	public function __construct($message, $action = 0, $target = 'self')
	{
		parent::__construct($message);
		
		$this->action = $action;
		$this->target = $target;
		
		App::log(__CLASS__ . " : {$message}", "error");
	}
	
	public function __toString()
	{
		// is_numeric  -> 숫자인지 아닌지 체크 
		$html = "<script>alert('".$this->getMessage()."');</script>";
		if ($this->action) {
			if (is_numeric($this->action)) { // 숫자 이면 history.go
				$html .= "<script>" . $this->target . ".history.go(".$this->action.");</script>";
			} else { // location.href
				$html .= "<script>" . $this->target . ".location.href='".$this->action."';</script>";
			}
		}
		return $html;
	}
}