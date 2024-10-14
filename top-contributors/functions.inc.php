<?php
/**
 * Refresh comment cache function, regenerates the comment list output html
 * This function is called every time the plugin settings are saved,
 * and each time a comment is posted, edited or deleted from WP Admin area.
 */
function jmetc_refresh_comment_cache() {
	global $wpdb;
	
	/**
	 * Get Top contributor 'commenter' options, and Star Icon options
	 */
	$jmetcop['icon'] = get_option('jmetc_icon');
	$jmetc_options = get_option('jmetc_commenters');
	
	/**
	 * Set Star Icon name and count lists as arrays
	 * Need to redefine these as arrays for users that are upgrading from version 1.4
	*/
	$jmetc_options['toplist']['name'] = array();
	$jmetc_options['toplist']['post_count'] = array();

	/**
	 * Start the html template code cache
	 * $jmevar['cache'] is variable used to store final html output.
	 */
	$jmevar['cache'] = '<div class="top-contributors">'."\n";
	
	
	/**
	 * If include/exclude categories is enabled in options, do a category sql query.
	 * Need to do a separate sql query that checks category tables.
	 */
	if($jmetc_options['show_category'] == 1) {
		
		/**
		 * Create comma'd category id list to do query search with
		 */
		$jmevar['catarray'] = implode(",",$jmetc_options['category_list']);
		
		/** 
		 * Create the category id include/exclude sql depending on which option is selected
		 */
		if($jmetc_options['cat_inc_exc'] == 0) 
			$jmevar['catsql'] = "AND t.term_id IN ($jmevar[catarray])";
		else 
			$jmevar['catsql'] = "AND t.term_id NOT IN ($jmevar[catarray]) AND t.taxonomy = 'category'";
		
		
		/**
		 * Do additional query modifications, author exclude, time interval and group by options.
		 */
		$jmevar['authorsql'] = jme_get_author_exclude(3,$jmetc_options['exclude_author']);
		$jmevar['timeInterval'] = jme_get_time_interval(3,$jmetc_options);		
		$jmevar['groupby'] = ($jmetc_options['count_by'] == 0) ? 'c.comment_author_email' : 'c.comment_author';
		
		/**
		 * Create the sql query
		 */
		$query = "SELECT 	
						COUNT(c.comment_ID) AS `comment_count`,
						c.comment_author,
						c.comment_author_email,
						c.comment_author_url
					FROM $wpdb->comments c
					LEFT JOIN $wpdb->term_relationships r
					ON c.comment_post_ID = r.object_id
					LEFT JOIN $wpdb->term_taxonomy t
					ON r.term_taxonomy_id = t.term_taxonomy_id
					WHERE c.comment_approved = 1
					AND c.comment_type = ''
					$jmevar[catsql]
					$jmevar[authorsql]
					$jmevar[timeInterval]
					GROUP BY $jmevar[groupby]
					ORDER BY comment_count DESC
					LIMIT $jmetc_options[limit]
				";
	} else {
		/** 
		 * (else) If there is no category includes/excludes, do standard query 
		 */
		 
				
		/** 
		 * Do additional query modifications, author exclude, time interval and group by options
		 * for normal query without category check.
		 */	
		$jmevar['authorsql'] = jme_get_author_exclude(2,$jmetc_options['exclude_author']);
		$jmevar['timeInterval'] = jme_get_time_interval(2,$jmetc_options);
		$jmevar['groupby'] = ($jmetc_options['count_by'] == 0) ? 'comment_author_email' : 'comment_author';
		
		/**
		 * Create the sql query
		 */
		$query = "	SELECT 	COUNT(comment_ID) AS `comment_count`,
						comment_author,
						comment_author_email,
						comment_author_url
					FROM $wpdb->comments
					WHERE comment_approved = 1
					AND comment_type = ''
					$jmevar[authorsql]
					$jmevar[timeInterval]
					GROUP BY $jmevar[groupby]
					ORDER BY comment_count DESC
					LIMIT $jmetc_options[limit]
				";
	}
				
	/**
	 * Now excute the sql query
	 */
	$gettc = $wpdb->get_results( $query );

	/**
	 * If we get results, we can create the html output of results
	 */
	if($gettc) {
			
		/**
		 * If its a list style format:
		 */
		if($jmetc_options['format'] == 1) {
			$jmevar['count'] = 0;
			
			/**
			 * If list columns is greater than 1, we need to put the list into a table for column formatting
			 * Define 'columns' as true (meaning more than 1 column), and start the 'cache' output with a table.
			 */
			if($jmetc_options['widget_columns'] > 1) {
				$jmevar['columns'] = true;
				$jmevar['cache'] .= '<table cellspacing="0"><tr>';
			}
			
			/**
			 * Create the foreach loop to output html code
			 */
			foreach($gettc as $tc) {
				
				/**
				 * If columns are true, add td tag for table, then start the div list.
				 */
				if($jmevar['columns']) $jmevar['cache'] .= '<td>';
				$jmevar['cache'] .= '<div class="list">';
			
				/**
				 * Generate and get output of username based on if keywordluv option
				 * is enabled, and if user has url or not (also check the rel link option).
				 */
				$jmevar['username'] = jmetc_do_keywordluv($tc->comment_author,
																		$tc->comment_author_url,
																		$jmetc_options['keywordluv'],
																		$jmetc_options['rel_links']);
			
				/**
				 * If show avatar option is checked, add get_avatar function to cache.
				 */
				if($jmetc_options['show_avatar'] == 1) {
					$jmevar['cache'] .= get_avatar($tc->comment_author_email, $jmetc_options['avatar_size']);
				}
			
				/**
				 * Now put the username, defined above, in the cache.
				 * If show comment count enabled, included that in cache as well.
				 */				
				$jmevar['cache'] .= '<div class="tc-user">' . $jmevar['username'] . '</div>';
					if($jmetc_options['show_count'] == 1) {
						$jmevar['cache'] .= '<div class="tc-count">';
						$jmevar['cache'] .= ($tc->comment_count == 1) ? sprintf(__("%s comment", 'jmetc'), $tc->comment_count) :
							sprintf(__("%s comments", 'jmetc'), number_format($tc->comment_count));
						$jmevar['cache'] .= '</div>';
					}
					
				/**
				 * Closing div tags for this output.
				 */
				$jmevar['cache'] .= '<div style="clear:both;"></div></div>'."\n";
				$jmevar['count']++;
				
				/** 
				 * If 'columns' true, close the td tag, and also check if loop 'count' has reached
				 * the column count, and if so, end the row with </tr>, and open new <tr>
				 */					
				if($jmevar['columns']) {
					$jmevar['cache'] .= '</td>';
					if($jmevar['count'] % $jmetc_options['widget_columns'] == 0) $jmevar['cache'] .= '</tr><tr>';
				}
			}
			
			/**
			 * After looping through all users, if columns true, close the table
			 */
			if($jmevar['columns']) $jmevar['cache'] .= "</tr></table>\n";
		}
		/** end of List Style output cache. */
		
		/**
		 * If gallery format is selected
		 */
		if($jmetc_options['format'] == 2) {
			
			/**
			 * Start the gallery list loop
			 */
			foreach($gettc as $tc) {
				/**
				 * Avatar is required for Gallery List, so get_avatar into variable
				 */
				$jmevar['gravatar'] = get_avatar($tc->comment_author_email, $jmetc_options['avatar_size']);
				
				/**
				 * Start gallery list html cache output
				 */
				$jmevar['cache'] .= '<div class="gallery">'."\n";
				
				
				/**
				 * Generate the user Tooltip data, including username, and post count
				 */
				$jmevar['tt'] = 'title="<div class=\'tc-user\'>' . $tc->comment_author . '</div>';
					if($jmetc_options['show_count'] == 1) {
						$jmevar['tt'] .= '<div class=\'tc-count\'>';
						$jmevar['tt'] .= ($tc->comment_count == 1) ? sprintf(__("%s comment", 'jmetc'), $tc->comment_count) :
							sprintf(__("%s comments", 'jmetc'), number_format($tc->comment_count));
						$jmevar['tt'] .= '</div>';
					}
				$jmevar['tt'] .= '" ';
				/** End tooltip info */	
							
				/**
				 * Now add the tooltip info to the Avatar image and put into cache
				 */
				$jmevar['cache'] .= str_replace('<img','<img '.$jmevar['tt'],$jmevar['gravatar']);
				
				/**
				 * Close the html tags
				 */
				$jmevar['cache'] .= "</div>\n";
			}
			/** Clear the Avatar image float */
			$jmevar['cache'] .= '<div style="clear:both;"></div>';
		}
		/** End of Gallery List loop and output cache */
			
		/**
		 * Create array of top users to add Star Icon next to in comments
		 * This part only applied if Top Commenter Icon option is enabled
		 * and the comment threshold is set to 0. This puts top X users in the array
		 * based on the results of 'top commenters' from query above.
		*/			
		if (($jmetcop['icon']['show_icon'] == 1) && ($jmetcop['icon']['comment_limit'] == '0')) {
			foreach($gettc as $tc) {
				$jmetc_options['toplist']['name'][] = $tc->comment_author;
			}
		}
			
	/**
	 * Now end of foreach loop of users
	 * (else) If no results, output No commenters found
	 */
	} else {
		$jmevar['cache'] .= __('No commenters found.', 'jmetc');
	}
	$jmevar['cache'] .= "</div>\n";
	/** End of Top Commenter output cache */

	/**
		If comment threshold is not 0, we need to create a new query to get
		the list of users that meet or exceed the threshold.
		First check to make sure Top contributor Icon is enabled, and 
		threshold limit is not set to '0'.
	*/
	if($jmetcop['icon']['show_icon'] == 1 && $jmetcop['icon']['comment_limit'] != '0') {
		
		/**
			Find the minimum comment count needed for a star.
			If threshold is comma list, get the minmium comment count needed
			to be in the username array.
		*/
		if(strpos($jmetcop['icon']['comment_limit'],",")) {
			$slist = explode(",",$jmetcop['icon']['comment_limit']);
			$starLimit = $slist[0];
		} else {
			$starLimit = $jmetcop['icon']['comment_limit'];
		}
		
		/**
			If include/exclude categories exist, do a category query
		*/
		if($jmetc_options['show_category'] == 1) {
	
			/**
				Create comma'd category id list to do query search with
			*/
			$jmevar['catarray'] = implode(",",$jmetc_options['category_list']);
	
			/** 
				Create the category id include/exclude sql depending on which option is selected
			*/
			if($jmetc_options['cat_inc_exc'] == 0) 
				$jmevar['catsql'] = "AND t.term_id IN ($jmevar[catarray])";
			else 
				$jmevar['catsql'] = "AND t.term_id NOT IN ($jmevar[catarray]) AND t.taxonomy = 'category'";
		
			/**
				Do additional query modifications, author exclude, time interval and group by options.
			*/
			$jmevar['authorsql'] = jme_get_author_exclude(3,$jmetc_options['exclude_author']);
			$jmevar['timeInterval'] = jme_get_time_interval(3,$jmetc_options);		
			$jmevar['groupby'] = ($jmetc_options['count_by'] == 0) ? 'c.comment_author_email' : 'c.comment_author';
	
			/**
				Create the sql query
			*/
			$query = "SELECT 	
							COUNT(c.comment_ID) AS `comment_count`,
							c.comment_author
						FROM $wpdb->comments c
						LEFT JOIN $wpdb->term_relationships r
						ON c.comment_post_ID = r.object_id
						LEFT JOIN $wpdb->term_taxonomy t
						ON r.term_taxonomy_id = t.term_taxonomy_id
						WHERE c.comment_approved = 1
						AND c.comment_type = ''
						$jmevar[catsql]
						$jmevar[authorsql]
						$jmevar[timeInterval]
						GROUP BY $jmevar[groupby]
						HAVING `comment_count` >= '" .$starLimit . "'
					";
		} else {				
			/** 
				(else) If there is no category includes/excludes, do standard query 
			*/
		
			/**
				Do additional query modifications, author exclude, time interval and group by options.
			*/		
			$jmevar['authorsql'] = jme_get_author_exclude(2,$jmetc_options['exclude_author']);
			$jmevar['timeInterval'] = jme_get_time_interval(2,$jmetc_options);
			$jmevar['groupby'] = ($jmetc_options['count_by'] == 0) ? 'comment_author_email' : 'comment_author';

			/**
				Create the sql query
			*/
			$query = "	SELECT 	
							COUNT(comment_ID) AS `comment_count`,
							comment_author
						FROM $wpdb->comments
						WHERE comment_approved = 1
						AND comment_type = ''
						$jmevar[authorsql]
						$jmevar[timeInterval]
						GROUP BY $jmevar[groupby]
						HAVING `comment_count` >= '" . $starLimit . "'
						";

		}
			
		/**
			Get the sql result for list of usernames who qualify for a star
		*/
		$gettc = $wpdb->get_results( $query );
		
		/**
		 * If results, put the result into username and comment count arrays 
		 * for users who qualify for a star.
		 */			 
		if($gettc) {			
			foreach($gettc as $tc) {				
				$jmetc_options['toplist']['name'][] = $tc->comment_author;
				$jmetc_options['toplist']['post_count'][$tc->comment_author] = $tc->comment_count;
			}
		}
	}

	/**
	 * Put resulting cache into wp options table and update.
	 */
	$jmetc_options['cache'] = $jmevar['cache'];
	update_option('jmetc_commenters', $jmetc_options);
		
/**
 * End of Top Commenter Cache function
 */
}


/**
 * Refresh author cache function, regenerates the author list output html
 * This function is called every time the plugin settings are saved,
 * and each time a new post is made, edited or deleted from WP Admin area.
 */
function jmetc_refresh_author_cache() {
	global $wpdb;
	
	/**
	 * Get author settings options
	 */
	$jmetc_options = get_option('jmetc_authors');

	/**
	 * Start html output cache
	 */
	$jmevar['cache'] = '<div class="top-contributors">'."\n";

	/**
	 * Get the author exclude list and time interval sql lines
	 */
	$jmevar['authorsql'] = jme_get_author_exclude(1,$jmetc_options['exclude_author']);
	$jmevar['timeInterval'] = jme_get_time_interval(1,$jmetc_options);

	/**
	 * If top authors list has include/exclude categories, do a
	 * category sql query
	 */
	if($jmetc_options['show_category'] == 1) {
		
		/**
		 * Create comma'd category id list to do query search with
		 */
		$jmevar['catarray'] = implode(",",$jmetc_options['category_list']);
		
		/** 
		 * Create the category id include/exclude sql depending on which option is selected
		 */
		if($jmetc_options['cat_inc_exc'] == 0) 
			$jmevar['catsql'] = "AND t.term_id IN ($jmevar[catarray])";
		else 
			$jmevar['catsql'] = "AND t.term_id NOT IN ($jmevar[catarray]) AND t.taxonomy = 'category'";
		
		/**
		 * Create the sql query
		 */
		$query = "	SELECT
						COUNT(DISTINCT(a.ID)) AS `post_count`,
						b.ID,
						b.display_name,
						b.user_email,
						b.user_url
					FROM $wpdb->posts a
					LEFT JOIN $wpdb->users b
					ON a.post_author = b.ID
					LEFT JOIN $wpdb->term_relationships r
					ON a.ID = r.object_id
					LEFT JOIN $wpdb->term_taxonomy t
					ON r.term_taxonomy_id = t.term_taxonomy_id
					WHERE a.post_status = 'publish'
					AND a.post_type = 'post'
					$jmevar[catsql]
					$jmevar[authorsql]
					$jmevar[timeInterval]
					GROUP BY b.ID
					ORDER BY post_count DESC
					LIMIT $jmetc_options[limit]
				";

	} else {
		/** 
		 * (else) If there is no category includes/excludes, do standard query 
		 */
		
		$query = "	SELECT 	
						COUNT(a.ID) AS `post_count`,
						b.ID,
						b.display_name,
						b.user_email,
						b.user_url
					FROM $wpdb->posts a
					LEFT JOIN $wpdb->users b
					ON a.post_author = b.ID
					WHERE a.post_status = 'publish'
					AND a.post_type = 'post'
					$jmevar[authorsql]
					$jmevar[timeInterval]
					GROUP BY b.ID
					ORDER BY post_count DESC
					LIMIT $jmetc_options[limit]
				";
	}
	
	/**
	 * Execute the sql query
	 */	
	$gettc = $wpdb->get_results( $query );

	/**
	 * If resuls are found
	 */
	if($gettc) {
		
		/**
		 * If author list is List Format setting
		 */
		if($jmetc_options['format'] == 1) {
			$jmevar['count'] = 0;
				
		
			/**
			 * If widget columns is greater than 1, define columns as true,
			 * and wrap the results in a table with each result in td tag.
			 */
			if($jmetc_options['widget_columns'] > 1) {
				$jmevar['columns'] = true;
				$jmevar['cache'] .= '<table cellspacing="0"><tr>';
			}
				
			/**
			 * Start the result loop
			 */
			foreach($gettc as $tc) {
				
				/**
				 * If columns true, wrap each result in td tag, then start standard formatting
				 */
				if($jmevar['columns']) $jmevar['cache'] .= '<td>';
				
				$jmevar['cache'] .= '<div class="list">';
				
				
				/**
				 * If linking to Author page is true, generate link for the username
				 * by getting 'author posts url' from author ID
				 * Else, do standard linking with keywordluv check, and rel links.
				 */
				if($jmetc_options['author_page'])
						$jmevar['username'] = '<a href="' . get_author_posts_url($tc->ID) . '">' . $tc->display_name . '</a>';
				else
						$jmevar['username'] = jmetc_do_keywordluv($tc->display_name,$tc->user_url,$jmetc_options['keywordluv'],$jmetc_options['rel_links']);
					
	
				/**
				 * Check if Show avatar option is enabled
				 */
				if($jmetc_options['show_avatar'] == 1) {
					
					/**
					 * Now check if linking to author page is enabled, to create a href link for the avatar image
					 */
					if($jmetc_options['author_page']) 
						$jmevar['cache'] .= '<a ' . jmetc_rel_link($jmetc_options['rel_links']) . 'href="' . get_author_posts_url($tc->ID) . '">';
				
					
					/** Put avatar result into cache */
					$jmevar['cache'] .= get_avatar($tc->user_email, $jmetc_options['avatar_size']);

					/**
					 * Then put closing </a> tag if author link enabled
					 */
					if($jmetc_options['author_page']) $jmevar['cache'] .= '</a>';
				}
				
				/**
				 * Now format the username and comment count for each result,
				 * use $jmevar[username] result that was created above.
				 */
				$jmevar['cache'] .= '<div class="tc-user">' . $jmevar['username'] . '</div>';
				
				/**
				 * If show comment count is true, add count to cache
				 */
				if($jmetc_options['show_count'] == 1) {
					$jmevar['cache'] .= '<div class="tc-count">';
					$jmevar['cache'] .= ($tc->post_count == 1) ? sprintf(__("%s post", 'jmetc'), $tc->post_count) :
						sprintf(__("%s posts", 'jmetc'), number_format($tc->post_count));
					$jmevar['cache'] .= '</div>';
				}
					
				/**
				 * Close username and comment count tags, and clear the image float left
				 * for each result
				 */
				$jmevar['cache'] .= '<div style="clear:both;"></div></div>'."\n";
				$jmevar['count']++;
					
				/**
				 * If columns is true, then need to finish the wrap in the table
				 */
				if($jmevar['columns']) {
					$jmevar['cache'] .= '</td>';
					if($jmevar['count'] % $jmetc_options['widget_columns'] == 0) $jmevar['cache'] .= '</tr><tr>';
				}
			}
				
			/**
			 * And finally close the table after the foreach loop
			 */
			if($jmevar['columns']) $jmevar['cache'] .= "</tr></table>\n";
		}
		/** End of html output of List Style format */
		
		
		
		/**
		 * If the format style is Gallery Style generate output html cache
		 */
		if($jmetc_options['format'] == 2) {
				
			/**
			 * Start foreach loop of each result
			 */
			foreach($gettc as $tc) {
					
				/**
				 * If linking to Author Page enabled, get the author page url from author ID
				 */
				if($jmetc_options['author_page']) $jmevar['cache'] .= '<a href="'.get_author_posts_url($tc->ID).'">';
						
				/**
				 * Generate user avatar, this is required for Gallery Style
				 */
				$jmetc['gravatar'] = get_avatar($tc->user_email, $jmetc_options['avatar_size']);
					
				$jmevar['cache'] .= '<div class="gallery">'."\n";
					
				/**
				 * Create the avatar tooltip information, such as username, post count
				 */
				$jmevar['tt'] = 'title="<div class=\'tc-user\'>' . $tc->display_name . '</div>';
				
				/**
				 * If show post count true, add it after the username
				 */
				if($jmetc_options['show_count'] == 1) {
					$jmevar['tt'] .= '<div class=\'tc-count\'>';
					$jmevar['tt'] .= ($tc->post_count == 1) ? sprintf(__("%s post", 'jmetc'), $tc->post_count) :
							sprintf(__("%s posts", 'jmetc'), number_format($tc->post_count));
					$jmevar['tt'] .= '</div>';
				}
				$jmevar['tt'] .= '" ';
				/** End of tooltip output */
					
				/**
				 * Add the tooltip info to the avatar image
				 */			
				$jmevar['cache'] .= str_replace('<img','<img '.$jmevar['tt'],$jmetc['gravatar']);
					
				/**
				 * If author page link enabled, close link to Author page after avatar image
				 */
				if($jmetc_options['author_page']) $jmevar['cache'] .= '</a>';
				
				/**
				 * Closing html tags for each user output
				 */
				$jmevar['cache'] .= "</div>\n";
			}
			$jmevar['cache'] .= '<div style="clear:both;"></div>';
		}
	} else {
		
		/**
		 * (else) if no results from query, output no authors found.
		 */
		$jmevar['cache'] .= __('No authors found.', 'jmetc');
	}
		
	$jmevar['cache'] .= "</div>\n";
	
	/**
	 * Store cached html output into WP option table, and update option table
	 */
	$jmetc_options['cache'] = $jmevar['cache'];
	update_option('jmetc_authors', $jmetc_options);
}
/** End of Author result cache */


/**
 * Function to generate the username exclude list for sql query
 */ 
function jme_get_author_exclude($type,$the_authors) {
	
	/** Define Author SQL as empty string */
	$author_sql = '';
	
	/**
	 * If exclude author list field is not empty,
	 * put the author emails into comma list for sql query.
	 */
	if(trim($the_authors) != '') {
		$authorlist = array();
		$authors = explode(",",$the_authors);
		for($i=0;$i<count($authors);$i++) {
			if(trim($authors[$i]) != '') {
				$authorlist[] = strtolower(trim($authors[$i]));
			}
		}
		$al = implode("','",$authorlist);		
		if($al != '') {
			
			/**
			 * Depending on $type of query, create the sql line
			 * to be appended to sql query
			 */
			if($type == 1) {
				$author_sql = "AND LOWER(b.user_email) NOT IN('" . $al . "')";
			} else if($type == 2) {
				$author_sql = "AND LOWER(comment_author_email) NOT IN('" . $al . "')";
			} else if($type == 3) {
				$author_sql = "AND LOWER(c.comment_author_email) NOT IN('" . $al . "')";
			}
		}
	}
	/** Return the sql query */
	return $author_sql;	
}

/**
 * This just gets the blog's categories to display in the Admin settings options
 * for including and excluding categories
 */
function jme_get_category_list_id() {
	global $wpdb;
	
	$query = "	SELECT t.term_id, t.name
					FROM $wpdb->terms t
					LEFT JOIN $wpdb->term_taxonomy a
					ON t.term_id = a.term_id
					WHERE a.taxonomy = 'category'
					ORDER BY t.name ASC";
	$gettc = $wpdb->get_results( $query );
	return $gettc;
}

/**
 * This creates the sql line for time interval to get
 * results from
 */
function jme_get_time_interval($type,$options) {
	$timeInterval = '';
	$currenttime = time();
	if($options['time_limit_type'] == 2) {

		$basetime = 60 * 60 * 24; // 1 day of time
		
		if ($options['time_limit_interval'] == 1) {
			$time = $basetime; // last day
		} else if ($options['time_limit_interval'] == 2) {
			$time = $basetime * 7; // last week
		} else if ($options['time_limit_interval'] == 3) {
			$time = $basetime * 30; // last month
		} else if ($options['time_limit_interval'] == 4) {
			$time = $basetime * 365; // last year
		}
		
		$int = (is_numeric(trim($options['time_limit_int']))) ? trim($options['time_limit_int']) : 1;
		$time = $time * $int; // multiply by number of intervals
		
		$subTime = $currenttime - $time;
		$dateLimit = gmdate('Y-m-d H:i:s', $subTime);
		if($type == 1) {
			$timeInterval = "AND a.post_date_gmt > '" . $dateLimit . "'";
		} else if($type == 2) {
			$timeInterval = "AND comment_date_gmt > '" . $dateLimit . "'";
		} else if($type == 3) {
			$timeInterval = "AND c.comment_date_gmt > '" . $dateLimit . "'";
		}
	}
	if($options['time_limit_type'] == 3) {
		
		// define current day, month, year
		$currentDay = gmdate('j'); 
		$currentMonth = gmdate('n');
		$currentYear = gmdate('Y');
		
		// set current to the time
		$theDay = $currentDay;
		$theMonth = $currentMonth;
		$theYear = $currentYear;
			
		/* if this week, get the start of week */
		if($options['time_limit_this'] == 1) {
			// set array of how many days into the week, Sunday = 0
			$weekArray = array(	'Sunday' => 0, 'Monday' => 1, 'Tuesday' => 2, 'Wednesday' => 3, 'Thursday' => 4, 'Friday' => 5, 'Saturday' => 6 );
	
			$currentDayOfWeek = gmdate('l'); // get day of week
			
			// get starting day of week. Used this method to support PHP4, only PHP5 can get current day directly.
			$theDay = $theDay - $weekArray[$currentDayOfWeek];
		}
		/* if this month, set day = 1 */
		if($options['time_limit_this'] == 2) {
			$theDay = 1;
		}
		/* if this year, set day, month = 1 */
		if($options['time_limit_this'] == 3) {
			$theDay = 1;
			$theMonth = 1;
		}
			
		$subTime = mktime(0, 0, 0, $theMonth, $theDay, $theYear);
		$dateLimit = gmdate('Y-m-d H:i:s', $subTime);
		if($type == 1) {
			$timeInterval = "AND a.post_date_gmt > '" . $dateLimit . "'";
		} else if($type == 2) {
			$timeInterval = "AND comment_date_gmt > '" . $dateLimit . "'";
		} else if($type == 3) {
			$timeInterval = "AND c.comment_date_gmt > '" . $dateLimit . "'";
		}
	}
	return $timeInterval;	
}

function jme_sanitize_js($str) {
	return str_replace('"','\"',stripslashes($str));
}

/**
 * Register and enqueue javascripts needed for Gallery Style tooltips and CSS style for
 * both List and Gallery style formatting
 */
function jme_top_contributors_init() {
	global $jmetcop;
	if(!is_admin()) {
		if($jmetcop['comment']['format'] == 2 || $jmetcop['author']['format'] == 2) {
			wp_register_script( 'jmetc-dim', JMETC_PLUGINPATH.'js/jquery.dimensions.js', array('jquery'), '' );
			wp_register_script( 'jmetc-tt', JMETC_PLUGINPATH.'js/jquery.tooltip.js', array('jquery'), '' );
			wp_enqueue_script( 'jmetc-dim' );
			wp_enqueue_script( 'jmetc-tt' );
		}
		wp_register_style( 'jmetc-css', JMETC_PLUGINPATH . "css/tooltip.css" );	
		wp_enqueue_style( 'jmetc-css' );
	}
}

/**
 * jQuery function required for Gallery List tooltip to work
 */
function jme_top_contributors_tooltip() {
	global $jmetcop;
	if($jmetcop['comment']['format'] == 2 || $jmetcop['author']['format'] == 2) {
		echo "<script type=\"text/javascript\">jQuery(document).ready(function($) { jQuery('.top-contributors img').tooltip({delay:0,showURL:false,}); });</script>\n";
	}
}

/**
 * This is the function that adds the Stars to each username in the comment list
 * This takes the array of user names created in the Comment List Cache function above
 * and if the username of the comment is in the array, add the neccessary amount of stars
 */ 
function jme_tc_icon($user) {
	global $jmetcop;
	$string = $user;
	$user = strip_tags($user);
	if($jmetcop['icon']['show_icon'] == 1) {
		if(in_array($user, $jmetcop['comment']['toplist']['name'])) {
			$string = $string . ' ';		
			$starList = explode(",",$jmetcop['icon']['comment_limit']);

			/**
				Loop through each threshold limit and check if user post count is above
				that threshold limit, and add a star if it does
			*/
			for($i=0;$i<count($starList);$i++) {
				if($jmetcop['comment']['toplist']['post_count'][$user] >= $starList[$i]) {

					$string .= '<img class="tc-icon" src="' . JMETC_PLUGINPATH . 'images/' . $jmetcop['icon']['icon'] . '" alt="" title="' . __('Top Contributor', 'jmetc') . '" />';
				}
			}
		}
	}
	return $string;
}

/**
 * Rel Link function
 */
function jmetc_rel_link($rel) {
	switch($rel) {
		case 1 : $jmevar['rel'] = 'rel="nofollow" '; break;
		case 2 : $jmevar['rel'] = 'rel="dofollow" '; break;
		default : $jmevar['rel'] = '';
	}
	return $jmevar['rel'];
}

/**
 * Just check username for KeywordLuv, and rel links
 */
function jmetc_do_keywordluv($name,$url,$kwl,$rel) {
	if(strpos($name,'@') && $url != '' && $kwl == 1) {
		$part = explode('@',$name);
		return trim($part[0]) . ' ' . __('from','jmetc') . ' <a ' . jmetc_rel_link($rel) . 'href="' . $url . '">' . trim($part[1]) . '</a>';
	} else if($url != '') {
		return '<a ' . jmetc_rel_link($rel) . 'href="' . $url . '">' . $name . '</a>';
	} else {
		return $name;
	}
}

?>