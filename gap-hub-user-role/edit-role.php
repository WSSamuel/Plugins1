<?php

/*
 * $since 3.4.1
 * @package wordpress
 * 
 */

if (!defined('URE_PLUGIN_URL')) {
  die;  // Silence is golden, direct call is prohibited
}

if (!isset($ure_currentRole) || !$ure_currentRole) {
  if (isset($_REQUEST['user_role']) && $_REQUEST['user_role'] && isset($ure_roles[$_REQUEST['user_role']])) {
    $ure_currentRole = $_REQUEST['user_role'];
  } else {
    $ure_currentRole = $ure_rolesId[count($ure_rolesId) - 1];
  }
  $ure_currentRoleName = $ure_roles[$ure_currentRole]['name'];
}

$youAreAdmin = defined('URE_SHOW_ADMIN_ROLE') && ure_is_admin();

$roleDefaultHTML = '<select id="default_user_role" name="default_user_role" width="200" style="width: 200px">';
$roleToCopyHTML = '<select id="user_role_copy_from" name="user_role_copy_from" width="200" style="width: 200px">
  <option value="none" selected="selected">'.__('None', 'ure').'</option>';
$roleSelectHTML = '<select id="user_role" name="user_role" onchange="ure_Actions(\'role-change\', this.value);">';
foreach ($ure_roles as $key=>$value) {
  $selected1 = ure_optionSelected($key, $ure_currentRole);
  $selected2 = ure_optionSelected($key, $defaultRole);
  if ($youAreAdmin || $key!='administrator') {
    $roleSelectHTML .= '<option value="'.$key.'" '.$selected1.'>'.__($value['name'], 'ure').'</option>';    
    $roleDefaultHTML .= '<option value="'.$key.'" '.$selected2.'>'.__($value['name'], 'ure').'</option>';
    $roleToCopyHTML .= '<option value="'.$key.'" >'.__($value['name'], 'ure').'</option>';
  }
  
}
$roleSelectHTML .= '</select>';
$roleDefaultHTML .= '</select>';
$roleToCopyHTML .= '</select>';

$ure_rolesCanDelete = ure_getRolesCanDelete($ure_roles);
if ($ure_rolesCanDelete && count($ure_rolesCanDelete)>0) {
  $roleDeleteHTML = '<select id="del_user_role" name="del_user_role" width="200" style="width: 200px">';
  foreach ($ure_rolesCanDelete as $key=>$value) {
    $roleDeleteHTML .= '<option value="'.$key.'">'.__($value, 'ure').'</option>';
  }
  $roleDeleteHTML .= '</select>';
} else {
  $roleDeleteHTML = '';
}

//$capabilityRemoveHTML = ure_getCapsToRemoveHTML();

?>

						<div class="has-sidebar-content">
<script language="javascript" type="text/javascript">
<?php
if (is_multisite()) {
?>

  function ure_applyToAllOnClick(cb) {
    el = document.getElementById('ure_apply_to_all_div');
    if (cb.checked) {
      el.style.color = '#FF0000';
    } else {
      el.style.color = '#000000';
    }
  }
<?php
}
?>
  function ure_Actions(action, value) {
    if (action=='cancel') {
      document.location = '<?php echo URE_WP_ADMIN_URL.'/'.URE_PARENT; ?>?page=user-role.php';
      return;
    }
    var elId = ''; var elInMess = '';
    if (action=='addnewrole' || action=='addnewcapability') {
      if (action=='addnewrole') {
        elId = 'new_user_role';
        elInMess = 'Role';
      } else {
        elId = 'new_user_capability';
        elInMess = 'capability';
      }
      var el = document.getElementById(elId);
      value = el.value;
      if (value=='') {
        alert(elInMess +'<?php _e(' Name can not be empty!','ure');?>');
        return false;
      }
      if  (!(/^[\w-]*$/.test(value))) {
        alert(elInMess +'<?php _e(' Name must contain latin characters and digits only!','ure');?>');
        return false;
      }
    } else if (action!='role-change' && action!='capsreadable' && action!='showdeprecatedcaps') {
      if (action=='delete') {
        actionText = '<?php _e('Delete Role', 'ure'); ?>';
      } else if (action=='default') {
        actionText = '<?php _e('Change Default Role', 'ure'); ?>';
      } else if (action=='reset') {
        actionText = '<?php _e('Restore Roles from backup copy. Be careful, backup was created when you started URE 1st time. All changes you made after that will be lost', 'ure'); ?>';
      } else if (action=='removeusercapability') {
        actionText = '<?php _e('Warning! Be careful - removing critical capability could crash some plugin or other custom code', 'ure'); ?>';
      }
      if (!confirm(actionText+': '+ "<?php _e('Please confirm to continue', 'ure'); ?>")) {
        return false;
      }
    }
    if (action!='update') {
      url = '<?php echo URE_WP_ADMIN_URL.'/'.URE_PARENT; ?>?page=user-role.php&action='+ action;
      if (action=='delete') {
        el = document.getElementById('del_user_role');
        value = el.options[el.selectedIndex].value;
      } else if (action=='default') {
        el = document.getElementById('default_user_role');
        value = el.options[el.selectedIndex].value;
      } else if (action=='removeusercapability') {
        el = document.getElementById('remove_user_capability');
        value = el.options[el.selectedIndex].value;
        elId = 'removeusercapability';
      }
      if (value!='' && value!=undefined) {
        if (action=='addnewcapability' || action=='removeusercapability') {
          url = url +'&'+ elId +'='+ escape(value);
        } else {
          url = url +'&user_role='+ escape(value);
          if (action=='addnewrole') {
            el = document.getElementById('user_role_copy_from');
            url = url +'&user_role_copy_from='+ el.value;
          }
        }
      }
      document.location.href = url;
    } else {
      document.getElementById('ure-form').submit();
    }
    
  }


  function ure_onSubmit() {
    if (!confirm('<?php echo sprintf(__('Role "%s" update: please confirm to continue', 'ure'), __($ure_roles[$ure_currentRole]['name'], 'ure')); ?>')) {
      return false;
    }
  }


</script>
<?php
			displayBoxStart(__('Select Role and assign its capabilities. ', 'ure'));
?>
              <div style="float: left;"><?php echo __('Select Role:', 'ure').' '.$roleSelectHTML; ?></div>
<?php
  if ($ure_caps_readable) {
    $checked = 'checked="checked"';
  } else {
    $checked = '';
  }
?>
              <div style="display:none;float:right;">
                <input type="checkbox" name="ure_caps_readable" id="ure_caps_readable" value="1" <?php echo $checked; ?> onclick="ure_Actions('capsreadable');"/>
                <label for="ure_caps_readable"><?php _e('Show capabilities in human readable form', 'ure'); ?></label><br />
<?php
    if ($ure_show_deprecated_caps) {
      $checked = 'checked="checked"';
    } else {
      $checked = '';
    }
?>
                <input type="checkbox" name="ure_show_deprecated_caps" id="ure_show_deprecated_caps" value="1" <?php echo $checked; ?> onclick="ure_Actions('showdeprecatedcaps');"/>
                <label for="ure_show_deprecated_caps"><?php _e('Show deprecated capabilities', 'ure'); ?></label>
              </div>
<?php
if (is_multisite() && is_super_admin()) {
  $hint = __('If checked, then apply action to ALL sites of this Network');
  if ($ure_apply_to_all) {
    $checked = 'checked="checked"';
    $fontColor = 'color:#FF0000;';
  } else {
    $checked = '';
    $fontColor = '';
  }
?>
              <div style="float: right; margin-left:10px; margin-right: 20px; <?php echo $fontColor;?>" id="ure_apply_to_all_div"><input type="checkbox" name="ure_apply_to_all" id="ure_apply_to_all" value="1" <?php echo $checked; ?> title="<?php echo $hint;?>" onclick="ure_applyToAllOnClick(this)"/>
                <label for="ure_apply_to_all" title="<?php echo $hint;?>"><?php _e('Apply to All Sites', 'ure');?></label>
              </div>
<?php
}
?>
<br/><br/><hr/>
        <table class="form-table" style="clear:none;" cellpadding="0" cellspacing="0">
          <tr>
            <td style="vertical-align:top;">
<?php
  //$deprecatedCaps = ure_get_deprecated_caps();
  $quant = count($ure_fullCapabilities);
  $quantInColumn = (int) $quant/3;
  $quantInCell = 0;
  foreach( $ure_fullCapabilities as $capability) {    
    if (!$ure_show_deprecated_caps && isset($deprecatedCaps[$capability['inner']])) {
      $input_type = 'hidden';        
    } else {
      $input_type = 'checkbox';      
    }
    if (isset($deprecatedCaps[$capability['inner']])) {
      $labelStyle = 'style="color:#BBBBBB;"';  
    } else {
      $labelStyle = '';
    }
    $checked = '';
    if (isset($ure_roles[$ure_currentRole]['capabilities'][$capability['inner']])) {
      $checked = 'checked="checked"';
    }
    $cap_id = str_replace(' ', URE_SPACE_REPLACER, $capability['inner']);    
?>
   <input type="<?php echo $input_type;?>" name="<?php echo $cap_id; ?>" id="<?php echo $cap_id; ?>" value="<?php echo $capability['inner']; ?>" <?php echo $checked; ?>/>
<?php
  if ($input_type=='checkbox') {
    if ($ure_caps_readable) {
      $capInd = 'human';
      $capIndAlt = 'inner';
    } else {
      $capInd = 'inner';
      $capIndAlt = 'human';
    }
?>
   <label for="<?php echo $cap_id; ?>" title="<?php echo $capability[$capIndAlt]; ?>" <?php echo $labelStyle;?> ><?php echo $capability[$capInd]; ?></label> <?php //echo ure_capability_help_link($capability['inner']); ?><br/>
<?php   
    $quantInCell++;
   }
   if ($quantInCell>=$quantInColumn) {
     $quantInCell = 0;
     echo '</td>
           <td style="vertical-align:top;">';
   }
  }
?>
            </td>
          </tr>
      </table>

<hr/>
    <input type="hidden" name="object" value="role" />
    <div class="submit" style="padding-top: 0px;padding-bottom: 0px;">
      <div style="float:left; padding-bottom: 10px;">
        <input type="submit" name="submit" value="<?php _e('Update', 'ure'); ?>" title="<?php _e('Save Changes', 'ure'); ?>" />
        <input type="button" name="cancel" value="<?php _e('Cancel', 'ure') ?>" title="<?php _e('Cancel not saved changes', 'ure'); ?>" onclick="ure_Actions('cancel');"/>          
      </div>     
    </div>
<?php
  ure_displayBoxEnd();
?>
    
<div style="clear: left; float: left; width: 800px;">
<?php
  $boxStyle = 'width: 330px; min-width:240px; min-height: 130px; margin-right: 10px;';
  displayBoxStart(__('Add New User Type', 'ure'), $boxStyle); ?>
<div class="ure-bottom-box-input">
  <label for="new_user_role"><?php echo __('Name: ', 'ure'); ?></label>
  <input type="text" name="new_user_role" id="new_user_role" size="25"/>
</div>
<div class="ure-bottom-box-input">
  <?php echo __('Make copy of: ', 'ure').$roleToCopyHTML; ?>
</div>  
<div class="submit" style="margin-left: 0; margin-right: 0; margin-bottom: 0; padding: 0; width: 100%; text-align: center;">
  <input type="button" name="addnewrole" value="<?php _e('Add', 'ure') ?>" title="<?php _e('Add New User Type','ure');?>" onclick="ure_Actions('addnewrole');" />
</div>
<?php
  ure_displayBoxEnd();
  displayBoxStart(__('Default Type for New User', 'ure'), $boxStyle); ?>
<div class="ure-bottom-box-input">
  <?php echo $roleDefaultHTML; ?>
</div>
<div class="submit" style="margin-left: 0; margin-right: 0; margin-bottom: 0; padding: 0; width: 100%; text-align: center;">
  <input type="button" name="default" value="<?php _e('Change', 'ure') ?>" title="<?php _e('Set as Default User Type','ure');?>" onclick="ure_Actions('default');" />
</div>
<?php
   ure_displayBoxEnd();
  if ($roleDeleteHTML) {
    displayBoxStart(__('Delete User Type', 'ure'), $boxStyle); ?>
<div class="ure-bottom-box-input">
  <?php echo $roleDeleteHTML; ?>
</div>
<div class="submit" style="margin-left: 0; margin-right: 0; margin-bottom: 0; padding: 0; width: 100%; text-align: center;">
  <input type="button" name="deleterole" value="<?php _e('Delete', 'ure') ?>" title="<?php _e('Delete User Role','ure');?>" onclick="ure_Actions('delete');" />
</div>
<?php
    ure_displayBoxEnd();
  }
 
?>
</div>
    
		</div>
