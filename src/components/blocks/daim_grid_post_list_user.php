<div class="daim-grid-content grid-template-<?php echo $obj->comp_template; ?>">
	<div class="daim-wrap-cont">
		<div>
			<a href="<?php echo $obj->comp_post_link['url']; ?>">
				<?php do_action(DAIM_PRFX.'comp_std_img',$obj->comp_post_img,['alt'=>$obj->comp_post_title]); ?>
			</a>
		</div>
		<div>
			<div class="daim-wrap-cont">

				<div class="daim-title">
					<a href="<?php echo $obj->comp_post_link['url']; ?>">
						<h3><?php echo do_shortcode($obj->comp_post_title); ?></h3>
					</a> 
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
					<?php echo get_post_meta($obj->comp_post_obj->ID,'job_title')[0]; ?>
					<div class="daim-social-networks">
						<ul>
							<li><a href="<?php echo get_post_meta($obj->comp_post_obj->ID,'facebook')[0]; ?>"><i class="fa fa-facebook-f"></i></a></li>
							<li><a href="<?php echo get_post_meta($obj->comp_post_obj->ID,'twitter')[0]; ?>"><i class="fa fa-twitter"></i></a></li>
							<li><a href="<?php echo get_post_meta($obj->comp_post_obj->ID,'instagram')[0]; ?>"><i class="fa fa-instagram"></i></a></li>
							<li><a href="<?php echo get_post_meta($obj->comp_post_obj->ID,'youtube')[0]; ?>"><i class="fa fa-youtube"></i></a></li>
						</ul>
					</div>
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