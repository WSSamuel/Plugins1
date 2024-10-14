<?php
$cta_box_button_link = get_post_meta($atts['id'], 'cta_box_button_link', true);
$cta_box_description = get_post_meta($atts['id'], 'cta_box_description', true);
$cta_box_button_id = get_post_meta($atts['id'], 'cta_box_button_id', true);
$cta_box_button_text = get_post_meta($atts['id'], 'cta_box_button_text', true);
?>
<div class="cta_wrap cta_tem_one container">

	<div class="cta_title">
		<h3 class="boxtittle"><?php echo get_the_title( $atts['id'] ) ?></h3>
	</div>
	
	<div class="cta_des">
		<p><?php echo $cta_box_description ?></p>
	</div>
	
	<div class="cta_bbtn">
		<a id="<?php echo $cta_box_button_id ?>" class="cta_box_btn" href="<?php echo $cta_box_button_link ?>"><?php echo $cta_box_button_text ?></a>
	</div>
	
</div>