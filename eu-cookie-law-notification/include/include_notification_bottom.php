<div id="cookie-notification-jc-<?php echo $position; ?>" class="cookie-notification-jc" style="display:block; position:fixed; background-color: rgba(30, 30, 30, <?php echo $background_opacity; ?>);">
	<div style="width:<?php echo $notification_width; ?>; margin: 0 auto;">
   		<p><?php echo $notification_text; ?></p>
        <div class="cookie-notification-jc-buttons">
        	<div class="cookie-notification-jc-accept"><?php echo $accept_text; ?></div>
        	<div class="cookie-notification-jc-details"><a href="<?php echo get_page_link( $details_page_id ); ?>"><?php echo $link_text_to_details; ?></a></div>
        </div>
    </div>
</div>