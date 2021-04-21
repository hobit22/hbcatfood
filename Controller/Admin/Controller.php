<?php

namespace Controller\Admin;

/**
* 관리자 페이지 메인 Controller 
*
*/
class Controller extends \Controller 
{
	private $outlinePath = __DIR__ . "/../../Views/Admin/Outline";
	private $headerPath = "";
	private $footerPath = "";
	protected $layoutBlank = false;


	// Admin header
	public function header()
	{
		if ($this->layoutBlank)  // 헤더 출력  X
			return;

		$commonHeader = $this->outlinePath . "/Header/main.php";
		$headerPath = $this->headerPath?$this->headerPath:$commonHeader;
		ob_start();
		include $headerPath;
		$content = ob_get_clean();
		echo $content;
	}
	// Admin 메인 
	public function index()
	{

	}
	// Admin footer
	public function footer()
	{
		if ($this->layoutBlank) // footer 출력 X 
			return;

		$commonFooter = $this->outlinePath . "/Footer/main.php";
		$footerPath = $this->footerPath?$this->footerPath:$commonFooter;
		ob_start();
		include $footerPath;
		$content = ob_get_clean();
		echo $content;
	}
}
