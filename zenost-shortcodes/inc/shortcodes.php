<?php
function pt_shortcode_scripts() {
	wp_enqueue_style( 'shortcodes',  plugin_dir_url( __FILE__ ) . 'css/shortcodes.css');
	wp_enqueue_style ('bootstrap' ,'http://maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.css');
	wp_enqueue_script('toggle-menu', plugin_dir_url( __FILE__ ) .'js/toggle-menu.js', array(),'null', true );
	wp_enqueue_script('bootstrap', plugin_dir_url( __FILE__ ) .'js/bootstrap.min.js', array(),'null', true );
}
add_action( 'wp_enqueue_scripts', 'pt_shortcode_scripts' );
function zenost_button( $atts, $content = null ) {
    extract(shortcode_atts(array(
    'link'	=> '',
    'target' => '',
    'color'	=> '',
    'size'	=> '',
    'align'	=> '',
    ), $atts));
 
	$style = ($color) ? 'btn-'.$color. '' : '';
	$align = ($align) ? ' align'.$align : '';
	$size = ($size == 'large') ? ' large_button' : '';
	//$target = ($target == 'blank') ? ' target="_blank"' : '';
	$target = ($target) ? ''.$target:'';
	$link = ($link) ? ''.$link :'';
 
	$out = '<a class="btn ' .$style. '" href="' .$link. '" target="'.$target.'">' .do_shortcode($content). '</a>';
    
    return $out;
}
add_shortcode('button', 'zenost_button');

function accordian_div( $atts, $content = null ) {
	extract(shortcode_atts(array(
    ), $atts));
	
	
	
	$out = '<div id="accordion3" class="accordion">
             ' .do_shortcode($content). '
 
            </div>';
	return $out;		
}
add_shortcode('accordian', 'accordian_div');

function accordian_group( $atts, $content = null ) {
	extract(shortcode_atts(array(
    'heading'	=> '',
	'item_no'	=> '',
    ), $atts));
	$heading = ($heading) ? ''.$heading :'';
	$item_no = ($item_no) ? ''.$item_no :'';
	
	$out = '<div class="accordion-group">
                    <div class="accordion-heading">
                        <a href="#collapse'.$item_no.'" data-parent="#accordion'.$item_no.'" data-toggle="collapse" class="accordion-toggle collapsed">
                            ' .$heading. '<i class="fa fa-chevron-down"></i>
                        </a>
                    </div>
                    <div class="accordion-body collapse" id="collapse'.$item_no.'">
                        <div class="accordion-inner">
                            <p class="normal-text">' .do_shortcode($content). '</p>
                        </div>
                    </div>
                </div>';
    return $out;				
}
add_shortcode('accordian-item', 'accordian_group');
				
function column_quarter( $atts, $content = null ) {
	extract(shortcode_atts(array(
    'heading'	=> '',
    ), $atts));
	$heading = ($heading) ? ''.$heading :'';

	
	$out = '<div class="col-sm-3">
            <div class="column-detail">
                <h3 class="codes-head">'.$heading.'</h3>
                <p class="normal-text">' .do_shortcode($content). '</p>
            </div>
        </div>';
    return $out;				
}
add_shortcode('column-quarter', 'column_quarter');				

function column_half( $atts, $content = null ) {
	extract(shortcode_atts(array(
    'heading'	=> '',
    ), $atts));
	$heading = ($heading) ? ''.$heading :'';

	
	$out = '<div class="col-sm-6">
            <div class="column-detail">
                <h3 class="codes-head">'.$heading.'</h3>
                <p class="normal-text">' .do_shortcode($content). '</p>
            </div>
        </div>';
    return $out;				
}
add_shortcode('column-half', 'column_half');				

function column_third( $atts, $content = null ) {
	extract(shortcode_atts(array(
    'heading'	=> '',
    ), $atts));
	$heading = ($heading) ? ''.$heading :'';

	
	$out = '<div class="col-sm-4">
            <div class="column-detail">
                <h3 class="codes-head">'.$heading.'</h3>
                <p class="normal-text">' .do_shortcode($content). '</p>
            </div>
        </div>';
    return $out;				
}
add_shortcode('column-third', 'column_third');	

function column_full( $atts, $content = null ) {
	extract(shortcode_atts(array(
    'heading'	=> '',
    ), $atts));
	$heading = ($heading) ? ''.$heading :'';

	
	$out = '<div class="col-sm-12">
            <div class="column-detail">
                <h3 class="codes-head">'.$heading.'</h3>
                <p class="normal-text">' .do_shortcode($content). '</p>
            </div>
        </div>';
    return $out;				
}
add_shortcode('column-full', 'column_full');

function lists( $atts, $content = null ) {
	extract(shortcode_atts(array(
    ), $atts));

	
	$out = '<div class="lists">
               ' .do_shortcode($content). '
            </div>';
    return $out;				
}
add_shortcode('list', 'lists');			

function list_item( $atts, $content = null ) {
	extract(shortcode_atts(array(
    ), $atts));

	
	$out = '<p class="normal-text"><i class="fa fa-check"></i>' .do_shortcode($content). '</p>';
    return $out;				
}
add_shortcode('list-item-check', 'list_item');	

function list_item_2( $atts, $content = null ) {
	extract(shortcode_atts(array(
    ), $atts));

	
	$out = '<p class="normal-text"><i class="fa fa-square-o"></i>' .do_shortcode($content). '</p>';
    return $out;				
}
add_shortcode('list-item-square', 'list_item_2');	

function list_item_3( $atts, $content = null ) {
	extract(shortcode_atts(array(
    ), $atts));

	
	$out = '<p class="normal-text"><i class="fa fa-chevron-right"></i>' .do_shortcode($content). '</p>';
    return $out;				
}
add_shortcode('list-item-arrow', 'list_item_3');

function toggle_menu( $atts, $content = null ) {
	extract(shortcode_atts(array(
	
    ), $atts));

	
	$out = '<div class="row"><div class="col-md-8"><div id="cssmenu"><ul>' .do_shortcode($content). '</ul></div></div></div>';
    return $out;				
}
add_shortcode('toggle', 'toggle_menu');	

function toggle_item( $atts, $content = null ) {
	extract(shortcode_atts(array(
	'heading'	=> '',
    ), $atts));
	$heading = ($heading) ? ''.$heading :'';
	
	$out = '<li class="has-sub"><a href="#">'.$heading.'<i class="fa fa-plus"></i></a>
                        <ul style="display:block">
                            <li>
                                <p class="normal-text">' .do_shortcode($content). '</p>
                            </li>

                        </ul>
                    </li>';
    return $out;				
}
add_shortcode('toggle-item', 'toggle_item');	

function head_group( $atts, $content = null ) {
	extract(shortcode_atts(array(
    ), $atts));
	
	
	$out = '<div class="headings">' .do_shortcode($content). '</div>';
    return $out;				
}
add_shortcode('head-group', 'head_group');	


function heading1( $atts, $content = null ) {
	extract(shortcode_atts(array(
	'title' => '',
    ), $atts));
	$title = ($title) ? ''.$title :'';
	
	$out = ' <h3 class="head3"><span>'.$title.'</span> ' .do_shortcode($content). '</h3>';
    return $out;				
}
add_shortcode('head1', 'heading1');	

function heading2( $atts, $content = null ) {
	extract(shortcode_atts(array(
	'title' => '',
    ), $atts));
	$title = ($title) ? ''.$title :'';
	
	$out = ' <h4 class="head3"><span>'.$title.'</span> ' .do_shortcode($content). '</h4>';
    return $out;				
}
add_shortcode('head2', 'heading2');	

function heading3( $atts, $content = null ) {
	extract(shortcode_atts(array(
	'title' => '',
    ), $atts));
	$title = ($title) ? ''.$title :'';
	
	$out = ' <h5 class="head3"><span>'.$title.'</span> ' .do_shortcode($content). '</h5>';
    return $out;				
}
add_shortcode('head3', 'heading3');	


add_filter('widget_text', 'do_shortcode');

 