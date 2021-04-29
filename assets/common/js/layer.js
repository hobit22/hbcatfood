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
		width = width || 300;
		height  = height || 300;
		/**
			id='layer_popup' -> body 끝에 추가 
		*/
		$popup = $("#layer_popup");
		if ($popup.length == 0) { // 레이어 팝업이 존재 X -> 생성 
			$("body").append("<div id='layer_popup'></div>");
			$popup = $("#layer_popup");
		}
		
		if (url) {
			const html = `<iframe src='${url}' width='100%' height='${height}' frameborder='0'></iframe>`;
			$popup.html(html);
		}
		
		const xpos = Math.round(($(window).width() - width) / 2);
		const ypos = Math.round(($(window).height() - height) / 2);
		
		$popup.css({
			width: width + "px",
			height: height + "px",
			left : xpos + "px",
			top : ypos + "px",
		});
		
	},
	/**
	* 레이어 팝업 닫기 
	*
	*/
	close : function() {
		
	}
};