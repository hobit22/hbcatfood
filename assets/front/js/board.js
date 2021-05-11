/**
* 게시글 관련 
*
*/
const board = {
	/**
	* 댓글 수정 양식 가져오기 
	*
	* @param Integer idx - 댓글번호 
	* @param Oject selector 
	*/
	loadCommentForm : function(idx, selector) {
		$.ajax({
			url : "../board/ajax",
			type : "get",
			data : { mode : "get_comment", idx : idx },
			dataType : "html",
			success : function (res) {	
				selector.append(res);
			},
			error : function (err) {
				console.error(err);
			}
		});
	}
}

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
		if ($obj.length > 0) { // 댓글 수정 중 
			const text = $obj.val(); 
			if (text == "") {
				alert("수정할 댓글을 입력해 주세요.");
				return;
			}
			
			$.ajax({
				url : "../board/indb",
				type : "post",
				data : { mode : "update_comment", idx : idx, comment : text },
				dataType : "text",
				success : function (res) {
					res = res.trim();
					if (res == '1') { // 수정 성공 
						// 성공시 -> 새로고침
						location.reload();
					} else {
						alert("댓글 수정 실패!");
					}
				},
				error : function(err) {
					console.error(err);
				}
			});
			
			
			
		} else { // 댓글 수정 시작
			
			$.ajax({
				url : "../board/ajax",
				type : "get",
				data : { mode : "get_comment", idx : idx },
				dataType : "html",
				success : function (res) {	
					$li.append(res);
				},
				error : function (err) {
					console.error(err);
				}
			});
		} // endif 
	});
	
	// 비회원 비밀번호 체크 
	$("body").on("click", ".password_confirm", function() {
		$li = $(this).closest("li");
		const idx = $li.data("idx"); // 댓글 번호 
		$password = $li.find("input[name='password']");
		const password = $password.val(); // 비회원 비밀번호 
		if (password == "") {
			alert("비회원 비밀번호를 입력해 주세요.");
			$password.focus();
			return;
		}
		
		$.ajax({
			type : "post",
			url : "../board/ajax",
			data : { mode : "check_password", idx : idx, password : password },
			dataType : "text",
			success : function (res) {
				if (res.trim() == "1") { // 인증 성공 
					
					
					
				} else { // 인증 실패 
					alert("비회원 비밀번호가 일치하지 않습니다.");
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