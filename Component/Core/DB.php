<?php

namespace Component\Core;

use App;
use PDOStatement;

/**
* 데이터베이스 쿼리 빌더
*
*/
class DB extends \PDO {  
	
	private $whereParams = []; // where 바인딩 데이터 
	private $where = []; // where 조건식 
	private $data = [];
	private $limit = 0; // 0이면 적용 X, 1이상부터 적용
	private $offset = 0; // 레코드 시작점, 없으면 기본값 0 
	private $columns = '*'; // SELECT 구문 실행시 추출 할 컬럼 지정 
	private $orderBy = ""; // ORDER BY 구문 추가 
	
	/**
	* DB 객체가 생성될 때 자동으로 DB 연결 
	*
	*/
	public function __construct() {
		try {
			$config = parse_ini_file(__DIR__ . "/../../../config.ini");
			$dsn = "mysql:host={$config['host']};dbname={$config['dbname']}";
			parent::__construct($dsn, $config['username'], $config['password']);

			App::log("DB 연결 성공");

		} catch (\PDOException $e) {
			App::log($e->getMessage(), 'error');
			exit;
		}
	}
	
	/**
	* 테이블명 설정 
	*
	* @param String $tableName
	* @prams Array $joinTable   JOIN을 할 테이블 목록
	*			[ 테이블명 => ['공통컬럼1', '공통컬럼2', 'inner'], 
				  테이블명 => ['공통컬럼1', '공통컬럼2', 'left'], 
				  테이블명 => ['공통컬럼1', '공통컬럼2', 'right'] ]
	* 			키 - 테이블명
	*			값 - 배열
					0 - JOIN하는 공통 컬럼 
					1 - JOIN 형태(inner - INNER JOIN, left - LEFT JOIN, right - RIGHT JOIN)
	*		
	*
	* @return $this
	*/
	public function table($tableName, $joinTable = []) {

		$config = getConfig();
		
		/* 초기화 S */
		$this->whereParams = $this->where = $this->data = [];
		$this->limit = $this->offset = 0;
		$this->columns = "*";
		$this->orderBy = "";
		/* 초기화 E */

		/**
		* 속성을 따로 정의 하지 않고 값을 대입하면 
		* public 속성으로 자동 생성된다.
		*/
		$this->tableName = $config['prefix'].$tableName;
		
		/** 테이블 JOIN 처리 S */
		if ($joinTable) {
			$tables = [];
			foreach ($joinTable as $tableNm => $args) {
				$joinType = $args[2]?$args[2]:"inner";
				$joinType = strtolower($joinType);
				$table = "";
				switch ($joinType) {
					case "left" :  // LEFT JOIN 
						$table = " LEFT JOIN ";
						break;
					case "right" :  // RIGHT JOIN 
						$table = " RIGHT JOIN ";
						break;
					default : // INNER JOIN 
						$table = " INNER JOIN ";
				}
				$table .= $config['prefix'].$tableNm . " ON " .$args[0] . " = " . $args[1];
				
				$tables[] = $table;
			}
			$this->tableName .= " " .implode(" ", $tables);
		}
		/** 테이블 JOIN 처리 E */
		
		return $this;
	}
	
	/**
	* 추가, 수정 데이터 
	*  ['컬럼' => '값', '컬럼' => '값']
	*  
	* @param Array $data
	* @return $this
	*/
	public function data($data = []) {
		$this->data = $data;
		
		return $this;
	}
	
	/**
	* WHERE 조건 생성 
	*
	* @param Array $params 조건 데이터
	* 	[
			'컬럼' => ['값', '>'],  컬럼 > '값', // 배열
			'컬럼' => '값',  --> 컬럼 = '값' // 문자열
			'컬럼' => ['값', 'LIKE', 'left|right|both'] // LIKE 조건 
					left - %값
					right - 값% 
					both - %값%
		];
	* @param String $opr - AND 또는 OR 조건 조건 
	*
	* @return $this
	*/
	
	public function where($params = [], $opr = 'AND') {
		
		$conds = [];
		if ($params) {
			$no = 0;
			foreach ($params as $k => $v) {
				if (strpos($k, '_same')) {
					$k = explode("_", $k);
					$k = $k[0];
				}
				
				$k2 = str_replace(".", "_", $k);
				
				if (is_array($v)) { // 조건 부분이 배열일때 
					$str = $k . " " .$v[1] ." :where_".$k2."_".$no;
				} else { // 조건 부분이 문자열일때 
					$str = $k." = :where_".$k2."_".$no;
				}
								
				/* LIKE 조건 처리 S */
				if (is_array($v) && $v[1] == 'LIKE') {
					switch ($v[2]) {
						case "left" :
							$v = "%".$v[0];
							break;
						case "right" :
							$v = $v[0]."%";
							break;
						default :  // both 
							$v = "%".$v[0]."%";
					}
				}
				/* LIKE 조건 처리 E */
				
				if (is_array($v)) $v = $v[0];
				$this->whereParams["where_".$k2."_".$no] = $v;
				array_push($conds, $str);
				$no++;
			}
		}
		
		$opr = $opr?$opr:" AND ";
		$where = $conds?implode(" {$opr} ", $conds):"";
		
		if (strtoupper($opr) == 'OR') {
			$where = "(".$where.")";
		}
		
		$this->where[] = $where;
		return $this;
	}
	
	/**
	* IN WHERE 조건 생성 
	*
	* @param Array $params 
	*				[
						'컬럼' => ['값1', '값2', '값3'],  컬럼 IN ('값1', '값2', '값3') 
						'컬럼' => ['값1', '값2', '값3']
					]
	* @return $this;
	*/
	public function inWhere($params = [])   
	{
		foreach ($params as $key => $value) {
			$bindValue = [];
			foreach ($value as $k => $v) {
				$bindValue[] = ":wherein_{$key}_{$k}";
				$this->whereParams["wherein_{$key}_{$k}"] = $v;
			}
			
			$this->where[] = $key  . " IN (".implode(",", $bindValue) . ")";
		}
		
		return $this;
	}
	
	/**
	* BETWEEN Where 조건 생성
	*
	* @param Array $params
	*					[ 컬럼 => [값1, 값2]]  --> 컬럼 BETWEEN 값1 AND 값2
	* @return $this
	*/
	public function btWhere($params = []) 
	{
		foreach ($params as $key => $value) {
			$this->where[] = $key . " BETWEEN :btwhere_{$key}_0 AND :btwhere_{$key}_1";
			$this->whereParams["btwhere_{$key}_0"] = $value[0];
			$this->whereParams["btwhere_{$key}_1"] = $value[1];
		}
		
		return $this;
	}
	
	/**
	* INSERT SQL 생성 및 실행
	*
	* @return Boolean|INTEGER, 실패시 false, 성공시 lastInsertId
	*/
	public function insert() {
		// SQL 생성 S
		$columns = array_keys($this->data);
		$params = [];
		foreach ($columns as $c) {
			$params[] = ":".$c;
		}
		
		$sql = "INSERT INTO " . $this->tableName . " (".implode(",", $columns). ") 
									VALUES (".implode(",", $params).")";
		// SQL 생성 E 
		// SQL 실행 S
		$stmt = $this->_prepare($sql);
		
		// 바인딩 처리 
		$this->procBinds($stmt);
		
		$result = $stmt->execute();
		if ($result) {
			// lastInsertid 
			return $this->lastInsertId();
		}
		
		// 실패시에는 에러 정보를 담아 준다 
		$this->errors = $this->errorInfo();
		// 에러 로그 처리 
		return $result; // 실패 false
		// SQL 실행 E 
	}
	
	/**
	* UPDATE SQL 생성 및 실행 
	*
	* @return Integer|Boolean 성공시 반영된 레코드 수, 실패시 false
	*/
	public function update() {
		/* SQL 생성 S */
		$setData = [];
		foreach ($this->data as $k => $v) {
			$setData[] = $k." = :".$k;
		}
	
		$sql = "UPDATE " . $this->tableName . " SET " . implode(", ", $setData);
		
		/* 조건식 */
		$this->addWhere($sql);

		/* SQL 생성 E */
		
		/* SQL 실행 S */
		$stmt = $this->_prepare($sql);
				
		/* 바인딩 처리 */
		$this->procBinds($stmt);
		$result = $stmt->execute();
		if ($result) { // 성공시에는 반영된 레코드 수를 반환 
			return $stmt->rowCount();
		}
		
		$this->errors = $this->errorInfo();
		return $result; // 실패시에는 false 
		
		/* SQL 실행 E */
		
	}
	
	/**
	* DELETE SQL 생성 및 실행 
	*
	* @return Integer|Boolean 성공시 반영된 레코드 수, 실패시 false
	*/
	public function delete() {
		$sql = "DELETE FROM " . $this->tableName;
		// where 조건 추가 
		$this->addWhere($sql);
		$stmt = $this->_prepare($sql);

		// 바인딩 처리 
		$this->procBinds($stmt);
		$result = $stmt->execute();
		
		if ($result) {
			return $stmt->rowCount();
		}
		
		$this->errors = $this->errorInfo();
		return $result; // SQL 실행 실패시 false
	}
	
	/**
	* SELECT SQL 생성 및 실행 
	*
	* @return Array 전체 레코드 
	*/
	public function rows() {
		$list = [];
		$sql = "SELECT ". $this->columns . " FROM " . $this->tableName;
		// Where 조건 추가 
		$this->addWhere($sql);
		
		if ($this->orderBy) {
			$sql .= " ORDER BY " .$this->orderBy;
		}
		
		if ($this->limit > 0) {
			$sql .= " LIMIT :offset, :limit";
			$this->whereParams['offset'] = $this->offset?$this->offset:0;
			$this->whereParams["limit"] = $this->limit;
		}

		$stmt = $this->_prepare($sql);
		
		// 바인딩 처리 
		$this->procBinds($stmt);
		$result = $stmt->execute();
		if ($result) {
			while ($row = $stmt->fetch(\PDO::FETCH_ASSOC)) {
				$list[] = $row;
			}
		}
		
		return $list;
	}
	
	public function row() {
		$this->limit = 1;
		$rows = $this->rows();
		$row = isset($rows[0])?$rows[0]:[];
		
		return $row;
	}
	
	/**
	* 레코드 수 반환
	*
	* @return Integer
	*/
	public function count() {	
		$row = $this->select("COUNT(*) as cnt")->row();
		$this->whereParams = [];
		
		return $row['cnt'];
	}
	
	/**
	* SELECT 구문에서 추출할 컬럼 지정 
	*
	* @param String $columns - 기본값은 *, idx,name
	* @return $this;
	*/
	public function select($columns = "*")
	{
		$this->columns = $columns?$columns:"*";
		
		return $this;
	}
	
	/**
	* ORDER BY 구문 생성 
	*
	* @param Array $params - [ // 1차 
											[컬럼, 정렬방식ASC|DESC], 
											[컬럼, 정렬방식ASC|DESC]
										]
	* @return $this
	*/
	public function orderBy($params = []) 
	{
		if ($params) {
			$orderby = [];
			foreach ($params as $v) {
				$type = (strtoupper($v[1]) == 'DESC')?"DESC":"ASC";
				$orderBy[] = $v[0] . " " .$type;
			}
			$this->orderBy = implode(", ", $orderBy);
		}
		
		return $this;
	}
	
	/**
	* LIMIT 구문 생성
	*
	* @param Integer $limit 레코드 수
	* @param Integer $offset 레코드 시작점
	*
	* @return $this
	*/
	public function limit($limit = 0, $offset = 0) 
	{
		$this->limit = $limit;
		$this->offset = $offset;
		
		return $this;
	}
	
	/**
	* WHERE 구문 추가 
	*
	* @param String &$sql 
	*/
	public function addWhere(&$sql) {
		if ($this->where) {
			$sql .= " WHERE " . implode(" AND ", $this->where);
		}
	}
	
	/**
	* bindValue로 바인딩할 데이터 
	* 
	* @return Array
	*/
	public function getBinds() {
		$binds = [];
		if ($this->data) $binds = array_merge($binds, $this->data);
		if ($this->whereParams) $binds = array_merge($binds, $this->whereParams);

		return $binds;
	}
	
	/**
	* 바인딩 데이터를 bindValue로 처리 
	*
	* @param PDOStatement &$stmt  
	*/
	public function procBinds(PDOStatement &$stmt) {
		$binds = $this->getBinds();

		$logs = [];
		foreach ($binds as $k => $v) {
			$type = is_numeric($v)?\PDO::PARAM_INT:\PDO::PARAM_STR;
			$stmt->bindValue(":{$k}", $v, $type);
			$logs[] = "{$k} : {$v}";
		}
		
		if ($logs) {
			$logs = "SQL BINDS - " . implode(",", $logs);
			App::log($logs);
		}
	}
	
	/**
	* 쿼리빌더외에 기타 SQL 실행 
	*
	* @param String $sql - SQL 구문
	* @param Array $binds - 바인딩 데이터 
	*							[바인딩 컬럼 => 값, 컬럼 => 값]
	*
	* @return PDOStatement 인스턴스|Boolean  쿼리실패 false
	*/
	public function execSQL($sql, $binds = []) 
	{
		if (!$sql) return false;
		
		$stmt = $this->_prepare($sql);
		if ($binds) {
			foreach ($binds as $column => $value) {
				$type = (is_numeric($value))?PDO::PARAM_INT:PDO::PARAM_STR;
				$stmt->bindValue(":".$column, $value, $type);
			}
		}
		
		$result = $stmt->execute();
		if ($result) {
			return $stmt; //  성공시에는 PDOStatement 인스턴스 반환
		}
		
		return false;
		
	}
	
	/**
	* 에러 정보 조회 
	*
	* @return Array
	*/
	public function getErrors() {
		return $this->errors;
	}
	
	/**
	* 데이터베이스 오류 처리 
	*
	* @return Array
	*/
	public function errorInfo()
	{
		$errors = parent::errorInfo();

		if ($errors) { // 데이터베이스 오류 로그 기록 
			App::log(implode(":", $errors), 'error');
		}

		return $errors;
	}
	
	/**
	* PDO::prepare 로그 기록위한 재정의
	*
	* @param String $sql SQL 구문
	* @return PDOStatement
	*/
	public function _prepare($sql)
	{
		$stmt = $this->prepare($sql);
		
		App::log("SQL - ".$sql);
		return $stmt;
	}
}