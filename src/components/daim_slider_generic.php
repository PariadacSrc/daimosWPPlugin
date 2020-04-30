<?php

    $args = array(
        'post_type' => $atts['post_type'],
        'orderby'   => 'date',
        'posts_per_page' => $atts['post_limit']
    );


    $categoryList = explode(',', $atts['cat_list']);
    if(count($categoryList)>0 && trim(strlen($atts['cat_list']))>0):

        $taxQuery = array('relation'=>'AND');

        $taxQuery[]= array(
            'taxonomy' => 'category',
            'field'    => 'slug',
            'terms'    => $categoryList,
        );

        $args['tax_query']=$taxQuery;

    endif;

    $query = new WP_Query( $args );

    $diffItems = ($atts['post_limit']==$atts['show_item'])? 1:0;
    $postCount = count($query->posts)-$atts['show_item'];

?>

<section class="daim-container-standar">				
	<div   class="daim-slider-standar" 
            data-showitems="<?php echo $atts['show_item']; ?>" 
            data-diffitems="<?php echo $diffItems; ?>"
            data-postcount="<?php echo $postCount; ?>"
    >

		<?php

		    if ( $query->have_posts() ) {
		        
		        while ( $query->have_posts() ) {
		            $query->the_post();
		            $post = get_post();

		            //Main Data
		            $comp_post_title 	= $post->post_title;
                    $comp_post_content  = (strlen($atts['meta_key'])===0)?do_shortcode($post->post_content):get_post_meta($post->ID,$atts['meta_key'],true);

					$comp_post_img 		= get_the_post_thumbnail_url( $post->ID, 'full' );
    				$comp_post_dates 	= mainHelper::getCustomDate($atts,$post);
                    $comp_post_bool_link= $atts['include_link'];
    				

                    if(sliderGeneric::getExtraButton($atts,$post)){
                        $comp_post_link_text= __('Read More',UER_TXT_DOMAIN);
                        $comp_post_url      = sliderGeneric::getExtraButton($atts,$post);
                        $comp_post_extra_btn = sliderGeneric::getCustomUrl($atts,$post);
                        $comp_post_extra_btn_text = $atts['custom_url_text'];
                    }else{
                        $comp_post_link_text= $atts['custom_url_text'];
                        $comp_post_url      = sliderGeneric::getCustomUrl($atts,$post);
                    }

					?> 
						<div><?php include(DAIM__DEFAULT_COMP_FOLDER.'blocks/slider_post_template_'.$atts['main_template'].'.php'); ?></div> 
					<?php

		        }
		        
		        wp_reset_postdata();
		        $post = get_post();
		    }

		?>

	</div>
</section>