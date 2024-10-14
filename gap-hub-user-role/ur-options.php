<?php
/* 
 *
 * User role plugin management page.
 * $since 3.4.1
 * @package wordpress
 */

if (!defined('URE_PLUGIN_URL')) {
  die; 
}

$mess = '';

$ure_caps_readable = get_option('ure_caps_readable');
$ure_show_deprecated_caps = get_option('ure_show_deprecated_caps');
$option_name = $wpdb->prefix.'user_roles';

if (isset($_REQUEST['object'])) {
  $ure_object = $_REQUEST['object'];
} else {
  $ure_object = '';
}

if (isset($_REQUEST['action'])) {
  $action = $_REQUEST['action'];
  // restore roles capabilities from the backup record
  if ($action=='reset') {
    $mess = ure_restore_user_roles();
    if (!$mess) {
      return;
    }
  } else if ($action=='addnewrole') {
    // process new role create request
    $mess = ure_newRoleCreate($ure_currentRole);
  } else if ($action=='delete') {
    $mess = ure_deleteRole();
  } else if ($action=='default') {
    $mess = ure_changeDefaultRole();
  } else if ($action=='capsreadable') {
    if ($ure_caps_readable) {
      $ure_caps_readable = 0;
    } else {
      $ure_caps_readable = 1;
    }
    update_option('ure_caps_readable', $ure_caps_readable);
  } else if ($action=='showdeprecatedcaps') {
    if ($ure_show_deprecated_caps) {
      $ure_show_deprecated_caps = 0;
    } else {
      $ure_show_deprecated_caps = 1;
    }
    update_option('ure_show_deprecated_caps', $ure_show_deprecated_caps);  
  } else if ($action=='addnewcapability') {
    $mess = ure_AddNewCapability();
  } else if ($action=='removeusercapability') {
    $mess = ure_RemoveCapability();
  } else if ($action=='roles_restore_note') {
    $mess = __('User Roles are restored from the backup data. ', 'ure');
  }
} else {
  $action = '';
}

$defaultRole = get_option('default_role');

if (isset($_POST['ure_apply_to_all'])) {
  $ure_apply_to_all = 1;
} else {
  $ure_apply_to_all = 0;
}

if (!isset($ure_roles) || !$ure_roles) {
// get roles data from database
  $ure_roles = ure_getUserRoles();
  if (!$ure_roles) {
    return;
  }
}

$ure_rolesId = array();
foreach ($ure_roles as $key=>$value) {
  $ure_rolesId[] = $key;
}


$ure_fullCapabilities = array();
foreach($ure_roles as $role) {
  // validate if capabilities is an array
  if (isset($role['capabilities']) && is_array($role['capabilities'])) {
    foreach ($role['capabilities'] as $key=>$value) {
      $cap = array();
      $cap['inner'] = $key;
      $cap['human'] = __(ure_ConvertCapsToReadable($key),'ure');
      if (!isset($ure_fullCapabilities[$key])) {
        $ure_fullCapabilities[$key] = $cap;
		      }
			
    }		
  }
}
asort($ure_fullCapabilities);

if ($ure_object=='user') {
  if (!isset($_REQUEST['user_id'])) {
    $mess .= ' user_id value is missed';
    return;
  }
  $user_id = $_REQUEST['user_id'];
  if (!is_numeric($user_id)) {
    return;
  }
  if (!$user_id) {
    return;
  }
  $ure_userToEdit = get_user_to_edit($user_id);
  if (empty($ure_userToEdit)) {
    return;
  }  
}

if (isset($_POST['action']) && $_POST['action'] == 'update' && isset($_POST['user_role'])) {
  $ure_currentRole = $_POST['user_role'];
  if (!isset($ure_roles[$ure_currentRole])) {
    $mess = __('Error: ', 'ure') . __('Role', 'ure') . ' <em>' . $ure_currentRole . '</em> ' . __('does not exist', 'ure');
  } else {
    $ure_currentRoleName = $ure_roles[$ure_currentRole]['name'];
    $ure_capabilitiesToSave = array();
    foreach ($ure_fullCapabilities as $availableCapability) {
      $cap_id = str_replace(' ', URE_SPACE_REPLACER, $availableCapability['inner']);
      if (isset($_POST[$cap_id])) {
        $ure_capabilitiesToSave[$availableCapability['inner']] = 1;
      }
    }
    if ($ure_object == 'role') {  // save role changes to database
      if (count($ure_capabilitiesToSave) > 0) {
        if (!ure_updateRoles()) {
          return;
        }
        if ($mess) {
          $mess .= '<br/>';
        }
        $mess = __('Role', 'ure') . ' <em>' . __($ure_roles[$ure_currentRole]['name'], 'ure') . '</em> ' . __('is updated successfully', 'ure');
      }
    } else {
      if (!ure_updateUser($ure_userToEdit)) {
        return;
      }
      if ($mess) {
        $mess .= '<br/>';
      }
      $mess = __('User', 'ure') . ' &lt;<em>' . $ure_userToEdit->display_name . '</em>&gt; ' . __('capabilities are updated successfully', 'ure');
    }
  }
}

// options page display part
function displayBoxStart($title, $style='') {
?>
			<div class="postbox" style="float: left; <?php echo $style; ?>">
				<h3 style="cursor:default;"><span><?php echo $title ?></span></h3>
				<div class="inside">
<?php
}
// 	end of displayBoxStart()

function ure_displayBoxEnd() {
?>
				</div>
			</div>
<?php
}
// end of thanks_displayBoxEnd()


ure_showMessage($mess);

?>
<script language="javascript" type="text/javascript" >
  function checkfun(message) {
    var el = document.getElementById('ure_greetings');
    if (el.style.visibility=='visible') {
      el.style.visibility = 'hidden';
    } else {
      el.style.visibility = 'visible';
    }
  }
  // end of ure_show_greetings()
  
  function ure_select_all(selected) {
    
    var form = document.getElementById('ure_form');
    for (i=0; i<form.elements.length; i++) {
      el = form.elements[i];
      if (el.type!='checkbox') { 
        continue;
      }  
      if (el.name=='ure_caps_readable' || el.name=='ure_show_deprecated_caps') {
        continue;
      }
      if (selected>=0) {
        form.elements[i].checked = selected;      
      } else {
        form.elements[i].checked = !form.elements[i].checked;      
      }
    }
    
  }
  // end of ure_select_all()
  
  
</script>
<!-- This div is for Display Donate Button on Plugin Setting Page  -->

<div id="poststuff">					
          <div class="has-sidebar"><div style="min-width:500px; background:#F0F0F0; min-height:200px; padding:20px; float:right; margin:auto;">
		 
		   <h1 style="padding:7px 15px; background:#EBEBEB;"><span>User Profile Page Shortcut Setting.</span></h1>		   
		      <h3> <span>For User Login use the shortcut  [user-login]  on your page.</span></h3>
	           <h3><span>For User Registeration use the shortcut  [user-registeration]  on your page.</span></h3>
		       <h3><span>For User Profile use the shortcut  [user-profile]  on your page.</span></h3>
			
		  </div>
            <form id="ure_form" method="post" action="<?php echo URE_PARENT; ?>?page=user-role.php" onsubmit="return ure_onSubmit();">
              <?php
              settings_fields('ure-options');
              ?>

              <?php
              if ($ure_object == 'user') {
                require_once('edit-user.php');
              } else {
                require_once('edit-role.php');
              }
              ?>
            </form>
          </div>          
        </div>
				


