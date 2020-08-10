<div class="daim-picture-block-container">
	
	<div>
		<div class="picture-content">
			<div style="background-image: url('<?php echo $obj->comp_post_img; ?>')"></div>
		</div>
		<div class="mask-content">
			<div>
				<div class="daim-standar-btn"> 
					<a href="<?php echo $obj->comp_post_link['url']; ?>"><?php _e('Read More',DAIM_PLUG_DOMAIN); ?></a>
				</div>
			</div>
		</div>
	</div>
	<div>
		<h4><?php echo $obj->comp_post_title; ?></h4>
	</div>
	
</div>