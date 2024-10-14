<?php

//start of Users List function
function icp_users_func($atts){
    	$a = shortcode_atts( array(
        'role' => 'all',
    ),$atts);
        
        //shortcode attribute value in local variable
        
        $cat = $a['role'];
        
        
        

        
        
                //for all role
        if($cat == "all"){
        
            
			//get all users data
			$icpd = get_users();
			
			
            ?>
                
				<div style="overflow-x:auto;">
                <table class="icp_table">
						<caption><?php esc_html_e('All Users', 'insertify'); ?></caption>
                    <tr> <th><?php esc_html_e('User', 'insertify'); ?></th> <th><?php esc_html_e('Email', 'insertify'); ?></th> <th><?php esc_html_e('Registration Date', 'insertify'); ?></th> <th><?php esc_html_e('Role', 'insertify'); ?></th> </tr>    
                
            <?php
    foreach($icpd as $icpd){
        ?>
            
            <tr>
                <td> <?php echo $icpd->display_name; ?> </td>
                <td> <?php echo $icpd->user_email; ?> </td>
                <td> <?php echo $icpd->user_registered; ?> </td>
                <td> <?php echo implode(', ', $icpd->roles); ?> </td>
            </tr>
            
        <?php
    }
    ?> </table></div> <?php
            
        }
        
        
        
        //for specific role
        else{
        
            //get users data by role
			$icpd = get_users("role=$cat");
			
            ?>
                
				<div style="overflow-x:auto;">
                <table class="icp_table">
						<caption><?php esc_html_e('Role: ', 'insertify'); ?><?php echo $cat;?> </caption>
                    <tr> <th><?php esc_html_e('User', 'insertify'); ?></th> <th><?php esc_html_e('Email', 'insertify'); ?></th> <th><?php esc_html_e('Registration Date', 'insertify'); ?></th> </tr>    
                
            <?php
    foreach($icpd as $icpd){
        ?>
            
            <tr>
                <td> <?php echo $icpd->display_name; ?> </td>
                <td> <?php echo $icpd->user_email; ?> </td>
                <td> <?php echo $icpd->user_registered; ?> </td>
            </tr>
            
        <?php
    }
    ?> </table></div> <?php
            
        }
        

        
       
}
//end of Users

add_shortcode( 'ic-users', 'icp_users_func' );
//end Users including shortcode
