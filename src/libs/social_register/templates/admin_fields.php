<div class="daim-social-register">
	<div class="title-area">
		<h2><?php _e('Main Settings'); ?></h2>
	</div>
	<div class="body-area">
		<div class="form-cluster">

			<div class="d-group">
				<label for=""><?php _e('Enable form for user action',DAIM_PLUG_DOMAIN); ?></label>
				<div>
					<input 
						name="<?php echo $fields["enable_social_register"]; ?>" 
						value="1" 
						type="checkbox"
						<?php echo ($enable==='1')?'checked':''; ?>>
				</div>
			</div>

			<div class="d-group">
				<label for=""><?php _e('Enable registration by email validation',DAIM_PLUG_DOMAIN); ?></label>
				<div>
					<input 
						name="<?php echo $fields["validate_token"]; ?>" 
						value="1" 
						type="checkbox"
						<?php echo ($validateToken==='1')?'checked':''; ?>>
				</div>
			</div>

			<div class="d-group">
				<label for=""><?php _e('Link field with username',DAIM_PLUG_DOMAIN); ?></label>

				<select name="<?php echo $fields["bind_user_name"]; ?>">
					<?php foreach($tags as $tagk => $tagv): ?>

						<option 
							<?php echo ( $bindUserName === $tagv['name'])?'selected="selected"':''; ?> 
						><?php echo $tagv['name']; ?></option>

					<?php endforeach; ?>
				</select>
			</div>

			<div class="d-group">
				<label for=""><?php _e('Link field with email',DAIM_PLUG_DOMAIN); ?></label>

				<select name="<?php echo $fields["bind_email"]; ?>">
					<?php foreach($tags as $tagk => $tagv): ?>

						<option 
							<?php echo ( $bindEmail === $tagv['name'])?'selected="selected"':''; ?> 
							><?php echo $tagv['name']; ?></option>

					<?php endforeach; ?>
				</select>
			</div>

			<div class="d-group">
				<label for=""><?php _e('Select user role',DAIM_PLUG_DOMAIN); ?></label>

				<select name="<?php echo $fields["bind_user_name"]; ?>">
					<?php foreach($listRoles as $rolk => $rolv): ?>

						<option 
							value="<?php echo esc_attr($rolk); ?> "
							<?php echo ( $bindRole === $rolk)?'selected="selected"':''; ?> 
							><?php echo translate_user_role($rolv['name']); ?></option>

					<?php endforeach; ?>
				</select>
			</div>

		</div>
	</div>
</div>