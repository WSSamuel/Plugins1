
  <input type="hidden" name="<?php echo $this->plugin_name . '_show_feedback'; ?>" value="always"> 
  <label class="radio-label">
    <input type="radio" name="<?php echo $this->plugin_name . '_show_feedback'; ?>" value="always" <?php checked( $is_enabled, 'always' ); ?><?php if ($disabled) echo " disabled" ?>> 
    <?php echo __("Always", $this->plugin_name); ?>
  </label>
  <label class="radio-label">
    <input type="radio" name="<?php echo $this->plugin_name . '_show_feedback'; ?>" value="after_rating" <?php checked( $is_enabled, 'after_rating' ); ?><?php if ($disabled) echo " disabled" ?>> 
    <?php echo __("After rating is selected", $this->plugin_name); ?>
  </label>
  <label class="radio-label">
    <input type="radio" name="<?php echo $this->plugin_name . '_show_feedback'; ?>" value="never" <?php checked( $is_enabled, 'never' ); ?><?php if ($disabled) echo " disabled" ?>> 
    <?php echo __("Never", $this->plugin_name); ?>
  </label>
