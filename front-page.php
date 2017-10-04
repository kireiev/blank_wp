<?php get_header(); ?>
<?php if ($slider = get_field('slider')) { ?>
	<div class="homeSlider swiper-container">
		<div class="swiper-wrapper">
			<?php foreach ($slider as $s) { ?>
				<div class="swiper-slide" style="background-image: url(<?php echo $s['background']; ?>);background-position: top center;background-size: cover">
					<div class="row">
						<?php echo $s['text'] ?>
					</div>
				</div>
			<?php } ?>
		</div>
		<div class="swiper-pagination"></div>
	</div>
<?php } ?>
<div class="section-2"></div>
<div class="section-3"></div>
<div class="section-4"></div>
<div class="section-5"></div>
<?php get_footer(); ?>
