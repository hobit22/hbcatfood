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

	/**
	* header 출력 뷰 변경시 
	*
	* @return $this
	*/
	public function setHeader($headerPath = null)
	{
		if ($headerPath) {
			$headerPath = $this->outlinePath . "/Header/".$headerPath.".php";
		}

		$this->headerPath = $headerPath;

		return $this;
	}
	
	/**
	* footer 출력 뷰 변경시
	*
	* @return $this
	*/
	public function setFooter($footerPath = null)
	{
		if ($footerPath) {
			$footerPath = $this->outlinePath . "/Footer/".$footerPath.".php";
		}

		$this->footerPath = $footerPath;

		return $this;
	}
}