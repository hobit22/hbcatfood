<?php
/**
* 공통 함수 
*
*/

/**
* 변수, 객체, 배열의 데이터 확인 함수
*
* @param Mixed $v 확인 데이터 
*/
function debug($v = null)
{
	echo "<xmp style='background-color: black; color: yellow; font-size: 12px; padding: 10px; font-weight: bold;'>";
	print_r($v);
	echo "</xmp>";
}