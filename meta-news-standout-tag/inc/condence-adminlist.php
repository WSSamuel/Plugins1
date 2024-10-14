<?php  
function settings_style_panel_admin_condence(){ 
    wp_enqueue_style("condence-style", plugins_url( '/css/style.css', __FILE__ ), false, "1.0", "all"); 
} 
function settings_panel_admin_condence() {
    add_menu_page( __( 'Google News'), __( 'Google News'), 'manage_options', 'GoogleNews_Condence', 'plugin_panel_admin_Condence');
} 
add_action( 'admin_init', 'settings_style_panel_admin_condence' );
add_action( 'admin_menu', 'settings_panel_admin_condence' );
 
function plugin_panel_admin_Condence() { ?>
<div class="wrap">
    <h2>Meta News & Standout tag</h2> 
    <div class="content">   
        <?php
            $args = array(
                'post_type'      => 'post',
                'post_status'    => 'publish',
                'orderby'        => 'date',
                'order'          => 'DESC',
                'date_query'     => array(array('after' => 'today'))
                );      
            $my_query = new WP_Query( $args );
            if ( $my_query->have_posts() ) : 
        ?> 
        <h3><?php echo __( 'Posts this day (You can only use one time per day)', 'meta-news-standout-tag-text' ); ?></h3>  
        <div class="table">
            <div class="row green header">
                <div class="cell">
                    ID
                </div>
                <div class="cell">
                    <?php echo __( 'Title', 'meta-news-standout-tag-text' ); ?>
                </div>
                <div class="cell">
                    <?php echo __( 'Tags', 'meta-news-standout-tag-text' ); ?>
                </div>
                <div class="cell"> 
                    <?php echo __( 'Standout', 'meta-news-standout-tag-text' ); ?>
                </div>
            </div>  
        <?php    
        if ( $my_query->have_posts() ) {
            while ( $my_query->have_posts() ) {
                $my_query->the_post();
                ?>
                <div class="row">
                    <div class="cell"> 
                        <?php echo get_the_id(); ?>
                    </div>
                    <div class="cell">
                        <?php echo get_the_title(); ?>
                    </div>
                    <div class="cell">
                        <?php echo get_post_meta(get_the_id(), "condence_metabox_tags", true); ?>
                    </div>
                    <div class="cell">
                    <?php 
                    $condence_standout = get_post_meta(get_the_id(), "condence_metabox_standout", true);
                    if ($condence_standout == '1') {
                        $condence_standout = __( 'Activated', 'meta-news-standout-tag-text' );
                    } else {
                        $condence_standout = __( 'Deactivated', 'meta-news-standout-tag-text' ); 
                    }
                    ?>
                    <?php echo  $condence_standout; ?>
                    </div>
                </div>
                <?php 
            }
        }  
        wp_reset_postdata();
        ?>
        </div>
        <?php else:  ?>
        <h3><?php echo __( 'No publications were found this day.', 'meta-news-standout-tag-text' ); ?></h3> 
        <?php endif; ?> 
        <?php
        $args = array(
            'post_type'      => 'post',
            'post_status'    => 'publish',
            'orderby'        => 'date',
            'order'          => 'DESC',
            'date_query'     => array(array('after' => '1 week ago'))
            );      
        $my_query = new WP_Query( $args );
        if ( $my_query->have_posts() ) : ?>  
        <h3><?php echo __( 'Posts this week', 'meta-news-standout-tag-text' ); ?></h3>
        <div class="table">
            <div class="row blue header">
                <div class="cell">
                    ID
                </div>
                <div class="cell">
                    <?php echo __( 'Title', 'meta-news-standout-tag-text' ); ?>
                </div>
                <div class="cell">
                    <?php echo __( 'Tags', 'meta-news-standout-tag-text' ); ?>
                </div>
                <div class="cell"> 
                    <?php echo __( 'Standout', 'meta-news-standout-tag-text' ); ?>
                </div>
            </div>  
        <?php    
        if ( $my_query->have_posts() ) {
            while ( $my_query->have_posts() ) {
                $my_query->the_post();
                ?>
                <div class="row">
                    <div class="cell"> 
                        <?php echo get_the_id(); ?>
                    </div>
                    <div class="cell">
                        <?php echo get_the_title(); ?>
                    </div>
                    <div class="cell">
                        <?php echo get_post_meta(get_the_id(), "condence_metabox_tags", true); ?>
                    </div>
                    <div class="cell">
                    <?php 
                    $condence_standout = get_post_meta(get_the_id(), "condence_metabox_standout", true);
                    if ($condence_standout == '1') {
                        $condence_standout = __( 'Activated', 'meta-news-standout-tag-text' );
                    } else {
                        $condence_standout = __( 'Deactivated', 'meta-news-standout-tag-text' ); 
                    }
                    ?>
                    <?php echo  $condence_standout; ?>
                    </div>
                </div>
                <?php 
            }
        }  
        wp_reset_postdata();
        ?>
        <?php else:  ?>
        <h3><?php echo __( 'No publications were found this week.', 'meta-news-standout-tag-text' ); ?></h3>  

        <?php endif; ?>

        </div>
        <div class="clear"> </div>
    </div>
    <div class="aside"> 
<?php echo __( 'Would you buy me a coffee or a pizza? Im a high college student passionate about code.', 'meta-news-standout-tag-text' ); ?>
<form action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_top">
<input type="hidden" name="cmd" value="_s-xclick">
<input type="hidden" name="hosted_button_id" value="WBUQXEFD53XAS">
<input type="image" src="https://www.paypalobjects.com/en_US/i/btn/btn_donateCC_LG.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!">
<img alt="" border="0" src="https://www.paypalobjects.com/es_XC/i/scr/pixel.gif" width="1" height="1">
</form>
<?php echo __( 'If you have problems with your page write me on twitter @DavidCondence I can help .', 'meta-news-standout-tag-text' ); ?> 
        <div class="clear"> </div>
    </div> 
</div> 
    <?php
}