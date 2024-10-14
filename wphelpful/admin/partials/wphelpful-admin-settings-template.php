
  <input type="hidden" name="<?php echo $this->plugin_name . '_template'; ?>" value="emojis"> 
  <label class="radio-label">
    <input type="radio" name="<?php echo $this->plugin_name . '_template'; ?>" value="emojis" <?php checked( $is_enabled, 'emojis' ); ?><?php if ($disabled) echo " disabled" ?>> 
    <?php echo __("Emojis", $this->plugin_name); ?>
  </label>
  <label class="radio-label">
    <input type="radio" name="<?php echo $this->plugin_name . '_template'; ?>" value="stars" <?php checked( $is_enabled, 'stars' ); ?><?php if ($disabled) echo " disabled" ?>> 
    <?php echo __("Stars", $this->plugin_name); ?>
  </label>
  <label class="radio-label">
    <input type="radio" name="<?php echo $this->plugin_name . '_template'; ?>" value="simple" <?php checked( $is_enabled, 'simple' ); ?><?php if ($disabled) echo " disabled" ?>> 
    <?php echo __("Yes/No", $this->plugin_name); ?>
  </label>
