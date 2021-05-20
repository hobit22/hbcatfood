/**
* 장바구니 관련
*
*/
const cart = {
	/**
	* 상품 구매수량 수정 
	*
	* @param Integer cartNo 장바구니 추가 번호
	* @param Integer goodsCnt 구매수량
	*/
	updateGoodsCnt : function(cartNo, goodsCnt) {
		if (!cartNo || !goodsCnt) return;
		
		$.ajax({
			url : "../order/indb",
			type : "post", 
			data : { mode : "update_goods_cnt", cartNo : cartNo, goodsCnt : goodsCnt },
			dataType : "html",
			success : function(res) {
				console.log(res);
			},
			error : function (err) {
				console.error(err);
			}
		});
	},
};

$(function() {
	/** 수량 증감 버튼 처리 */
	$(".goodsCnt_up, .goodsCnt_dn").click(function() {
		$goodsCnt = $(this).closest("td").find(".goodsCnt");
		let goodsCnt = Number($goodsCnt.val());
		
		if ($(this).hasClass("goodsCnt_up")) { // 수량 증가
			goodsCnt++;
		} else { // 수량 감소 
			goodsCnt--;
		}
		
		if (goodsCnt < 1) goodsCnt = 1;
		$goodsCnt.val(goodsCnt);
		
		
		// 증가한 수량 -> DB에 반영, cartNo, goodsCnt
		const cartNo = $(this).closest("tr").find("input[name^='cartNo'").val();
		cart.updateGoodsCnt(cartNo, goodsCnt);
	});
});