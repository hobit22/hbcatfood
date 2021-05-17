<?php

namespace Controller\Front;

use App;

/**
* Front 페이지 메인 Controller 
*
*/
class Controller extends \Controller 
{	
	protected $outlinePath = __DIR__ . "/../../Views/Front/Outline";
	protected $headerPath = "";
	protected $footerPath = "";
	protected $layoutBlank = false;

	protected $css = []; // 추가 CSS
	protected $script = []; // 추가 Script 
	
	// front header
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
				$addCss .= "<link rel='stylesheet' type='text/css' href='".siteUrl("assets/front/css/{$css}.css")."?t=".time()."'>".PHP_EOL;
			}
		}
		
		if ($this->script) {
			foreach ($this->script as $script) {
				$addScript .= "<script src='".siteUrl("assets/front/js/{$script}.js")."?t=".time()."'></script>".PHP_EOL;
			}
		}
		
		$content = str_replace("[[addCss]]", $addCss, $content);
		$content = str_replace("[[addScript]]", $addScript, $content);
		/** CSS, JS 추가 처리 E */
		
		echo $content;
	}
	// front 메인 
	public function index()
	{

	}
	// front footer
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
	
	/**
	* 프론트 메인메뉴
	*
	*/
	public function mainMenu()
	{
		if ($this->layoutBlank) return;
		
		// 기본 메뉴  - 상품분류 
		$goods = App::load(\Component\Goods\Goods::class);
		$data = [
			'categories' => $goods->getCategories(),
		];
		
		App::render("Menus/main", $data);
	}
}