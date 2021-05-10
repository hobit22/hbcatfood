/**
* 주소 팝업 및 처리 
*
*/

const juso = {
	/**
	* 다음 주소 팝업 
	* 
	* @param function callback 
					사용자가 선택한 주소에 대한 정보
	*/
	popup : function(callback) {
		new daum.Postcode({
			oncomplete : function(data) {
				callback(data);
			}
		}).open(); 
	}
}