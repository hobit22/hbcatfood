/**
* 파일 업로드 처리 
*
*/
const fileUpload = {
	
};

$(function() {
	// 파일을 선택하자마자 자동으로 submit 
	$("#fileFrm input[type='file']").change(function() {
		$("#fileFrm").submit();
	});
});