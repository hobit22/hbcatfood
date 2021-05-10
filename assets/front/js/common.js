$(function() {
	/** 주소 검색 버튼 클릭 */
	$(".search_address").click(function() {
		juso.popup(function(data) {
			// 선택한 데이터 
			if (data) {
				$zipcode = $("input[name='zipcode']");
				$address = $("input[name='address']");
				$addressSub = $("input[name='addressSub']");
				
				if ($zipcode.length > 0)  $zipcode.val(data.zonecode);
				if ($address.length > 0) $address.val(data.address);
				if ($addressSub.length > 0) $addressSub.focus();
			} // endif 
		});
	});
});