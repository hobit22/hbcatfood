$(function() {
	if ($("#contents").length > 0) {
		CKEDITOR.replace("contents");	
		CKEDITOR.config.height = 350;
	}
	
	/** 본문 이미지 추가 */
	$("body").on("click", ".file_box .addContents", function() {
		$fileBox = $(this).closest(".file_box");
		const url = $fileBox.data("url");
		const tag = `<img src='${url}'>`;
		CKEDITOR.instances.contents.insertHtml(tag);
	});
	
	/** 이미지 파일 삭제 */
	$("body").on("click", ".file_box .remove", function() {
		if (!confirm("정말 삭제하시겠습니까")) {
			return;
		}
		
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
	
	/** 댓글 삭제 */
	$(".delete_comment").click(function() {
		if (!confirm("정말 삭제하시겠습니까?")) {
			return;
		}
		
		$li = $(this).closest("li");
		const idx = $li.data("idx");
		
		$.ajax({
			url : "../board/indb",
			type : "post", 
			data : { mode : "delete_comment", idx : idx },
			dataType : "text",
			success : function (res) {
				res = res.trim();
				if (res == '1') { // 삭제 성공 
					alert("댓글 삭제 성공");
					$li.remove();
				} else { // 삭제 실패 
					alert("삭제 실패!");
				}
			},
			error : function (err) {
				console.error(err);
			}
		});
	});
	
	/** 댓글 수정 */
	$(".update_comment").click(function() {
		$li = $(this).closest("li");
		const idx = $li.data("idx");
		
		$obj = $li.find(".comment_data");
		if ($obj.length > 0) {
			$obj.remove();
		}
		
		$.ajax({
			url : "../board/ajax",
			type : "get",
			data : { mode : "get_comment", idx : idx },
			dataType : "json",
			success : function (res) {
				if (res) {
					if (res.error == '1') { // 에러 있는 경우 
						alert(res.message);
					} else { // 정상인 경우 
						const html = `<textarea class='comment_data'>${res.data.comment}</textarea>`;
						
						$li.append(html);
					}
				}
			},
			error : function (err) {
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