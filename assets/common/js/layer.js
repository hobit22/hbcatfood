/**
* 레이어 팝업 
*
*/
const layer = {
	/**
	* 레이어 팝업 열기 
	*
	* @param String url 팝업 출력 URL 
	* @param Integer width 팝업 너비 
	* @param Integer height 팝업 높이 
	*/
	popup : function(url, width, height) {
		/**
			id='layer_popup' -> body 끝에 추가 
		*/
		
		$popup = $("#layer_popup");
		if ($popup.length == 0) { // 레이어 팝업이 존재 X -> 생성 
			$("body").append("<div id='layer_popup'></div>");
			$popup = $("#layer_popup");
		}
		
	},
	/**
	* 레이어 팝업 닫기 
	*
	*/
	close : function() {
		
	}
};