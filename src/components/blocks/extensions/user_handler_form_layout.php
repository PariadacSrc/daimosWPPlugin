<div class="users-handler-forms <?php echo $comp['comp_modal_css']; ?> bind-action-mdl-<?php echo $comp['comp_hash']; ?>">
	<div class="<?php echo ($comp['comp_atts']['template']==='modal')?'d-modal-body':'' ?>">

		<?php foreach ($comp['comp_forms'] as $fkey => $fval): ?>

			
			<?php $type = $fval['form']; ?>
	
			<div id="bind-<?php echo $type; ?>-<?php echo $comp['comp_hash']; ?>" class="bind-form <?php echo ($fkey===0)?'show':''; ?>" data-bind-tab="#bind-<?php echo $fval['bind']; ?>-<?php echo $comp['comp_hash']; ?>">

				<div class="handler-action-container">
					<h3><?php echo $comp['comp_atts'][$type.'_title']; ?></h3>
					<div>
						<?php echo ($comp['comp_atts']['content_area']==='before')? do_shortcode($comp['comp_atts']['content']):'' ; ?>
						
							<form action="<?php echo $comp['comp_action_url'][$type]; ?>" method="post">

								<?php if($type==='login'): ?>

									<div class="fields-group"> 
										<input type="email" name="userEmail" class="input f-required" value="" placeholder="Email">
									</div>
									<div class="fields-group">
										<input type="password" name="passWord" class="input f-required" value="" placeholder="Password" >
									</div>

								<?php else: ?>

									<div class="fields-group"> 
										<input type="text" name="userName"  class="input f-required" value="" placeholder="Nombre">
									</div>
									<div class="fields-group"> 
										<input type="text" name="userLastName"  class="input f-required" value="" placeholder="Apellido">
									</div>
									<div class="fields-group">
										<input type="email" name="userEmail" class="input f-required" value="" placeholder="Email">
									</div>

								<?php endif; ?>
								
								<div class="fields-group condition-group">
									<label class="check-field">
										<input name="rememberMe" type="checkbox" value="forever" checked="checked">
										<span>Remember Me</span>
									</label>
									<label class="check-field">
										<input class="f-required" name="terms-and-conditions" type="checkbox">
										<span>Terminos y Condiciones</span>
									</label>
								</div>
								<div class="field-submit">
									<input type="submit" name="wp-submit"class="button-primary" value="<?php echo $comp['comp_atts']['button'] ?>">
									<input type="hidden" name="redirect_to" value="<?php echo get_home_url(); ?>">
								</div>

								<div class="mmesage-area"></div>

								<div class="bind-area">
									<span><?php echo $comp['comp_atts'][$fval['bind'].'_text']; ?></span>
								</div>
										
							</form>

						<?php echo ($comp['comp_atts']['content_area']==='after')? do_shortcode($comp['comp_atts']['content']):'' ; ?>
					</div>
				</div>

			</div>
		

		<?php endforeach; ?>
		

	</div>
	<?php if($comp['comp_atts']['template']==='modal'): ?>
		<div class="mdl-closer-handler"></div>
	<?php endif; ?>
</div>