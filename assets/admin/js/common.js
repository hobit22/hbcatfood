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

	// 이미지 공통 업로드 처리 
	$(".addImage").click(function() {
		const gid = $(this).data("gid"); // 그룹 ID 
		const loc = $(this).data("location"); // 파일 위치 
	
		$frm = $("#frmUpload");
		if ($frm.length == 0) return;
		
		$frm.find("input[name='gid']").val(gid);
		$frm.find("input[name='location']").val(loc);
		
		$frm.find("input[type='file']").click(); // 파일 창 
	});
	
	// 파일을 선택하면 change 이벤트가 발생 
	$("#frmUpload input[type='file']").change(function() {
		$(this).closest("#frmUpload").submit();
	});
	
	/** 이미지 공통 업로드 삭제 */
	$("body").on("click", ".add_uploaded_image .remove", function() {
		if (!confirm('정말 삭제하시겠습니까?')) {
			return;
		}
		
		$image = $(this).closest(".images");
		const idx = $image.data("idx");
		
		$.ajax({
			url : "../../file/delete",
			type : "post",
			data : { idx : idx },
			dataType : "text", 
			success : function (res) {
				if (res.trim() == "1") { // 삭제 성공 
					$image.remove();
				} else { // 삭제 실패 
					alert("이미지 삭제 실패!");
				}
			},
			error: function (err) {
				console.error(err);
			}
		});
	});
	
/** 공통 이벤트 처리 E */
});