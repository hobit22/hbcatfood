<?php 
/**
* 최상위 Controller 
*
*/
abstract class Controller
{
	/** 공통 속성 */
	protected $outlinePath = __DIR__ . "/../../Views/Front/Outline";
	protected $headerPath = "";
	protected $footerPath = "";
	protected $layoutBlank = false;
	
	protected $css = []; // 추가 CSS
	protected $script = []; // 추가 Script 
	
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
	
	/**
	* CSS 추가 
	*
	* @param Array $css 
	* @return $this
	*/
	public function addCss($css = [])
	{
		$this->css = $css;
		return $this;
	}
	
	/**
	* Javascript 추가 
	*
	* @param Array $script 
	* @return $this
	*/
	public function addScript($script = [])
	{
		$this->script = $script;
		return $this;
	}
}