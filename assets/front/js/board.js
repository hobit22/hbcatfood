$(function() {
	CKEDITOR.replace("contents");
	CKEDITOR.config.height = 350;
	
	/** 본문 이미지 추가 */
	$("body").on("click", ".addContents", function() {
		$fileBox = $(this).closest(".file_box");
	});
});


/**
파일 업로드 콜백 처리 
*/
function fileUploadCallback(data) {	
	/**
	1. 에디터에 이미지 추가 
	2. 추가된 파일목록 추가 
	3. 레이어 팝업 닫기 
	*/
	if (!data) 
		return false;
	
	// 에디터에 이미지 추가 
	const tag = `<img src='${data.url}'>`;
	CKEDITOR.instances.contents.insertHtml(tag);
	
	const html = `<span class='file_box' data-idx='${data.idx}' data-url='${data.url}'>
						${data.fileName}
						<i class='remove xi-file-remove'></i>
						<i class='addContents xi-upload'></i>
						</span>`;
	
	$(".uploaded_images").append(html);
	
	
	// 레이터팝업 닫기
	layer.close();
}