<?php

/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       https://wphelpful.com
 * @since      1.0.0
 *
 * @package    WPHelpful
 * @subpackage WPHelpful/admin/partials
 */

$active_tab = isset( $_GET[ 'tab' ] ) ? $_GET[ 'tab' ] : 'general';

?>

<div class="wphelpful-settings wrap">
  
  <h1><a href="https://wphelpful.com" target="_blank"><?php printf('<img src="%1$s" alt="WPHelpful" width="30px" />', plugins_url( '/images/wph.png', dirname(__FILE__) ) ); ?></a></h1>

  <nav class="nav-tab-wrapper">
    <a href="?page=wphelpful&amp;tab=general" class="nav-tab<?php echo $active_tab == 'general' ? ' nav-tab-active' : ''; ?>">General</a>
    <a href="?page=wphelpful&amp;tab=colors" class="nav-tab<?php echo $active_tab == 'colors' ? ' nav-tab-active' : ''; ?>">Colors</a>
    <a href="?page=wphelpful&amp;tab=copy" class="nav-tab<?php echo $active_tab == 'copy' ? ' nav-tab-active' : ''; ?>">Copy</a>
    <a href="?page=wphelpful&amp;tab=advanced" class="nav-tab<?php echo $active_tab == 'advanced' ? ' nav-tab-active' : ''; ?>">Advanced</a>
  </nav>

  <div class="content">
    <form action="options.php" method="post">
      <?php
        
        settings_fields( $this->plugin_name . '_' . $active_tab );
        do_settings_sections( $this->plugin_name . '_' . $active_tab );
        submit_button();

      ?>
    </form>
  </div>

  <hr>
  <?php if ( !wpcomplete_is_installed() ) : ?>
  <p>If you like WPHelpful, please checkout our other plugin, <a href="https://wpcomplete.co" target="_blank">WPComplete</a>.</p>
  <?php else : ?>
  <p>If you like WPHelpful, please <a href="https://wordpress.org/support/view/plugin-reviews/wphelpful">leave us a ★★★★★ rating</a>. Your votes really make a difference! Thanks.</p>
  <?php endif; ?>

</div>
