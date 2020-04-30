<?php $img = wp_get_attachment_image_src($atts['mask_img'],'full'); ?>
<div class="daim-standar-mask" style="background-image: url('<?php echo $img[0]; ?>')">
	<div style="background-color: <?php echo $atts['mask_color']; ?>"></div>
</div>