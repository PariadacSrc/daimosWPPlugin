<?php  /* Template Name: Daimos (Single Page)*/  global $wp, $post; ?>

<?php add_filter('get_daim_header_settings',function($arg){ return array_merge($arg,['daim-temp-single-page']); },10,1); ?>

<?php get_header(); ?>

<?php
    //Reference the main block Loop
    if(have_posts()):
        while ( have_posts() ): the_post();
        	?>
				
				<section class="daim-body-container daim-page-id-<?php echo $post->ID; ?>">
					<div class="daim-header-section">
						<?php do_action('daim_post_header',$post->ID); ?>
					</div>
			 		<div class="daim-container">
			 			<?php the_content(); ?>
			 		</div>
			 		<div class="daim-footer-section">
						<?php do_action('daim_post_footer',$post->ID); ?>
					</div>
			 	</section>

        	<?php

        endwhile;
        wp_reset_postdata();
    endif;
?>

<?php get_footer(); ?>