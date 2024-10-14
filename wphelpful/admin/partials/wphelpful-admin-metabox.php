
  <p>
    <input type="hidden" name="wphelpful[feedback]" value="false">
    <label><input type="checkbox" id="feedback" name="wphelpful[feedback]" value="true"<?php if ($feedback) echo " checked"; ?> onclick="jQuery('#feedback-enabled').toggle();"><?php echo __( 'Yes, I want to show feedback widget on this page.', $this->plugin_name ); ?></label>
  </p>

  <div id="feedback-enabled"<?php if (!$feedback) echo " style='display:none;'"; ?>>
    <p style="margin-top: -10px;"><em><small>
      If you do not include the shortcode <code>[wphelpful]</code> anywhere inside your page content, we will auto append your feedback widget at the end of the content.
    </small></em></p>
  </div>  
