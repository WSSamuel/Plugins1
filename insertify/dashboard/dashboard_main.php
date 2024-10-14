<?php

//dashboard main page function
function icp_main(){
    ?>
    
    <br>
    <h1><center><?php esc_html_e('INSERTIFY: How to Use', 'insertify');?></center></h1>
    <center><p><?php esc_html_e('Use simple shortcodes to put useful and amazing contents anywhere in your website!', 'insertify');?></p></center>
    <br>

    
    <div style="overflow-x:auto;">
    <table class="icp_table">
        <tr> <th><b><?php esc_html_e('POSTS LIST', 'insertify');?></b></th> </tr>
        
        <tr>
            <td><b><?php esc_html_e('Custom Posts', 'insertify');?></b></td>
            <td><?php esc_html_e('Control posts type with specific category, number of entries and the title itself.', 'insertify');?></td>
            <td><textarea rows="2" cols="50">[ic-post cat="Post Category" num="Number of Posts" head="Your Title"]</textarea></td>
        </tr>
        
        <tr>
            <td><b><?php esc_html_e('Recent Posts', 'insertify');?></b></td>
            <td><?php esc_html_e("Newly added posts of all categories. 5 posts by default and the title is 'Recent Posts'.", "insertify");?></td>
            <td><textarea rows="1" cols="50">[ic-post]</textarea></td>
        </tr>
        
        <tr>
            <td><b><?php esc_html_e('Random Posts', 'insertify');?></b></td>
            <td><?php esc_html_e("Randomly selected posts from all categories. 5 posts by default and the title is 'Random Posts'.", "insertify");?></td>
            <td><textarea rows="1" cols="50">[ic-post cat="rand"]</textarea></td>
        </tr>
        
        <tr>
            <td><b><?php esc_html_e('Example', 'insertify');?></b></td>
            <td><?php esc_html_e("Last '7' posts of the category: 'my_cat' with the title 'My Posts'.", "insertify");?></td>
            <td><textarea rows="1" cols="50">[ic-post cat="my_cat" num="7" head="My Posts"]</textarea></td>
        </tr>        
        
    </table>
    </div>

    
    <br>
    

    <div style="overflow-x:auto;">
    <table class="icp_table">
        <tr> <th><b><?php esc_html_e('USERS LIST', 'insertify');?></b></th> </tr>
        
        <tr>
            <td><b><?php esc_html_e('All Users', 'insertify');?></b></td>
            <td><?php esc_html_e('Show the public list of all users.', 'insertify');?></td>
            <td><textarea rows="1" cols="50">[ic-users]</textarea></td>
        </tr>
        
        <tr>
            <td><b><?php esc_html_e('Specific Users', 'insertify');?></b></td>
            <td><?php esc_html_e("Users based on specific role. For the subscribers list, role name should be 'subscriber'.", "insertify");?></td>
            <td><textarea rows="1" cols="50">[ic-users role="role_name"]</textarea></td>
        </tr>       
        
    </table>
    </div>
    
    
    <br>
    
    
    
        <div style="overflow-x:auto;">
    <table class="icp_table">
        <tr> <th><b><?php esc_html_e('POST/PAGE CONTENTS', 'insertify');?></b></th> </tr>
        
        <tr>
            <td><b><?php esc_html_e('By Title', 'insertify');?></b></td>
            <td><?php esc_html_e("Show any existing page/post contents using it's title", "insertify");?></td>
            <td><textarea rows="1" cols="50">[ic title="My Post Title"]</textarea></td>
        </tr>
        
        <tr>
            <td><b><?php esc_html_e('By Name', 'insertify');?></b></td>
            <td><?php esc_html_e("If you know the page/post name. Normally it is like, 'my_post_title.", "insertify");?></td>
            <td><textarea rows="1" cols="50">[ic name="my_post_title"]</textarea></td>
        </tr>       
        
        <tr>
            <td><b><?php esc_html_e('By ID', 'insertify');?></b></td>
            <td><?php esc_html_e('If you only know the page/post ID.', 'insertify');?></td>
            <td><textarea rows="1" cols="50">[ic id="1"]</textarea></td>
        </tr>
        
        <tr>
            <td><b><?php esc_html_e('Random Post', 'insertify');?></b></td>
            <td><?php esc_html_e("Show a randomly selected post. Write the name as 'rand'.", "insertify");?></td>
            <td><textarea rows="1" cols="50">[ic name="rand"]</textarea></td>
        </tr>
        
        <tr>
            <td><b><?php esc_html_e('Add Title', 'insertify');?></b></td>
            <td><?php esc_html_e("Add page/post title above it's contents. Put 'yes' in the head attribute.", "insertify");?></td>
            <td><textarea rows="1" cols="50">[ic id="1" head="yes"]</textarea></td>
        </tr>        
                
    </table>
    </div>
        
        
        
        <br>
        
        
        

    <div style="overflow-x:auto;">
    <table class="icp_table">
        <tr> <th><b><?php esc_html_e('USER COMMENTS', 'insertify');?></b></th> </tr>
        
        <tr>
            <td><b><?php esc_html_e('All Users', 'insertify');?></b></td>
            <td><?php esc_html_e('Show the list of all comments by a specific user using his/her username.', 'insertify');?></td>
            <td><textarea rows="1" cols="50">[ic-comments author="username"]</textarea></td>
        </tr>
        
        <tr>
            <td><b><?php esc_html_e('Specific Users', 'insertify');?></b></td>
            <td><?php esc_html_e('Show the list of all comments by a specific user using his/her email.', 'insertify');?></td>
            <td><textarea rows="1" cols="50">[ic-comments email="user@mail.com"]</textarea></td>
        </tr>       
        
    </table>
    </div>
    
    
    <br>  
    
    
    <?php
}
//end of function
