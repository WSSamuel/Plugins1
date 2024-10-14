<?php if ( $column_name == 'wphelpful' ) { ?>
  <fieldset>
    <div class="inline-edit-col column-<?php echo $column_name; ?>">
      <label class="inline-edit-group">
        <?php wp_nonce_field( $this->plugin_name, 'wphelpful_nonce' ); ?>
        <input type="hidden" name="wphelpful[feedback]" value="false">
        <input type="checkbox" name="wphelpful[feedback]" value="true"><?php echo __( 'Yes, I want this page to show feedback.', $this->plugin_name ); ?>
      </label>
    </div>
  </fieldset>
<?php } ?>
