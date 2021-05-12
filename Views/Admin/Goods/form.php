<!-- 
상품등록
1. 상품명
2. 상품에 대한 짧은 설명
		
3. 판매가(결제가)
	+ 소비자(정가)
	
4. 상품 선택 옵션(+옵션가)

5. 상품이미지
		- 상세페이지 메인 이미지(복수 등록 가능)
		- 리스트페이지 이미지(이미지 1개)

6. 배송 설정(배송방법 + 배송비)

7. 상세설명 +( 에디터)

-->
<div class='title1'>상품<?=isset($goodsNo)?"수정":"등록"?></div>
<div class='content_box'>
	<form method='post' action='<?=siteUrl("admin/goods/indb")?>' target='ifrmHidden' autocomplete='off'>
		<input type='hidden' name='mode' value='<?=isset($goodsNo)?"update":"register"?>'>
		<input type='hidden' name='gid' value='<?=$gid?>'>
		<?php if (isset($goodsNo)) : ?>
		<input type='hidden' name='goodsNo' value='<?=$goodsNo?>'>
		<?php endif; ?>
		<dl>
			<dt>상품명</dt>
			<dd>
				<input type='text' name='goodsNm' value='<?=isset($goodsNm)?$goodsNm:""?>'>
			</dd>
		</dl>
		<dl>
			<dt>짧은 설명</dt>
			<dd>
				<input type='text' name='shortDescription' value='<?=isset($shortDescription)?$shortDescription:""?>'>
			</dd>
		</dl>
		<dl>
			<dt>상품가격</dt>
			<dd>
				판매가 :  
				<input type='text' name='salePrice' class='w120' value='<?=isset($salePrice)?$salePrice:''?>'>원
				/ 
				소비자가 : 
				<input type='text' name='consumerPrice' class='w120' value='<?=isset($consumerPrice)?$consumerPrice:''?>'>원
			</dd>
		</dl>
		<dl>
			<dt>옵션</dt>
			<dd></dd>
		</dl>
		<dl>
			<dt>메인이미지</dt>
			<dd></dd>
		</dl>
		<dl>
			<dt>리스트이미지</dt>
			<dd></dd>
		</dl>
		<dl>
			<dt>배송설정</dt>
			<dd></dd>
		</dl>
		<dl>
			<dt>상세설명</dt>
			<dd>
				<textarea name='description' id='description'><?=isset($description)?$description:""?></textarea>
				<div class='mt10'>
					<span class='btn2' onclick="layer.popup('<?=siteUrl("file/upload")?>?gid=<?=$gid?>&type=image', 280, 130);">이미지 추가</span>
					<span class='uploaded_images'>
					<?php if (isset($attachFiles) && isset($attachFiles['images'])) : ?>
					<?php foreach ($attachFiles['images'] as $file) : ?>
					<span class='file_box' data-idx='<?=$file['idx']?>' data-url='<?=$file['url']?>'>
						<a href='<?=siteUrl("file/download")?>?idx=<?=$file['idx']?>' target='ifrmHidden'><?=$file['fileName']?></a>
						<i class='remove xi-file-remove'></i>
						<i class='addContents xi-upload'></i>
					</span>
					<?php endforeach;?>
					<?php endif; ?>
					</span>
				</div>
			</dd>
		</dl>
		<input type='submit' value='상품등록' class='btn1'>
	</form>
</div>
<!--// content_box -->