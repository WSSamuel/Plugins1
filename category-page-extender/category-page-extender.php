<?php
/*
Plugin Name: Category Page Extender
Plugin URI: http://categorypageextender.wordpress.com/
Description: Adds posts to corresponding pages
Version: 1.0.3
Author: Tim Murray
Author URI: http://categorypageextender.wordpress.com/
*/

/*  Copyright 2009  Tim Murray  (email : grpsmglr00@gmail.com)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation; either version 2 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

function page2cat_pages($base_page_id, $default_display = 10, $max_num_of_pages = 15){ ///default number of posts to display at once here (enter -1 to display all)
 echo '<link type="text/css" rel="stylesheet" href="' . get_bloginfo('wpurl') . '/wp-content/plugins/category-page-extender/default/catpage.css" />' . "\n";
global $wpdb;

	$cur_page = $base_page_id;	
	$query_catID = $wpdb->get_var("SELECT cat_ID FROM $wpdb->page2cat WHERE page_ID=$cur_page");
	$post_count = $wpdb->get_var("SELECT count FROM $wpdb->term_taxonomy WHERE term_id=$query_catID");
	if( isset($query_catID) ) {
		$current_page = $_GET['posts_page'];
		if (isset($current_page)){
		} else { 
			$current_page =1;
		}
		if ($default_display > 0){
		$display_num = $default_display;
		} else {
		$display_num = $post_count +1;
		}
		while(($post_count/$display_num) < ($current_page-1) ){
			$current_page -= 1;
		}
		//Permalink for page scrolling
		$base_link = get_permalink();

			if ( strlen(stristr($base_link,'?')) > 0){
			$variable_prefix = '&';
			} else {
			$variable_prefix = '?';
		}
	
		$offsetnum = ($display_num * ($current_page - 1)); 
		$query = 'cat=' . $query_catID . '&showposts=' . $display_num. '&offset=' . $offsetnum;
		query_posts($query); 
		
	?>
		
		
	<?php	
	///////////////////////////////////////////////////////////////////////////
	///          You can replace the code below to match your theme         ///
	/// (you can copy this from your archive.php, index.php or customize it ///
	///////////////////////////////////////////////////////////////////////////
	?>
	
	<?php // ----- Start Code Replace ------ ?>
	
		<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
			<div class="post">
			
					<h3 id="post-<?php the_ID(); ?>"><a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title_attribute(); ?>"><?php the_title(); ?></a></h3>
					<div class="entry">
						<?php the_excerpt() ?>
					</div>
					<div class="postmetadata"><?php edit_post_link('Edit', '', ' | '); ?> <?php the_time('d F Y') ?> |  <?php the_author_posts_link('namefl'); ?> | <?php the_category(', ') ?> |  <?php comments_popup_link('No Comment', '1 Comment', '% Comments'); ?> | <a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title(); ?>" class="more">Read More</a> <?php the_tags('<br /> Tags: ', ', ', ''); ?></div>
		
				</div>
				
			
		<?php endwhile; endif; ?>
		
	<?php // ----- End Code Replace ------ ?>
	
	<?php	
	///////////////////////////////////////////////////////////////////////////
	///////////////////////////////////////////////////////////////////////////
	?>	
	
	<?php // --------- For Page Count --------- ?>
	
	<?php 
		$aa = $post_count / $display_num ;
		$bb = intval($aa);
		
		if ($aa == $bb) {
				$num_of_pages = $bb;
			} else {
				$num_of_pages = $bb + 1;
			}
			if ($max_num_of_pages > 0){
			} else {
				$max_num_of_pages = $num_of_pages;
			}
		if ($num_of_pages > 1){
			echo '<br />';
			$start_dots = '';
			$start_arrows = '';
			$end_dots = '';
			$end_arrows = '';
			if($num_of_pages > $max_num_of_pages){
				if($current_page > ($max_num_of_pages/2) ){
					$start_page = $current_page - intval($max_num_of_pages/2)+1;
				} else {
					$start_page = 1;
				}
				if ($start_page > ($num_of_pages - $max_num_of_pages)){
							$start_page = ($num_of_pages - $max_num_of_pages +1);
							$end_text = '';
				} else {
					$end_dots = '<span></span><li>..</li><span> </span>';
					$end_arrow = '<span></span><li style="font-size:80%;"><a href="' . $base_link . $variable_prefix . 'posts_page=' . $num_of_pages . '" title="Go to the last page">&gt;&gt;</a></li>';
				}
				if( $start_page > 1 ) {
					$start_dots = '<span></span><li>..</li><span> </span>';
					$start_arrow = '<span></span><li style="font-size:80%;"><a href="' . $base_link . $variable_prefix . 'posts_page=1" title="Go to the first page">&lt;&lt;</a></li><span>&nbsp;&nbsp;</span>';
				}
			
			} else {
				$start_page = 1;
				$max_num_of_pages = $num_of_pages;
			}
			$page_stop = $start_page + ($max_num_of_pages - 1);
			$pg_count = $start_page;

			echo '<div id="p2c-navigation">';
			echo '<div class="p2c-nav">';						
			echo '<li>Page ' . $current_page . ' of ' . $num_of_pages . '&nbsp;</li><span>&nbsp;&nbsp;</span>';
			if ($current_page > 1) {
				echo $start_arrow;
				
				echo '<span></span><li style="font-size:80%;"><a href="' . $base_link . $variable_prefix . 'posts_page=' . ($current_page - 1) . '" title="Go to the previous page ( ' . ($current_page - 1) . ' )">&lt;</a></li><span>&nbsp;&nbsp;</span>';				
			}
			
			while ($pg_count <= $page_stop) {
				if ($pg_count == $current_page){
				
					echo '<span></span><li class="p2c-currentpage"><span >' . $pg_count . '</span></li><span> </span>' ;
				} else {
					echo '<span></span><li><a href="' . $base_link . $variable_prefix . 'posts_page=' . ($pg_count) . '" title="Go to page ' . $pg_count . '">' . $pg_count . '</a></li><span>&nbsp;</span>';
				}
				$pg_count += 1; 
			}
			echo $end_text;
			if ($current_page < $num_of_pages){
				echo '<span>&nbsp;</span><li style="font-size:80%;"><a href="' . $base_link . $variable_prefix . 'posts_page=' . ($current_page + 1) . '" title="Go to the next page ( ' . ($current_page + 1) . ' )">&gt;</a></li><span>&nbsp;</span>';
				echo $end_arrow;
			}
			echo '</div></div>';
			
		}
	}
}

?>
