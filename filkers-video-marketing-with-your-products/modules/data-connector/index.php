<?php

$filkers_init = new filkers_init();
$filkers_init->filkers_hooks();

class filkers_init{
	public function filkers_hooks(){
    register_activation_hook(__FILE__, [$this, 'filkers_activate']);
    register_deactivation_hook(__FILE__, [$this, 'filkers_deactivate']);

    add_action('wp_enqueue_scripts', [$this, 'filkers_enqueue_scripts_and_styles'], 20, 1);
    add_action('admin_enqueue_scripts', [$this, 'filkers_enqueue_scripts_and_styles'], 20, 1);
    add_action('wp', [$this, 'filkers_cron_schedule']);
    add_action('admin_footer', [$this, 'filkers_footer']);
    add_action('filkers_cron_five_minutes', [$this, 'filkers_cron_five_minutes_function']);
    add_action('save_post_product', [$this,'filkers_save_post_product'], 10, 2);
    add_action('admin_notices', [$this,'filkers_admin_notices']);
    add_action('admin_menu', [$this, 'filkers_admin_dashboard_menu_edition']);
    add_action('plugins_loaded', [$this, 'filkers_textdomain']);
    add_action('activated_plugin',[$this, 'filkers_activated_plugin']);
    add_action('woocommerce_settings_save_advanced', [$this, 'filkers_update_option_filkers_api'], 99, 2);
    add_action('wp_ajax_filker_ajax', [$this, 'filker_ajax_server']);

    add_filter('cron_schedules', [$this, 'filkers_cron_five_minutes_schedule']);
    add_filter('woocommerce_get_sections_advanced', [$this, 'filkers_woocommerce_get_sections_advanced']);
    add_filter('woocommerce_get_settings_advanced', [$this, 'filkers_woocommerce_get_settings_advanced'], 10, 2);
  }

  public function filker_ajax_server() {
    foreach ($_POST as $key => $value) {
      ${$key} = $value;
    }

    switch ($sub_action) {
      case 'filker_ajax_variations_updated':
        $this->filkers_request_post_item_change([$filkers_product_id]);
        update_user_meta(1, 'wph_dev_var_filkerssss', $filkers_product_id);
        echo 'filker_ajax_variations_updated_success';exit();
        break;
    }
  }

  public function filkers_activated_plugin($plugin) {
    if($plugin == plugin_basename(__FILE__)) {
      exit(wp_redirect(admin_url('/admin.php?page=filkers_menu_main')));
    }
  }

  public function filkers_activate(){
    delete_option('filkers_api_key_id');
    delete_option('filkers_api_debug_key_id');
  }

  public function filkers_deactivate(){
    delete_option('filkers_api_key_id');
    delete_option('filkers_api_connection_errors_register');
    delete_option('filkers_api_connection_errors_item_change_ids');
    delete_option('filkers_api_connection_errors_item_change');
    delete_option('filkers_api_connection_checkbox');
    delete_option('filkers_api_connection_response');
    delete_option('filkers_api_connection_appid');
    delete_option('filkers_api_connection_appsecret');

    delete_option('filkers_api_debug_key_id');
    delete_option('filkers_api_debug_connection_errors_register');
    delete_option('filkers_api_debug_connection_errors_item_change_ids');
    delete_option('filkers_api_debug_connection_errors_item_change');
    delete_option('filkers_api_debug_connection_checkbox');
    delete_option('filkers_api_debug_checkbox');
    delete_option('filkers_api_debug_connection_response');
  }

  public function filkers_update_option_filkers_api(){
    $this->filkers_request_post_register();
  }

	public function filkers_textdomain() {
    load_plugin_textdomain('filkers-video-marketing-with-your-products', false, dirname(plugin_basename(__FILE__)) . '/languages');
  }

  public function get_remote_server() {
     return (get_option('filkers_api_debug_checkbox') === 'yes') ?
        'https://integracion-front.filkers.ovxtest.com'
        : 'https://apirest.filkers.com';
  }

  public function filkers_request_post_register() {
    /* echo $this->filkers_request_post_register(); */
    global $wpdb;

    if (get_option('filkers_api_debug_checkbox') == 'no' || empty(get_option('filkers_api_debug_checkbox'))) {
      if (!empty(get_option('filkers_api_key_id'))) {
        $wpdb->delete($wpdb->prefix . 'woocommerce_api_keys', ['key_id' => get_option('filkers_api_key_id'),]);
      }

      $consumer_key = 'ck_' . wc_rand_hash();
      $consumer_secret = 'cs_' . wc_rand_hash();
      $user_id = get_current_user_id();
      $description = 'Filkers API';
      $permissions = 'read';

      $wpdb->insert($wpdb->prefix . 'woocommerce_api_keys', [
        'user_id'         => $user_id,
        'description'     => $description,
        'permissions'     => $permissions,
        'consumer_key'    => wc_api_hash($consumer_key),
        'consumer_secret' => $consumer_secret,
        'truncated_key'   => substr($consumer_key, -7),
      ]);

      update_option('filkers_api_key_id', $wpdb->insert_id);

      $remote_server =  $this->get_remote_server();
      $remote_endpoint = 'register';
      $remote_url = $remote_server . '/api/data/v1/woo/' . $remote_endpoint;

      $response = wp_remote_post($remote_url, [
        'method'      => 'POST',
        'timeout'     => 45,
        'redirection' => 5,
        'httpversion' => '1.0',
        'blocking'    => true,
        'headers'     => [
          'Content-Type'  => 'application/json',
        ],
        'body'        => json_encode([
          'appId'         => get_option('filkers_api_connection_appid'),
          'appSecret'     => get_option('filkers_api_connection_appsecret'),
          'url'           => get_bloginfo('url'),
          'wooApiKey'     => $consumer_key,
          'wooApiSecret'  => $consumer_secret,
          'wooCurrency'  => get_option('woocommerce_currency'),
          'wooTimezone'  => wp_timezone_string(),
          'wooLocale'  => get_locale(),
        ]),
        'cookies'     => [],
      ]);

      if (is_wp_error($response)) {
        update_option('filkers_api_connection_errors_register', $response);
        /*return $response;*/
      }else{
        if ($response['response']['code'] == 200) {
          delete_option('filkers_api_connection_errors_register');
          /*return $response['response']['code'];*/
        }else{
          update_option('filkers_api_connection_errors_register', $response);
          /*return $response;*/
        }
      }
      
      update_option('filkers_api_connection_response', $response);
    }elseif (get_option('filkers_api_debug_checkbox') == 'yes'){
      if (!empty(get_option('filkers_api_debug_key_id'))) {
        $wpdb->delete($wpdb->prefix . 'woocommerce_api_keys', ['key_id' => get_option('filkers_api_debug_key_id'),]);
      }

      $consumer_key = 'ck_' . wc_rand_hash();
      $consumer_secret = 'cs_' . wc_rand_hash();
      $user_id = get_current_user_id();
      $description = 'Filkers Debug API';
      $permissions = 'read';

      $wpdb->insert($wpdb->prefix . 'woocommerce_api_keys', [
        'user_id'         => $user_id,
        'description'     => $description,
        'permissions'     => $permissions,
        'consumer_key'    => wc_api_hash($consumer_key),
        'consumer_secret' => $consumer_secret,
        'truncated_key'   => substr($consumer_key, -7),
      ]);

      update_option('filkers_api_debug_key_id', $wpdb->insert_id);

      $remote_server =  $this->get_remote_server();
      $remote_endpoint = 'register';
      $remote_url = $remote_server . '/api/data/v1/woo/' . $remote_endpoint;

      $response = wp_remote_post($remote_url, [
        'method'      => 'POST',
        'timeout'     => 45,
        'redirection' => 5,
        'httpversion' => '1.0',
        'blocking'    => true,
        'headers'     => [
          'Content-Type'  => 'application/json',
        ],
        'body'        => json_encode([
          'appId'         => get_option('filkers_api_connection_appid'),
          'appSecret'     => get_option('filkers_api_connection_appsecret'),
          'url'           => get_bloginfo('url'),
          'wooApiKey'     => $consumer_key,
          'wooApiSecret'  => $consumer_secret,
          'wooCurrency'  => get_option('woocommerce_currency'),
          'wooTimezone'  => wp_timezone_string(),
        ]),
        'cookies'     => [],
      ]);

      if (is_wp_error($response)) {
        update_option('filkers_api_debug_connection_errors_register', $response);
        /*return $response;*/
      }else{
        if ($response['response']['code'] == 200) {
          delete_option('filkers_api_debug_connection_errors_register');
          /*return $response['response']['code'];*/
        }else{
          update_option('filkers_api_debug_connection_errors_register', $response);
          /*return $response;*/
        }
      }
      update_option('filkers_api_debug_connection_response', $response);
    }
  }

  public function filkers_request_post_item_change($item_array) {
    /* echo $this->filkers_request_post_item_change(); */

    $remote_server =  $this->get_remote_server();
    $remote_endpoint = 'item/change';
    $remote_url = $remote_server . '/api/data/v1/woo/' . $remote_endpoint;

    $response = wp_remote_post($remote_url, [
      'method'      => 'POST',
      'timeout'     => 10,
      'redirection' => 5,
      'httpversion' => '1.0',
      'blocking'    => true,
      'headers'     => [
        'Content-Type'  => 'application/json',
      ],
      'body'        => json_encode([
        'appId'         => get_option('filkers_api_connection_appid'),
        'appSecret'     => get_option('filkers_api_connection_appsecret'),
        'url'           => get_bloginfo('url'),
        'wooCurrency'  => get_option('woocommerce_currency'),
        'wooTimezone'  => wp_timezone_string(),
        'itemIds'       => $item_array,
      ]),
      'cookies'     => [],
    ]);

    if (is_wp_error($response) || $response['response']['code'] != 200) {
      update_option('filkers_api_connection_errors_item_change', $response);

      $filkers_meta_value = $item_array[0];
      if(empty(get_option('filkers_api_connection_errors_item_change_ids'))) {
        update_option('filkers_api_connection_errors_item_change_ids', [$filkers_meta_value]);
      }else{
        $filkers_option_new = get_option('filkers_api_connection_errors_item_change_ids', true);
        $filkers_option_new[] = $filkers_meta_value;
        update_option('filkers_api_connection_errors_item_change_ids', array_unique($filkers_option_new));
      }

      return $response;
    }else{
      if (empty(get_option('filkers_api_connection_errors_item_change_ids'))) {
        update_option('filkers_api_connection_errors_item_change', '');
      }else{
        $filkers_option_new = get_option('filkers_api_connection_errors_item_change_ids', true);
        esc_html_e('<pre> filkers_option_new: ');esc_html_e($filkers_option_new);esc_html_e('</pre><br>');
        unset($filkers_option_new[array_search($item_array[0], $filkers_option_new)]);
        esc_html_e('<pre> filkers_option_new: ');esc_html_e($filkers_option_new);esc_html_e('</pre><br>');
        update_option('filkers_api_connection_errors_item_change_ids', array_unique($filkers_option_new));
      }
                
      return $response['response']['code'];
    }


    return $response['response']['code'];
  }

  public function filkers_menu_main($atts) {
    /* echo do_shortcode('[filkers-test filkers_user_id="1"]'); */
    $a = extract(shortcode_atts([
      'filkers_user_id' => get_current_user_id(),
    ], $atts));

    ob_start();
    ?>
      <div class="filkers-welcome filkers-mt-50">
        <div class="filkers-text-align-center filkers-mb-30 filkers-max-width-200 filkers-margin-auto">
          <img src="<?php echo plugin_dir_url(__FILE__) . 'assets/icon-128x128.png'; ?>" alt="<?php _e('Filkers logo', 'filkers-video-marketing-with-your-products'); ?>">
        </div>
        <h2 class="filkers-font-size-30 filkers-text-align-center filkers-line-height-50"><?php _e('Connect your store and boost your business', 'filkers-video-marketing-with-your-products'); ?></h2>

        <div class="filkers-text-align-center filkers-max-width-800 filkers-margin-auto filkers-mb-50">
          <p class="filkers-font-size-15 filkers-font-weight-bold filkers-mb-30 filkers-line-height-25"><?php _e('Access thousands of designs to improve your conversions and bring your product to many more customers. Everything you need to convert and sell more.', 'filkers-video-marketing-with-your-products'); ?></p>
          <p class="filkers-font-size-15 filkers-font-weight-bold filkers-mb-30 filkers-line-height-25">* <?php _e('Filkers only works under the secure https protocol', 'filkers-video-marketing-with-your-products'); ?></p>
          <?php if (class_exists('woocommerce')): ?>
            <a href="<?php echo admin_url('/admin.php?page=wc-settings&tab=advanced&section=filkers_api_section'); ?>" class="filkers-btn"><?php _e('Connect your API', 'filkers-video-marketing-with-your-products'); ?></a>
          <?php else: ?>
            <a href="<?php echo admin_url('/plugin-install.php?s=woocommerce&tab=search&type=term'); ?>" class="filkers-btn"><?php _e('Install WooCommerce', 'filkers-video-marketing-with-your-products'); ?></a>
          <?php endif ?>
        </div>

        <div class="filkers-display-table filkers-width-100-percent filkers-text-align-center filkers-mb-30 filkers-margin-auto
        ">
          <div class="filkers-display-inline-table filkers-width-33-percent filkers-tablet-display-block filkers-tablet-width-100-percent">
            <img class="filkers-max-width-100" src="<?php echo plugin_dir_url(__FILE__) . 'assets/connect-2.gif'; ?>" alt="<?php _e('Immediate connection', 'filkers-video-marketing-with-your-products'); ?>">
            <h4 class="filkers-font-size-25 filkers-mb-10 filkers-font-weight-bold"><?php _e('Immediate connection', 'filkers-video-marketing-with-your-products'); ?></h4>
            <p class="filkers-font-size-14 filkers-p-10"><?php _e('with the images and data of your products', 'filkers-video-marketing-with-your-products'); ?></p>
          </div>
          <div class="filkers-display-inline-table filkers-width-33-percent filkers-tablet-display-block filkers-tablet-width-100-percent">
            <img class="filkers-max-width-100" src="<?php echo plugin_dir_url(__FILE__) . 'assets/sync-2.gif'; ?>" alt="<?php _e('Automatic sync', 'filkers-video-marketing-with-your-products'); ?>">
            <h4 class="filkers-font-size-25 filkers-mb-10 filkers-font-weight-bold"><?php _e('Automatic sync', 'filkers-video-marketing-with-your-products'); ?></h4>
            <p class="filkers-font-size-14 filkers-p-10"><?php _e('when updating your products or adding new references', 'filkers-video-marketing-with-your-products'); ?></p>
          </div>
          <div class="filkers-display-inline-table filkers-width-33-percent filkers-tablet-display-block filkers-tablet-width-100-percent">
            <img class="filkers-max-width-100" src="<?php echo plugin_dir_url(__FILE__) . 'assets/video-2.gif'; ?>" alt="<?php _e('Unlimited creativity', 'filkers-video-marketing-with-your-products'); ?>">
            <h4 class="filkers-font-size-25 filkers-mb-10 filkers-font-weight-bold"><?php _e('Unlimited creativity', 'filkers-video-marketing-with-your-products'); ?></h4>
            <p class="filkers-font-size-14 filkers-p-10"><?php _e('with thousands of templates to promote your products in a personalized way', 'filkers-video-marketing-with-your-products'); ?></p>
          </div>
        </div>
      </div>
    <?php
    $filkers_return_string = ob_get_contents(); 
    ob_end_clean(); 
    echo $filkers_return_string;
  }

  public function filkers_admin_notices() {
    if ((isset($_GET['page']) && $_GET['page'] == 'wc-settings') && (isset($_GET['tab']) && $_GET['tab'] == 'advanced') && (isset($_GET['section']) && $_GET['section'] == 'filkers_api_section') && get_option('filkers_api_connection_checkbox') == 'yes') {
      if (get_option('filkers_api_debug_checkbox') == 'no' || empty(get_option('filkers_api_debug_checkbox'))) {
        if (empty(get_option('filkers_api_connection_errors_register')) && !empty(get_option('filkers_api_connection_appid')) && !empty(get_option('filkers_api_connection_appsecret'))) {
          ?>
            <div class="notice notice-success is-dismissible">
              <p><?php _e('Filkers API is connected', 'filkers-video-marketing-with-your-products'); ?></p>
            </div>
          <?php
        }elseif (!empty(get_option('filkers_api_connection_errors_register')) && !empty(get_option('filkers_api_connection_appid'))) {
          ?>
            <div class="notice notice-error">
              <div class="filkers-toggle-wrapper">
                <p class="filkers-toggle filkers-cursor-pointer"><?php _e('Filkers API - An error has ocurred.', 'filkers-video-marketing-with-your-products'); ?> <small class="filkers-ml-50"><?php _e('Click for more information', 'filkers-video-marketing-with-your-products'); ?></small> <i class="material-icons filkers-float-right">keyboard_arrow_down</i></p>

                <div class="filkers-content filkers-toggle-content filkers-display-none-soft">
                  <pre><?php esc_html_e(print_r(get_option('filkers_api_connection_errors_register'))); ?></pre>
                </div>
              </div>
            </div>
          <?php
        }else{
          ?>
            <div class="notice notice-warning">      
              <p><?php _e('Filkers API is not connected', 'filkers-video-marketing-with-your-products'); ?></p>
            </div>
          <?php
        }
      }elseif (get_option('filkers_api_debug_checkbox') == 'yes'){
        if (empty(get_option('filkers_api_debug_connection_errors_register')) && !empty(get_option('filkers_api_connection_appid')) && !empty(get_option('filkers_api_connection_appsecret'))) {
          ?>
            <div class="notice notice-success is-dismissible">
              <p><?php _e('Filkers Debug API is connected', 'filkers-video-marketing-with-your-products'); ?></p>
            </div>
          <?php
        }elseif (!empty(get_option('filkers_api_debug_connection_errors_register')) && !empty(get_option('filkers_api_connection_appid'))) {
          ?>
            <div class="notice notice-error">
              <div class="filkers-toggle-wrapper">
                <p class="filkers-toggle filkers-cursor-pointer"><?php _e('Debug Filkers API - An error has ocurred.', 'filkers-video-marketing-with-your-products'); ?> <small class="filkers-ml-50"><?php _e('Click for more information', 'filkers-video-marketing-with-your-products'); ?></small> <i class="material-icons filkers-float-right">keyboard_arrow_down</i></p>

                <div class="filkers-content filkers-toggle-content filkers-display-none-soft">
                  <pre><?php esc_html_e(print_r(get_option('filkers_api_debug_connection_errors_register'))); ?></pre>
                </div>
              </div>
            </div>
          <?php
        }else{
          ?>
            <div class="notice notice-warning">      
              <p><?php _e('Filkers Debug API is not connected', 'filkers-video-marketing-with-your-products'); ?></p>
            </div>
          <?php
        }
      }

      if (!empty(get_option('filkers_api_connection_errors_item_change')) && ((isset($_GET['debug']) && $_GET['debug'] == 'true') || get_option('filkers_api_debug_checkbox') == 'yes')) {
        ?>
          <div class="notice notice-error">
            <div class="filkers-toggle-wrapper">
              <p class="filkers-toggle filkers-cursor-pointer"><?php _e('Filkers API - Product synchronization - An error has ocurred.', 'filkers-video-marketing-with-your-products'); ?> <small class="filkers-ml-50"><?php _e('Click for more information', 'filkers-video-marketing-with-your-products'); ?></small> <i class="material-icons filkers-float-right">keyboard_arrow_down</i></p>

              <div class="filkers-content filkers-toggle-content filkers-display-none-soft">
                <pre><?php _e('Product IDs with errors', 'filkers-video-marketing-with-your-products'); ?><?php esc_html_e(print_r(get_option('filkers_api_connection_errors_item_change_ids'))); ?></pre>
                <pre><?php esc_html_e(print_r(get_option('filkers_api_connection_errors_item_change'))); ?></pre>
              </div>
            </div>
          </div>
        <?php
      }
    }
  }

  public function filkers_save_post_product($filkers_post_id, $filkers_custom_post) {
    $this->filkers_request_post_item_change([$filkers_post_id]);
  }

  public function filkers_woocommerce_get_sections_advanced($sections) {
    $sections['filkers_api_section'] = __('Filkers API', 'filkers-video-marketing-with-your-products');
    return $sections;
  }

  public function filkers_woocommerce_get_settings_advanced($settings, $current_section) {
    $custom_settings = [];
    if('filkers_api_section' == $current_section) {
      $custom_settings =  [
        [
          'type' => 'title',
          'name' => __('Connect your Filkers API', 'filkers-video-marketing-with-your-products'),
          'desc' => __('Connect your Filkers API inserting the AppId and the AppSecret in the fields. * Filkers only works under the secure https protocol.', 'filkers-video-marketing-with-your-products'),
          'id'   => 'filkers_api_connection' 
        ],
        [
          'type' => 'checkbox',
          'name' => __('Enable Filkers API', 'filkers-video-marketing-with-your-products'),
          'id'  => 'filkers_api_connection_checkbox'
        ],
        [
          'type' => 'text',
          'name' => __('AppId', 'filkers-video-marketing-with-your-products'),
          'desc' => __('Find your AppId in the Filkers dashboard', 'filkers-video-marketing-with-your-products'),
          'desc_tip' => true,
          'id'  => 'filkers_api_connection_appid'
        ],
        [
          'type' => 'text',
          'name' => __('AppSecret', 'filkers-video-marketing-with-your-products'),
          'desc' => __('Find your AppSecret in the Filkers dashboard', 'filkers-video-marketing-with-your-products'),
          'desc_tip' => true,
          'id'  => 'filkers_api_connection_appsecret'
        ],
      ];

      if ((isset($_GET['debug']) && $_GET['debug'] == 'true') || get_option('filkers_api_debug_checkbox') == 'yes') {
        $custom_settings[] =  [
          'type' => 'checkbox',
          'name' => __('Debug mode', 'filkers-video-marketing-with-your-products'),
          'id'  => 'filkers_api_debug_checkbox'
        ];
      }

      $custom_settings[] =  [ 
        'type' => 'sectionend', 
        'id' => 'filkers_senction_end' 
      ];

      return $custom_settings;
    }else{
      return $settings;
    }
  }

  public function filkers_cron_schedule() {
    if (!wp_next_scheduled('filkers_cron_five_minutes')){
      wp_schedule_event(time(), 'filkers_five_minutes', 'filkers_cron_five_minutes');
    }
  }
    
  public function filkers_cron_five_minutes_schedule($schedules) {
    $schedules['filkers_five_minutes'] = [
      'interval' => 300,
      'display' => __('Every 5 minutes', 'filkers-video-marketing-with-your-products'),
    ];
    return $schedules;
  }

  public function filkers_cron_five_minutes_function() {
    /*if (!empty(get_option('filkers_api_connection_errors_register'))) {
      $this->filkers_request_post_register();
    }*/

    $filkers_api_connection_errors_item_change_ids = get_option('filkers_api_connection_errors_item_change_ids');
    $filkers_api_connection_errors_item_change = get_option('filkers_api_connection_errors_item_change');

    if (!empty($filkers_api_connection_errors_item_change_ids)) {
      if ($filkers_api_connection_errors_item_change['response']['code'] != 401) {
        foreach ($filkers_api_connection_errors_item_change_ids as $item_id) {
          $this->filkers_request_post_item_change([$item_id]);
        }
      }
    }
  }

  public function filkers_footer() {
    global $post;

    ?>
      <script>
        jQuery(document).ready(function($) {
          $(document).on('woocommerce_variations_loaded', function(event) {
            var ajaxurl = '<?php echo admin_url('admin-ajax.php'); ?>';
            var data = {
              action: 'filker_ajax',
              sub_action: 'filker_ajax_variations_updated',
              filkers_product_id: <?php echo !empty($post->ID) ? $post->ID : 0; ?>,
            };

            $.post(ajaxurl, data, function(response) {
              if (response == 'filker_ajax_variations_updated_success') {
                console.log('<?php _e('Filkers message: Product variations successfully updated.', 'filkers-video-marketing-with-your-products'); ?>');
              }
            });
          });
        });
      </script>

      <div id="filkers-main-message" class="filkers-main-message filkers-display-none-soft filkers-z-index-top"><span id="filkers-main-message-span"></span><i class="material-icons filkers-vertical-align-bottom filkers-ml-20 filkers-cursor-pointer filkers-color-white filkers-close-icon">close</i></div>
    <?php
  }

  public function filkers_admin_dashboard_menu_edition() {
    add_menu_page(__('Filkers', 'filkers-video-marketing-with-your-products'), __('Filkers', 'filkers-video-marketing-with-your-products'), 'read', 'filkers_menu_main', [$this, 'filkers_menu_main'], "data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='20' height='34' viewBox='0 0 20 34'%3E%3Cdefs%3E%3Cstyle%3E.cls-1%7Bfill:none;%7D.cls-2%7Bfill:%23f0f6fc;fill-opacity:1;%7D%3C/style%3E%3C/defs%3E%3Cpath class='cls-2' d='M10,11.14c-1.55,0-2.76.75-2.76,1.72S8.45,14.58,10,14.58s2.76-.75,2.76-1.72S11.55,11.14,10,11.14Z'/%3E%3Cpath class='cls-2' d='M19.15,11.88l-.06,0h0l-1-.39a1.25,1.25,0,0,0,.2-.67c0-1-1.21-1.72-2.75-1.72a3.59,3.59,0,0,0-2.11.6l-.83-.32a1.31,1.31,0,0,0,.18-.63C12.76,7.76,11.55,7,10,7s-2.76.76-2.76,1.72a1.31,1.31,0,0,0,.18.63l-.61.23a3.72,3.72,0,0,0-2-.51c-1.55,0-2.76.76-2.76,1.72a1.19,1.19,0,0,0,.14.56l-1.3.5h0l-.06,0a.36.36,0,0,0-.16.29V22.86a.34.34,0,0,0,.21.32l8.6,3.64V15.38L2,12.19l.74-.29a3.57,3.57,0,0,0,2.13.62c1.55,0,2.76-.76,2.76-1.73a1.22,1.22,0,0,0-.22-.68l.57-.23a3.66,3.66,0,0,0,2.06.57,3.66,3.66,0,0,0,2.06-.57l.85.33a1.19,1.19,0,0,0-.15.58c0,1,1.21,1.73,2.76,1.73a3.77,3.77,0,0,0,2-.53l.52.2-8,3.4V27h.13l9-3.79a.34.34,0,0,0,.21-.32V12.17A.36.36,0,0,0,19.15,11.88ZM14.79,22.79l.09-3.23,2.82.07Zm-.13-5.08a3.47,3.47,0,0,0-1.83,3l-.11,4.07-1.51-.95a1.17,1.17,0,0,1-.46-1.07l.09-3.26a3.46,3.46,0,0,1,1.82-2.95L15.53,15l.11,0,0,0,.08,0h0l.07,0h0l.09,0H16l.08,0h.34l.08,0h0l.08,0h0l.06,0h0l1.5.93Z'/%3E%3C/svg%3E");
  }

  public function filkers_enqueue_scripts_and_styles() {
    wp_enqueue_script('jquery');
    wp_enqueue_style('filkers-styles', plugins_url('/css/filkers-styles.css', __FILE__), false, NULL, 'all');
    wp_enqueue_script('filkers-scripts', plugins_url('/js/filkers-scripts.js', __FILE__), ['jquery'], NULL, false);
    wp_enqueue_style('material-icons-styles', 'https://fonts.googleapis.com/icon?family=Material+Icons', false, NULL, 'all');
  }
}