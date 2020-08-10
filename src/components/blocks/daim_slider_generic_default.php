<div class="daim-slide <?php echo 'daim-tmp-'.$obj->comp_template; ?>">
	<div class="daim-flex-container flex-not-align daim-flex-space">
		<div class="daim-flex-col-30">
			<div class="daim-bg-img" style="background-image: url('<?php echo $obj->comp_post_img; ?>')"></div>
		</div>
		<div class="daim-flex-col-70">
			<div>
				<div class="u-main-content">
					<h3><?php echo $obj->comp_post_title; ?></h3>
					<div class="daim-standar-date-content">
						<i class="fa fa-calendar-minus-o"></i>
						<?php
							foreach ($obj->comp_post_dates as $key => $value) {
								echo "<span>".$key.": ".$value."</span>";
							}
						?>
					</div>
					<?php echo $obj->comp_post_content; ?>

					<?php if($obj->comp_post_link['include']==='1'): ?>

						<?php if(isset($obj->comp_post_link['extra_btn'])): ?>
							<div class="daim-default-btn-container">
								<div class="daim-standar-btn"> 
									<a class="daim-button" href="<?php echo $obj->comp_post_link['url']; ?>"><?php echo $obj->comp_post_link['link_text']; ?></a>
								</div>
								<div class="daim-standar-btn"> 
									<a class="daim-button daim-btn-color-v3" href="<?php echo $obj->comp_post_link['extra_btn']; ?>"><?php echo $obj->comp_post_link['extra_btn_text']; ?></a>
								</div>
							</div>
						<?php else: ?>
							<div class="daim-standar-btn"> 
								<a class="daim-button" href="<?php echo $obj->comp_post_link['url']; ?>"><?php echo $obj->comp_post_link['link_text']; ?></a>
							</div>
						<?php endif; ?>
					<?php endif; ?>
				</div>

			</div>
		</div>
	</div>
</div>