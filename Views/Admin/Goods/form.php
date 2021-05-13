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
			<dt>진열상태</dt>
			<dd>
				<input type='radio' name='isDisplay' value='1' id='isDisplay1'<?php if (!isset($isDisplay) || $isDisplay) echo " checked";?>>
				<label for='isDisplay1'>진열</label>
				
				<input type='radio' name='isDisplay' value='0' id='isDisplay0'<?php if (isset($isDisplay) && !$isDisplay) echo " checked";?>>
				<label for='isDisplay0'>미진열</label>
			</dd>
		</dl>
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
			<dt>총재고</dt>
			<dd>
				<input type='text' name='totalStock' value='<?=isset($totalStock)?$totalStock:0?>' class='w120'>
				 / 
				 품절 여부 
				 <input type='radio' name='stockOut' value='1' id='stockOut1'<?php if (isset($stockOut) && $stockOut) echo " checked";?>>
				 <label for='stockOut1'>품절</label> 
				 <input type='radio' name='stockOut' value='0' id='stockOut0'<?php if (!isset($stockOut) || !$stockOut) echo " checked";?>>
				 <label for='stockOut0'>판매중</label>
			</dd>
		</dl>
		<dl>
			<dt>옵션</dt>
			<dd></dd>
		</dl>
		<dl>
			<dt>메인이미지</dt>
			<dd>
				<span class='addImage' data-location='main' data-gid='<?=$gid?>'>
					<i class='xi-plus'></i>
				</span>
				<span class='uploaded_main_images add_uploaded_image'>
				<?php if (isset($images) && $images['main']) : ?>
				<?php foreach ($images['main'] as $im) : ?>
					<span class='images' style="background:url('<?=$im['url']?>') no-repeat center center; background-size: cover;" data-idx='<?=$im['idx']?>'>
						<i class='xi-close-min remove'></i>
					</span>
				<?php endforeach;?>
				<?php endif; ?>
				</span>
			</dd>
		</dl>
		<dl>
			<dt>리스트이미지</dt>
			<dd>
				<span class='addImage' data-location='list' data-gid='<?=$gid?>'>
					<i class='xi-plus'></i>
				</span>
				<span class='uploaded_list_images add_uploaded_image'>
				<?php if (isset($images) && $images['list']) : ?>
				<?php foreach ($images['list'] as $im) : ?>
					<span class='images' style="background:url('<?=$im['url']?>') no-repeat center center; background-size: cover;" data-idx='<?=$im['idx']?>'>
						<i class='xi-close-min remove'></i>
					</span>
				<?php endforeach;?>
				<?php endif; ?>
				</span>
			</dd>
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
					<span class='btn2' onclick="layer.popup('<?=siteUrl("file/upload")?>?gid=<?=$gid?>&type=image&location=description', 280, 130);">이미지 추가</span>
					<span class='uploaded_images'>
					<?php if (isset($images) && $images['description']) : ?>
					<?php foreach ($images['description'] as $file) : ?>
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
		<input type='submit' value='상품<?=isset($goodsNo)?"수정":"등록"?>' class='btn1'>
	</form>
</div>
<!--// content_box -->

<form name='frmUpload' id='frmUpload' method='post' action='<?=siteUrl("file/uploadOk")?>' enctype='multipart/form-data' target='ifrmHidden'>
	<input type='hidden' name='gid' value='<?=$gid?>'>
	<input type='hidden' name='type' value='image'>
	<input type='hidden' name='location' value=''>
	<input type='file' name='file' class='dn'>
</form>