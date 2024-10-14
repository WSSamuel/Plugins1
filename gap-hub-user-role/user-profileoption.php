<?php
/**
 * 
 *function page for displaying User Inofrmation such as login,registeration and user profile page on front page.
 * @package wordpress
 *@since 3.4.1
 * * 
 *
 * 
 * 
 */
 
  $siteurl=site_url();
  @include_once('$siteurl/wp-load.php');
  @include_once( ABSPATH . WPINC . '/registration.php' );
 function user_information()
 {
  global $current_user;
  $current_user = wp_get_current_user();
  
	 $Username=$current_user->user_login;
	 $Useremail= $current_user->user_email;
	 $Userfname= $current_user->user_firstname;
	 $Userlname= $current_user->user_lastname;
	 $Userdisplayname= $current_user->display_name;
     $website=$current_user->user_url;
     $about= $current_user->user_desc;
	 $contactno=$current_user->user_contactno;
	$add1=$current_user->user_add1;
	$add2=$current_user->user_add2;
	$state=$current_user->user_state;
	$country=$current_user->user_country;
	$pin=$current_user->user_citypin;
	$about=$current_user->user_desc;
	$city=$current_user->user_city;		
	$UserID=$current_user->ID;
	if (is_user_logged_in() ) {
	
	if(isset($_REQUEST['update']))	
			{
				if ( !empty( $_POST['fname'] ) )
				{
					update_user_meta( $current_user->id, 'first_name', esc_attr( $_POST['fname'] ) );
				}
				if (!empty( $_POST['dislayname'] ) )
			    {
				  wp_update_user( array( 'ID' => $current_user->id, 'display_name' => esc_attr( $_POST['dislayname'] ) ) );
		        }
				if ( !empty( $_POST['lname'] ) )
			    {
		          update_user_meta( $current_user->id, 'last_name', esc_attr( $_POST['lname'] ) );
		        }
				if ( !empty( $_POST['contactno'] ) )
			    {
		          update_user_meta($current_user->id, 'user_contactno',esc_attr($_POST['contactno']));
		        }
				if ( !empty( $_POST['about'] ) )
			    {
				 update_user_meta($current_user->id, 'user_desc',esc_attr($_POST['about']));
		        }
				
				if ( !empty( $_POST['website'] ) )
			    {
		          update_user_meta( $current_user->id, 'user_url', esc_attr( $_POST['website'] ) );
		        }
				
				if ( !empty( $_POST['add1'] ) )
			    {
		          update_user_meta( $current_user->id, 'user_add1', esc_attr( $_POST['add1'] ) );
		        }
				
				if ( !empty( $_POST['add2'] ) )
			    {
		          update_user_meta( $current_user->id, 'user_add2', esc_attr( $_POST['add2'] ) );
		        }
				
				if ( !empty( $_POST['state'] ) )
			    {
		          update_user_meta(  $current_user->id, 'user_state' , esc_attr( $_POST['state'] ) );
		        }
				
				if ( !empty( $_POST['country'] ) )
			    {
		          update_user_meta( $current_user->id, 'user_country', esc_attr( $_POST['country'] ) );
		        }
				if ( !empty( $_POST['pin'] ) )
			    {
		          update_user_meta(  $current_user->id, 'user_citypin', esc_attr( $_POST['pin'])  );
		        }
				
				if ( !empty( $_POST['city'] ) )
			    {
		          update_user_meta(  $current_user->id, 'user_city', esc_attr( $_POST['city'] ) );
		        }
				
				if ( !empty($_POST['pass1'] ) && !empty( $_POST['pass2'] ) )
				 {
					if ( $_POST['pass1'] == $_POST['pass2'] )
						wp_update_user( array( 'ID' => $current_user->id, 'user_pass' => esc_attr( $_POST['pass1'] ) ) );
					else
						 $error = __('The passwords you entered do not match.  Your password was not updated.');
						 echo "<span style='font-size:16px; color:red;'>$error</span>";
				}
				
				
	 	}				
 
 ?>
 	<form method="post">
				<table style="width:100%;">
					<tbody>
						<tr>
								<td>User Name</td><td><input type="text" name="username" value="<?php echo $Username; ?>" readonly="true"> </td>						
								<td>Email</td><td><input type="text" name="uemail" value="<?php echo $Useremail; ?>"> </td>
						</tr>
						<tr>
								<td>First Name</td><td><input type="text" name="fname" value="<?php echo $Userfname; ?>"> </td>						
								<td>Last Name</td><td><input type="text" name="lname" value="<?php echo $Userlname; ?>"> </td>
						</tr>
						<tr>
								<td>Website</td><td><input type="text" name="website" value="<?php echo $website; ?>"></td>
								<td>Display Name</td><td><input type="text" name="dislayname" value="<?php echo $Userdisplayname; ?>"></td>
						</tr>
						<tr>
								<td>New Password</td><td><input type="password" name="pass1"></td>
								<td>Confirm Password</td><td><input type="password" name="pass2"></td>
						</tr>
						<tr>
								<td>Contact No.</td><td><input type="text" name="contactno" value=" <?php echo $contactno; ?>"></td>
								<td>About</td><td><textarea cols="5" rows="10" name="about"><?php echo $about; ?></textarea></td>
						</tr>
						
						
						<tr>
								<td>Address1</td><td><textarea cols="5" rows="10" name="add1" id="add1"><?php echo $add1; ?></textarea></td>
								<td>Address2</td><td><textarea cols="5" rows="10" name="add2" id="add2"><?php echo $add2; ?></textarea></td>
						</tr>
						<tr>
								<td>Country</td><td><input type="text" name="country" id"country"></td>
								<td>State</td><td><input type="text" name="state" id="state"></td>
						</tr>
						<tr>
								<td>Pin</td><td><input type="text" name="pin" id="pin" value="<?php echo $pin; ?>" /></td>
								<td>City</td><td><input type="text" name="city" id="city" value="<?php echo $city; ?>" /></td>
						</tr>
						 <tr>
							<td colspan="4"><input type="submit" name="update" value="Update" style="padding:5px 10px; border-style:inherit; margin-left:110px;"></td>
						</tr>
					 </tbody>
				</table>
			</form>
 <?php
	 }
	 else
	 {
	 echo "<h2><span>To see your profile first login.</span> </h2>";
	 }
}
 function user_loginform()
 {
 global $current_user;
  $current_user = wp_get_current_user();
  
	 $Username=$current_user->user_login;
 	
		   
			if (!is_user_logged_in() ) 
			{
			if(isset($_REQUEST['submit']))
			{
			$home=get_option('home');
			header("location:.'$home.'");
			}
			
			 ?>	
			<!--  Login Page start here    -->
		<form action="<?php echo get_option('home'); ?>/wp-login.php" method="post">
		<table border="0px" cellpadding="0px"  cellspacing="0px">
		<tbody>
			<tr><td style="width:100px;">UserName</td><td><input type="text" name="log" id="log" value="<?php echo wp_specialchars(stripslashes($user_login), 1) ?>" size="20" /> </td></tr>
		
			<tr><td>Password</td><td style="width:100px;"><input type="password" name="pwd" id="pwd" size="21" /></td></tr>
		
			<tr><td>
			  <input name="rememberme" id="rememberme" type="checkbox" checked="checked" value="forever" /> </td><td>Remember me</td></tr>
			  <tr><td>
			  <input type="submit" name="submit" value="Send" class="button" /></td>
			   
			
			   <input type="hidden" name="redirect_to" value="<?php echo $_SERVER['REQUEST_URI']; ?>" />
			   <td><a href="<?php echo get_option('home'); ?>/wp-login.php?action=lostpassword">Forgot password</a></td></tr>
		</tbody></table>
		</form>
		
		<?php 
		
		} else { ?>
				<ul class="admin_box">
				<h4>You are Currently Logged in as Username: &nbsp;<?php wp_get_current_user();  echo $current_user->user_login ;?></h4>
				
				<?php wp_get_current_user();
				/*echo 'Username: ' . $current_user->user_login . '<br />';
				echo 'User email: ' . $current_user->user_email . '<br />';
				echo 'User first name: ' . $current_user->user_firstname . '<br />';
				echo 'User last name: ' . $current_user->user_lastname . '<br />';
				echo 'User display name: ' . $current_user->display_name . '<br />';
				echo 'User ID: ' . $current_user->ID . '<br />';*/
				
				
				 ?>			  
					 				
					<!--<li><a href="<?php echo get_option('home'); ?>/wp-admin/post-new.php?post_type=page">Write new Page</a></li> -->
					<li><a href="../user-role/<?php echo get_option('home'); ?>/wp-login.php?action=logout&amp;redirect_to=<?php echo get_option('home'); ?>"><h4>Log out</h4></a></li>
					<li><a href="<?php echo get_option('home'); ?>/wp-admin"><h4>Go Dashboard</h4></a></li>
				</ul>
		
		<?php 
		}
		
}
function userregister()
{

if (isset($_REQUEST['oksubmit'])) {	 
	$user_pass = wp_generate_password();
	
	$userdata = array(
		'user_pass' => esc_attr( $_POST['user_pass'] ),
		'user_login' => esc_attr( $_POST['user_name'] ),
		'first_name' => esc_attr( $_POST['first_name'] ),
		'last_name' => esc_attr( $_POST['last_name'] ),		
		'user_email' => esc_attr( $_POST['user_email'] ),
		'display_name' => esc_attr( $_POST['displayname'] ),
		'user_url' => esc_attr($_POST['website'] ),
		'role' => get_option( 'default_role' ),
	);
 
 
	if ( !$userdata['user_login'] )
		 $error = __('A username is required for registration.');
	elseif ( username_exists($userdata['user_login']) )
		 $error = __('Sorry, that username already exists!');
 
	elseif ( !is_email($userdata['user_email'], true) )
		$error = __('You must enter a valid email address.');
	elseif ( email_exists($userdata['user_email']) )
		$error = __('Sorry, that email address is already used!');
 
	else{
		$new_user = wp_insert_user( $userdata );
		wp_new_user_notification($new_user, $user_pass); 
	
	}
	if($error!="")
    {
	   echo "<h3 style='padding:5px 20px;color:red; background:black;'>$error</h3>";	
    }
	else {
	 echo "<h3 style='padding:5px 20px;color:green; background:black;'>Thanks for Registering, $_REQUEST[user_name].Your Password has been sent on your mail.Please check.</h3>";
	}

 } 
 ///////////////////////////////////////////////////////////Registeration page start here/////////////////////////
  
 //include"registerhtml.php";
if ( !is_user_logged_in() ) { ?>
		
<form method="post">
				<table style="width:100%;">
					<tbody>
						<tr>
							<td>User Name<span style="font-size:12px; font-style:italic; margin-left:5px;color:#FF0000; letter-spacing:1px;">(required)</span></td><td><input type="text" name="user_name" value="<?php echo $_POST['user_name'] ;?>"> </td>
						
							<td>Email<span style="font-size:12px; font-style:italic; margin-left:5px;color:#FF0000; letter-spacing:1px;">(required)</span></td><td><input type="text" name="user_email" value="<?php echo $_POST['user_email'] ;?>"> </td>
						</tr>
						<tr>
							<td>First Name</td><td><input type="text" name="first_name" value="<?php echo $_POST['first_name'] ;?>"> </td>
						
							<td>Last Name</td><td><input type="text" name="last_name" value="<?php echo $_POST['last_name'] ;?>"> </td>
						</tr>
						<!--  <tr>
						<td>Password<span style="font-size:12px; font-style:italic; margin-left:5px;color:#FF0000; letter-spacing:1px;">(required)</span></td><td><input type="password" name="user_pass"> </td>
						<td>Confirm Password<span style="font-size:12px; font-style:italic; margin-left:5px;color:#FF0000; letter-spacing:1px;">(required)</span></td><td><input type="password" name="confpass"></td>							
						</tr> -->
						<tr>
							<td>Website</td><td><input type="text" name="website" value="<?php echo $_POST['website'] ;?>"></td>
							<td>Display Name</td><td><input type="text" name="displayname" value="<?php echo $_POST['displayname'] ;?>"></td>
						</tr>
						<tr>
							<td colspan="4"><input type="submit" name="oksubmit" value="Submit" style="padding:5px 10px; border-style:inherit; margin-left:110px;">
							</td>
						</tr>
					</tbody>
				</table>
			</form>
	<?php
	}
	else
	{
		echo "<h2>You are already the member of this site.</h2>";
	?>
	<a href="../user-role/<?php echo get_option('home'); ?>/wp-login.php?action=logout&amp;redirect_to=<?php echo get_option('home'); ?>"><h4>Log out</h4></a>
	<?php
		
	}
  
}
?>