<?php

namespace Component;

use App;
use Component\Exception\File\FileUploadException;

/**
* 파일 Component
*
*/
class File
{
	// 파일 업로드 경로 
	private $uploadPath = __DIR__ . "/../assets/upload/";
	
	
	/**
	* 파일 업로드 처리 
	*
	* @param String $gid 그룹 ID 
	* @param String $name 파일 태그의 name 
	*							<iniput type='file' name='image' --> $name = 'image' 
	* @param String $type 
								image -> 이미지 파일만 
								all -> 전체 파일( 값이 없으면 전체로)
	* @param Boolean $useException FileUploadException throw 할지 여부 
	* @return Integer|Boolean 
						업로드 성공시 - 파일 추가 번호(idx) 
						실패 - false
	*/
	public function upload($gid, $name, $type = "all", $useException = false)
	{
		$files = request()->files();
		$file = isset($files[$name])?$files[$name]:[];
		// 파일 유효성 검사 S
		if (!$file || !$file['tmp_name']) {
			if ($useException) {
				throw new FileUploadException("파일을 업로드해 주세요.");
			}
			
			return false;
		}
		
		if ($file['error']) {
			if ($useException) {
				throw new FileUploadException("파일 업로드 에러!");
			}
			
			return false;
		}
		
		if ($type == 'image' && !preg_match("/^image/", $file['type'])) { // 이미지 파일만 업로드 하는데, 이미지가 아닌 경우 
			if ($useException) {
				throw new FileUploadException("이미지형식의 파일만 업로드 가능합니다.");
			}
			
			return false;
		}
		// 파일 유효성 검사 E 
		
		/**
			파일 저장 처리 
			1. 파일 데이터를 DB 기록 -> idx 
			2. 업로드될 파일 경로  /assets/upload/번호 폴더/idx에 업로드 
			3. yh_fileInfo - isDone -> 1로 업데이트 
		*/
		$inData = [
			'fileName' => $file['name'],
			'mimeType' => $file['type'],
			'gid' => $gid
		];
		
		$idx = db()->table("fileInfo")->data($inData)->insert();
		if ($idx > 0) {
			$folder = $idx % 10;
			$dirPath = $this->uploadPath .$folder;
			if (!file_exists($dirPath)) {
				mkdir($dirPath);
			}
			
			if (file_exists($dirPath)) {
				$result = move_uploaded_file($file['tmp_name'], $dirPath."/".$idx);
				if ($result) {
					db()->table("fileInfo")
						->data(["isDone" => 1])
						->where(["idx" => $idx])
						->update();
						
					return $idx; // 파일 업로드가 잘 처리되면 idx
				} // endif 
			} // endif 
		} // endif 
		
		return false; // 처리 실패시 false
	}
	
	/**
	* 업로드된 파일 URL
	*
	* @param Integer $idx 파일 추가 번호
	* @return String 
	*/ 
	public function getUploadedUrl($idx)
	{
		$folder = $idx % 10;
		$url = siteUrl("assets/upload/{$folder}/{$idx}");
		
		return $url;
	}
	
	/**
	* 업로드된 파일 경로 
	*
	* @param Integer $idx 파일 추가 번호
	* @return String 
	*/
	public function getUploadedPath($idx)
	{
		$folder = $idx % 10;
		$path = $this->uploadPath . $folder . "/".$idx;
		
		return $path;
	}
	
	/**
	* 업로드된 파일 정보
	*
	* @param Integer $idx 파일 등록번호 
	* @return Array
	*/
	public function get($idx) 
	{
		$data = db()->table("fileInfo")->where(["idx" => $idx])->row();
		if ($data) {
			$data['url'] = $this->getUploadedUrl($idx);
		}
		
		return $data;
	}
	
	/**
	* 파일 삭제 처리 
	*
	* 	unlink
	* @param Integer $idx 파일 추가 번호
	* @return Boolean
	*/
	public function delete($idx)
	{
		$folder = $idx % 10;
		$path = $this->uploadPath . $folder . "/".$idx;
		if (unlink($path)) { // 삭제 성공 -> DB 삭제 
			$result = db()->table("fileInfo")->where(["idx" => $idx])->delete();
			return $result !== false; // 성공시 true, 실패시 false
		}
		
		return false; // 파일 삭제 실패 
	}
}