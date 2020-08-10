<div class="daim-menu-container">
	<div class="d-menu">
		<div class="collapse-button">
			<button><i class="fa fa-bars"></i></button>
		</div>
		<?php echo wp_nav_menu( ['menu' => $atts['menu_id']] ); ?>
	</div>
	<div class="collapse-button">
		<button><i class="fa fa-bars"></i></button>
	</div>
</div>