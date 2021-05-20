/**
* 장바구니 관련
*
*/
const cart = {
	
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