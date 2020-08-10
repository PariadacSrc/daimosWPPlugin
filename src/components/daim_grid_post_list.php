<?php
    
    use Daim\Helpers\mainHelper;

    $args = apply_filters('prepare_'.$this->getCodeName().'_query_args',[],$atts);

    $query = new WP_Query( $args );

    $mdCount = ceil($atts['post_per_row']/2);
    $smCount = ceil($mdCount/2);
?>

<section class="daim-grid-post-list daim-flx-row <?php echo esc_html($atts['class_css']); ?>" 
    <?php echo (strlen($atts['id_css'])>0)?'id="'.esc_html($atts['id_css']).'"':''; ?>
    >
    <div class="flx-col-12">
        
        <div class="daim-flx-row flx-cols-<?php echo $atts['post_per_row']; ?>  flx-cols-md-<?php echo $mdCount; ?> flx-cols-sm-<?php echo $smCount; ?> flx-cols-xs-1">
            
            <?php

                if ( $query->have_posts() ) {
                    
                    while ( $query->have_posts() ) {
                        $query->the_post();
                        $post = get_post();

                        //Main Data
                        $gridContent = (object) array(
                            'comp_prefix'       => $this->getCodeName(),
                            'comp_post_obj'     => $post,
                            'comp_template'     => $atts['main_template'],
                            'comp_post_title'   => $post->post_title,
                            'comp_post_content' => (strlen($atts['meta_key'])===0)?$post->post_content:get_post_meta($post->ID,$atts['meta_key'],true),
                            'comp_post_img'     => get_the_post_thumbnail_url( $post->ID, 'full' ),
                            'comp_post_dates'   => mainHelper::getCustomDate($atts,$post),
                            'comp_post_link'    => array(
                                'include' => $atts['include_link'],
                                'text'    => $atts['custom_url_text'],
                                'url'     => get_permalink($post->ID)
                            )
                        );

                        do_action(DAIM_PRFX.'internal_template',$gridContent);

                    }
                    
                    wp_reset_postdata();
                    $post = get_post();
                }

            ?>

        </div>

    </div>
</section>
