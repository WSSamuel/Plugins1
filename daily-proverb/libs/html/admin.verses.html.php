<div class="wrap" id="jwdpv0001-admin-page">
    
    <?php include JWDPV0001_HTML_PATH . 'promoadd.php'; ?>
    
    <h1 id="jwdpv0001-plg-title"><?php _e( 'Daily Proverb' , 'daily-proverb' ) ?> <span id="jwdpv0001-plg-type"><?php _e( 'Light' , 'daily-proverb' ) ?></span> | <?php _e( 'Verses' , 'daily-proverb' ) ?></h1>

    
    <div class="" id="jwdpv0001-message-box"></div>
    
    
    <form method="post"id="jwdpv0001-vod-verses">       
        
        <h2><?php _e( 'Daily Verses' , 'daily-proverb' ) ?></h2>
        
        <table class="wp-list-table widefat fixed striped" id="jwdpv0001-verses-table">
            <thead>
                <tr>
                    <th class="day"><?php _e( 'Daily Chapter' , 'daily-proverb' ); ?></th>
                    <th class="vnum"><?php _e( 'Verse#' , 'daily-proverb' ); ?></th>
                    <th><?php _e( 'Verse' , 'daily-proverb' ); ?></th>
                </tr>
            </thead>
            <tbody>
                <?php echo jwdpv0001_admin_render_verses(); ?>
            </tbody>
        </table>
        
    </form>
    
    <p>            
        <button class="button" id="jwdpv0001-reset-verses"><?php _e( 'Reset' , 'daily-proverb' ); ?></button>
    </p>
	
    <?php include JWDPV0001_HTML_PATH . 'credits.php'; ?>

</div>