<div class="daim-slide <?php echo 'daim-tmp-'.$atts['main_template']; ?>">
	<div class="daim-flex-container flex-not-align daim-flex-space">
		<div class="daim-flex-col-100">
			<?php if($comp_post_bool_link==='1'): ?>
				<a class="daim-button" href="<?php echo $comp_post_url; ?>">
					<div class="daim-bg-img" style="background-image: url('<?php echo $comp_post_img; ?>')"></div>
				</a>
			<?php else: ?>
				<div class="daim-bg-img" style="background-image: url('<?php echo $comp_post_img; ?>')"></div>
			<?php endif; ?>
			
		</div>
	</div>
</div>