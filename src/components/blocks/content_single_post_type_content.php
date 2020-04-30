<div class="uer-flex-col-70">
	<div class="uer-orient-<?php echo $comp_post_orient; ?>">
		<div>
			<h3><?php echo $comp_post_title; ?></h3>
			<div class="uer-standar-content">
				<?php echo do_shortcode($comp_post_content); ?>
			</div>
			<div class="uer-standar-date-content">
				<i class="fa fa-calendar-minus-o"></i>
				<?php
					foreach ($comp_post_dates as $key => $value) {
						echo "<span>".$key.": ".$value."</span>";
					}
				?>
			</div>

			<?php if(isset($comp_post_extra_btn)): ?>
				<div class="uer-default-btn-container">
					<div class="uer-standar-btn"> 
						<a class="uer-general-btn" href="<?php echo $comp_post_url; ?>"><?php echo $comp_post_link_text; ?></a>
					</div>
					<div class="uer-standar-btn"> 
						<a class="uer-general-btn uer-btn-color-v3" href="<?php echo $comp_post_extra_btn; ?>"><?php echo $comp_post_extra_btn_text; ?></a>
					</div>
				</div>
			<?php else: ?>
				<div class="uer-standar-btn"> 
					<a class="uer-general-btn" href="<?php echo $comp_post_url; ?>"><?php echo $comp_post_link_text; ?></a>
				</div>
			<?php endif; ?>
		</div>
	</div>
</div>