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

/** 공통 이벤트 처리 E */
});