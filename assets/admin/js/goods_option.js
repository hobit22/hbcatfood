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
	},
	/**
	* 옵션 항목 추가 
	*
	*/
	addOptItem : function(obj) {
		let html = $("#opt_item_rows_template").html();
		$optItem = obj.closest(".opt_item");
		const no = $optItem.index();
		
		html = html.replace(/<%no%>/g, no);
		
		$target = $optItem.find("tbody");
		$target.append(html);
	},
	/**
	* 옵션 항목 제거 
	*
	*/
	removeOptItem : function(obj) {
		$target = obj.closest(".opt_item").find("tbody").find("tr").last();
		$target.remove();
	}, 
	/**
	* 옵션 전체 삭제(초기화)
	*
	*/
	removeOptions : function() {
		const goodsNo = $("input[name='goodsNo']").val();
		$.ajax({
			url : "../goods/indb",
			type : "post",
			data : { mode : "delete_options", goodsNo : goodsNo },
			dataType : "html",
			success : function (res) {
				console.log(res);
			},
			error : function (err) {
				console.error(err);
			}
		});
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
	
	
	/** 옵션 항목 추가 */
	$("body").on("click", ".opt_items .add", function() {
		goodsOption.addOptItem($(this));
	});
	
	/** 옵션 항목 삭제 */
	$("body").on("click", ".opt_items .remove", function() {
		goodsOption.removeOptItem($(this));
	});
	
	/** 옵션 항목 클릭한 행 삭제 */
	$("body").on("click", ".opt_item .remove_rows", function() {
		$(this).closest("tr").remove();
	});
	
	/** 옵션 항목 초기화 */
	$(".initialize_opt_items").click(function() {
		if (confirm('정말 삭제하시겠습니까?')) {
			goodsOption.removeOptions();
		}
	});
	
});