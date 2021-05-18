<div class='goods_view'>
	<div class='goods_top'>
		<div class='images'>
			<div class='swiper-container'>
				<div class='swiper-wrapper'>
					<?php if ($images['main']) : ?>
					<?php foreach ($images['main'] as $image) : ?>
						<div class='swiper-slide'>
							<img src='<?=$image['url']?>'>
						</div>
					<?php endforeach; ?>
					<?php endif; ?>
				</div>
				<div class='swiper-pagination'></div>
			</div>
		</div>
		<!--// images -->
		<div class='info'>
		
		</div>
		<!--// info -->
	</div>
	<!--// goods_top -->
	<div class='description'>
		<?=$description?>
	</div>
</div>
<!-- goods_view -->