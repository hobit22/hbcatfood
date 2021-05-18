<?php

namespace Controller\Admin;

use App;

/**
* 관리자 페이지 메인 Controller 
*
*/
class Controller extends \Controller 
{
	protected $outlinePath = __DIR__ . "/../../Views/Admin/Outline";
	protected $headerPath = "";
	protected $footerPath = "";
	protected $layoutBlank = false;
	
	protected $css = []; // 추가 CSS
	protected $script = []; // 추가 Script 
	
	protected $mainCode = "";
	
	public function __construct()
	{
		// 관리자 페이지 접근 제한 처리
		$memberAdmin = App::load(\Component\Member\MemberAdmin::class);
		$memberAdmin->accessCheck();
	}
	
	// Admin header
	public function header()
	{
		if ($this->layoutBlank)  // 헤더 출력  X
			return;

		$commonHeader = $this->outlinePath . "/Header/main.php";
		$headerPath = $this->headerPath?$this->headerPath:$commonHeader;
		
		// 파일이 없으면 추가 X
		if (!file_exists($headerPath))
			return;
		
		ob_start();
		include $headerPath;
		$content = ob_get_clean();
		// [[addCss]], [[addScript]]
		/** CSS, JS 추가 처리 S  */
		$addCss = $addScript = "";
		if ($this->css) {
			foreach ($this->css as $css) {
				$addCss .= "<link rel='stylesheet' type='text/css' href='".siteUrl("assets/admin/css/{$css}.css")."?t=".time()."'>".PHP_EOL;
			}
		}
		
		if ($this->script) {
			foreach ($this->script as $script) {
				$addScript .= "<script src='".siteUrl("assets/admin/js/{$script}.js")."?t=".time()."'></script>".PHP_EOL;
			}
		}
		
		$content = str_replace("[[addCss]]", $addCss, $content);
		$content = str_replace("[[addScript]]", $addScript, $content);
		/** CSS, JS 추가 처리 E */
		
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
		
		// 파일이 없으면 추가 X
		if (!file_exists($footerPath))
			return;
		
		ob_start();
		include $footerPath;
		$content = ob_get_clean();
		echo $content;
	}
	
	/** 메인 메뉴 */
	public function mainMenu()
	{
		if ($this->layoutBlank) return;
		
		// 팝업인 경우는 미출력
		if (strpos($this->headerPath, "popup") !== false) return;
		
		$menu = $this->mainCode?$this->mainCode:"";
		App::render("Menus/main", ["menu" => $menu]);
	}
}
