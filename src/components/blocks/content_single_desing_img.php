<?php  if($atts['url']): ?>
	<div class="uer-content-mask single-desing-img" style="background-image: url('<?php echo wp_get_attachment_url($atts['img']); ?>');">
		<div>
			<div class="uer-standar-btn">
				<a href="<?php echo $atts['url']; ?>"><?php _e('Read More',DAIM_PLUG_DOMAIN); ?></a>
			</div>
		</div>
	</div>
<?php else: ?>
	<div class="single-desing-img" style="background-image: url('<?php echo wp_get_attachment_url($atts['img']); ?>');"></div>
<?php endif; ?>