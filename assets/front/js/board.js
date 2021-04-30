$(function() {
	CKEDITOR.replace("contents");
	
	CKEDITOR.config.height = 350;
	
	/** 본문 이미지 추가 */
	$("body").on("click", ".file_box .addContents", function() {
		$fileBox = $(this).closest(".file_box");
		const url = $fileBox.data("url");
		const tag = `<img src='${url}'>`;
		CKEDITOR.instances.contents.insertHtml(tag);
	});
	
	/** 이미지 파일 삭제 */
	$("body").on("click", ".file_box .remove", function() {
		$fileBox = $(this).closest(".file_box");
		const idx = $fileBox.data('idx');
		
		$.ajax({
			url : "../file/delete",
			type : "post",
			data : { idx : idx },
			dataType : "text",
			success : function(res) {
				if (res == "1") {
					$fileBox.remove(); 
				} else {
					alert("파일 삭제 실패!");
				}
			},
			error : function(err) {
				console.error(err);
			}
		});
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
						<a href='../file/download?idx=${data.idx}' target='ifrmHidden'>${data.fileName}</a>
						<i class='remove xi-file-remove'></i>
						<i class='addContents xi-upload'></i>
						</span>`;
	
	$(".uploaded_images").append(html);
	
	
	// 레이터팝업 닫기
	layer.close();
}