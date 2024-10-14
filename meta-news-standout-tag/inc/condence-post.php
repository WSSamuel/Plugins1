<?php 
function condence_post_meta_tags() {
	if (is_single()){ 
		echo '<meta name="news_keywords" content="'.get_post_meta(get_the_id(), "condence_metabox_tags", true).'">'; 
		if (get_post_meta(get_the_id(), "condence_metabox_standout", true) == 1) {
			echo '<meta name="standout" content="'.get_permalink().'"/>'; 
		}
	}
}
add_action('wp_head', 'condence_post_meta_tags', 1);
?>