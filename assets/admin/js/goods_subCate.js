/**
* 상품관리 서브메뉴  
*
*/
const goodsSubcate = {
}


$(function() {
	/** 상품 분류 변경 시 서브 메뉴 업데이트 */
	$("select[name='cateCd']").change(function() {
		const cateCd = $(this).val();
		$.ajax({
			url : "../goods/indb",
			type : "get",
			data : { mode : "get_sub_category", cateCd : cateCd },
			dataType : "json",
			success : function (res) {
				
				let html = "<option value=''>- 선택 하세요 -</option>";
				if (res && res.length > 0) {
					res.forEach(function(sub) {
						html += "<option value='" + sub + "'>" + sub + "</option>";
					});
				}
				$("select[name='subCategory']").html(html);
			},
			error : function (err) {
				console.log(err);
			}
		});
	});
	$("select[name='cateCd']").change(function() {
		const cateCd = $(this).val();
		$.ajax({
			url : "../goods/indb",
			type : "get",
			data : { mode : "get_brand_category", cateCd : cateCd },
			dataType : "json",
			success : function (res) {
				let html = "<option value=''>- 선택 하세요 -</option>";
				if (res && res.length > 0) {
					res.forEach(function(brand) {
						html += "<option value='" + brand + "'>" + brand + "</option>";
					});
				}
				$("select[name='brandCate']").html(html);
			},
			error : function (err) {
				console.log(err);
			}
		});
	});
	
});