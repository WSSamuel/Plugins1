<?php

//start of the function
function icp_site_info(){
    
    //get data from database
    global $wpdb;
    //$user_table = $wpdb->users;
    
    //Get total number of users
     $user_count = $wpdb->get_var( 
            "
            SELECT COUNT(*) 
            FROM $wpdb->users
            "
            );
     
     $page_count = $wpdb->get_var( 
            "
            SELECT COUNT(*) 
            FROM $wpdb->posts
            WHERE post_status = 'publish' AND post_type = 'page'
            "
            );
     
     $post_count = $wpdb->get_var( 
            "
            SELECT COUNT(*) 
            FROM $wpdb->posts
            WHERE post_status = 'publish' AND post_type = 'post'
            "
            );
    
    
    ?>
    
    
    <br>
    <h1><center><?php esc_html_e('Site Information', 'insertify'); ?></center></h1>
    <center><p><?php esc_html_e('Find all importants and basic info about your site here!', 'insertify'); ?></p></center>
    <br>
    
    
    
    <div style="overflow-x:auto;">
    <table class="icp_table">
        
        
        <tr> <th><b><?php esc_html_e('Site Title', 'insertify'); ?></b></th> <td><?php echo get_bloginfo('name'); ?></td> </tr>
        <tr> <th><b><?php esc_html_e('Site URL', 'insertify'); ?></b></th> <td><?php echo get_bloginfo('url'); ?></td> </tr>
        <tr> <th><b><?php esc_html_e('Site Description', 'insertify'); ?></b></th> <td><?php echo get_bloginfo('description'); ?></td> </tr>
        <tr> <th><b><?php esc_html_e('WordPress Version', 'insertify'); ?></b></th> <td><?php echo get_bloginfo('version'); ?></td> </tr>
        <tr> <th><b><i>* <?php esc_html_e('PHP Version', 'insertify'); ?></i></b></th> <td><?php echo phpversion(); ?></td> </tr>
        <tr> <th><b><?php esc_html_e('Admin Email', 'insertify'); ?></b></th> <td><?php echo get_bloginfo('admin_email'); ?></td> </tr>
        <tr> <th><b><?php esc_html_e('Encoding Type', 'insertify'); ?></b></th> <td><?php echo get_bloginfo('charset'); ?></td> </tr>
        <tr> <th><b><?php esc_html_e('Content Type', 'insertify'); ?></b></th> <td><?php echo get_bloginfo('html_type'); ?></td> </tr>
        <tr> <th><b><?php esc_html_e('Language', 'insertify'); ?></b></th> <td><?php echo get_bloginfo('language'); ?></td> </tr>
        
        <tr> <th><b><?php esc_html_e('Total Number of Users', 'insertify'); ?></b></th> <td><?php echo $user_count; ?></td> </tr>
        
        <tr> <th><b><?php esc_html_e('Total Published Pages', 'insertify'); ?></b></th> <td><?php echo $page_count; ?></td> </tr>
        <tr> <th><b><?php esc_html_e('Total Published Posts', 'insertify'); ?></b></th> <td><?php echo $post_count; ?></td> </tr>
        <tr> <th><b><?php esc_html_e('Active Theme', 'insertify'); ?></b></th> <td><?php echo wp_get_theme(); ?></td> </tr>
        <tr> <th><b><?php esc_html_e('Current Stylesheet', 'insertify'); ?></b></th> <td><?php echo get_stylesheet() ?></td> </tr>
        
        <tr> <th><b><?php esc_html_e('Total Installed Plugins', 'insertify'); ?></b></th> <td><?php print_r(count(get_plugins())); ?></td> </tr>
        
    </table>
    </div>
    
     
    
    <?php
}

