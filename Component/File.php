<?php

namespace Component;

use App;

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
		
	}
}