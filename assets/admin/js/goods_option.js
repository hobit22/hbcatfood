/**
* 상품관리 옵션  
*
*/
const goodsOption = {
	/** 
	* 옵션명 추가 
	*
	*/
	addOptName : function() {
		const html = $("#opt_name_template").html();
		$(".opt_names > .inner").append(html);
		
		$(".create_opt_items").removeClass("dn"); // 항목 생성 버튼 노출 
	},
	/**
	* 옵션명 삭제 
	*
	*/
	removeOptName : function() {
		$(".opt_names .opt_name:last-child").remove();
		
		$list = $(".opt_names .opt_name");
		if ($list.length == 0) {
			$(".create_opt_items").removeClass('dn').addClass('dn');
		}
	},
	
	/**
	* 옵션 항목 입력 양식 생성 
	* 
	*/
	createOptItems : function() {
		$list = $(".opt_names .opt_name input[type='text']");
		if ($list.length > 0) {
			const optNames = [];
			$.each($list, function() {
				const optName = $(this).val().trim();
				// 이미 추가된 옵션명이면 추가 X
				if (optNames.indexOf(optName) == -1) { // -1은 optNames에 없는 경우 
					optNames.push(optName);
				}
			});
			
			// 옵션 항목 양식 템플릿 
			const template = $("#opt_item_template").html();
			let html = "";
			optNames.forEach(function(optNm) {
				
				/// <%optName%>
				html += template.replace(/<%optName%>/g, optNm); 
				
			});
			
			$(".opt_items").html(html);
		} // endif 
	}
}


$(function() {
	/** 옵션명 추가 */
	$(".opt_names .add").click(function() {
		goodsOption.addOptName();
	});
	
	/** 옵션명 삭제 */
	$(".opt_names .remove").click(function() {
		goodsOption.removeOptName();
	});
	
	/** 옵션 항목 생성하기 */
	$(".create_opt_items").click(function() {
		goodsOption.createOptItems();
	});
});