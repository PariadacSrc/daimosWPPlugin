<?php

    use Daim\Helpers\mainHelper;

    $args = apply_filters('prepare_'.$this->getCodeName().'_query_args',[],$atts);
    $query = new WP_Query( $args );

    $diffItems = ($atts['post_limit']==$atts['show_item'])? 1:0;
    $postCount = count($query->posts)-$atts['show_item'];

    $itemHash = $atts['main_template'].'_'.$atts['id_css'];
?>

<section class="daim-container-standar <?php echo esc_html($atts['class_css']); ?>" 
    <?php echo (strlen($atts['id_css'])>0)?'id="'.esc_html($atts['id_css']).'"':''; ?>
    >				
	<div    class="daim-slider-standar" 
            data-showitems="<?php echo $atts['show_item']; ?>" 
            data-diffitems="<?php echo $diffItems; ?>"
            data-postcount="<?php echo $postCount; ?>"
            data-custom-settings="<?php echo 'setting_'.$itemHash; ?>"
            data-custom-actions="<?php echo 'action_'.$itemHash; ?>"
    >

		<?php

		    if ( $query->have_posts() ) {
		        
		        while ( $query->have_posts() ) {
		            $query->the_post();
		            $post = get_post();

		            //Main Data
                    $gridContent = array(
                        'comp_prefix'       => $this->getCodeName(),
                        'comp_post_obj'     => $post,
                        'comp_template'     => $atts['main_template'],
                        'comp_post_title'   => $post->post_title,
                        'comp_post_content' => (strlen($atts['meta_key'])===0)?$post->post_content:get_post_meta($post->ID,$atts['meta_key'],true),
                        'comp_post_img'     => get_the_post_thumbnail_url( $post->ID, 'full' ),
                        'comp_post_dates'   => mainHelper::getCustomDate($atts,$post),
                        'comp_post_link'    => array('include' => $atts['include_link'])
                    );

                    if(sliderGeneric::getExtraButton($atts,$post)){
                        $gridContent['comp_post_link']['link_text'] = __('Read More',UER_TXT_DOMAIN);
                        $gridContent['comp_post_link']['url']       = sliderGeneric::getExtraButton($atts,$post);
                        $gridContent['comp_post_link']['extra_btn'] = sliderGeneric::getCustomUrl($atts,$post);
                        $gridContent['comp_post_link']['extra_btn_text'] = $atts['custom_url_text'];
                    }else{
                        $gridContent['comp_post_link']['link_text'] = $atts['custom_url_text'];
                        $gridContent['comp_post_link']['url']       = sliderGeneric::getCustomUrl($atts,$post);
                    }

                    $gridContent = (object) $gridContent;

                    do_action(DAIM_PRFX.'internal_template',$gridContent);

		        }
		        
		        wp_reset_postdata();
		        $post = get_post();
		    }

		?>

	</div>
</section>