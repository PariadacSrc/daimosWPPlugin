<div class="daim-grid-content grid-template-<?php echo $obj->comp_template; ?>">
	<div class="daim-wrap-cont">
		<div>
			<?php do_action(DAIM_PRFX.'comp_std_img',$obj->comp_post_img,['alt'=>$obj->comp_post_title]); ?>
		</div>
		<div>
			<div class="daim-wrap-cont">

				<div class="daim-title">
					<h3><?php echo do_shortcode($obj->comp_post_title); ?></h3>
				</div>

				<div class="daim-standar-date-content">
					<i class="fa fa-calendar-minus-o"></i>
					<?php
						foreach ($obj->comp_post_dates as $key => $value) {
							echo "<span>".$key.": ".$value."</span>";
						}
					?>
				</div>

				<div class="daim-post-content">
					<?php echo do_shortcode($obj->comp_post_content); ?>
				</div>

				<?php if($obj->comp_post_link['include']): ?>
					<div class="daim-links-content">
						
						<?php do_action(DAIM_PRFX.'comp_button',$obj->comp_post_link['url'],$obj->comp_post_link['text']); ?>

					</div>
				<?php endif; ?>
			</div>
		</div>
	</div>
</div>