<div class="wrap" id="jwdpv0001-admin-page">
    
    <?php include JWDPV0001_HTML_PATH . 'promoadd.php'; ?>
    
    <h1 id="jwdpv0001-plg-title"><?php _e( 'Daily Proverb' , 'daily-proverb' ) ?> <span id="jwdpv0001-plg-type"><?php _e( 'Light' , 'daily-proverb' ) ?></span> | <?php _e( 'Versions' , 'daily-proverb' ) ?></h1>

    <form method="post">
        
        <div id="jwdpv0001-bibles">        
            <h2><?php _e( 'Current Version' , 'daily-proverb' ) ?></h2>
            <select id="jwdpv0001-versions-sel" name="jwdpv0001-versions-sel">
            <?php foreach( $jwdpv0001_all_bibles as $version ) : ?>
                <?php $vsn = end( explode( '/' , $version ) ); ?>
                <?php if( $vsn == $jwdpv0001_bible ) : ?>
                <option value="<?php echo $vsn; ?>" selected="selected"><?php echo array_shift( explode( '.', $vsn ) ); ?></option>
                <?php else: ?>
                <option value="<?php echo $vsn; ?>"><?php echo array_shift( explode( '.', $vsn ) ); ?></option>
                <?php endif; ?>
            <?php endforeach; ?>
            </select>
        </div>
        
        <div id="jwdpv0001-bop-head">
            <h2><?php _e( 'The Book of Proverbs' , 'daily-proverb' ); ?></h2>
        </div>
        <table id="jwdpv0001-bop" class="widefat">            
            <tbody>
                <tr>                
                    <td class="chlinks" style="width:90px">
                        <ul id="bible-book-links">
                            <li><a href="#chapter-tab-1"><?php _e( 'Chapter' , 'daily-proverb' ); ?> 1</a></li>
                            <li><a href="#chapter-tab-2"><?php _e( 'Chapter' , 'daily-proverb' ); ?> 2</a></li>
                            <li><a href="#chapter-tab-3"><?php _e( 'Chapter' , 'daily-proverb' ); ?> 3</a></li>
                            <li><a href="#chapter-tab-4"><?php _e( 'Chapter' , 'daily-proverb' ); ?> 4</a></li>
                            <li><a href="#chapter-tab-5"><?php _e( 'Chapter' , 'daily-proverb' ); ?> 5</a></li>
                            <li><a href="#chapter-tab-6"><?php _e( 'Chapter' , 'daily-proverb' ); ?> 6</a></li>
                            <li><a href="#chapter-tab-7"><?php _e( 'Chapter' , 'daily-proverb' ); ?> 7</a></li>
                            <li><a href="#chapter-tab-8"><?php _e( 'Chapter' , 'daily-proverb' ); ?> 8</a></li>
                            <li><a href="#chapter-tab-9"><?php _e( 'Chapter' , 'daily-proverb' ); ?> 9</a></li>
                            <li><a href="#chapter-tab-10"><?php _e( 'Chapter' , 'daily-proverb' ); ?> 10</a></li>
                            <li><a href="#chapter-tab-11"><?php _e( 'Chapter' , 'daily-proverb' ); ?> 11</a></li>
                            <li><a href="#chapter-tab-12"><?php _e( 'Chapter' , 'daily-proverb' ); ?> 12</a></li>
                            <li><a href="#chapter-tab-13"><?php _e( 'Chapter' , 'daily-proverb' ); ?> 13</a></li>
                            <li><a href="#chapter-tab-14"><?php _e( 'Chapter' , 'daily-proverb' ); ?> 14</a></li>
                            <li><a href="#chapter-tab-15"><?php _e( 'Chapter' , 'daily-proverb' ); ?> 15</a></li>
                            <li><a href="#chapter-tab-16"><?php _e( 'Chapter' , 'daily-proverb' ); ?> 16</a></li>
                            <li><a href="#chapter-tab-17"><?php _e( 'Chapter' , 'daily-proverb' ); ?> 17</a></li>
                            <li><a href="#chapter-tab-18"><?php _e( 'Chapter' , 'daily-proverb' ); ?> 18</a></li>
                            <li><a href="#chapter-tab-19"><?php _e( 'Chapter' , 'daily-proverb' ); ?> 19</a></li>
                            <li><a href="#chapter-tab-20"><?php _e( 'Chapter' , 'daily-proverb' ); ?> 20</a></li>
                            <li><a href="#chapter-tab-21"><?php _e( 'Chapter' , 'daily-proverb' ); ?> 21</a></li>
                            <li><a href="#chapter-tab-22"><?php _e( 'Chapter' , 'daily-proverb' ); ?> 22</a></li>
                            <li><a href="#chapter-tab-23"><?php _e( 'Chapter' , 'daily-proverb' ); ?> 23</a></li>
                            <li><a href="#chapter-tab-24"><?php _e( 'Chapter' , 'daily-proverb' ); ?> 24</a></li>
                            <li><a href="#chapter-tab-25"><?php _e( 'Chapter' , 'daily-proverb' ); ?> 25</a></li>
                            <li><a href="#chapter-tab-26"><?php _e( 'Chapter' , 'daily-proverb' ); ?> 26</a></li>
                            <li><a href="#chapter-tab-27"><?php _e( 'Chapter' , 'daily-proverb' ); ?> 27</a></li>
                            <li><a href="#chapter-tab-28"><?php _e( 'Chapter' , 'daily-proverb' ); ?> 28</a></li>
                            <li><a href="#chapter-tab-29"><?php _e( 'Chapter' , 'daily-proverb' ); ?> 29</a></li>
                            <li><a href="#chapter-tab-30"><?php _e( 'Chapter' , 'daily-proverb' ); ?> 30</a></li>
                            <li><a href="#chapter-tab-31"><?php _e( 'Chapter' , 'daily-proverb' ); ?> 31</a></li>
                        </ul>
                    </td>
                    <td>
                        <div id="bible-book-container">
                            <?php foreach ( $chapters as $num=>$chapter ) : ?>
                                <?php echo jwdpv0001_admin_render_verse_tabs( $num , $chapter , $jwdpv0001_txt_dir ); ?>
                            <?php endforeach; ?>
                        </div>
                    </td>
                </tr>
            </tbody>
            
        </table>        
        
    </form>
    <hr/>
    <h2><?php _e( '"Proverbs" In Your Own Language' , 'daily-proverb' ) ?></h2>
    <p><input type="text" id="jwdpv0001-prv-txt" value="<?php echo get_option( 'jwdpv0001_proverbs' ); ?>"/></p>
    <p>            
        <button class="button" id="jwdpv0001-prv-txt-save"><?php _e( 'Save ' , 'daily-proverb' ); ?></button> <span id=jwdpv0001-prv-txt-save-msg"" style="display: none"><?php _e( 'Saved' , 'daily-proverb' ); ?></span>
    </p>
    
    <?php include JWDPV0001_HTML_PATH . 'credits.php'; ?>

</div>

