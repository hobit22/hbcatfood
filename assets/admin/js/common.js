$(function() {
/** 공통 이벤트 처리 S */
	// checkbox 전체 선택 
	/**
	 // attr  -> 일반적인 속성을 읽거나 설정 
	 // prop -> 상태에 대한 속성을 읽거나 설정 - true, false
	*/
	$(".selectAll").click(function() {
		// data-target-name 
		const target = $(this).data("target-name");
		if (!target)
			return;
			
		$("input[name^='" + target + "']").prop("checked", $(this).prop("checked"));
	});

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

/** 공통 이벤트 처리 E */
});