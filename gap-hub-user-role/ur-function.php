<?php
/* 
 * *
  * 
 */


if (!function_exists("get_option")) {
  die; 
}

$ure_siteURL = get_site_url();
$urePluginDirName = substr(strrchr(dirname(__FILE__), DIRECTORY_SEPARATOR), 1);

define('URE_PLUGIN_URL', WP_PLUGIN_URL.'/'.$urePluginDirName);
define('URE_PLUGIN_DIR', WP_PLUGIN_DIR.'/'.$urePluginDirName);
define('URE_WP_ADMIN_URL', $ure_siteURL.'/wp-admin');
define('URE_ERROR', 'Error is encountered');
define('URE_SPACE_REPLACER', '_URE-SR_');
define('URE_PARENT', 'users.php');
define('URE_KEY_CAPABILITY', 'administrator');


// returns true is user has Role "Administrator"
function ure_has_administrator_role($user_id) {
  global $wpdb, $ure_userToCheck;

  if (!isset($user_id) || !$user_id) {
    return false;
  }

  $tableName = (!is_multisite() && defined('CUSTOM_USER_META_TABLE')) ? CUSTOM_USER_META_TABLE : $wpdb->usermeta;
  $metaKey = $wpdb->prefix.'capabilities';
  $query = "SELECT count(*)
                FROM $tableName
                WHERE user_id=$user_id AND meta_key='$metaKey' AND meta_value like '%administrator%'";
  $hasAdminRole = $wpdb->get_var($query);
  if ($hasAdminRole>0) {
    $result = true;
  } else {
    $result = false;
  }
  $ure_userToCheck[$user_id] = $result;
  
  return $result;
}
// end of ure_has_administrator_role()


// true if user is superadmin under multi-site environment or has administrator role
function ure_is_admin( $user_id = false ) {
  global $current_user;

	if ( ! $user_id ) {
    if (empty($current_user) && function_exists('get_currentuserinfo')) {
      get_currentuserinfo();
    }
		$user_id = ! empty($current_user) ? $current_user->ID : 0;
	}

	if ( ! $user_id )
		return false;

	$user = new WP_User($user_id);

  $simpleAdmin = ure_has_administrator_role($user_id);

	if ( is_multisite() ) {
		$super_admins = get_super_admins();
		$superAdmin =  is_array( $super_admins ) && in_array( $user->user_login, $super_admins );
	} else {
    $superAdmin = false;
  }

	return $simpleAdmin || $superAdmin;
}
// end of ure_is_super_admin()


function ure_optionSelected($value, $etalon) {
  $selected = '';
  if (strcasecmp($value,$etalon)==0) {
    $selected = 'selected="selected"';
  }

  return $selected;
}
// end of ure_optionSelected()


function ure_showMessage($message) {

  if ($message) {
    if (strpos(strtolower($message), 'error')===false) {
      $class = 'updated fade';
    } else {
      $class = 'error';
    }
    echo '<div class="'.$class.'" style="margin:0;">'.$message.'</div><br style="clear: both;"/>';
  }

}
// end of ure_showMessage()


function ure_getUserRoles() {
  global $wp_roles;

  if (!isset($wp_roles)) {
    $wp_roles = new WP_Roles();
  } 
  
  $ure_roles = $wp_roles->roles;
  if (is_array($ure_roles)) {
    asort($ure_roles);
  }
  
  return $ure_roles;
 
}
// end of ure_getUserRoles()

// Save Roles to database
function ure_saveRolesToDb() {
  global $wpdb, $ure_roles, $ure_capabilitiesToSave, $ure_currentRole, $ure_currentRoleName;

  if (!isset($ure_roles[$ure_currentRole])) {
    $ure_roles[$ure_currentRole]['name'] = $ure_currentRoleName;
  }
  $ure_roles[$ure_currentRole]['capabilities'] = $ure_capabilitiesToSave;
  $option_name = $wpdb->prefix.'user_roles';
  $serialized_roles = serialize($ure_roles);
  $query = "update $wpdb->options
                set option_value='$serialized_roles'
                where option_name='$option_name'
                limit 1";
  $record = $wpdb->query($query);
  if ($wpdb->last_error) {
    ure_logEvent($wpdb->last_error, true);
    return false;
  }

  return true;
}
// end of saveRolesToDb()


function ure_direct_site_roles_update($blogIds) {
  global $wpdb, $table_prefix, $ure_roles, $ure_capabilitiesToSave, $ure_currentRole, $ure_currentRoleName;

  if (!isset($ure_roles[$ure_currentRole])) {
    $ure_roles[$ure_currentRole]['name'] = $ure_currentRoleName;
  }
  $ure_roles[$ure_currentRole]['capabilities'] = $ure_capabilitiesToSave;
  $serialized_roles = serialize($ure_roles);  
  foreach ($blogIds as $blog_id) {
    $prefix = $wpdb->get_blog_prefix($blog_id);
    $options_table_name = $prefix.'options';
    $option_name = $prefix.'user_roles';
    $query = "update $options_table_name
                set option_value='$serialized_roles'
                where option_name='$option_name'
                limit 1";
    $record = $wpdb->query($query);
    if ($wpdb->last_error) {
      ure_logEvent($wpdb->last_error, true);
      return false;
    }
  }
  
}

function ure_updateRoles() {
  global $wpdb, $ure_apply_to_all, $ure_roles, $ure_toldAboutBackup;
  
  $ure_toldAboutBackup = false;
  if (is_multisite() && is_super_admin() && $ure_apply_to_all) {  // update Role for the all blogs/sites in the network (permitted to superadmin only)
    
    if (defined('WP_DEBUG') && WP_DEBUG==1) {
     $time_shot = microtime();
    }
    
    $old_blog = $wpdb->blogid;
    // Get all blog ids
    $blogIds = $wpdb->get_col($wpdb->prepare("SELECT blog_id FROM $wpdb->blogs"));
    if (defined('URE_MULTISITE_DIRECT_UPDATE') && URE_MULTISITE_DIRECT_UPDATE == 1) {
      ure_direct_site_roles_update($blogIds);
    } else {
      foreach ($blogIds as $blog_id) {
        switch_to_blog($blog_id);
        $ure_roles = ure_getUserRoles();
        if (!$ure_roles) {
          return false;
        }
        if (!ure_saveRolesToDb()) {
          return false;
        }
      }
      switch_to_blog($old_blog);
      $ure_roles = ure_getUserRoles();
	  print_r();
            
    }
  
    if (defined('WP_DEBUG') && WP_DEBUG==1) {
      echo '<div class="updated fade below-h2">Roles updated for '.(microtime()-$time_shot).' milliseconds</div>';
    }
    
  } else {
    if (!ure_saveRolesToDb()) {
      return false;
    }
  }
      
  return true;
}
// end of ure_updateRoles()


// process new role create request
function ure_newRoleCreate(&$ure_currentRole) {

  global $wp_roles;
  
  $mess = '';
  $ure_currentRole = '';
  if (isset($_GET['user_role']) && $_GET['user_role']) {
    $user_role = utf8_decode(urldecode($_GET['user_role']));
    // sanitize user input for security
    $valid_name = preg_match('/[A-Za-z0-9_\-]*/', $user_role, $match);
    if (!$valid_name || ($valid_name && ($match[0]!=$user_role))) { // some non-alphanumeric charactes found!
      return __('Error: Role name must contain latin characters and digits only!', 'ure');
    }  
    if ($user_role) {
      if (!isset($wp_roles)) {
        $wp_roles = new WP_Roles();
      }
      if (isset($wp_roles->roles[$user_role])) {      
        return sprintf('Error! '.__('Role %s exists already', 'ure'), $user_role);
      }
      // add new role to the roles array
      $ure_currentRole = strtolower($user_role);
      $user_role_copy_from = isset($_GET['user_role_copy_from']) ? $_GET['user_role_copy_from'] : false;
      if (!empty($user_role_copy_from) && $user_role_copy_from!='none' && $wp_roles->is_role($user_role_copy_from)) {
        $role = $wp_roles->get_role($user_role_copy_from);
        $capabilities = $role->capabilities;
      } else {
        $capabilities = array('read'=>1, 'level_0'=>1);
      }
      $result = add_role($ure_currentRole, $user_role, $capabilities);
      if (!isset($result) || !$result) {
        $mess = 'Error! '.__('Error is encountered during new role create operation', 'ure');
      } else {
        $mess = sprintf(__('Role %s is created successfully', 'ure'), $user_role);
      }
    }
  }
  return $mess;
}
// end of newRoleCreate()


// define roles which we could delete, e.g self-created and not used with any blog user
function ure_getRolesCanDelete($ure_roles) {
  global $wpdb;
  
  $tableName = (!is_multisite() && defined('CUSTOM_USER_META_TABLE')) ? CUSTOM_USER_META_TABLE : $wpdb->usermeta;
  $metaKey = $wpdb->prefix.'capabilities';
  $defaultRole = get_option('default_role');
  $standardRoles = array('administrator', 'editor', 'author', 'contributor', 'subscriber');
  $ure_rolesCanDelete = array();
  foreach ($ure_roles as $key=>$role) {
    $canDelete = true;
    // check if it is default role for new users
    if ($key==$defaultRole) {
      $canDelete = false;
      continue;
    }
    // check if it is standard role
    foreach ($standardRoles as $standardRole) {
      if ($key==$standardRole) {
        $canDelete = false;
        break;
      }
    }
    if (!$canDelete) {
      continue;
    }
    // check if user with such role exists
    $query = "SELECT meta_value
                FROM $tableName
                WHERE meta_key='$metaKey' AND meta_value like '%$key%'";
    $ure_rolesUsed = $wpdb->get_results($query);
    if ($ure_rolesUsed && count($ure_rolesUsed>0)) {
      foreach ($ure_rolesUsed as $roleUsed) {
        $roleName = unserialize($roleUsed->meta_value);
        foreach ($roleName as $key1=>$value1) {
          if ($key==$key1) {
            $canDelete = false;
            break;
          }
        }
        if (!$canDelete) {
          break;
        }
      }
    }
    if ($canDelete) {
      $ure_rolesCanDelete[$key] = $role['name'];
    }
  }

  return $ure_rolesCanDelete;
}
// end of getRolesCanDelete()


function ure_deleteRole() {
  global $wp_roles;

  $mess = '';
  if (isset($_GET['user_role']) && $_GET['user_role']) {
    $role = $_GET['user_role'];
    //$result = remove_role($_GET['user_role']);
    // use this modified code from remove_role() directly as remove_role() returns nothing to check
    if (!isset($wp_roles)) {
      $wp_roles = new WP_Roles();
    }
    if (isset($wp_roles->roles[$role])) {
      unset($wp_roles->role_objects[$role]);
      unset($wp_roles->role_names[$role]);
      unset($wp_roles->roles[$role]);
      $result = update_option($wp_roles->role_key, $wp_roles->roles);
    } else {
      $result = false;
    }
    if (!isset($result) || !$result) {
      $mess = 'Error! '.__('Error encountered during role delete operation', 'ure');
    } else {
      $mess = sprintf(__('Role %s is deleted successfully', 'ure'), $role);
    }
    unset($_REQUEST['user_role']);
  }

  return $mess;
}
// end of ure_deleteRole()


function ure_changeDefaultRole() {
  global $wp_roles;

  $mess = '';
  if (!isset($wp_roles)) {
		$wp_roles = new WP_Roles();
  }
  if (isset($_GET['user_role']) && $_GET['user_role']) {
    $errorMessage = 'Error! '.__('Error encountered during default role change operation', 'ure');
    if (isset($wp_roles->role_objects[$_GET['user_role']])) {
      $result = update_option('default_role', $_GET['user_role']);
      if (!isset($result) || !$result) {
        $mess = $errorMessage;
      } else {
        $mess = sprintf(__('Default role for new users is set to %s successfully', 'ure'), $wp_roles->role_names[$_GET['user_role']]);
      }
    } else {
      $mess = $errorMessage;
    }
    unset($_REQUEST['user_role']);
  }

  return $mess;
}
// end of ure_changeDefaultRole()


function ure_ConvertCapsToReadable($capsName) {

  $capsName = str_replace('_', ' ', $capsName);
  $capsName = ucfirst($capsName);

  return $capsName;
}

function ure_ArrayUnique($myArray) {
    if (!is_array($myArray)) {
      return $myArray;
    }
    
    foreach ($myArray as $key=>$value) {
      $myArray[$key] = serialize($value);
    }

    $myArray = array_unique($myArray);

    foreach ($myArray as $key=>$value) {
      $myArray[$key] = unserialize($value);
    }

    return $myArray;

} 

function ure_updateUser($user) {
  global $wpdb, $ure_capabilitiesToSave, $ure_currentRole;

  $user->remove_all_caps();
  if (count($user->roles)>0) {
    $userRole = $user->roles[0];
  } else {
    $userRole = '';
  }
  $user->set_role($ure_currentRole);
    
  if (count($ure_capabilitiesToSave)>0) {
    foreach ($ure_capabilitiesToSave as $key=>$value) {
      $user->add_cap($key);
    }
  }
  $user->update_user_level_from_caps();

  return true;
}
// end of ure_updateUser()
?>
