<?php $eu_map_org = $this->options; ?>

<form method="post" action="<?php echo esc_url(admin_url('/')); ?>admin.php?page=eu-map-org">
<div id="map-admin">

  <div id="map-header">
    <p class="map-shortcode"><?php esc_html_e( 'Insert this shortcode ', 'eu-map-org' ); ?><input type="text" value="[eu_map_org]" readonly> <?php esc_html_e( 'in any page or post to display the map.', 'eu-map-org' ); ?> &nbsp; | &nbsp; <span class="submit"><input type="submit" name="submit" id="submit" class="button button-primary" value="<?php esc_html_e( 'Save Changes', 'eu-map-org' ); ?>"></span></p>
  </div>

  <div id="map-page">

    <div class="map-col-lt">
      <div id="map-preview">
        <?php include 'map.php'; ?>
      </div>
    </div><!-- map-col-lt -->

    <!-- General Map Colors -->
    <div class="map-col-rt">
      <div class="map-settings">
        <div class="box-header shape-icon"><?php esc_html_e( 'General Settings', 'eu-map-org' ); ?></div>
        <div class="box-body">
          <div class="general-box"><span class="general-set i-border"><?php esc_html_e( 'Border Color', 'eu-map-org' ); ?></span>
            <input type="text" name="eubrdrclr_org" value="<?php echo esc_attr($eu_map_org['eubrdrclr_org']); ?>" class="color-field" />
          </div>
        </div><!-- box-body -->
      </div><!-- map-settings -->
      <style type="text/css">
        .mt-4px {margin-top: 4px;}
        .mb-0 {margin-bottom: 0;}
        .line-h-14 {line-height: 14px}
      </style>
      <p class="mb-0">The <a href="https://www.wpmapplugins.com/interactive-map-of-europe-wordpress-plugin.html"><strong>Premium Map of Europe</strong></a> has:
        <ul class="mt-4px">
          <li class="line-h-14">&#10003; Visible country names (optional).</li>
          <li class="line-h-14">&#10003; Hover tooltip (optional).</li>
          <li class="line-h-14">&#10003; Modal window (optional).</li></li>
          <li class="line-h-14">&#10003; 3 instances of the plugin.</li>
        </ul>
      </p>
      <p>Discount Coupon Code <a href="https://wpmapplugins.onfastspring.com/wpeu"><strong>EUMAPORG</strong></a></p>
    </div><!-- map-col-rt -->

  </div><!-- map-page -->

  <div class="map-settings areas-settings">
    <div class="box-header individ-i"><?php esc_html_e( 'Settings', 'eu-map-org' ); ?></div>
    <div class="box-body">

      <div class="map-area"><p class="area-name"><?php esc_html_e( 'ALBANIA', 'eu-map-org' ); ?></p>
        <span class="chkbx"><input type="checkbox" name="enbl_1" value="1" <?php if (isset($eu_map_org['enbl_1']) && $eu_map_org['enbl_1'] == '1'){ echo esc_attr(" checked"); } ?>>&nbsp;<?php esc_html_e( 'Active', 'eu-map-org' ); ?></span>
        <div class="inner-content">
          <div class="area-clrs">
            <p><label><?php esc_html_e( 'Up Color', 'eu-map-org' ); ?></label><input type="text" name="upclr_1" value="<?php echo esc_attr($eu_map_org['upclr_1']); ?>" class="color-field" /></p>  
            <p><label><?php esc_html_e( 'Hover Color', 'eu-map-org' ); ?></label><input type="text" name="ovrclr_1" value="<?php echo esc_attr($eu_map_org['ovrclr_1']); ?>" class="color-field" /></p> 
            <p><label><?php esc_html_e( 'Click Color', 'eu-map-org' ); ?></label><input type="text" name="dwnclr_1" value="<?php echo esc_attr($eu_map_org['dwnclr_1']); ?>" class="color-field" /></p>
          </div>
          <div class="area-url">
            <p class="link"><label><?php esc_html_e( 'Link', 'eu-map-org' ); ?></label><input type="text" name="url_1" value="<?php echo esc_url($eu_map_org['url_1']); ?>" /></p>
            <p><label><?php esc_html_e( 'Target', 'eu-map-org' ); ?></label>
              <select name="turl_1">
                <option value="_self" <?php if ($eu_map_org['turl_1'] == '_self'){ echo esc_attr("selected"); } ?>><?php esc_html_e( 'Same Page', 'eu-map-org' ); ?></option>
                <option value="_blank" <?php if ($eu_map_org['turl_1'] == '_blank'){ echo esc_attr("selected"); } ?>><?php esc_html_e( 'New Page', 'eu-map-org' ); ?></option>
              </select>
            </p>
          </div>
        </div>
      </div>

      <div class="map-area"><p class="area-name"><?php esc_html_e( 'ANDORRA', 'eu-map-org' ); ?></p>
        <span class="chkbx"><input type="checkbox" name="enbl_2" value="1" <?php if (isset($eu_map_org['enbl_2']) && $eu_map_org['enbl_2'] == '1'){ echo esc_attr(" checked"); } ?>>&nbsp;<?php esc_html_e( 'Active', 'eu-map-org' ); ?></span>
        <div class="inner-content">
          <div class="area-clrs">
            <p><label><?php esc_html_e( 'Up Color', 'eu-map-org' ); ?></label><input type="text" name="upclr_2" value="<?php echo esc_attr($eu_map_org['upclr_2']); ?>" class="color-field" /></p> 
            <p><label><?php esc_html_e( 'Hover Color', 'eu-map-org' ); ?></label><input type="text" name="ovrclr_2" value="<?php echo esc_attr($eu_map_org['ovrclr_2']); ?>" class="color-field" /></p> 
            <p><label><?php esc_html_e( 'Click Color', 'eu-map-org' ); ?></label><input type="text" name="dwnclr_2" value="<?php echo esc_attr($eu_map_org['dwnclr_2']); ?>" class="color-field" /></p>
          </div>
          <div class="area-url">
            <p class="link"><label><?php esc_html_e( 'Link', 'eu-map-org' ); ?></label><input type="text" name="url_2" value="<?php echo esc_url($eu_map_org['url_2']); ?>" /></p>
            <p><label><?php esc_html_e( 'Target', 'eu-map-org' ); ?></label>
              <select name="turl_2">
                <option value="_self" <?php if ($eu_map_org['turl_2'] == '_self'){ echo esc_attr("selected"); } ?>><?php esc_html_e( 'Same Page', 'eu-map-org' ); ?></option>
                <option value="_blank" <?php if ($eu_map_org['turl_2'] == '_blank'){ echo esc_attr("selected"); } ?>><?php esc_html_e( 'New Page', 'eu-map-org' ); ?></option>
              </select>
            </p>
          </div>
        </div>
      </div>

      <div class="map-area"><p class="area-name"><?php esc_html_e( 'AUSTRIA', 'eu-map-org' ); ?></p>
        <span class="chkbx"><input type="checkbox" name="enbl_3" value="1" <?php if (isset($eu_map_org['enbl_3']) && $eu_map_org['enbl_3'] == '1'){ echo esc_attr(" checked"); } ?>>&nbsp;<?php esc_html_e( 'Active', 'eu-map-org' ); ?></span>
        <div class="inner-content">
          <div class="area-clrs">
            <p><label><?php esc_html_e( 'Up Color', 'eu-map-org' ); ?></label><input type="text" name="upclr_3" value="<?php echo esc_attr($eu_map_org['upclr_3']); ?>" class="color-field" /></p> 
            <p><label><?php esc_html_e( 'Hover Color', 'eu-map-org' ); ?></label><input type="text" name="ovrclr_3" value="<?php echo esc_attr($eu_map_org['ovrclr_3']); ?>" class="color-field" /></p> 
            <p><label><?php esc_html_e( 'Click Color', 'eu-map-org' ); ?></label><input type="text" name="dwnclr_3" value="<?php echo esc_attr($eu_map_org['dwnclr_3']); ?>" class="color-field" /></p>
          </div>
          <div class="area-url">
            <p class="link"><label><?php esc_html_e( 'Link', 'eu-map-org' ); ?></label><input type="text" name="url_3" value="<?php echo esc_url($eu_map_org['url_3']); ?>" /></p>
            <p><label><?php esc_html_e( 'Target', 'eu-map-org' ); ?></label>
              <select name="turl_3">
                <option value="_self" <?php if ($eu_map_org['turl_3'] == '_self'){ echo esc_attr("selected"); } ?>><?php esc_html_e( 'Same Page', 'eu-map-org' ); ?></option>
                <option value="_blank" <?php if ($eu_map_org['turl_3'] == '_blank'){ echo esc_attr("selected"); } ?>><?php esc_html_e( 'New Page', 'eu-map-org' ); ?></option>
              </select>
            </p>
          </div>
        </div>
      </div>
      
      <div class="map-area"><p class="area-name"><?php esc_html_e( 'BELARUS', 'eu-map-org' ); ?></p>
        <span class="chkbx"><input type="checkbox" name="enbl_4" value="1" <?php if (isset($eu_map_org['enbl_4']) && $eu_map_org['enbl_4'] == '1'){ echo esc_attr(" checked"); } ?>>&nbsp;<?php esc_html_e( 'Active', 'eu-map-org' ); ?></span>
        <div class="inner-content">
          <div class="area-clrs">
            <p><label><?php esc_html_e( 'Up Color', 'eu-map-org' ); ?></label><input type="text" name="upclr_4" value="<?php echo esc_attr($eu_map_org['upclr_4']); ?>" class="color-field" /></p> 
            <p><label><?php esc_html_e( 'Hover Color', 'eu-map-org' ); ?></label><input type="text" name="ovrclr_4" value="<?php echo esc_attr($eu_map_org['ovrclr_4']); ?>" class="color-field" /></p> 
            <p><label><?php esc_html_e( 'Click Color', 'eu-map-org' ); ?></label><input type="text" name="dwnclr_4" value="<?php echo esc_attr($eu_map_org['dwnclr_4']); ?>" class="color-field" /></p>
          </div>
          <div class="area-url">
            <p class="link"><label><?php esc_html_e( 'Link', 'eu-map-org' ); ?></label><input type="text" name="url_4" value="<?php echo esc_url($eu_map_org['url_4']); ?>" /></p>
            <p><label><?php esc_html_e( 'Target', 'eu-map-org' ); ?></label>
              <select name="turl_4">
                <option value="_self" <?php if ($eu_map_org['turl_4'] == '_self'){ echo esc_attr("selected"); } ?>><?php esc_html_e( 'Same Page', 'eu-map-org' ); ?></option>
                <option value="_blank" <?php if ($eu_map_org['turl_4'] == '_blank'){ echo esc_attr("selected"); } ?>><?php esc_html_e( 'New Page', 'eu-map-org' ); ?></option>
              </select>
            </p>
          </div>
        </div>
      </div>
      
      <div class="map-area"><p class="area-name"><?php esc_html_e( 'BELGIUM', 'eu-map-org' ); ?></p>
        <span class="chkbx"><input type="checkbox" name="enbl_5" value="1" <?php if (isset($eu_map_org['enbl_5']) && $eu_map_org['enbl_5'] == '1'){ echo esc_attr(" checked"); } ?>>&nbsp;<?php esc_html_e( 'Active', 'eu-map-org' ); ?></span>
        <div class="inner-content">
          <div class="area-clrs">
            <p><label><?php esc_html_e( 'Up Color', 'eu-map-org' ); ?></label><input type="text" name="upclr_5" value="<?php echo esc_attr($eu_map_org['upclr_5']); ?>" class="color-field" /></p> 
            <p><label><?php esc_html_e( 'Hover Color', 'eu-map-org' ); ?></label><input type="text" name="ovrclr_5" value="<?php echo esc_attr($eu_map_org['ovrclr_5']); ?>" class="color-field" /></p> 
            <p><label><?php esc_html_e( 'Click Color', 'eu-map-org' ); ?></label><input type="text" name="dwnclr_5" value="<?php echo esc_attr($eu_map_org['dwnclr_5']); ?>" class="color-field" /></p>
          </div>
          <div class="area-url">
            <p class="link"><label><?php esc_html_e( 'Link', 'eu-map-org' ); ?></label><input type="text" name="url_5" value="<?php echo esc_url($eu_map_org['url_5']); ?>" /></p>
            <p><label><?php esc_html_e( 'Target', 'eu-map-org' ); ?></label>
              <select name="turl_5">
                <option value="_self" <?php if ($eu_map_org['turl_5'] == '_self'){ echo esc_attr("selected"); } ?>><?php esc_html_e( 'Same Page', 'eu-map-org' ); ?></option>
                <option value="_blank" <?php if ($eu_map_org['turl_5'] == '_blank'){ echo esc_attr("selected"); } ?>><?php esc_html_e( 'New Page', 'eu-map-org' ); ?></option>
              </select>
            </p>
          </div>
        </div>
      </div>
      
      <div class="map-area"><p class="area-name"><?php esc_html_e( 'BOSNIA AND HERZEGOVINA', 'eu-map-org' ); ?></p>
        <span class="chkbx"><input type="checkbox" name="enbl_6" value="1" <?php if (isset($eu_map_org['enbl_6']) && $eu_map_org['enbl_6'] == '1'){ echo esc_attr(" checked"); } ?>>&nbsp;<?php esc_html_e( 'Active', 'eu-map-org' ); ?></span>
        <div class="inner-content">
          <div class="area-clrs">
            <p><label><?php esc_html_e( 'Up Color', 'eu-map-org' ); ?></label><input type="text" name="upclr_6" value="<?php echo esc_attr($eu_map_org['upclr_6']); ?>" class="color-field" /></p> 
            <p><label><?php esc_html_e( 'Hover Color', 'eu-map-org' ); ?></label><input type="text" name="ovrclr_6" value="<?php echo esc_attr($eu_map_org['ovrclr_6']); ?>" class="color-field" /></p> 
            <p><label><?php esc_html_e( 'Click Color', 'eu-map-org' ); ?></label><input type="text" name="dwnclr_6" value="<?php echo esc_attr($eu_map_org['dwnclr_6']); ?>" class="color-field" /></p>
          </div>
          <div class="area-url">
            <p class="link"><label><?php esc_html_e( 'Link', 'eu-map-org' ); ?></label><input type="text" name="url_6" value="<?php echo esc_url($eu_map_org['url_6']); ?>" /></p>
            <p><label><?php esc_html_e( 'Target', 'eu-map-org' ); ?></label>
              <select name="turl_6">
                <option value="_self" <?php if ($eu_map_org['turl_6'] == '_self'){ echo esc_attr("selected"); } ?>><?php esc_html_e( 'Same Page', 'eu-map-org' ); ?></option>
                <option value="_blank" <?php if ($eu_map_org['turl_6'] == '_blank'){ echo esc_attr("selected"); } ?>><?php esc_html_e( 'New Page', 'eu-map-org' ); ?></option>
              </select>
            </p>
          </div>
        </div>
      </div>
      
      <div class="map-area"><p class="area-name"><?php esc_html_e( 'BULGARIA', 'eu-map-org' ); ?></p>
        <span class="chkbx"><input type="checkbox" name="enbl_7" value="1" <?php if (isset($eu_map_org['enbl_7']) && $eu_map_org['enbl_7'] == '1'){ echo esc_attr(" checked"); } ?>>&nbsp;<?php esc_html_e( 'Active', 'eu-map-org' ); ?></span>
        <div class="inner-content">
          <div class="area-clrs">
            <p><label><?php esc_html_e( 'Up Color', 'eu-map-org' ); ?></label><input type="text" name="upclr_7" value="<?php echo esc_attr($eu_map_org['upclr_7']); ?>" class="color-field" /></p> 
            <p><label><?php esc_html_e( 'Hover Color', 'eu-map-org' ); ?></label><input type="text" name="ovrclr_7" value="<?php echo esc_attr($eu_map_org['ovrclr_7']); ?>" class="color-field" /></p> 
            <p><label><?php esc_html_e( 'Click Color', 'eu-map-org' ); ?></label><input type="text" name="dwnclr_7" value="<?php echo esc_attr($eu_map_org['dwnclr_7']); ?>" class="color-field" /></p>
          </div>
          <div class="area-url">
            <p class="link"><label><?php esc_html_e( 'Link', 'eu-map-org' ); ?></label><input type="text" name="url_7" value="<?php echo esc_url($eu_map_org['url_7']); ?>" /></p>
            <p><label><?php esc_html_e( 'Target', 'eu-map-org' ); ?></label>
              <select name="turl_7">
                <option value="_self" <?php if ($eu_map_org['turl_7'] == '_self'){ echo esc_attr("selected"); } ?>><?php esc_html_e( 'Same Page', 'eu-map-org' ); ?></option>
                <option value="_blank" <?php if ($eu_map_org['turl_7'] == '_blank'){ echo esc_attr("selected"); } ?>><?php esc_html_e( 'New Page', 'eu-map-org' ); ?></option>
              </select>
            </p>
          </div>
        </div>
      </div>
      
      <div class="map-area"><p class="area-name"><?php esc_html_e( 'CROATIA', 'eu-map-org' ); ?></p>
        <span class="chkbx"><input type="checkbox" name="enbl_8" value="1" <?php if (isset($eu_map_org['enbl_8']) && $eu_map_org['enbl_8'] == '1'){ echo esc_attr(" checked"); } ?>>&nbsp;<?php esc_html_e( 'Active', 'eu-map-org' ); ?></span>
        <div class="inner-content">
          <div class="area-clrs">
            <p><label><?php esc_html_e( 'Up Color', 'eu-map-org' ); ?></label><input type="text" name="upclr_8" value="<?php echo esc_attr($eu_map_org['upclr_8']); ?>" class="color-field" /></p> 
            <p><label><?php esc_html_e( 'Hover Color', 'eu-map-org' ); ?></label><input type="text" name="ovrclr_8" value="<?php echo esc_attr($eu_map_org['ovrclr_8']); ?>" class="color-field" /></p> 
            <p><label><?php esc_html_e( 'Click Color', 'eu-map-org' ); ?></label><input type="text" name="dwnclr_8" value="<?php echo esc_attr($eu_map_org['dwnclr_8']); ?>" class="color-field" /></p>
          </div>
          <div class="area-url">
            <p class="link"><label><?php esc_html_e( 'Link', 'eu-map-org' ); ?></label><input type="text" name="url_8" value="<?php echo esc_url($eu_map_org['url_8']); ?>" /></p>
            <p><label><?php esc_html_e( 'Target', 'eu-map-org' ); ?></label>
              <select name="turl_8">
                <option value="_self" <?php if ($eu_map_org['turl_8'] == '_self'){ echo esc_attr("selected"); } ?>><?php esc_html_e( 'Same Page', 'eu-map-org' ); ?></option>
                <option value="_blank" <?php if ($eu_map_org['turl_8'] == '_blank'){ echo esc_attr("selected"); } ?>><?php esc_html_e( 'New Page', 'eu-map-org' ); ?></option>
              </select>
            </p>
          </div>
        </div>
      </div>
      
      <div class="map-area"><p class="area-name"><?php esc_html_e( 'CYPRUS', 'eu-map-org' ); ?></p>
        <span class="chkbx"><input type="checkbox" name="enbl_9" value="1" <?php if (isset($eu_map_org['enbl_9']) && $eu_map_org['enbl_9'] == '1'){ echo esc_attr(" checked"); } ?>>&nbsp;<?php esc_html_e( 'Active', 'eu-map-org' ); ?></span>
        <div class="inner-content">
          <div class="area-clrs">
            <p><label><?php esc_html_e( 'Up Color', 'eu-map-org' ); ?></label><input type="text" name="upclr_9" value="<?php echo esc_attr($eu_map_org['upclr_9']); ?>" class="color-field" /></p> 
            <p><label><?php esc_html_e( 'Hover Color', 'eu-map-org' ); ?></label><input type="text" name="ovrclr_9" value="<?php echo esc_attr($eu_map_org['ovrclr_9']); ?>" class="color-field" /></p> 
            <p><label><?php esc_html_e( 'Click Color', 'eu-map-org' ); ?></label><input type="text" name="dwnclr_9" value="<?php echo esc_attr($eu_map_org['dwnclr_9']); ?>" class="color-field" /></p>
          </div>
          <div class="area-url">
            <p class="link"><label><?php esc_html_e( 'Link', 'eu-map-org' ); ?></label><input type="text" name="url_9" value="<?php echo esc_url($eu_map_org['url_9']); ?>" /></p>
            <p><label><?php esc_html_e( 'Target', 'eu-map-org' ); ?></label>
              <select name="turl_9">
                <option value="_self" <?php if ($eu_map_org['turl_9'] == '_self'){ echo esc_attr("selected"); } ?>><?php esc_html_e( 'Same Page', 'eu-map-org' ); ?></option>
                <option value="_blank" <?php if ($eu_map_org['turl_9'] == '_blank'){ echo esc_attr("selected"); } ?>><?php esc_html_e( 'New Page', 'eu-map-org' ); ?></option>
              </select>
            </p>
          </div>
        </div>
      </div>
      
      <div class="map-area"><p class="area-name"><?php esc_html_e( 'CZECH REPUBLIC', 'eu-map-org' ); ?></p>
        <span class="chkbx"><input type="checkbox" name="enbl_10" value="1" <?php if (isset($eu_map_org['enbl_10']) && $eu_map_org['enbl_10'] == '1'){ echo esc_attr(" checked"); } ?>>&nbsp;<?php esc_html_e( 'Active', 'eu-map-org' ); ?></span>
        <div class="inner-content">
          <div class="area-clrs">
            <p><label><?php esc_html_e( 'Up Color', 'eu-map-org' ); ?></label><input type="text" name="upclr_10" value="<?php echo esc_attr($eu_map_org['upclr_10']); ?>" class="color-field" /></p> 
            <p><label><?php esc_html_e( 'Hover Color', 'eu-map-org' ); ?></label><input type="text" name="ovrclr_10" value="<?php echo esc_attr($eu_map_org['ovrclr_10']); ?>" class="color-field" /></p> 
            <p><label><?php esc_html_e( 'Click Color', 'eu-map-org' ); ?></label><input type="text" name="dwnclr_10" value="<?php echo esc_attr($eu_map_org['dwnclr_10']); ?>" class="color-field" /></p>
          </div>
          <div class="area-url">
            <p class="link"><label><?php esc_html_e( 'Link', 'eu-map-org' ); ?></label><input type="text" name="url_10" value="<?php echo esc_url($eu_map_org['url_10']); ?>" /></p>
            <p><label><?php esc_html_e( 'Target', 'eu-map-org' ); ?></label>
              <select name="turl_10">
                <option value="_self" <?php if ($eu_map_org['turl_10'] == '_self'){ echo esc_attr("selected"); } ?>><?php esc_html_e( 'Same Page', 'eu-map-org' ); ?></option>
                <option value="_blank" <?php if ($eu_map_org['turl_10'] == '_blank'){ echo esc_attr("selected"); } ?>><?php esc_html_e( 'New Page', 'eu-map-org' ); ?></option>
              </select>
            </p>
          </div>
        </div>
      </div>
      
      <div class="map-area"><p class="area-name"><?php esc_html_e( 'DENMARK', 'eu-map-org' ); ?></p>
        <span class="chkbx"><input type="checkbox" name="enbl_11" value="1" <?php if (isset($eu_map_org['enbl_11']) && $eu_map_org['enbl_11'] == '1'){ echo esc_attr(" checked"); } ?>>&nbsp;<?php esc_html_e( 'Active', 'eu-map-org' ); ?></span>
        <div class="inner-content">
          <div class="area-clrs">
            <p><label><?php esc_html_e( 'Up Color', 'eu-map-org' ); ?></label><input type="text" name="upclr_11" value="<?php echo esc_attr($eu_map_org['upclr_11']); ?>" class="color-field" /></p> 
            <p><label><?php esc_html_e( 'Hover Color', 'eu-map-org' ); ?></label><input type="text" name="ovrclr_11" value="<?php echo esc_attr($eu_map_org['ovrclr_11']); ?>" class="color-field" /></p> 
            <p><label><?php esc_html_e( 'Click Color', 'eu-map-org' ); ?></label><input type="text" name="dwnclr_11" value="<?php echo esc_attr($eu_map_org['dwnclr_11']); ?>" class="color-field" /></p>
          </div>
          <div class="area-url">
            <p class="link"><label><?php esc_html_e( 'Link', 'eu-map-org' ); ?></label><input type="text" name="url_11" value="<?php echo esc_url($eu_map_org['url_11']); ?>" /></p>
            <p><label><?php esc_html_e( 'Target', 'eu-map-org' ); ?></label>
              <select name="turl_11">
                <option value="_self" <?php if ($eu_map_org['turl_11'] == '_self'){ echo esc_attr("selected"); } ?>><?php esc_html_e( 'Same Page', 'eu-map-org' ); ?></option>
                <option value="_blank" <?php if ($eu_map_org['turl_11'] == '_blank'){ echo esc_attr("selected"); } ?>><?php esc_html_e( 'New Page', 'eu-map-org' ); ?></option>
              </select>
            </p>
          </div>
        </div>
      </div>
      
      <div class="map-area"><p class="area-name"><?php esc_html_e( 'ESTONIA', 'eu-map-org' ); ?></p>
        <span class="chkbx"><input type="checkbox" name="enbl_12" value="1" <?php if (isset($eu_map_org['enbl_12']) && $eu_map_org['enbl_12'] == '1'){ echo esc_attr(" checked"); } ?>>&nbsp;<?php esc_html_e( 'Active', 'eu-map-org' ); ?></span>
        <div class="inner-content">
          <div class="area-clrs">
            <p><label><?php esc_html_e( 'Up Color', 'eu-map-org' ); ?></label><input type="text" name="upclr_12" value="<?php echo esc_attr($eu_map_org['upclr_12']); ?>" class="color-field" /></p> 
            <p><label><?php esc_html_e( 'Hover Color', 'eu-map-org' ); ?></label><input type="text" name="ovrclr_12" value="<?php echo esc_attr($eu_map_org['ovrclr_12']); ?>" class="color-field" /></p> 
            <p><label><?php esc_html_e( 'Click Color', 'eu-map-org' ); ?></label><input type="text" name="dwnclr_12" value="<?php echo esc_attr($eu_map_org['dwnclr_12']); ?>" class="color-field" /></p>
          </div>
          <div class="area-url">
            <p class="link"><label><?php esc_html_e( 'Link', 'eu-map-org' ); ?></label><input type="text" name="url_12" value="<?php echo esc_url($eu_map_org['url_12']); ?>" /></p>
            <p><label><?php esc_html_e( 'Target', 'eu-map-org' ); ?></label>
              <select name="turl_12">
                <option value="_self" <?php if ($eu_map_org['turl_12'] == '_self'){ echo esc_attr("selected"); } ?>><?php esc_html_e( 'Same Page', 'eu-map-org' ); ?></option>
                <option value="_blank" <?php if ($eu_map_org['turl_12'] == '_blank'){ echo esc_attr("selected"); } ?>><?php esc_html_e( 'New Page', 'eu-map-org' ); ?></option>
              </select>
            </p>
          </div>
        </div>
      </div>
      
      <div class="map-area"><p class="area-name"><?php esc_html_e( 'FINLAND', 'eu-map-org' ); ?></p>
        <span class="chkbx"><input type="checkbox" name="enbl_13" value="1" <?php if (isset($eu_map_org['enbl_13']) && $eu_map_org['enbl_13'] == '1'){ echo esc_attr(" checked"); } ?>>&nbsp;<?php esc_html_e( 'Active', 'eu-map-org' ); ?></span>
        <div class="inner-content">
          <div class="area-clrs">
            <p><label><?php esc_html_e( 'Up Color', 'eu-map-org' ); ?></label><input type="text" name="upclr_13" value="<?php echo esc_attr($eu_map_org['upclr_13']); ?>" class="color-field" /></p> 
            <p><label><?php esc_html_e( 'Hover Color', 'eu-map-org' ); ?></label><input type="text" name="ovrclr_13" value="<?php echo esc_attr($eu_map_org['ovrclr_13']); ?>" class="color-field" /></p> 
            <p><label><?php esc_html_e( 'Click Color', 'eu-map-org' ); ?></label><input type="text" name="dwnclr_13" value="<?php echo esc_attr($eu_map_org['dwnclr_13']); ?>" class="color-field" /></p>
          </div>
          <div class="area-url">
            <p class="link"><label><?php esc_html_e( 'Link', 'eu-map-org' ); ?></label><input type="text" name="url_13" value="<?php echo esc_url($eu_map_org['url_13']); ?>" /></p>
            <p><label><?php esc_html_e( 'Target', 'eu-map-org' ); ?></label>
              <select name="turl_13">
                <option value="_self" <?php if ($eu_map_org['turl_13'] == '_self'){ echo esc_attr("selected"); } ?>><?php esc_html_e( 'Same Page', 'eu-map-org' ); ?></option>
                <option value="_blank" <?php if ($eu_map_org['turl_13'] == '_blank'){ echo esc_attr("selected"); } ?>><?php esc_html_e( 'New Page', 'eu-map-org' ); ?></option>
              </select>
            </p>
          </div>
        </div>
      </div>
      
      <div class="map-area"><p class="area-name"><?php esc_html_e( 'FRANCE', 'eu-map-org' ); ?></p>
        <span class="chkbx"><input type="checkbox" name="enbl_14" value="1" <?php if (isset($eu_map_org['enbl_14']) && $eu_map_org['enbl_14'] == '1'){ echo esc_attr(" checked"); } ?>>&nbsp;<?php esc_html_e( 'Active', 'eu-map-org' ); ?></span>
        <div class="inner-content">
          <div class="area-clrs">
            <p><label><?php esc_html_e( 'Up Color', 'eu-map-org' ); ?></label><input type="text" name="upclr_14" value="<?php echo esc_attr($eu_map_org['upclr_14']); ?>" class="color-field" /></p> 
            <p><label><?php esc_html_e( 'Hover Color', 'eu-map-org' ); ?></label><input type="text" name="ovrclr_14" value="<?php echo esc_attr($eu_map_org['ovrclr_14']); ?>" class="color-field" /></p> 
            <p><label><?php esc_html_e( 'Click Color', 'eu-map-org' ); ?></label><input type="text" name="dwnclr_14" value="<?php echo esc_attr($eu_map_org['dwnclr_14']); ?>" class="color-field" /></p>
          </div>
          <div class="area-url">
            <p class="link"><label><?php esc_html_e( 'Link', 'eu-map-org' ); ?></label><input type="text" name="url_14" value="<?php echo esc_url($eu_map_org['url_14']); ?>" /></p>
            <p><label><?php esc_html_e( 'Target', 'eu-map-org' ); ?></label>
              <select name="turl_14">
                <option value="_self" <?php if ($eu_map_org['turl_14'] == '_self'){ echo esc_attr("selected"); } ?>><?php esc_html_e( 'Same Page', 'eu-map-org' ); ?></option>
                <option value="_blank" <?php if ($eu_map_org['turl_14'] == '_blank'){ echo esc_attr("selected"); } ?>><?php esc_html_e( 'New Page', 'eu-map-org' ); ?></option>
              </select>
            </p>
          </div>
        </div>
      </div>
      
      <div class="map-area"><p class="area-name"><?php esc_html_e( 'GERMANY', 'eu-map-org' ); ?></p>
        <span class="chkbx"><input type="checkbox" name="enbl_15" value="1" <?php if (isset($eu_map_org['enbl_15']) && $eu_map_org['enbl_15'] == '1'){ echo esc_attr(" checked"); } ?>>&nbsp;<?php esc_html_e( 'Active', 'eu-map-org' ); ?></span>
        <div class="inner-content">
          <div class="area-clrs">
            <p><label><?php esc_html_e( 'Up Color', 'eu-map-org' ); ?></label><input type="text" name="upclr_15" value="<?php echo esc_attr($eu_map_org['upclr_15']); ?>" class="color-field" /></p> 
            <p><label><?php esc_html_e( 'Hover Color', 'eu-map-org' ); ?></label><input type="text" name="ovrclr_15" value="<?php echo esc_attr($eu_map_org['ovrclr_15']); ?>" class="color-field" /></p> 
            <p><label><?php esc_html_e( 'Click Color', 'eu-map-org' ); ?></label><input type="text" name="dwnclr_15" value="<?php echo esc_attr($eu_map_org['dwnclr_15']); ?>" class="color-field" /></p>
          </div>
          <div class="area-url">
            <p class="link"><label><?php esc_html_e( 'Link', 'eu-map-org' ); ?></label><input type="text" name="url_15" value="<?php echo esc_url($eu_map_org['url_15']); ?>" /></p>
            <p><label><?php esc_html_e( 'Target', 'eu-map-org' ); ?></label>
              <select name="turl_15">
                <option value="_self" <?php if ($eu_map_org['turl_15'] == '_self'){ echo esc_attr("selected"); } ?>><?php esc_html_e( 'Same Page', 'eu-map-org' ); ?></option>
                <option value="_blank" <?php if ($eu_map_org['turl_15'] == '_blank'){ echo esc_attr("selected"); } ?>><?php esc_html_e( 'New Page', 'eu-map-org' ); ?></option>
              </select>
            </p>
          </div>
        </div>
      </div>
      
      <div class="map-area"><p class="area-name"><?php esc_html_e( 'GREECE', 'eu-map-org' ); ?></p>
        <span class="chkbx"><input type="checkbox" name="enbl_16" value="1" <?php if (isset($eu_map_org['enbl_16']) && $eu_map_org['enbl_16'] == '1'){ echo esc_attr(" checked"); } ?>>&nbsp;<?php esc_html_e( 'Active', 'eu-map-org' ); ?></span>
        <div class="inner-content">
          <div class="area-clrs">
            <p><label><?php esc_html_e( 'Up Color', 'eu-map-org' ); ?></label><input type="text" name="upclr_16" value="<?php echo esc_attr($eu_map_org['upclr_16']); ?>" class="color-field" /></p> 
            <p><label><?php esc_html_e( 'Hover Color', 'eu-map-org' ); ?></label><input type="text" name="ovrclr_16" value="<?php echo esc_attr($eu_map_org['ovrclr_16']); ?>" class="color-field" /></p> 
            <p><label><?php esc_html_e( 'Click Color', 'eu-map-org' ); ?></label><input type="text" name="dwnclr_16" value="<?php echo esc_attr($eu_map_org['dwnclr_16']); ?>" class="color-field" /></p>
          </div>
          <div class="area-url">
            <p class="link"><label><?php esc_html_e( 'Link', 'eu-map-org' ); ?></label><input type="text" name="url_16" value="<?php echo esc_url($eu_map_org['url_16']); ?>" /></p>
            <p><label><?php esc_html_e( 'Target', 'eu-map-org' ); ?></label>
              <select name="turl_16">
                <option value="_self" <?php if ($eu_map_org['turl_16'] == '_self'){ echo esc_attr("selected"); } ?>><?php esc_html_e( 'Same Page', 'eu-map-org' ); ?></option>
                <option value="_blank" <?php if ($eu_map_org['turl_16'] == '_blank'){ echo esc_attr("selected"); } ?>><?php esc_html_e( 'New Page', 'eu-map-org' ); ?></option>
              </select>
            </p>
          </div>
        </div>
      </div>
      
      <div class="map-area"><p class="area-name"><?php esc_html_e( 'HUNGARY', 'eu-map-org' ); ?></p>
        <span class="chkbx"><input type="checkbox" name="enbl_17" value="1" <?php if (isset($eu_map_org['enbl_17']) && $eu_map_org['enbl_17'] == '1'){ echo esc_attr(" checked"); } ?>>&nbsp;<?php esc_html_e( 'Active', 'eu-map-org' ); ?></span>
        <div class="inner-content">
          <div class="area-clrs">
            <p><label><?php esc_html_e( 'Up Color', 'eu-map-org' ); ?></label><input type="text" name="upclr_17" value="<?php echo esc_attr($eu_map_org['upclr_17']); ?>" class="color-field" /></p> 
            <p><label><?php esc_html_e( 'Hover Color', 'eu-map-org' ); ?></label><input type="text" name="ovrclr_17" value="<?php echo esc_attr($eu_map_org['ovrclr_17']); ?>" class="color-field" /></p> 
            <p><label><?php esc_html_e( 'Click Color', 'eu-map-org' ); ?></label><input type="text" name="dwnclr_17" value="<?php echo esc_attr($eu_map_org['dwnclr_17']); ?>" class="color-field" /></p>
          </div>
          <div class="area-url">
            <p class="link"><label><?php esc_html_e( 'Link', 'eu-map-org' ); ?></label><input type="text" name="url_17" value="<?php echo esc_url($eu_map_org['url_17']); ?>" /></p>
            <p><label><?php esc_html_e( 'Target', 'eu-map-org' ); ?></label>
              <select name="turl_17">
                <option value="_self" <?php if ($eu_map_org['turl_17'] == '_self'){ echo esc_attr("selected"); } ?>><?php esc_html_e( 'Same Page', 'eu-map-org' ); ?></option>
                <option value="_blank" <?php if ($eu_map_org['turl_17'] == '_blank'){ echo esc_attr("selected"); } ?>><?php esc_html_e( 'New Page', 'eu-map-org' ); ?></option>
              </select>
            </p>
          </div>
        </div>
      </div>
      
      <div class="map-area"><p class="area-name"><?php esc_html_e( 'ICELAND', 'eu-map-org' ); ?></p>
        <span class="chkbx"><input type="checkbox" name="enbl_18" value="1" <?php if (isset($eu_map_org['enbl_18']) && $eu_map_org['enbl_18'] == '1'){ echo esc_attr(" checked"); } ?>>&nbsp;<?php esc_html_e( 'Active', 'eu-map-org' ); ?></span>
        <div class="inner-content">
          <div class="area-clrs">
            <p><label><?php esc_html_e( 'Up Color', 'eu-map-org' ); ?></label><input type="text" name="upclr_18" value="<?php echo esc_attr($eu_map_org['upclr_18']); ?>" class="color-field" /></p> 
            <p><label><?php esc_html_e( 'Hover Color', 'eu-map-org' ); ?></label><input type="text" name="ovrclr_18" value="<?php echo esc_attr($eu_map_org['ovrclr_18']); ?>" class="color-field" /></p> 
            <p><label><?php esc_html_e( 'Click Color', 'eu-map-org' ); ?></label><input type="text" name="dwnclr_18" value="<?php echo esc_attr($eu_map_org['dwnclr_18']); ?>" class="color-field" /></p>
          </div>
          <div class="area-url">
            <p class="link"><label><?php esc_html_e( 'Link', 'eu-map-org' ); ?></label><input type="text" name="url_18" value="<?php echo esc_url($eu_map_org['url_18']); ?>" /></p>
            <p><label><?php esc_html_e( 'Target', 'eu-map-org' ); ?></label>
              <select name="turl_18">
                <option value="_self" <?php if ($eu_map_org['turl_18'] == '_self'){ echo esc_attr("selected"); } ?>><?php esc_html_e( 'Same Page', 'eu-map-org' ); ?></option>
                <option value="_blank" <?php if ($eu_map_org['turl_18'] == '_blank'){ echo esc_attr("selected"); } ?>><?php esc_html_e( 'New Page', 'eu-map-org' ); ?></option>
              </select>
            </p>
          </div>
        </div>
      </div>
      
      <div class="map-area"><p class="area-name"><?php esc_html_e( 'IRELAND', 'eu-map-org' ); ?></p>
        <span class="chkbx"><input type="checkbox" name="enbl_19" value="1" <?php if (isset($eu_map_org['enbl_19']) && $eu_map_org['enbl_19'] == '1'){ echo esc_attr(" checked"); } ?>>&nbsp;<?php esc_html_e( 'Active', 'eu-map-org' ); ?></span>
        <div class="inner-content">
          <div class="area-clrs">
            <p><label><?php esc_html_e( 'Up Color', 'eu-map-org' ); ?></label><input type="text" name="upclr_19" value="<?php echo esc_attr($eu_map_org['upclr_19']); ?>" class="color-field" /></p> 
            <p><label><?php esc_html_e( 'Hover Color', 'eu-map-org' ); ?></label><input type="text" name="ovrclr_19" value="<?php echo esc_attr($eu_map_org['ovrclr_19']); ?>" class="color-field" /></p> 
            <p><label><?php esc_html_e( 'Click Color', 'eu-map-org' ); ?></label><input type="text" name="dwnclr_19" value="<?php echo esc_attr($eu_map_org['dwnclr_19']); ?>" class="color-field" /></p>
          </div>
          <div class="area-url">
            <p class="link"><label><?php esc_html_e( 'Link', 'eu-map-org' ); ?></label><input type="text" name="url_19" value="<?php echo esc_url($eu_map_org['url_19']); ?>" /></p>
            <p><label><?php esc_html_e( 'Target', 'eu-map-org' ); ?></label>
              <select name="turl_19">
                <option value="_self" <?php if ($eu_map_org['turl_19'] == '_self'){ echo esc_attr("selected"); } ?>><?php esc_html_e( 'Same Page', 'eu-map-org' ); ?></option>
                <option value="_blank" <?php if ($eu_map_org['turl_19'] == '_blank'){ echo esc_attr("selected"); } ?>><?php esc_html_e( 'New Page', 'eu-map-org' ); ?></option>
              </select>
            </p>
          </div>
        </div>
      </div>
      
      <div class="map-area"><p class="area-name"><?php esc_html_e( 'ITALY', 'eu-map-org' ); ?></p>
        <span class="chkbx"><input type="checkbox" name="enbl_20" value="1" <?php if (isset($eu_map_org['enbl_20']) && $eu_map_org['enbl_20'] == '1'){ echo esc_attr(" checked"); } ?>>&nbsp;<?php esc_html_e( 'Active', 'eu-map-org' ); ?></span>
        <div class="inner-content">
          <div class="area-clrs">
            <p><label><?php esc_html_e( 'Up Color', 'eu-map-org' ); ?></label><input type="text" name="upclr_20" value="<?php echo esc_attr($eu_map_org['upclr_20']); ?>" class="color-field" /></p> 
            <p><label><?php esc_html_e( 'Hover Color', 'eu-map-org' ); ?></label><input type="text" name="ovrclr_20" value="<?php echo esc_attr($eu_map_org['ovrclr_20']); ?>" class="color-field" /></p> 
            <p><label><?php esc_html_e( 'Click Color', 'eu-map-org' ); ?></label><input type="text" name="dwnclr_20" value="<?php echo esc_attr($eu_map_org['dwnclr_20']); ?>" class="color-field" /></p>
          </div>
          <div class="area-url">
            <p class="link"><label><?php esc_html_e( 'Link', 'eu-map-org' ); ?></label><input type="text" name="url_20" value="<?php echo esc_url($eu_map_org['url_20']); ?>" /></p>
            <p><label><?php esc_html_e( 'Target', 'eu-map-org' ); ?></label>
              <select name="turl_20">
                <option value="_self" <?php if ($eu_map_org['turl_20'] == '_self'){ echo esc_attr("selected"); } ?>><?php esc_html_e( 'Same Page', 'eu-map-org' ); ?></option>
                <option value="_blank" <?php if ($eu_map_org['turl_20'] == '_blank'){ echo esc_attr("selected"); } ?>><?php esc_html_e( 'New Page', 'eu-map-org' ); ?></option>
              </select>
            </p>
          </div>
        </div>
      </div>
      
      <div class="map-area"><p class="area-name"><?php esc_html_e( 'KOSOVO', 'eu-map-org' ); ?></p>
        <span class="chkbx"><input type="checkbox" name="enbl_21" value="1" <?php if (isset($eu_map_org['enbl_21']) && $eu_map_org['enbl_21'] == '1'){ echo esc_attr(" checked"); } ?>>&nbsp;<?php esc_html_e( 'Active', 'eu-map-org' ); ?></span>
        <div class="inner-content">
          <div class="area-clrs">
            <p><label><?php esc_html_e( 'Up Color', 'eu-map-org' ); ?></label><input type="text" name="upclr_21" value="<?php echo esc_attr($eu_map_org['upclr_21']); ?>" class="color-field" /></p> 
            <p><label><?php esc_html_e( 'Hover Color', 'eu-map-org' ); ?></label><input type="text" name="ovrclr_21" value="<?php echo esc_attr($eu_map_org['ovrclr_21']); ?>" class="color-field" /></p> 
            <p><label><?php esc_html_e( 'Click Color', 'eu-map-org' ); ?></label><input type="text" name="dwnclr_21" value="<?php echo esc_attr($eu_map_org['dwnclr_21']); ?>" class="color-field" /></p>
          </div>
          <div class="area-url">
            <p class="link"><label><?php esc_html_e( 'Link', 'eu-map-org' ); ?></label><input type="text" name="url_21" value="<?php echo esc_url($eu_map_org['url_21']); ?>" /></p>
            <p><label><?php esc_html_e( 'Target', 'eu-map-org' ); ?></label>
              <select name="turl_21">
                <option value="_self" <?php if ($eu_map_org['turl_21'] == '_self'){ echo esc_attr("selected"); } ?>><?php esc_html_e( 'Same Page', 'eu-map-org' ); ?></option>
                <option value="_blank" <?php if ($eu_map_org['turl_21'] == '_blank'){ echo esc_attr("selected"); } ?>><?php esc_html_e( 'New Page', 'eu-map-org' ); ?></option>
              </select>
            </p>
          </div>
        </div>
      </div>
      
      <div class="map-area"><p class="area-name"><?php esc_html_e( 'LATVIA', 'eu-map-org' ); ?></p>
        <span class="chkbx"><input type="checkbox" name="enbl_22" value="1" <?php if (isset($eu_map_org['enbl_22']) && $eu_map_org['enbl_22'] == '1'){ echo esc_attr(" checked"); } ?>>&nbsp;<?php esc_html_e( 'Active', 'eu-map-org' ); ?></span>
        <div class="inner-content">
          <div class="area-clrs">
            <p><label><?php esc_html_e( 'Up Color', 'eu-map-org' ); ?></label><input type="text" name="upclr_22" value="<?php echo esc_attr($eu_map_org['upclr_22']); ?>" class="color-field" /></p> 
            <p><label><?php esc_html_e( 'Hover Color', 'eu-map-org' ); ?></label><input type="text" name="ovrclr_22" value="<?php echo esc_attr($eu_map_org['ovrclr_22']); ?>" class="color-field" /></p> 
            <p><label><?php esc_html_e( 'Click Color', 'eu-map-org' ); ?></label><input type="text" name="dwnclr_22" value="<?php echo esc_attr($eu_map_org['dwnclr_22']); ?>" class="color-field" /></p>
          </div>
          <div class="area-url">
            <p class="link"><label><?php esc_html_e( 'Link', 'eu-map-org' ); ?></label><input type="text" name="url_22" value="<?php echo esc_url($eu_map_org['url_22']); ?>" /></p>
            <p><label><?php esc_html_e( 'Target', 'eu-map-org' ); ?></label>
              <select name="turl_22">
                <option value="_self" <?php if ($eu_map_org['turl_22'] == '_self'){ echo esc_attr("selected"); } ?>><?php esc_html_e( 'Same Page', 'eu-map-org' ); ?></option>
                <option value="_blank" <?php if ($eu_map_org['turl_22'] == '_blank'){ echo esc_attr("selected"); } ?>><?php esc_html_e( 'New Page', 'eu-map-org' ); ?></option>
              </select>
            </p>
          </div>
        </div>
      </div>
      
      <div class="map-area"><p class="area-name"><?php esc_html_e( 'LIECHTENSTEIN', 'eu-map-org' ); ?></p>
        <span class="chkbx"><input type="checkbox" name="enbl_23" value="1" <?php if (isset($eu_map_org['enbl_23']) && $eu_map_org['enbl_23'] == '1'){ echo esc_attr(" checked"); } ?>>&nbsp;<?php esc_html_e( 'Active', 'eu-map-org' ); ?></span>
        <div class="inner-content">
          <div class="area-clrs">
            <p><label><?php esc_html_e( 'Up Color', 'eu-map-org' ); ?></label><input type="text" name="upclr_23" value="<?php echo esc_attr($eu_map_org['upclr_23']); ?>" class="color-field" /></p> 
            <p><label><?php esc_html_e( 'Hover Color', 'eu-map-org' ); ?></label><input type="text" name="ovrclr_23" value="<?php echo esc_attr($eu_map_org['ovrclr_23']); ?>" class="color-field" /></p> 
            <p><label><?php esc_html_e( 'Click Color', 'eu-map-org' ); ?></label><input type="text" name="dwnclr_23" value="<?php echo esc_attr($eu_map_org['dwnclr_23']); ?>" class="color-field" /></p>
          </div>
          <div class="area-url">
            <p class="link"><label><?php esc_html_e( 'Link', 'eu-map-org' ); ?></label><input type="text" name="url_23" value="<?php echo esc_url($eu_map_org['url_23']); ?>" /></p>
            <p><label><?php esc_html_e( 'Target', 'eu-map-org' ); ?></label>
              <select name="turl_23">
                <option value="_self" <?php if ($eu_map_org['turl_23'] == '_self'){ echo esc_attr("selected"); } ?>><?php esc_html_e( 'Same Page', 'eu-map-org' ); ?></option>
                <option value="_blank" <?php if ($eu_map_org['turl_23'] == '_blank'){ echo esc_attr("selected"); } ?>><?php esc_html_e( 'New Page', 'eu-map-org' ); ?></option>
              </select>
            </p>
          </div>
        </div>
      </div>
      
      <div class="map-area"><p class="area-name"><?php esc_html_e( 'LITHUANIA', 'eu-map-org' ); ?></p>
        <span class="chkbx"><input type="checkbox" name="enbl_24" value="1" <?php if (isset($eu_map_org['enbl_24']) && $eu_map_org['enbl_24'] == '1'){ echo esc_attr(" checked"); } ?>>&nbsp;<?php esc_html_e( 'Active', 'eu-map-org' ); ?></span>
        <div class="inner-content">
          <div class="area-clrs">
            <p><label><?php esc_html_e( 'Up Color', 'eu-map-org' ); ?></label><input type="text" name="upclr_24" value="<?php echo esc_attr($eu_map_org['upclr_24']); ?>" class="color-field" /></p> 
            <p><label><?php esc_html_e( 'Hover Color', 'eu-map-org' ); ?></label><input type="text" name="ovrclr_24" value="<?php echo esc_attr($eu_map_org['ovrclr_24']); ?>" class="color-field" /></p> 
            <p><label><?php esc_html_e( 'Click Color', 'eu-map-org' ); ?></label><input type="text" name="dwnclr_24" value="<?php echo esc_attr($eu_map_org['dwnclr_24']); ?>" class="color-field" /></p>
          </div>
          <div class="area-url">
            <p class="link"><label><?php esc_html_e( 'Link', 'eu-map-org' ); ?></label><input type="text" name="url_24" value="<?php echo esc_url($eu_map_org['url_24']); ?>" /></p>
            <p><label><?php esc_html_e( 'Target', 'eu-map-org' ); ?></label>
              <select name="turl_24">
                <option value="_self" <?php if ($eu_map_org['turl_24'] == '_self'){ echo esc_attr("selected"); } ?>><?php esc_html_e( 'Same Page', 'eu-map-org' ); ?></option>
                <option value="_blank" <?php if ($eu_map_org['turl_24'] == '_blank'){ echo esc_attr("selected"); } ?>><?php esc_html_e( 'New Page', 'eu-map-org' ); ?></option>
              </select>
            </p>
          </div>
        </div>
      </div>
      
      <div class="map-area"><p class="area-name"><?php esc_html_e( 'LUXEMBOURG', 'eu-map-org' ); ?></p>
        <span class="chkbx"><input type="checkbox" name="enbl_25" value="1" <?php if (isset($eu_map_org['enbl_25']) && $eu_map_org['enbl_25'] == '1'){ echo esc_attr(" checked"); } ?>>&nbsp;<?php esc_html_e( 'Active', 'eu-map-org' ); ?></span>
        <div class="inner-content">
          <div class="area-clrs">
            <p><label><?php esc_html_e( 'Up Color', 'eu-map-org' ); ?></label><input type="text" name="upclr_25" value="<?php echo esc_attr($eu_map_org['upclr_25']); ?>" class="color-field" /></p> 
            <p><label><?php esc_html_e( 'Hover Color', 'eu-map-org' ); ?></label><input type="text" name="ovrclr_25" value="<?php echo esc_attr($eu_map_org['ovrclr_25']); ?>" class="color-field" /></p> 
            <p><label><?php esc_html_e( 'Click Color', 'eu-map-org' ); ?></label><input type="text" name="dwnclr_25" value="<?php echo esc_attr($eu_map_org['dwnclr_25']); ?>" class="color-field" /></p>
          </div>
          <div class="area-url">
            <p class="link"><label><?php esc_html_e( 'Link', 'eu-map-org' ); ?></label><input type="text" name="url_25" value="<?php echo esc_url($eu_map_org['url_25']); ?>" /></p>
            <p><label><?php esc_html_e( 'Target', 'eu-map-org' ); ?></label>
              <select name="turl_25">
                <option value="_self" <?php if ($eu_map_org['turl_25'] == '_self'){ echo esc_attr("selected"); } ?>><?php esc_html_e( 'Same Page', 'eu-map-org' ); ?></option>
                <option value="_blank" <?php if ($eu_map_org['turl_25'] == '_blank'){ echo esc_attr("selected"); } ?>><?php esc_html_e( 'New Page', 'eu-map-org' ); ?></option>
              </select>
            </p>
          </div>
        </div>
      </div>
      
      <div class="map-area"><p class="area-name"><?php esc_html_e( 'MACEDONIA', 'eu-map-org' ); ?></p>
        <span class="chkbx"><input type="checkbox" name="enbl_26" value="1" <?php if (isset($eu_map_org['enbl_26']) && $eu_map_org['enbl_26'] == '1'){ echo esc_attr(" checked"); } ?>>&nbsp;<?php esc_html_e( 'Active', 'eu-map-org' ); ?></span>
        <div class="inner-content">
          <div class="area-clrs">
            <p><label><?php esc_html_e( 'Up Color', 'eu-map-org' ); ?></label><input type="text" name="upclr_26" value="<?php echo esc_attr($eu_map_org['upclr_26']); ?>" class="color-field" /></p> 
            <p><label><?php esc_html_e( 'Hover Color', 'eu-map-org' ); ?></label><input type="text" name="ovrclr_26" value="<?php echo esc_attr($eu_map_org['ovrclr_26']); ?>" class="color-field" /></p> 
            <p><label><?php esc_html_e( 'Click Color', 'eu-map-org' ); ?></label><input type="text" name="dwnclr_26" value="<?php echo esc_attr($eu_map_org['dwnclr_26']); ?>" class="color-field" /></p>
          </div>
          <div class="area-url">
            <p class="link"><label><?php esc_html_e( 'Link', 'eu-map-org' ); ?></label><input type="text" name="url_26" value="<?php echo esc_url($eu_map_org['url_26']); ?>" /></p>
            <p><label><?php esc_html_e( 'Target', 'eu-map-org' ); ?></label>
              <select name="turl_26">
                <option value="_self" <?php if ($eu_map_org['turl_26'] == '_self'){ echo esc_attr("selected"); } ?>><?php esc_html_e( 'Same Page', 'eu-map-org' ); ?></option>
                <option value="_blank" <?php if ($eu_map_org['turl_26'] == '_blank'){ echo esc_attr("selected"); } ?>><?php esc_html_e( 'New Page', 'eu-map-org' ); ?></option>
              </select>
            </p>
          </div>
        </div>
      </div>
      
      <div class="map-area"><p class="area-name"><?php esc_html_e( 'MALTA', 'eu-map-org' ); ?></p>
        <span class="chkbx"><input type="checkbox" name="enbl_27" value="1" <?php if (isset($eu_map_org['enbl_27']) && $eu_map_org['enbl_27'] == '1'){ echo esc_attr(" checked"); } ?>>&nbsp;<?php esc_html_e( 'Active', 'eu-map-org' ); ?></span>
        <div class="inner-content">
          <div class="area-clrs">
            <p><label><?php esc_html_e( 'Up Color', 'eu-map-org' ); ?></label><input type="text" name="upclr_27" value="<?php echo esc_attr($eu_map_org['upclr_27']); ?>" class="color-field" /></p> 
            <p><label><?php esc_html_e( 'Hover Color', 'eu-map-org' ); ?></label><input type="text" name="ovrclr_27" value="<?php echo esc_attr($eu_map_org['ovrclr_27']); ?>" class="color-field" /></p> 
            <p><label><?php esc_html_e( 'Click Color', 'eu-map-org' ); ?></label><input type="text" name="dwnclr_27" value="<?php echo esc_attr($eu_map_org['dwnclr_27']); ?>" class="color-field" /></p>
          </div>
          <div class="area-url">
            <p class="link"><label><?php esc_html_e( 'Link', 'eu-map-org' ); ?></label><input type="text" name="url_27" value="<?php echo esc_url($eu_map_org['url_27']); ?>" /></p>
            <p><label><?php esc_html_e( 'Target', 'eu-map-org' ); ?></label>
              <select name="turl_27">
                <option value="_self" <?php if ($eu_map_org['turl_27'] == '_self'){ echo esc_attr("selected"); } ?>><?php esc_html_e( 'Same Page', 'eu-map-org' ); ?></option>
                <option value="_blank" <?php if ($eu_map_org['turl_27'] == '_blank'){ echo esc_attr("selected"); } ?>><?php esc_html_e( 'New Page', 'eu-map-org' ); ?></option>
              </select>
            </p>
          </div>
        </div>
      </div>
      
      <div class="map-area"><p class="area-name"><?php esc_html_e( 'MOLDOVA', 'eu-map-org' ); ?></p>
        <span class="chkbx"><input type="checkbox" name="enbl_28" value="1" <?php if (isset($eu_map_org['enbl_28']) && $eu_map_org['enbl_28'] == '1'){ echo esc_attr(" checked"); } ?>>&nbsp;<?php esc_html_e( 'Active', 'eu-map-org' ); ?></span>
        <div class="inner-content">
          <div class="area-clrs">
            <p><label><?php esc_html_e( 'Up Color', 'eu-map-org' ); ?></label><input type="text" name="upclr_28" value="<?php echo esc_attr($eu_map_org['upclr_28']); ?>" class="color-field" /></p> 
            <p><label><?php esc_html_e( 'Hover Color', 'eu-map-org' ); ?></label><input type="text" name="ovrclr_28" value="<?php echo esc_attr($eu_map_org['ovrclr_28']); ?>" class="color-field" /></p> 
            <p><label><?php esc_html_e( 'Click Color', 'eu-map-org' ); ?></label><input type="text" name="dwnclr_28" value="<?php echo esc_attr($eu_map_org['dwnclr_28']); ?>" class="color-field" /></p>
          </div>
          <div class="area-url">
            <p class="link"><label><?php esc_html_e( 'Link', 'eu-map-org' ); ?></label><input type="text" name="url_28" value="<?php echo esc_url($eu_map_org['url_28']); ?>" /></p>
            <p><label><?php esc_html_e( 'Target', 'eu-map-org' ); ?></label>
              <select name="turl_28">
                <option value="_self" <?php if ($eu_map_org['turl_28'] == '_self'){ echo esc_attr("selected"); } ?>><?php esc_html_e( 'Same Page', 'eu-map-org' ); ?></option>
                <option value="_blank" <?php if ($eu_map_org['turl_28'] == '_blank'){ echo esc_attr("selected"); } ?>><?php esc_html_e( 'New Page', 'eu-map-org' ); ?></option>
              </select>
            </p>
          </div>
        </div>
      </div>
      
      <div class="map-area"><p class="area-name"><?php esc_html_e( 'MONACO', 'eu-map-org' ); ?></p>
        <span class="chkbx"><input type="checkbox" name="enbl_29" value="1" <?php if (isset($eu_map_org['enbl_29']) && $eu_map_org['enbl_29'] == '1'){ echo esc_attr(" checked"); } ?>>&nbsp;<?php esc_html_e( 'Active', 'eu-map-org' ); ?></span>
        <div class="inner-content">
          <div class="area-clrs">
            <p><label><?php esc_html_e( 'Up Color', 'eu-map-org' ); ?></label><input type="text" name="upclr_29" value="<?php echo esc_attr($eu_map_org['upclr_29']); ?>" class="color-field" /></p> 
            <p><label><?php esc_html_e( 'Hover Color', 'eu-map-org' ); ?></label><input type="text" name="ovrclr_29" value="<?php echo esc_attr($eu_map_org['ovrclr_29']); ?>" class="color-field" /></p> 
            <p><label><?php esc_html_e( 'Click Color', 'eu-map-org' ); ?></label><input type="text" name="dwnclr_29" value="<?php echo esc_attr($eu_map_org['dwnclr_29']); ?>" class="color-field" /></p>
          </div>
          <div class="area-url">
            <p class="link"><label><?php esc_html_e( 'Link', 'eu-map-org' ); ?></label><input type="text" name="url_29" value="<?php echo esc_url($eu_map_org['url_29']); ?>" /></p>
            <p><label><?php esc_html_e( 'Target', 'eu-map-org' ); ?></label>
              <select name="turl_29">
                <option value="_self" <?php if ($eu_map_org['turl_29'] == '_self'){ echo esc_attr("selected"); } ?>><?php esc_html_e( 'Same Page', 'eu-map-org' ); ?></option>
                <option value="_blank" <?php if ($eu_map_org['turl_29'] == '_blank'){ echo esc_attr("selected"); } ?>><?php esc_html_e( 'New Page', 'eu-map-org' ); ?></option>
              </select>
            </p>
          </div>
        </div>
      </div>
      
      <div class="map-area"><p class="area-name"><?php esc_html_e( 'MONTENEGRO', 'eu-map-org' ); ?></p>
        <span class="chkbx"><input type="checkbox" name="enbl_30" value="1" <?php if (isset($eu_map_org['enbl_30']) && $eu_map_org['enbl_30'] == '1'){ echo esc_attr(" checked"); } ?>>&nbsp;<?php esc_html_e( 'Active', 'eu-map-org' ); ?></span>
        <div class="inner-content">
          <div class="area-clrs">
            <p><label><?php esc_html_e( 'Up Color', 'eu-map-org' ); ?></label><input type="text" name="upclr_30" value="<?php echo esc_attr($eu_map_org['upclr_30']); ?>" class="color-field" /></p> 
            <p><label><?php esc_html_e( 'Hover Color', 'eu-map-org' ); ?></label><input type="text" name="ovrclr_30" value="<?php echo esc_attr($eu_map_org['ovrclr_30']); ?>" class="color-field" /></p> 
            <p><label><?php esc_html_e( 'Click Color', 'eu-map-org' ); ?></label><input type="text" name="dwnclr_30" value="<?php echo esc_attr($eu_map_org['dwnclr_30']); ?>" class="color-field" /></p>
          </div>
          <div class="area-url">
            <p class="link"><label><?php esc_html_e( 'Link', 'eu-map-org' ); ?></label><input type="text" name="url_30" value="<?php echo esc_url($eu_map_org['url_30']); ?>" /></p>
            <p><label><?php esc_html_e( 'Target', 'eu-map-org' ); ?></label>
              <select name="turl_30">
                <option value="_self" <?php if ($eu_map_org['turl_30'] == '_self'){ echo esc_attr("selected"); } ?>><?php esc_html_e( 'Same Page', 'eu-map-org' ); ?></option>
                <option value="_blank" <?php if ($eu_map_org['turl_30'] == '_blank'){ echo esc_attr("selected"); } ?>><?php esc_html_e( 'New Page', 'eu-map-org' ); ?></option>
              </select>
            </p>
          </div>
        </div>
      </div>
      
      <div class="map-area"><p class="area-name"><?php esc_html_e( 'NETHERLANDS', 'eu-map-org' ); ?></p>
        <span class="chkbx"><input type="checkbox" name="enbl_31" value="1" <?php if (isset($eu_map_org['enbl_31']) && $eu_map_org['enbl_31'] == '1'){ echo esc_attr(" checked"); } ?>>&nbsp;<?php esc_html_e( 'Active', 'eu-map-org' ); ?></span>
        <div class="inner-content">
          <div class="area-clrs">
            <p><label><?php esc_html_e( 'Up Color', 'eu-map-org' ); ?></label><input type="text" name="upclr_31" value="<?php echo esc_attr($eu_map_org['upclr_31']); ?>" class="color-field" /></p> 
            <p><label><?php esc_html_e( 'Hover Color', 'eu-map-org' ); ?></label><input type="text" name="ovrclr_31" value="<?php echo esc_attr($eu_map_org['ovrclr_31']); ?>" class="color-field" /></p> 
            <p><label><?php esc_html_e( 'Click Color', 'eu-map-org' ); ?></label><input type="text" name="dwnclr_31" value="<?php echo esc_attr($eu_map_org['dwnclr_31']); ?>" class="color-field" /></p>
          </div>
          <div class="area-url">
            <p class="link"><label><?php esc_html_e( 'Link', 'eu-map-org' ); ?></label><input type="text" name="url_31" value="<?php echo esc_url($eu_map_org['url_31']); ?>" /></p>
            <p><label><?php esc_html_e( 'Target', 'eu-map-org' ); ?></label>
              <select name="turl_31">
                <option value="_self" <?php if ($eu_map_org['turl_31'] == '_self'){ echo esc_attr("selected"); } ?>><?php esc_html_e( 'Same Page', 'eu-map-org' ); ?></option>
                <option value="_blank" <?php if ($eu_map_org['turl_31'] == '_blank'){ echo esc_attr("selected"); } ?>><?php esc_html_e( 'New Page', 'eu-map-org' ); ?></option>
              </select>
            </p>
          </div>
        </div>
      </div>
      
      <div class="map-area"><p class="area-name"><?php esc_html_e( 'NORWAY', 'eu-map-org' ); ?></p>
        <span class="chkbx"><input type="checkbox" name="enbl_32" value="1" <?php if (isset($eu_map_org['enbl_32']) && $eu_map_org['enbl_32'] == '1'){ echo esc_attr(" checked"); } ?>>&nbsp;<?php esc_html_e( 'Active', 'eu-map-org' ); ?></span>
        <div class="inner-content">
          <div class="area-clrs">
            <p><label><?php esc_html_e( 'Up Color', 'eu-map-org' ); ?></label><input type="text" name="upclr_32" value="<?php echo esc_attr($eu_map_org['upclr_32']); ?>" class="color-field" /></p> 
            <p><label><?php esc_html_e( 'Hover Color', 'eu-map-org' ); ?></label><input type="text" name="ovrclr_32" value="<?php echo esc_attr($eu_map_org['ovrclr_32']); ?>" class="color-field" /></p> 
            <p><label><?php esc_html_e( 'Click Color', 'eu-map-org' ); ?></label><input type="text" name="dwnclr_32" value="<?php echo esc_attr($eu_map_org['dwnclr_32']); ?>" class="color-field" /></p>
          </div>
          <div class="area-url">
            <p class="link"><label><?php esc_html_e( 'Link', 'eu-map-org' ); ?></label><input type="text" name="url_32" value="<?php echo esc_url($eu_map_org['url_32']); ?>" /></p>
            <p><label><?php esc_html_e( 'Target', 'eu-map-org' ); ?></label>
              <select name="turl_32">
                <option value="_self" <?php if ($eu_map_org['turl_32'] == '_self'){ echo esc_attr("selected"); } ?>><?php esc_html_e( 'Same Page', 'eu-map-org' ); ?></option>
                <option value="_blank" <?php if ($eu_map_org['turl_32'] == '_blank'){ echo esc_attr("selected"); } ?>><?php esc_html_e( 'New Page', 'eu-map-org' ); ?></option>
              </select>
            </p>
          </div>
        </div>
      </div>
      
      <div class="map-area"><p class="area-name"><?php esc_html_e( 'POLAND', 'eu-map-org' ); ?></p>
        <span class="chkbx"><input type="checkbox" name="enbl_33" value="1" <?php if (isset($eu_map_org['enbl_33']) && $eu_map_org['enbl_33'] == '1'){ echo esc_attr(" checked"); } ?>>&nbsp;<?php esc_html_e( 'Active', 'eu-map-org' ); ?></span>
        <div class="inner-content">
          <div class="area-clrs">
            <p><label><?php esc_html_e( 'Up Color', 'eu-map-org' ); ?></label><input type="text" name="upclr_33" value="<?php echo esc_attr($eu_map_org['upclr_33']); ?>" class="color-field" /></p> 
            <p><label><?php esc_html_e( 'Hover Color', 'eu-map-org' ); ?></label><input type="text" name="ovrclr_33" value="<?php echo esc_attr($eu_map_org['ovrclr_33']); ?>" class="color-field" /></p> 
            <p><label><?php esc_html_e( 'Click Color', 'eu-map-org' ); ?></label><input type="text" name="dwnclr_33" value="<?php echo esc_attr($eu_map_org['dwnclr_33']); ?>" class="color-field" /></p>
          </div>
          <div class="area-url">
            <p class="link"><label><?php esc_html_e( 'Link', 'eu-map-org' ); ?></label><input type="text" name="url_33" value="<?php echo esc_url($eu_map_org['url_33']); ?>" /></p>
            <p><label><?php esc_html_e( 'Target', 'eu-map-org' ); ?></label>
              <select name="turl_33">
                <option value="_self" <?php if ($eu_map_org['turl_33'] == '_self'){ echo esc_attr("selected"); } ?>><?php esc_html_e( 'Same Page', 'eu-map-org' ); ?></option>
                <option value="_blank" <?php if ($eu_map_org['turl_33'] == '_blank'){ echo esc_attr("selected"); } ?>><?php esc_html_e( 'New Page', 'eu-map-org' ); ?></option>
              </select>
            </p>
          </div>
        </div>
      </div>
      
      <div class="map-area"><p class="area-name"><?php esc_html_e( 'PORTUGAL', 'eu-map-org' ); ?></p>
        <span class="chkbx"><input type="checkbox" name="enbl_34" value="1" <?php if (isset($eu_map_org['enbl_34']) && $eu_map_org['enbl_34'] == '1'){ echo esc_attr(" checked"); } ?>>&nbsp;<?php esc_html_e( 'Active', 'eu-map-org' ); ?></span>
        <div class="inner-content">
          <div class="area-clrs">
            <p><label><?php esc_html_e( 'Up Color', 'eu-map-org' ); ?></label><input type="text" name="upclr_34" value="<?php echo esc_attr($eu_map_org['upclr_34']); ?>" class="color-field" /></p> 
            <p><label><?php esc_html_e( 'Hover Color', 'eu-map-org' ); ?></label><input type="text" name="ovrclr_34" value="<?php echo esc_attr($eu_map_org['ovrclr_34']); ?>" class="color-field" /></p> 
            <p><label><?php esc_html_e( 'Click Color', 'eu-map-org' ); ?></label><input type="text" name="dwnclr_34" value="<?php echo esc_attr($eu_map_org['dwnclr_34']); ?>" class="color-field" /></p>
          </div>
          <div class="area-url">
            <p class="link"><label><?php esc_html_e( 'Link', 'eu-map-org' ); ?></label><input type="text" name="url_34" value="<?php echo esc_url($eu_map_org['url_34']); ?>" /></p>
            <p><label><?php esc_html_e( 'Target', 'eu-map-org' ); ?></label>
              <select name="turl_34">
                <option value="_self" <?php if ($eu_map_org['turl_34'] == '_self'){ echo esc_attr("selected"); } ?>><?php esc_html_e( 'Same Page', 'eu-map-org' ); ?></option>
                <option value="_blank" <?php if ($eu_map_org['turl_34'] == '_blank'){ echo esc_attr("selected"); } ?>><?php esc_html_e( 'New Page', 'eu-map-org' ); ?></option>
              </select>
            </p>
          </div>
        </div>
      </div>
      
      <div class="map-area"><p class="area-name"><?php esc_html_e( 'ROMANIA', 'eu-map-org' ); ?></p>
        <span class="chkbx"><input type="checkbox" name="enbl_35" value="1" <?php if (isset($eu_map_org['enbl_35']) && $eu_map_org['enbl_35'] == '1'){ echo esc_attr(" checked"); } ?>>&nbsp;<?php esc_html_e( 'Active', 'eu-map-org' ); ?></span>
        <div class="inner-content">
          <div class="area-clrs">
            <p><label><?php esc_html_e( 'Up Color', 'eu-map-org' ); ?></label><input type="text" name="upclr_35" value="<?php echo esc_attr($eu_map_org['upclr_35']); ?>" class="color-field" /></p> 
            <p><label><?php esc_html_e( 'Hover Color', 'eu-map-org' ); ?></label><input type="text" name="ovrclr_35" value="<?php echo esc_attr($eu_map_org['ovrclr_35']); ?>" class="color-field" /></p> 
            <p><label><?php esc_html_e( 'Click Color', 'eu-map-org' ); ?></label><input type="text" name="dwnclr_35" value="<?php echo esc_attr($eu_map_org['dwnclr_35']); ?>" class="color-field" /></p>
          </div>
          <div class="area-url">
            <p class="link"><label><?php esc_html_e( 'Link', 'eu-map-org' ); ?></label><input type="text" name="url_35" value="<?php echo esc_url($eu_map_org['url_35']); ?>" /></p>
            <p><label><?php esc_html_e( 'Target', 'eu-map-org' ); ?></label>
              <select name="turl_35">
                <option value="_self" <?php if ($eu_map_org['turl_35'] == '_self'){ echo esc_attr("selected"); } ?>><?php esc_html_e( 'Same Page', 'eu-map-org' ); ?></option>
                <option value="_blank" <?php if ($eu_map_org['turl_35'] == '_blank'){ echo esc_attr("selected"); } ?>><?php esc_html_e( 'New Page', 'eu-map-org' ); ?></option>
              </select>
            </p>
          </div>
        </div>
      </div>
      
      <div class="map-area"><p class="area-name"><?php esc_html_e( 'RUSSIA (EUROPEAN PART)', 'eu-map-org' ); ?></p>
        <span class="chkbx"><input type="checkbox" name="enbl_36" value="1" <?php if (isset($eu_map_org['enbl_36']) && $eu_map_org['enbl_36'] == '1'){ echo esc_attr(" checked"); } ?>>&nbsp;<?php esc_html_e( 'Active', 'eu-map-org' ); ?></span>
        <div class="inner-content">
          <div class="area-clrs">
            <p><label><?php esc_html_e( 'Up Color', 'eu-map-org' ); ?></label><input type="text" name="upclr_36" value="<?php echo esc_attr($eu_map_org['upclr_36']); ?>" class="color-field" /></p> 
            <p><label><?php esc_html_e( 'Hover Color', 'eu-map-org' ); ?></label><input type="text" name="ovrclr_36" value="<?php echo esc_attr($eu_map_org['ovrclr_36']); ?>" class="color-field" /></p> 
            <p><label><?php esc_html_e( 'Click Color', 'eu-map-org' ); ?></label><input type="text" name="dwnclr_36" value="<?php echo esc_attr($eu_map_org['dwnclr_36']); ?>" class="color-field" /></p>
          </div>
          <div class="area-url">
            <p class="link"><label><?php esc_html_e( 'Link', 'eu-map-org' ); ?></label><input type="text" name="url_36" value="<?php echo esc_url($eu_map_org['url_36']); ?>" /></p>
            <p><label><?php esc_html_e( 'Target', 'eu-map-org' ); ?></label>
              <select name="turl_36">
                <option value="_self" <?php if ($eu_map_org['turl_36'] == '_self'){ echo esc_attr("selected"); } ?>><?php esc_html_e( 'Same Page', 'eu-map-org' ); ?></option>
                <option value="_blank" <?php if ($eu_map_org['turl_36'] == '_blank'){ echo esc_attr("selected"); } ?>><?php esc_html_e( 'New Page', 'eu-map-org' ); ?></option>
              </select>
            </p>
          </div>
        </div>
      </div>
      
      <div class="map-area"><p class="area-name"><?php esc_html_e( 'SAN MARINO', 'eu-map-org' ); ?></p>
        <span class="chkbx"><input type="checkbox" name="enbl_37" value="1" <?php if (isset($eu_map_org['enbl_37']) && $eu_map_org['enbl_37'] == '1'){ echo esc_attr(" checked"); } ?>>&nbsp;<?php esc_html_e( 'Active', 'eu-map-org' ); ?></span>
        <div class="inner-content">
          <div class="area-clrs">
            <p><label><?php esc_html_e( 'Up Color', 'eu-map-org' ); ?></label><input type="text" name="upclr_37" value="<?php echo esc_attr($eu_map_org['upclr_37']); ?>" class="color-field" /></p> 
            <p><label><?php esc_html_e( 'Hover Color', 'eu-map-org' ); ?></label><input type="text" name="ovrclr_37" value="<?php echo esc_attr($eu_map_org['ovrclr_37']); ?>" class="color-field" /></p> 
            <p><label><?php esc_html_e( 'Click Color', 'eu-map-org' ); ?></label><input type="text" name="dwnclr_37" value="<?php echo esc_attr($eu_map_org['dwnclr_37']); ?>" class="color-field" /></p>
          </div>
          <div class="area-url">
            <p class="link"><label><?php esc_html_e( 'Link', 'eu-map-org' ); ?></label><input type="text" name="url_37" value="<?php echo esc_url($eu_map_org['url_37']); ?>" /></p>
            <p><label><?php esc_html_e( 'Target', 'eu-map-org' ); ?></label>
              <select name="turl_37">
                <option value="_self" <?php if ($eu_map_org['turl_37'] == '_self'){ echo esc_attr("selected"); } ?>><?php esc_html_e( 'Same Page', 'eu-map-org' ); ?></option>
                <option value="_blank" <?php if ($eu_map_org['turl_37'] == '_blank'){ echo esc_attr("selected"); } ?>><?php esc_html_e( 'New Page', 'eu-map-org' ); ?></option>
              </select>
            </p>
          </div>
        </div>
      </div>
      
      <div class="map-area"><p class="area-name"><?php esc_html_e( 'SERBIA', 'eu-map-org' ); ?></p>
        <span class="chkbx"><input type="checkbox" name="enbl_38" value="1" <?php if (isset($eu_map_org['enbl_38']) && $eu_map_org['enbl_38'] == '1'){ echo esc_attr(" checked"); } ?>>&nbsp;<?php esc_html_e( 'Active', 'eu-map-org' ); ?></span>
        <div class="inner-content">
          <div class="area-clrs">
            <p><label><?php esc_html_e( 'Up Color', 'eu-map-org' ); ?></label><input type="text" name="upclr_38" value="<?php echo esc_attr($eu_map_org['upclr_38']); ?>" class="color-field" /></p> 
            <p><label><?php esc_html_e( 'Hover Color', 'eu-map-org' ); ?></label><input type="text" name="ovrclr_38" value="<?php echo esc_attr($eu_map_org['ovrclr_38']); ?>" class="color-field" /></p> 
            <p><label><?php esc_html_e( 'Click Color', 'eu-map-org' ); ?></label><input type="text" name="dwnclr_38" value="<?php echo esc_attr($eu_map_org['dwnclr_38']); ?>" class="color-field" /></p>
          </div>
          <div class="area-url">
            <p class="link"><label><?php esc_html_e( 'Link', 'eu-map-org' ); ?></label><input type="text" name="url_38" value="<?php echo esc_url($eu_map_org['url_38']); ?>" /></p>
            <p><label><?php esc_html_e( 'Target', 'eu-map-org' ); ?></label>
              <select name="turl_38">
                <option value="_self" <?php if ($eu_map_org['turl_38'] == '_self'){ echo esc_attr("selected"); } ?>><?php esc_html_e( 'Same Page', 'eu-map-org' ); ?></option>
                <option value="_blank" <?php if ($eu_map_org['turl_38'] == '_blank'){ echo esc_attr("selected"); } ?>><?php esc_html_e( 'New Page', 'eu-map-org' ); ?></option>
              </select>
            </p>
          </div>
        </div>
      </div>
      
      <div class="map-area"><p class="area-name"><?php esc_html_e( 'SLOVAKIA', 'eu-map-org' ); ?></p>
        <span class="chkbx"><input type="checkbox" name="enbl_39" value="1" <?php if (isset($eu_map_org['enbl_39']) && $eu_map_org['enbl_39'] == '1'){ echo esc_attr(" checked"); } ?>>&nbsp;<?php esc_html_e( 'Active', 'eu-map-org' ); ?></span>
        <div class="inner-content">
          <div class="area-clrs">
            <p><label><?php esc_html_e( 'Up Color', 'eu-map-org' ); ?></label><input type="text" name="upclr_39" value="<?php echo esc_attr($eu_map_org['upclr_39']); ?>" class="color-field" /></p> 
            <p><label><?php esc_html_e( 'Hover Color', 'eu-map-org' ); ?></label><input type="text" name="ovrclr_39" value="<?php echo esc_attr($eu_map_org['ovrclr_39']); ?>" class="color-field" /></p> 
            <p><label><?php esc_html_e( 'Click Color', 'eu-map-org' ); ?></label><input type="text" name="dwnclr_39" value="<?php echo esc_attr($eu_map_org['dwnclr_39']); ?>" class="color-field" /></p>
          </div>
          <div class="area-url">
            <p class="link"><label><?php esc_html_e( 'Link', 'eu-map-org' ); ?></label><input type="text" name="url_39" value="<?php echo esc_url($eu_map_org['url_39']); ?>" /></p>
            <p><label><?php esc_html_e( 'Target', 'eu-map-org' ); ?></label>
              <select name="turl_39">
                <option value="_self" <?php if ($eu_map_org['turl_39'] == '_self'){ echo esc_attr("selected"); } ?>><?php esc_html_e( 'Same Page', 'eu-map-org' ); ?></option>
                <option value="_blank" <?php if ($eu_map_org['turl_39'] == '_blank'){ echo esc_attr("selected"); } ?>><?php esc_html_e( 'New Page', 'eu-map-org' ); ?></option>
              </select>
            </p>
          </div>
        </div>
      </div>
      
      <div class="map-area"><p class="area-name"><?php esc_html_e( 'SLOVENIA', 'eu-map-org' ); ?></p>
        <span class="chkbx"><input type="checkbox" name="enbl_40" value="1" <?php if (isset($eu_map_org['enbl_40']) && $eu_map_org['enbl_40'] == '1'){ echo esc_attr(" checked"); } ?>>&nbsp;<?php esc_html_e( 'Active', 'eu-map-org' ); ?></span>
        <div class="inner-content">
          <div class="area-clrs">
            <p><label><?php esc_html_e( 'Up Color', 'eu-map-org' ); ?></label><input type="text" name="upclr_40" value="<?php echo esc_attr($eu_map_org['upclr_40']); ?>" class="color-field" /></p> 
            <p><label><?php esc_html_e( 'Hover Color', 'eu-map-org' ); ?></label><input type="text" name="ovrclr_40" value="<?php echo esc_attr($eu_map_org['ovrclr_40']); ?>" class="color-field" /></p> 
            <p><label><?php esc_html_e( 'Click Color', 'eu-map-org' ); ?></label><input type="text" name="dwnclr_40" value="<?php echo esc_attr($eu_map_org['dwnclr_40']); ?>" class="color-field" /></p>
          </div>
          <div class="area-url">
            <p class="link"><label><?php esc_html_e( 'Link', 'eu-map-org' ); ?></label><input type="text" name="url_40" value="<?php echo esc_url($eu_map_org['url_40']); ?>" /></p>
            <p><label><?php esc_html_e( 'Target', 'eu-map-org' ); ?></label>
              <select name="turl_40">
                <option value="_self" <?php if ($eu_map_org['turl_40'] == '_self'){ echo esc_attr("selected"); } ?>><?php esc_html_e( 'Same Page', 'eu-map-org' ); ?></option>
                <option value="_blank" <?php if ($eu_map_org['turl_40'] == '_blank'){ echo esc_attr("selected"); } ?>><?php esc_html_e( 'New Page', 'eu-map-org' ); ?></option>
              </select>
            </p>
          </div>
        </div>
      </div>
      
      <div class="map-area"><p class="area-name"><?php esc_html_e( 'SPAIN', 'eu-map-org' ); ?></p>
        <span class="chkbx"><input type="checkbox" name="enbl_41" value="1" <?php if (isset($eu_map_org['enbl_41']) && $eu_map_org['enbl_41'] == '1'){ echo esc_attr(" checked"); } ?>>&nbsp;<?php esc_html_e( 'Active', 'eu-map-org' ); ?></span>
        <div class="inner-content">
          <div class="area-clrs">
            <p><label><?php esc_html_e( 'Up Color', 'eu-map-org' ); ?></label><input type="text" name="upclr_41" value="<?php echo esc_attr($eu_map_org['upclr_41']); ?>" class="color-field" /></p> 
            <p><label><?php esc_html_e( 'Hover Color', 'eu-map-org' ); ?></label><input type="text" name="ovrclr_41" value="<?php echo esc_attr($eu_map_org['ovrclr_41']); ?>" class="color-field" /></p> 
            <p><label><?php esc_html_e( 'Click Color', 'eu-map-org' ); ?></label><input type="text" name="dwnclr_41" value="<?php echo esc_attr($eu_map_org['dwnclr_41']); ?>" class="color-field" /></p>
          </div>
          <div class="area-url">
            <p class="link"><label><?php esc_html_e( 'Link', 'eu-map-org' ); ?></label><input type="text" name="url_41" value="<?php echo esc_url($eu_map_org['url_41']); ?>" /></p>
            <p><label><?php esc_html_e( 'Target', 'eu-map-org' ); ?></label>
              <select name="turl_41">
                <option value="_self" <?php if ($eu_map_org['turl_41'] == '_self'){ echo esc_attr("selected"); } ?>><?php esc_html_e( 'Same Page', 'eu-map-org' ); ?></option>
                <option value="_blank" <?php if ($eu_map_org['turl_41'] == '_blank'){ echo esc_attr("selected"); } ?>><?php esc_html_e( 'New Page', 'eu-map-org' ); ?></option>
              </select>
            </p>
          </div>
        </div>
      </div>
      
      <div class="map-area"><p class="area-name"><?php esc_html_e( 'SWEDEN', 'eu-map-org' ); ?></p>
        <span class="chkbx"><input type="checkbox" name="enbl_42" value="1" <?php if (isset($eu_map_org['enbl_42']) && $eu_map_org['enbl_42'] == '1'){ echo esc_attr(" checked"); } ?>>&nbsp;<?php esc_html_e( 'Active', 'eu-map-org' ); ?></span>
        <div class="inner-content">
          <div class="area-clrs">
            <p><label><?php esc_html_e( 'Up Color', 'eu-map-org' ); ?></label><input type="text" name="upclr_42" value="<?php echo esc_attr($eu_map_org['upclr_42']); ?>" class="color-field" /></p> 
            <p><label><?php esc_html_e( 'Hover Color', 'eu-map-org' ); ?></label><input type="text" name="ovrclr_42" value="<?php echo esc_attr($eu_map_org['ovrclr_42']); ?>" class="color-field" /></p> 
            <p><label><?php esc_html_e( 'Click Color', 'eu-map-org' ); ?></label><input type="text" name="dwnclr_42" value="<?php echo esc_attr($eu_map_org['dwnclr_42']); ?>" class="color-field" /></p>
          </div>
          <div class="area-url">
            <p class="link"><label><?php esc_html_e( 'Link', 'eu-map-org' ); ?></label><input type="text" name="url_42" value="<?php echo esc_url($eu_map_org['url_42']); ?>" /></p>
            <p><label><?php esc_html_e( 'Target', 'eu-map-org' ); ?></label>
              <select name="turl_42">
                <option value="_self" <?php if ($eu_map_org['turl_42'] == '_self'){ echo esc_attr("selected"); } ?>><?php esc_html_e( 'Same Page', 'eu-map-org' ); ?></option>
                <option value="_blank" <?php if ($eu_map_org['turl_42'] == '_blank'){ echo esc_attr("selected"); } ?>><?php esc_html_e( 'New Page', 'eu-map-org' ); ?></option>
              </select>
            </p>
          </div>
        </div>
      </div>
      
      <div class="map-area"><p class="area-name"><?php esc_html_e( 'SWITZERLAND', 'eu-map-org' ); ?></p>
        <span class="chkbx"><input type="checkbox" name="enbl_43" value="1" <?php if (isset($eu_map_org['enbl_43']) && $eu_map_org['enbl_43'] == '1'){ echo esc_attr(" checked"); } ?>>&nbsp;<?php esc_html_e( 'Active', 'eu-map-org' ); ?></span>
        <div class="inner-content">
          <div class="area-clrs">
            <p><label><?php esc_html_e( 'Up Color', 'eu-map-org' ); ?></label><input type="text" name="upclr_43" value="<?php echo esc_attr($eu_map_org['upclr_43']); ?>" class="color-field" /></p> 
            <p><label><?php esc_html_e( 'Hover Color', 'eu-map-org' ); ?></label><input type="text" name="ovrclr_43" value="<?php echo esc_attr($eu_map_org['ovrclr_43']); ?>" class="color-field" /></p> 
            <p><label><?php esc_html_e( 'Click Color', 'eu-map-org' ); ?></label><input type="text" name="dwnclr_43" value="<?php echo esc_attr($eu_map_org['dwnclr_43']); ?>" class="color-field" /></p>
          </div>
          <div class="area-url">
            <p class="link"><label><?php esc_html_e( 'Link', 'eu-map-org' ); ?></label><input type="text" name="url_43" value="<?php echo esc_url($eu_map_org['url_43']); ?>" /></p>
            <p><label><?php esc_html_e( 'Target', 'eu-map-org' ); ?></label>
              <select name="turl_43">
                <option value="_self" <?php if ($eu_map_org['turl_43'] == '_self'){ echo esc_attr("selected"); } ?>><?php esc_html_e( 'Same Page', 'eu-map-org' ); ?></option>
                <option value="_blank" <?php if ($eu_map_org['turl_43'] == '_blank'){ echo esc_attr("selected"); } ?>><?php esc_html_e( 'New Page', 'eu-map-org' ); ?></option>
              </select>
            </p>
          </div>
        </div>
      </div>
      
      <div class="map-area"><p class="area-name"><?php esc_html_e( 'UKRAINE', 'eu-map-org' ); ?></p>
        <span class="chkbx"><input type="checkbox" name="enbl_44" value="1" <?php if (isset($eu_map_org['enbl_44']) && $eu_map_org['enbl_44'] == '1'){ echo esc_attr(" checked"); } ?>>&nbsp;<?php esc_html_e( 'Active', 'eu-map-org' ); ?></span>
        <div class="inner-content">
          <div class="area-clrs">
            <p><label><?php esc_html_e( 'Up Color', 'eu-map-org' ); ?></label><input type="text" name="upclr_44" value="<?php echo esc_attr($eu_map_org['upclr_44']); ?>" class="color-field" /></p> 
            <p><label><?php esc_html_e( 'Hover Color', 'eu-map-org' ); ?></label><input type="text" name="ovrclr_44" value="<?php echo esc_attr($eu_map_org['ovrclr_44']); ?>" class="color-field" /></p> 
            <p><label><?php esc_html_e( 'Click Color', 'eu-map-org' ); ?></label><input type="text" name="dwnclr_44" value="<?php echo esc_attr($eu_map_org['dwnclr_44']); ?>" class="color-field" /></p>
          </div>
          <div class="area-url">
            <p class="link"><label><?php esc_html_e( 'Link', 'eu-map-org' ); ?></label><input type="text" name="url_44" value="<?php echo esc_url($eu_map_org['url_44']); ?>" /></p>
            <p><label><?php esc_html_e( 'Target', 'eu-map-org' ); ?></label>
              <select name="turl_44">
                <option value="_self" <?php if ($eu_map_org['turl_44'] == '_self'){ echo esc_attr("selected"); } ?>><?php esc_html_e( 'Same Page', 'eu-map-org' ); ?></option>
                <option value="_blank" <?php if ($eu_map_org['turl_44'] == '_blank'){ echo esc_attr("selected"); } ?>><?php esc_html_e( 'New Page', 'eu-map-org' ); ?></option>
              </select>
            </p>
          </div>
        </div>
      </div>
      
      <div class="map-area"><p class="area-name"><?php esc_html_e( 'UNITED KINGDOM', 'eu-map-org' ); ?></p>
        <span class="chkbx"><input type="checkbox" name="enbl_45" value="1" <?php if (isset($eu_map_org['enbl_45']) && $eu_map_org['enbl_45'] == '1'){ echo esc_attr(" checked"); } ?>>&nbsp;<?php esc_html_e( 'Active', 'eu-map-org' ); ?></span>
        <div class="inner-content">
          <div class="area-clrs">
            <p><label><?php esc_html_e( 'Up Color', 'eu-map-org' ); ?></label><input type="text" name="upclr_45" value="<?php echo esc_attr($eu_map_org['upclr_45']); ?>" class="color-field" /></p> 
            <p><label><?php esc_html_e( 'Hover Color', 'eu-map-org' ); ?></label><input type="text" name="ovrclr_45" value="<?php echo esc_attr($eu_map_org['ovrclr_45']); ?>" class="color-field" /></p> 
            <p><label><?php esc_html_e( 'Click Color', 'eu-map-org' ); ?></label><input type="text" name="dwnclr_45" value="<?php echo esc_attr($eu_map_org['dwnclr_45']); ?>" class="color-field" /></p>
          </div>
          <div class="area-url">
            <p class="link"><label><?php esc_html_e( 'Link', 'eu-map-org' ); ?></label><input type="text" name="url_45" value="<?php echo esc_url($eu_map_org['url_45']); ?>" /></p>
            <p><label><?php esc_html_e( 'Target', 'eu-map-org' ); ?></label>
              <select name="turl_45">
                <option value="_self" <?php if ($eu_map_org['turl_45'] == '_self'){ echo esc_attr("selected"); } ?>><?php esc_html_e( 'Same Page', 'eu-map-org' ); ?></option>
                <option value="_blank" <?php if ($eu_map_org['turl_45'] == '_blank'){ echo esc_attr("selected"); } ?>><?php esc_html_e( 'New Page', 'eu-map-org' ); ?></option>
              </select>
            </p>
          </div>
        </div>
      </div>
      
      <div class="map-area"><p class="area-name"><?php esc_html_e( 'VATICAN CITY', 'eu-map-org' ); ?></p>
        <span class="chkbx"><input type="checkbox" name="enbl_46" value="1" <?php if (isset($eu_map_org['enbl_46']) && $eu_map_org['enbl_46'] == '1'){ echo esc_attr(" checked"); } ?>>&nbsp;<?php esc_html_e( 'Active', 'eu-map-org' ); ?></span>
        <div class="inner-content">
          <div class="area-clrs">
            <p><label><?php esc_html_e( 'Up Color', 'eu-map-org' ); ?></label><input type="text" name="upclr_46" value="<?php echo esc_attr($eu_map_org['upclr_46']); ?>" class="color-field" /></p> 
            <p><label><?php esc_html_e( 'Hover Color', 'eu-map-org' ); ?></label><input type="text" name="ovrclr_46" value="<?php echo esc_attr($eu_map_org['ovrclr_46']); ?>" class="color-field" /></p> 
            <p><label><?php esc_html_e( 'Click Color', 'eu-map-org' ); ?></label><input type="text" name="dwnclr_46" value="<?php echo esc_attr($eu_map_org['dwnclr_46']); ?>" class="color-field" /></p>
          </div>
          <div class="area-url">
            <p class="link"><label><?php esc_html_e( 'Link', 'eu-map-org' ); ?></label><input type="text" name="url_46" value="<?php echo esc_url($eu_map_org['url_46']); ?>" /></p>
            <p><label><?php esc_html_e( 'Target', 'eu-map-org' ); ?></label>
              <select name="turl_46">
                <option value="_self" <?php if ($eu_map_org['turl_46'] == '_self'){ echo esc_attr("selected"); } ?>><?php esc_html_e( 'Same Page', 'eu-map-org' ); ?></option>
                <option value="_blank" <?php if ($eu_map_org['turl_46'] == '_blank'){ echo esc_attr("selected"); } ?>><?php esc_html_e( 'New Page', 'eu-map-org' ); ?></option>
              </select>
            </p>
          </div>
        </div>
      </div>
      
    </div><!-- box-body / for areas -->
  </div><!-- map-settings / for areas -->

  <div class="map-settings margin-top-10">
    <div class="box-header bulk-i"><?php esc_html_e( 'Bulk Edit', 'eu-map-org' ); ?></div>
    <div class="box-body">
      <div class="map-area"><p class="area-name"><?php esc_html_e( 'COLORS', 'eu-map-org' ); ?></p>
        <div class="inner-content">
          <div class="area-clrs">
            <p><label><?php esc_html_e( 'Up Color', 'eu-map-org' ); ?></label><input type="text" name="upclr_all" value="<?php echo esc_attr($eu_map_org['upclr_1']); ?>" class="color-field" /></p>
            <p><label><?php esc_html_e( 'Hover Color', 'eu-map-org' ); ?></label><input type="text" name="ovrclr_all" value="<?php echo esc_attr($eu_map_org['ovrclr_1']); ?>" class="color-field" /></p> 
            <p><label><?php esc_html_e( 'Click Color', 'eu-map-org' ); ?></label><input type="text" name="dwnclr_all" value="<?php echo esc_attr($eu_map_org['dwnclr_1']); ?>" class="color-field" /></p>
          </div><hr>
          <p><span class="submitbulk"><input type="submit" class="button button-primary" name="submit-clrs" value="Overwrite Colors"></span> <strong><?php esc_html_e( 'Note: Clicking this button will overwrite the colors of the entire map.', 'eu-map-org' ); ?></strong></p>
        </div>
      </div>
      <div class="map-area"><p class="area-name"><?php esc_html_e( 'LINK', 'eu-map-org' ); ?></p>
        <div class="inner-content">
          <div class="area-url">
            <p class="link"><label><?php esc_html_e( 'Link', 'eu-map-org' ); ?></label><input type="text" name="url_all" value="<?php echo esc_url($eu_map_org['url_1']); ?>" /></p>
            <p><label><?php esc_html_e( 'Target', 'eu-map-org' ); ?></label>
              <select name="turl_all">
                <option value="_self" <?php if ($eu_map_org['turl_1'] == '_self') { echo esc_attr("selected"); } ?>><?php esc_html_e( 'Same Page', 'eu-map-org' ); ?></option>
                <option value="_blank" <?php if ($eu_map_org['turl_1'] == '_blank') { echo esc_attr("selected"); } ?>><?php esc_html_e( 'New Page', 'eu-map-org' ); ?></option>
              </select>
            </p>
          </div><hr>              
          <p><span class="submitbulk"><input type="submit" class="button button-primary" name="submit-url" value="Overwrite Links"></span> <strong><?php esc_html_e( 'Note: Clicking this button will overwrite the links of all the countries.', 'eu-map-org' ); ?></strong></p>
        </div>
      </div>
    </div><!-- box-body / for bulk -->
  </div><!-- map-settings / for bulk -->

  <input type="hidden" name="eu_map_org">
  <?php
  settings_fields(__FILE__);
  do_settings_sections(__FILE__);
  ?>

  <p class="restore-default-btn">
    <input type="submit" name="restore_default" class="button" value="<?php esc_html_e( 'Restore Default', 'eu-map-org' ); ?>">
  </p>

    <div class="scroll-top"><span class="scroll-top-icon"></span></div>
    <!--scroll-top script-->
    <script>
      jQuery(function(){jQuery(document).on( 'scroll', function(){ if (jQuery(window).scrollTop() > 100) {jQuery('.scroll-top').addClass('show');} else {jQuery('.scroll-top').removeClass('show');}});jQuery('.scroll-top').on('click', scrollToTop);});function scrollToTop() {verticalOffset = typeof(verticalOffset) != 'undefined' ? verticalOffset : 0;element = jQuery('body');offset = element.offset();offsetTop = offset.top -32;jQuery('html, body').animate({scrollTop: offsetTop}, 500, 'linear');}
    </script>

</div><!-- map-admin -->
</form>
