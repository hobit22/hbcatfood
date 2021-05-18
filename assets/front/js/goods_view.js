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
			dataType : "json", 
			success : function (res) {
				if (res.error == '1' ) { // 에러가 있는 경우 
					alert(res.message);
				} else if (!res.data) { // 옵션이 존재하지 않는 경우 
					alert("존재하지않는 옵션을 선택하였습니다.");
				} else { // 에러가 없는 경우 
					let html = $("#opt_template").html();
					const data = res.data;
					
					const optPrice = Number(data.salePrice) + Number(data.addPrice);
					html = html.replace(/<%optNo%>/g, data.optNo);
					html = html.replace(/<%optItem%>/g, data.optItem);
					html = html.replace(/<%optPrice%>/g, optPrice);
					
					$(".selected_opts").append(html);
				}
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