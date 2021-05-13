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
});