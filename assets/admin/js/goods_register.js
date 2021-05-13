/**
* 상품 등록/수정 
* 
*/

$(function() {
	// 에디터 로드
	CKEDITOR.replace("description");
	CKEDITOR.config.height=300;
	
	/** 본문 이미지 추가 */
	$("body").on("click", ".file_box .addContents", function() {
		$fileBox = $(this).closest(".file_box");
		const url = $fileBox.data("url");
		const tag = `<img src='${url}'>`;
		CKEDITOR.instances.description.insertHtml(tag);
	});
	
	/** 이미지 파일 삭제 */
	$("body").on("click", ".file_box .remove", function() {
		if (!confirm("정말 삭제하시겠습니까")) {
			return;
		}
		
		$fileBox = $(this).closest(".file_box");
		const idx = $fileBox.data('idx');
		
		$.ajax({
			url : "../../file/delete",
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

	
	if (!data) 
		return false;
	
	switch (data.location) {
		case "description" : 
			/**
			1. 에디터에 이미지 추가 
			2. 추가된 파일목록 추가 
			3. 레이어 팝업 닫기 
			*/
			
			// 에디터에 이미지 추가 
			const tag = `<img src='${data.url}'>`;
			CKEDITOR.instances.description.insertHtml(tag);
			
			const html = `<span class='file_box' data-idx='${data.idx}' data-url='${data.url}'>
								<a href='../../file/download?idx=${data.idx}' target='ifrmHidden'>${data.fileName}</a>
								<i class='remove xi-file-remove'></i>
								<i class='addContents xi-upload'></i>
								</span>`;
			
			$(".uploaded_images").append(html);
			
			
			// 레이터팝업 닫기
			layer.close();
			break;
		case "main":
		case "list" : 
			const tag2 = `<span class='images' style="background:url('${data.url}') no-repeat center center; background-size: cover;" data-idx='${data.idx}'>
									<i class='xi-close-min remove'></i>
								</span>`;
			
			$target = $(`.uploaded_${data.location}_images`);
			if ($target.length > 0) {
				$target.append(tag2);
			}
			break;
	}
}