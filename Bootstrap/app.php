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
	*/
	public static function routes()
	{
		$uri = $_SERVER['REQUEST_URI'];
		$pattern = "/\/([^\?~]+)/";
		if (preg_match($pattern, $uri, $matches)) {
			$path = array_reverse(explode("/", $matches[1]));
			
			$folder = ucfirst($path[1]);
			$file = ucfirst($path[0]);

			$type = "Front";
			if (count($path) > 2 && strtolower($path[2]) == 'admin') {
				$type = "Admin";
			}

			$nsp = "\\Controller\\{$type}\\{$folder}\\{$file}Controller";
			$controller = self::load($nsp);

			$controller->header();
			$controller->index();
			$controller->footer();
		} 
	}
	
	/**
	* 뷰 출력 
	*
	* @param String $skinPath 출력할 뷰 파일 경로 
	* @param String $data 뷰에 넘길 데이터 
	*/
	public static function render($skinPath, $data = [])
	{
		echo $skinPath;
		if (!$skinPath)
			return;
		
	}
}