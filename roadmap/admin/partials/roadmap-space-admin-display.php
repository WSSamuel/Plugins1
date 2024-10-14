<div class="wrap">
  <h1><?php _e( 'Roadmap', 'roadmap-space' ); ?></h1>

  <form class="<?php echo $this->plugin_name; ?>_settings" method="post" action="options.php">
    <?php settings_fields("{$this->plugin_name}_options_group"); ?>

    <p><?php _e( 'Welcome to the Roadmap Wordpress plugin! With only a few options to setup, you\'ll be up and running in no time.', 'roadmap-space' ); ?></p>

    <p>
      <?php printf(
        /* translators: %s: code html tags. */
        __( 'After saving your Roadmap ID, you can use the %s[roadmap]%s shortcode to display your roadmap on any page or article.', 'roadmap-space' ),
        "<code>",
        "</code>"
      ); ?>
    </p>

    <p>
      <?php
      printf(
        /* translators: %s: a html tags. */
        __( 'To use this plugin, you need an active Roadmap account. Don\'t have one ? %sCreate one%s today!', 'roadmap-space' ),
        '<a href="https://roadmap.space/?utm_source=plugins&utm_medium=wordpress&utm_campaign=admin-signup" target="_blank">',
        '</a>'
      ); ?>
    </p>

    <table class="form-table" role="presentation">
      <tr valign="middle">
        <th scope="row"><label for="<?php echo $this->plugin_name; ?>_roadmap_id"><?php _e( 'Your Roadmap ID', 'roadmap-space' ); ?></label></th>
        <td>
          <input type="text" class="regular-text" id="<?php echo $this->plugin_name; ?>_roadmap_id" name="<?php echo $this->plugin_name; ?>_roadmap_id" value="<?php echo get_option("{$this->plugin_name}_roadmap_id"); ?>" />
          <p class="description" id="tagline-description"><?php _e( 'You can find your Roadmap ID <a href="https://app.roadmap.space/#/roadmap/widget" target="_blank">here</a>, at the bottom of the page.', 'roadmap-space' ); ?></p>
        </td>
      </tr>
      <tr valign="middle">
        <th scope="row"><label><?php _e( 'Feedback Widget', 'roadmap-space' ); ?></label></th>
        <td>
          <label for="<?php echo $this->plugin_name; ?>_feedback_widget_all">
            <input type="radio" id="<?php echo $this->plugin_name; ?>_feedback_widget_all" name="<?php echo $this->plugin_name; ?>_feedback_widget" value="all" <?php checked(get_option("{$this->plugin_name}_feedback_widget"), "all"); ?> />
            <?php _e( 'Show the Feedback Widget for connected users and visitors', 'roadmap-space' ); ?>
          </label><br>
          <label for="<?php echo $this->plugin_name; ?>_feedback_widget_logged-in">
            <input type="radio" id="<?php echo $this->plugin_name; ?>_feedback_widget_logged-in" name="<?php echo $this->plugin_name; ?>_feedback_widget" value="logged-in" <?php checked(get_option("{$this->plugin_name}_feedback_widget"), "logged-in"); ?> />
            <?php _e( 'Show the Feedback Widget for connected users only', 'roadmap-space' ); ?>
          </label><br>
          <label for="<?php echo $this->plugin_name; ?>_feedback_widget_none">
            <input type="radio" id="<?php echo $this->plugin_name; ?>_feedback_widget_none" name="<?php echo $this->plugin_name; ?>_feedback_widget" value="none" <?php checked(get_option("{$this->plugin_name}_feedback_widget"), "none"); ?> />
            <?php _e( 'Do not show the Feedback Widget', 'roadmap-space' ); ?>
          </label>
        </td>
      </tr>
    </table>

    <?php submit_button(); ?>

  </form>
</div>