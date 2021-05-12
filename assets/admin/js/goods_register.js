/**
* 상품 등록/수정 
* 
*/

$(function() {
	// 에디터 로드
	CKEDITOR.replace("description");
	CKEDITOR.config.height=300;
});


/**
파일 업로드 콜백 처리 
*/
function fileUploadCallback(data) {	
	console.log(data);
	/**
	1. 에디터에 이미지 추가 
	2. 추가된 파일목록 추가 
	3. 레이어 팝업 닫기 
	*/
	if (!data) 
		return false;
	
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
}