<div class="daimos-dash-container wrap">
	
	<?php settings_errors(); ?>
	<div>
		<div class="daim-title-area">
			<h1><i class="daimos-font daimos-logo"></i> Theme Manager</h1>
		</div>

		<div class="daim-body-area">
			
			<!--Main Options Group-->
			<div class="daim-admin-form-group">
				<form action="options.php" method="post">
					<?php
						settings_fields('daim_plugin_options');
						do_settings_sections('daimos_manager');
					?>
					<div class="sumit-container">
						<?php submit_button(); ?>
					</div>
				</form>
			</div>

			<!--Extension Daimos Group-->
			<div class="daim-admin-form-group">
				<form action="options.php" method="post">
					<?php
						settings_fields('daim_extension_theme');
						do_settings_sections('daimos_extension');
					?>
					<div class="sumit-container">
						<?php submit_button(); ?>
					</div>
				</form>
			</div>

		</div>
	</div>

</div>
