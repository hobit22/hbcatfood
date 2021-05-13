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
	},
	/**
	* 옵션명 삭제 
	*
	*/
	removeOptName : function() {
		$(".opt_names .opt_name:last-child").remove();
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