<?php


use Monolog\Handler\StreamHandler;

$instances = []; // 생성된 인스턴스 

/**
* 사이트 공통 클래스
*
*/
class App
{
	/** 
	* 로그 기록 
	*
	* @param String $message 기록 내용 
	* @mode String 처리모드 (info, warning, error, notice, critical)
	*/
	public static function log($message, $mode = 'info')
	{
		$mode = $mode?$mode:"info";
		$mode = strtolower($mode);

		$logPath = __DIR__ . "/../log/".date("Ymd").".log";
		$log = self::load(\Monolog\Logger::class, 'general');
		$streamHandler = self::load(\Monolog\Handler\StreamHandler::class, $logPath, \Monolog\Logger::DEBUG);
		$log->pushHandler($streamHandler);

		switch ($mode) {
			case "warning" : 
				$log->warning($message);
				break;
			case "notice" : 
				$log->notice($message);
				break;
			case "error" :
				$log->error($message);
				break;
			case "critical" : 
				$log->critical($message);
				break;
			default : // info 
				$log->info($message);
		}
	}

	/**
	* 인스턴스 생성 
	*
	* @param String $nsp - 클래스명을 포함한 네임스페이스
	* @param Array $args - 생성자 인수 
	*
	* @return Object 생성된 인스턴스
	*/
	public static function load($nsp, ...$args)
	{
		// 객체가 이미 생성되지 않은 경우만 생성
		$GLOBALS['instances'][$nsp] = $GLOBALS['instances'][$nsp] ?? "";
		if (!$GLOBALS['instances'][$nsp]) {
			$args = $args ?? [];
			$class = new ReflectionClass($nsp);
			$GLOBALS['instances'][$nsp] = $class->newInstanceArgs($args);
		}

		return $GLOBALS['instances'][$nsp];
	}
	
	/**
	* REQUEST URI -> 매칭되는 컨트롤러 호출
	*
	* URI 정제 -> 정규표현식 -> preg_match 
	* array_unshift / array_push 
	*/
	public static function routes()
	{
		// 프론트 메인 Controller 기본값
		$nsp = "\\Controller\\Front\\Main\\IndexController";
		
		$uri = $_SERVER['REQUEST_URI'];
		$pattern = "/\/([^\?~]+)/";
		if (preg_match($pattern, $uri, $matches)) {
			$config = getConfig();
			if (!preg_match("/\/$/", $matches[0])) {
				$matches[0] .= "/";
			}

			$path = explode("/", $matches[1]);
			if ($config['mainurl'] && $config['mainurl'] != '/') {
				$matches[0] = str_replace($config['mainurl'], "", $matches[0]);
				$path = explode("/", $matches[0]);
			}
			
			foreach ($path as $k => $v) {
				if (!$v) {
					unset($path[$k]);
				}
			}	
			$path = array_reverse(array_values($path));
			
			// 메인페이지 
			if (empty($path[0])) {
				$path = ["index", "main"];
			}
				
			if (count($path) == 1) {
				if ($path[0] == 'admin') { // 어드민 메인 
					array_unshift($path, "index", "main");
				} else { // 프론트 각 폴더별 메인 
					array_unshift($path, 'index');
				}
			// 예) /admin/goods 
			} else if (count($path) == 2 && strtolower($path[1]) == 'admin') {
				array_unshift($path, "index");
			}
					
			$folder = ucfirst($path[1]);
			$file = ucfirst($path[0]);
			
			$type = "Front";
			if (count($path) > 2 && strtolower($path[2]) == 'admin') {
				$type = "Admin";
			}

			$nsp = "\\Controller\\{$type}\\{$folder}\\{$file}Controller";
		} 
		
		/**
		* 없는 페이지 체크 - class_exists 
		*  클래스가 존재 X -> 없는 페이지 -> 없는 페이지 안내로 이동 
		* Response 헤더 -> Location -> 페이지 이동
		*/
		if (!class_exists($nsp)) {
			// 없는 페이지 
			$_SESSION['errorURL'] = $_SERVER['REQUEST_URI'];
			$errorUrl = siteUrl("error/e404");
			header("Location: {$errorUrl}");
			exit;
		}
		
		$controller = self::load($nsp);

		$controller->header();
		$controller->index();
		$controller->footer();
	}
	
	/**
	* 뷰 출력 
	*
	* @param String $skinPath 출력할 뷰 파일 경로 
	* @param String $data 뷰에 넘길 데이터 
	*/
	public static function render($skinPath, $data = [])
	{
		if (!$skinPath)
			return;
		
		/*
		* extract 
		*  배열을 분해 -> 키이름을 변수명 분해
		* ["test1" => 1, "test2" => 2]  -> $test1 = 1, $test2 = 2
		*/
		if ($data && is_array($data)) extract($data);

		// URL에 따라서 Admin, Front, Mobile인지를 구분 
		$viewType = self::viewType();
		$path = __DIR__ . "/../Views/{$viewType}/{$skinPath}.php";
		ob_start();
		include $path;
		$content = ob_get_clean();

		echo $content;
	}
	
	/**
	* Admin, Front, Mobile 구분
	*
	* 1. Admin, Front 구분 
			- URI에 /admin이 포함되어 있는 경우 - Admin 아니면 Front 

	* @return String Admin, Front, Mobile
	*/
	public static function viewType()
	{
		$type = "Front";
		$uri = $_SERVER['REQUEST_URI'];
		$pattern = "/\/([^\?~]+)/";
		if (preg_match($pattern, $uri, $matches)) {
			$path = array_reverse(explode("/", $matches[1]));
			if (count($path) > 2 && strtolower($path[2]) == 'admin') {
				$type = "Admin";
			}
		}

		return $type;
	}
	
	/**
	* 초기 boot시 Component, Controller 추가될 될 파일 목록 
	*
	* @param Array 조회할 디렉토리
	* @return Array
	*/
	public static function includeFiles($dirs = [])
	{
		$list = [];
		$list[] = __DIR__ . "/../Controller/Controller.php";
		
		if (!$dirs) return $list;
		foreach ($dirs as $dir) {
			$path = $dir."/*";
			$flist = glob($path);
			if (!$flist) break;
			foreach ($flist as $f) {
				$pi = pathinfo($f);
				// PHP 파일이면 추가 목록(list)에 추가 
				if (isset($pi['extension']) && strtolower($pi['extension']) == 'php') {
					$list[] = $f;
				} elseif (is_dir($f)) { // 디렉토리면 재귀적으로 순회
					$_list = self::includeFiles([$f]);
					if ($_list) {
						$list = array_merge($list, $_list);
					}
				}
			}
		}
		
		$list = array_unique($list);
		return $list;
	}
}