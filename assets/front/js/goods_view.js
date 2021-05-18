/**
* 상품 상세 
*
*/
const goodsView = {
	/**
	* 옵션 선택 
	*
	* @param Integer optNo - 옵션 선택번호
	*/
	selectOption : function(optNo) {
		if (!optNo) return;
		
		$.ajax({
			url : "../goods/ajax", 
			type : "post", 
			data : { mode : "get_options", optNo : optNo },
			dataType : "html", 
			success : function (res) {
				console.log(res);
			},
			error : function (err) {
				console.error(err);
			}
		});
	}
};

/** swiper 추가 */
const swiperMain = new Swiper(".goods_top .swiper-container", {
	pagination : {
		el: ".goods_top .swiper-pagination",
	}
});

$(function() {
	/** 옵션 선택 처리 */
	$(".goods_top .options").change(function() {
		const optNo = $(this).val();
		if (optNo) {
			goodsView.selectOption(optNo);
		}
	});
});