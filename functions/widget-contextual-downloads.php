<?php

		/*-----------------------------------------------------------------------------------*/
		/*	Widget for dynamics101 to show resources based on parent category */
		/*-----------------------------------------------------------------------------------*/

		
		class list_downloads_widget extends WP_Widget {
		 
		 
			/** constructor -- name this the same as the class above */
			function list_downloads_widget() {
				parent::WP_Widget(false, $name = 'List Contextual Downloads');
			}
		 
			/** @see WP_Widget::widget -- do not rename this */
			function widget($args, $instance) {
				extract( $args );
				$number 	= $instance['number']; // the number of categories to show
				$taxonomy 	= $instance['taxonomy']; // the taxonomy to display				
				$cat = get_the_category(); // get applicable categories	
				
				$cat_parent = get_parent_id($cat); // get id of parent category
				// if no posts in the parent category, don't show categories
				if($cat_parent === 0) { exit; }
				$cat_parent_id = $cat_parent[0];
				$cat_parent_slug = $cat_parent[1];
				$cat_parent_name = $cat_parent[2];
				// debug 
				/*
					echo 'Value: '.$cat_parent_id;
					echo 'Value: '.$instance['title'];
					print_r($cat_parent);
				*/
				/*if(strlen($instance['title']) > 2) { 
					$title 		= apply_filters('widget_title', $instance['title'] ); // the widget title
				} else { 
					$title 		= apply_filters('widget_title', $cat_parent_name." Academy"); // the widget title
				}*/
				$title 		= apply_filters('widget_title', $cat_parent_name." Academy"); // the widget title
				$args = array(
					'number' 	=> $number,
					'taxonomy'	=> $taxonomy,
					'child_of'  => $cat_parent_id
				);
				
				
				
				
				
				
				// get and output the downloads
				$catname = $cat_parent_slug;
				// match url to catid array
				
				$cat_list = array (  
				
					 "1" => "microsoft-dynamics-ax", 
					 "2" => "microsoft-dynamics-nav", 
					 "3" => "microsoft-dynamics-gp", 
					 "4" => "microsoft-crm", 
					 "5" => "sharepoint", 
					 "6" => "sql-server", 
					 "7" => "academy", 
				); 
				
				$catid = array_search($catname, $cat_list);
				// debug 
				// echo $catname;
				// echo $catid;
				// don't forget, [list_downloads] required on page
				// only assets that match tags will show up
				
				if($catid > 0) { 

					$orderby = 'date';
					// if qty not set in widget settings, use default
					if($number < 0) $qty = 3;
					$char_count = 105;
					$char_count_video = 40;
					$path = get_bloginfo('template_directory');
					// $title = get_the_title().' ';
					
					// tags = whitepaper, guide, screencast, demo, case study, brochure
					
					
					$dl = get_downloads('limit='.$qty.'&category='.$catid.'&tags=guide, screencast, demo,case study,whitepaper,brochure&order=desc&orderby='.$orderby);
					if (!empty($dl)) {
					
					 
						// build and process (ASC or desc)
						$dl_guide = get_downloads('limit='.$qty.'&category='.$catid.'&tags=guide&order=desc&orderby='.$orderby);
						$dl_screencast = get_downloads('limit='.$qty.'&category='.$catid.'&tags=screencast&order=desc&orderby='.$orderby);
						$dl_demo = get_downloads('limit='.$qty.'&category='.$catid.'&tags=demo&order=desc&orderby='.$orderby);
						$dl_whitepaper = get_downloads('limit='.$qty.'&category='.$catid.'&tags=whitepaper&order=desc&orderby='.$orderby);
						$dl_casestudy = get_downloads('limit='.$qty.'&category='.$catid.'&tags=case study&order=desc&orderby='.$orderby);
						$dl_brochure = get_downloads('limit='.$qty.'&category='.$catid.'&tags=brochure&order=desc&orderby='.$orderby);
						
						// check if all 4 have results, adjust span size accordingly
						
						// output
						$before_widget_rg = '<div class="download_widget">';
						$after_widget_rg = '</div>';
						$widget_top = '<div id="academy" class="eat-margins" style="background-color:#494a4a;"><img src="http://www.dynamics101.com/images/sidebar/MS-AX-banner-top.png" width="455px">';
						$widget_bottom = '<img src="http://www.dynamics101.com/images/sidebar/MS-AX-banner-bottom.png" width="455px"></div>';
						
						$buff = $before_widget_rg.$before_widget.$widget_top;
						// if ( $title ) { $buff .= $before_title . $title . $after_title; }
						 
						$buff .= '<ul>';
								
						// guides
						if (!empty($dl_guide)) {
							foreach($dl_guide as $d) { 
								$buff .= '<li style="background:none;margin-right:10px;"><a href="/academy/?did='.$d->id.'" title="'.$d->title.'" class="downloadLink download'.$d->id.'">
								<img src="http://www.dynamics101.com/images/sidebar/i_guides.png" style="padding-right:11px;" align="left" alt="'.$d->title.'" />
								<p>'.neat_trim($d->title,$char_count).'</p>
								</a></li>';
							}
							$buff .= "</ul></li>";
						}
						
						$buff .= '<ul>';
						
						// screencasts
						if (!empty($dl_screencast)) {						
							foreach($dl_screencast as $d) { 
								$buff .= '<li style="background:none;margin-right:10px;"><a href="/academy/?did='.$d->id.'" title="'.$d->title.'" class="downloadLink downloadVideo download'.$d->id.'">
								<img src="http://www.dynamics101.com/images/sidebar/i_screencast.png" style="padding-right:1px;margin:0 10px 0 2px;" align="left" alt="'.$d->title.'" />
								<p>'.neat_trim($d->title,$char_count_video).'</p>
								</a></li>';
							}
							$buff .= "</ul></li>";

						}
						// demos
						if (!empty($dl_demo)) {						
							foreach($dl_demo as $d) { 
								$buff .= '<li><a href="/academy/?did='.$d->id.'" title="'.$d->title.'" class="downloadLink downloadVideo download'.$d->id.'">
								<img src="'.$d->thumbnail.'" align="left" alt="'.$d->title.'" />
								<h5>'.neat_trim($d->title,$char_count_video).'</h5>
								</a></li>';
							}
							$buff .= "</ul></li>";
						}

						// white papers
						if (!empty($dl_whitepaper)) {
							foreach($dl_whitepaper as $d) { 

								$buff .= '<li style="background:none;list-style-type: none;"><a href="/academy/?did='.$d->id.'" title="'.$d->title.'" class="downloadLink download'.$d->id.'">
								<img src="http://www.dynamics101.com/images/sidebar/i_whitepaper.png" style="padding-right:7px;" align="left" alt="'.$d->title.'" />
								<p>'.neat_trim($d->title,$char_count).'</p>
								</a></li>';
							}
							$buff .= "</ul></li>";
						}

						// case studies
						if (!empty($dl_casestudy)) {
							foreach($dl_casestudy as $d) { 
								$buff .= '<li><a href="/academy/?did='.$d->id.'" title="'.$d->title.'" class="downloadLink download'.$d->id.'">
								<img src="'.$d->thumbnail.'" align="left" alt="'.$d->title.'" />
								<h5>'.neat_trim($d->title,$char_count).'</h5>
								</a></li>';
							}
							$buff .= "</ul></li>";
						}

						// Brochure
						if (!empty($dl_brochure)) {
							foreach($dl_brochure as $d) { 
								$buff .= '<li><a href="/academy/?did='.$d->id.'" title="'.$d->title.'" class="downloadLink download'.$d->id.'">
								<img src="'.$d->thumbnail.'" align="left" alt="'.$d->title.'" />
								<h5>'.neat_trim($d->title,$char_count).'</h5>
								</a></li>';
							}
							$buff .= "</ul></li>";
						}

					$buff .= '</ul>';
					$buff .= $widget_bottom.$after_widget_rg.$after_widget;
					
					// collect buffer
					echo $buff;
			
					}
				
				}
			}
		 
			/** @see WP_Widget::update -- do not rename this */
			function update($new_instance, $old_instance) {
				$instance = $old_instance;
				$instance['title'] = strip_tags($new_instance['title']);
				$instance['number'] = strip_tags($new_instance['number']);
				$instance['taxonomy'] = $new_instance['taxonomy'];
				return $instance;
			}
		 
			/** @see WP_Widget::form -- do not rename this */
			function form($instance) {
		 
				$title 		= esc_attr($instance['title']);
				$number		= esc_attr($instance['number']);
				$exclude	= esc_attr($instance['exclude']);
				$taxonomy	= esc_attr($instance['taxonomy']);
				?>
				 <p>
				  <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:'); ?></label>
				  <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" />
				</p>
				<p>
				  <label for="<?php echo $this->get_field_id('number'); ?>"><?php _e('Number of downloads to display'); ?></label>
				  <input class="widefat" id="<?php echo $this->get_field_id('number'); ?>" name="<?php echo $this->get_field_name('number'); ?>" type="text" value="<?php echo $number; ?>" />
				</p>
				<?php
			}
		 
		 
		} // end class list_categories_widget
		add_action('widgets_init', create_function('', 'return register_widget("list_downloads_widget");'));		
	
?>