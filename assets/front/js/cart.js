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
			dataType : "json",
			success : function(res) {
				if (res.error == '1') { // 에러가 있는 경우 
					alert(res.message);
				} else { // 에러가 없는 경우 
					// 장바구니 요약정보 업데이트 
					cart.updateSummary();
				}
			},
			error : function (err) {
				console.error(err);
			}
		});
	},
	/**
	* 상품요약정보 업데이트
	* 
	*/
	updateSummary : function() {
		const cartNo = [];
		// 체크가 되어 있는 장바구니 checkbox 
		$list = $("input[name^='cartNo']:checked");
		if ($list.length > 0) {
			$.each($list, function() {
				cartNo.push($(this).val());
			});
		} else { // 전부 체크 해제 
			$(".totalGoodsPrice, .totalDeliveryPrice, .totalPayPrice").text(0);
			return;
		}
		
		$.ajax({
			url : "../order/indb",
			type : "post",
			data : { mode : "get_summary", cartNo : cartNo },
			dataType : "json",
			success : function (res) {
				if (res) {
					$(".totalGoodsPrice").text(res.totalGoodsPrice.format());
					$(".totalDeliveryPrice").text(res.totalDeliveryPrice.format());
					$(".totalPayPrice").text(res.totalPayPrice.format());
				}
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
		
		// 상품 개별 합계 
		$goodsTotal = $(this).closest("tr").find(".goodsTotal");
		let basicPrice = $goodsTotal.data("basic");
		basicPrice = Number(basicPrice);
		const total = basicPrice * goodsCnt;
		$goodsTotal.text(total.format());
	});
	
	$(".goodsCnt").on("keyup change", function() {
		/**
			1. 수량 체크 (0 이하 X -> 1) - O 
			2. 수량을 DB에 반영  - cartNo, goodsCnt - O
			3. 상품 개별 합계 - O 
		*/
		
		let goodsCnt = Number($(this).val());
		goodsCnt = (goodsCnt < 1)?1:goodsCnt;
		
		const cartNo = $(this).closest("tr").find("input[name^='cartNo']").val();
		cart.updateGoodsCnt(cartNo, goodsCnt);
		
		// 상품 개별 합계 
		$goodsTotal = $(this).closest("tr").find(".goodsTotal");
		let basicPrice = $goodsTotal.data("basic");
		basicPrice = Number(basicPrice);
		const total = basicPrice * goodsCnt;
		$goodsTotal.text(total.format());
	});
	
	// 상품 선택 체크 박스 
	$("input[type='checkbox']").click(function() {
		cart.updateSummary();
	});
	
	// 장바구니 비우기, 선택상품 삭제
	$(".empty_cart, .selected_delete").click(function() {
		if (confirm('정말 삭제하시겠습니까?')) {
			// 장바구니 비우기 -> 전체 선택
			if ($(this).hasClass("empty_cart")) {
				$("input[name^='cartNo']").prop("checked", true);
			}
			
			frmCart.mode.value = 'delete';
			frmCart.submit();
		} // endif 
	});
	
	// 선택주문, 전체 주문하기 
	$(".selected_order, .order_all").click(function() {
		// 전체 주문하기 -> 전체 선택 
		if ($(this).hasClass("order_all")) {
			$("input[name^='cartNo']").prop("checked", true);
		}
		
		frmCart.mode.value = 'order';
		frmCart.submit();
	});
	
});