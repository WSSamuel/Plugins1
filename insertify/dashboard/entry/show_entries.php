<?php


function icp_show_entries(){
    
    
        //get data from database
    global $wpdb;
    $table_name = $wpdb->prefix .'insertify';
    
    $icdb = $wpdb->get_results( 
            "
            SELECT * 
            FROM $table_name
            ORDER BY id DESC
            "
            );
    ?>
    
    
    <div style="overflow-x:auto;" id="ic_entry_div">
        <table class="icp_table" id="ic_entry_table">
            
            <tr>
                <th><?php esc_html_e('ID', 'insertify'); ?></th> <th><?php esc_html_e('Name', 'insertify'); ?></th> <th><?php esc_html_e('Type', 'insertify'); ?></th>
                <th><?php esc_html_e('Action', 'insertify'); ?></th> <th><?php esc_html_e('Active', 'insertify'); ?></th> <th><?php esc_html_e('Shortcode', 'insertify'); ?></th>
            </tr>
            
    
    <?php
    foreach($icdb as $icdb){
        
        $id = $icdb->id;
        $name = $icdb->name;
        $type = $icdb->type;
        $activeness = $icdb->activeness;
        $shortcode = $icdb->shortcode;
        
    ?>
        
            <tr>
                <td> <?php echo $id; ?> </td>
                <td> <?php echo $name; ?> </td>
                <td>
                    <?php
                    //type name
                    switch($type){
                        case "insert_in_post":
                            _e("Insert Ad/Content","insertify");
                            break;
                        case "html":
                            _e("HTML Snippet","insertify");
                            break;
                        case "insert_css":
                            _e("Insert CSS","insertify");
                            break;
                        case "insert_js":
                            _e("Insert JS","insertify");
                            break;
                        case "embed":
                            _e("Header & Footer","insertify");
                            break;
                        case "css_individual":
                            _e("CSS (individual)","insertify");
                            break;
                        case "js_individual":
                             _e("JS (individual)","insertify");
                            break;
                        case "pdf":
                            _e("Embed PDF","insertify");
                            break;
                        case "youtube":
                            _e("Youtube Video","insertify");
                            break;
                        case "php":
                            _e("PHP Snippet","insertify");
                            break;
                    }
                    ?>
                </td>
                
                
                <td>
                    
                    <form action="<?php echo admin_url( 'admin.php' ); ?>" method="get" style="display: inline;">
                        <input type="hidden" name="page" value="icps_entries" >
                        <input type="hidden" name="edit_id" value="<?php echo $id; ?>">
                        <input type="submit" value="<?php esc_html_e('Edit', 'insertify'); ?>" name="action" style="background-color:#4CAF50; cursor: pointer; color: white; margin-right:15px;">
                    </form>
                    
                    
                    <form action="" method="post" style="display: inline;">
                        <input type="hidden" name="copy_id" value="<?php echo $id; ?>">
                        <input type="submit" name="ic_copy_entry_button" value="<?php esc_html_e('Copy', 'insertify'); ?>" style="background-color:orange; cursor: pointer; color: white; margin-right:15px;">
                    </form>
                    
                    
                    <form action="" method="post" style="display: inline;">
                        <input type="hidden" name="delete_id" value="<?php echo $id; ?>">
                        <input type="submit" value="<?php esc_html_e('Delete', 'insertify'); ?>" name="ic_delete_entry_button" style="background-color:red; cursor: pointer; color: white;">
                    </form>
                    
                </td>
                
                <td> <?php if($activeness == 'yes'){_e("Yes","insertify");}else{_e("No","insertify");} ?> </td>
                
                <td> <?php if($shortcode == "yes"){ ?><textarea rows="1" cols="22" >[insertify id="<?php echo $icdb->id; ?>"]</textarea> <?php } ?> </td>
            
            </tr>    
    
    
    <?php } ?>
    
        </table>
    </div>

    <?php



}
    