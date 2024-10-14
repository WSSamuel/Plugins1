<?php
/*
Uninstalls Social Dropdown plugin options

In order to uninstall the plugin please follow these steps:
1) Deactivate the plugin
2) Change the value of $enableuninstall from 'no' to 'yes' (for security purposes)
3) Run the uninstaller
4) Delete the plugin files

*/

/* Change this before you run this script! */
$enableuninstall = 'no';

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" dir="ltr">

<head profile="http://gmpg.org/xfn/11">
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />

<title>Plugin Uninstallation</title>

<style>
.mainform {
background-color: #F9F9F9;
border: 1px solid #DDDDDD;
text-align: center;
padding: 5px;
margin: 0px;
}
.mainform form {
margin: 0px;
padding: 0px;
}
.mainform form p {
margin: 0px;
padding: 0px;
}
</style>
</head>
<body>
<div class="mainform">
<?php

if ($enableuninstall == 'no') {
echo 'Please change the value of $enableuninstall to &quot;yes&quot; in this file in order to run the script.';
?>
<?php
} else {
@include_once('../../../wp-blog-header.php');
if (!function_exists('bloginfo')) {
@include_once('../../wp-blog-header.php');
}
if ($_POST['comfirm'] == '') {
?>
<form action="socialdropdown_uninstall.php" method="post">
<p>This script would remove database values used by the plugin.</p>
<p>Click <strong>&quot;Continue&quot;</strong> to continue with the uninstaller, or <strong>&quot;Reset Options&quot;</strong> in order to set the options of the plugin back to its original values.</p>
<p><input type="submit" name="comfirm" value="Continue" /> <input type="submit" name="comfirm" value="Reset Options" /></p>
</form>
<?php
} else {

if ($_POST['comfirm'] == 'Continue') {
//Deletes the options
delete_option('dropdown_allowlinkback');
delete_option('dropdown_query');
delete_option('dropdown_width');
delete_option('dropdown_use');
delete_option('dropdown_configmode');

echo 'Plugin uninstalled successfully';
}

if ($_POST['comfirm'] == 'Reset Options') {
//Default options
$dropdown_linkback = 'true';
$dropdown_configmode = 'advanced';
$dropdown_query = 'blinkbits|blinklist|bloglines|blogmarks|buddymarks|citeulike|comments|delicious|digg|diigo,fark|feedmelinks|furl|google|linkagogo|magnolia|misterwong|newsvine|propeller|rawsugar,reddit|rojo|simpy|sphinn|spurl|squidoo|stumbleupon|tailrank|technorati|yahoo';
$dropdown_width = '300px';
$usedropdown = 'true';

update_option('dropdown_allowlinkback', $dropdown_linkback);
update_option('dropdown_query', $dropdown_query);
update_option('dropdown_width', $dropdown_width);
update_option('dropdown_use', $usedropdown);
update_option('dropdown_configmode', $dropdown_configmode);

echo 'Plugin options resetted';
} 

}
}
?>
</div>
</body>
</html>