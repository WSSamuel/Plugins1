<?php
// Settings page partial
?>
<div class="wrap ric">
    <h2><?php echo RIC::plugin_name(); ?></h2>
    
    <p><?php
		$shortcodes = RIC::shortcodes();
        
		printf(
			__('Thank you for using Responsive Investment Calculator. Add the calculator widget from the Widgets page, or add it to a page or post using the shortcode %1$s or %2$s.', RIC::text_domain() ),
			'<b>[' . $shortcodes[0] . ']</b>',
			'<b>[' . $shortcodes[1] . ']</b>'
		);
	
	?></p>
    
    <form action="options.php" method="post" enctype="multipart/form-data">
        
    <?php
        do_settings_sections( RIC::option_name() );
        settings_fields( RIC::option_name() );
        submit_button();
    ?>

    <input type="hidden" name="page" value="<?php echo RIC::option_name(); ?>" />
    </form>
    
</div><!-- .wrap -->
