<div class="daim-slide <?php echo 'daim-tmp-'.$obj->comp_template; ?>">
	<div class="daim-flex-container flex-not-align daim-flex-space">
		<div class="daim-flex-col-100">
			<?php if($obj->comp_post_link['include']==='1'): ?>
				<a class="daim-button" href="<?php echo $obj->comp_post_link['url']; ?>">
					<div class="daim-bg-img" style="background-image: url('<?php echo $obj->comp_post_img; ?>')"></div>
				</a>
			<?php else: ?>
				<div class="daim-bg-img" style="background-image: url('<?php echo $obj->comp_post_img; ?>')"></div>
			<?php endif; ?>
			
		</div>
	</div>
</div>