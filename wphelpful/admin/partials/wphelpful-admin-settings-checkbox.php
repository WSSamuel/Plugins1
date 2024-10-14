  
  </td>
</table>
<table style="margin-top: -20px;">
  <tbody>
    <tr>
      <td>
    <div class="wphelpful-checkbox-container">
      <input type="hidden" name="<?php echo $name; ?>" value="false">
      <label>
        <input type="checkbox" name="<?php echo $name; ?>" id="<?php echo $name; ?>" value="true" <?php checked( 'true', $is_enabled ); ?><?php if ($disabled) echo " disabled" ?><?php if (isset($onchange)) echo ' onchange="' . $onchange . '"'; ?>> 
        <?php echo __($text, $this->plugin_name); ?>
      </label>
    </div>
