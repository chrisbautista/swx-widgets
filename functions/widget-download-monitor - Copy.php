<?php 

// ########################################################################
// Dynamically pull resources via Download Monitor plugin based on tags 
// (which are set within Download Monitor) that match the slug (permalink) 
// of the page the visitor is on. 
// ########################################################################
// config
// basename returns the trailing section of the url
// eg: /solutions/gp/training/ it will return "training"


// wait until all plugins are loaded before loading this
function init_my_plugin()
{
	// do init stuff
	if (!function_exists('get_downloads')) { 
		return;
		
	} else { 

	
		/* ############################################# */
		//  Determine site, customize functions based on site
		/* ############################################# */
		
		/*
		$blogurl = get_bloginfo( 'url', 'raw' );
		$blogurl_d101 = 'http://www.dynamics101.com';
		$blogurl_rg = 'http://www.randgroup.com';
		*/
		

		
	
		/* [list_downloads] */
		function list_downloads($atts, $content = null) {  
			extract(shortcode_atts(array(  
				"tag" => 'all'
			), $atts));  
			

			$catname = basename(get_permalink());
			
			// match url to catid array
			
			$cat_list = array (  
			
				 "25" => "oil-gas", 


				 
			); 
			
			// look for trailing folder first, then look for parent folders
			$catid = array_search($catname, $cat_list);
			// if not found, look at each folder in url for a match			
			if(empty($catid)) { 
				// explode url into array					
				$url= get_permalink();
				$parsed_url=parse_url($url);
				$sub_folder = explode('/',$parsed_url['path']);
				$domain=$parsed_url['scheme'].'://'.$parsed_url['host'];
				$folder="";
				$max=count($sub_folder);
				// check each sub folder
				for ($i=0;$i<$max;$i++)
				{
				  // once we find a match, don't overwrite it
				  if(empty($temp_catid)) {
					$sub_folder_to_search = $sub_folder[$i];
					$temp_catid = array_search($sub_folder_to_search, $cat_list);
					//echo "no".$sub_folder[$i].": ".$temp_catid."<br/>";
				  } else {
					$catid = $temp_catid;
					//echo "yes".$sub_folder[$i].": ".$temp_catid."<br/>";
				  }
				}				
			}
			
			
			// debug 
			// echo $catname;
			// echo $catid;
			// $catid = 25;
			// don't forget, [list_downloads] required on page
			// only assets that match tags will show up
			
			if(!is_null($catid)) { 

				$orderby = 'date';
				$qty = 4;
				$char_count = 105;
				$char_count_video = 40;
				$path = get_bloginfo('template_directory');
				$title = get_the_title().' ';
					
				$dl = get_downloads('limit='.$qty.'&category='.$catid.'&tags=demo,case study,whitepaper,brochure&order=desc&orderby='.$orderby);
				if (!empty($dl)) {
				 
					// build and process (ASC or desc)
					$dl_demo = get_downloads('limit='.$qty.'&category='.$catid.'&tags=demo&order=desc&orderby='.$orderby);
					$dl_whitepaper = get_downloads('limit='.$qty.'&category='.$catid.'&tags=whitepaper&order=desc&orderby='.$orderby);
					$dl_casestudy = get_downloads('limit='.$qty.'&category='.$catid.'&tags=case study&order=desc&orderby='.$orderby);
					$dl_brochure = get_downloads('limit='.$qty.'&category='.$catid.'&tags=brochure&order=desc&orderby='.$orderby);
					
					// check if all 4 have results, adjust span size accordingly
					
					// output
					$buff = '<div class="download_list"><!-- Related Resources -->
    <div class="section-colored">
        <div class="container">
        	<div class="row">
	        	<div class="col-lg-12 col-md-12 col-sm-12">
		    		<div class="col-sm-9">
		        		<h3>Related Resources</h3>
					</div>
					<div class="col-sm-3">
		        		<h4>See All Resources <span class="glyphicon glyphicon-play"></span></h4>
					</div>
	        	</div>
        	</div>';
			
					// check if individual categories contain resources, if so show subnav
					$i = 0;
					// demos
					if (!empty($dl_demo)) {						
						$buff .= '<div class="row">';
						$buff .= '<h4>'.$title.'Demos</h4>';
						foreach($dl_demo as $d) { 
							$i++;
							//if this is first value in row, create new row
							if($i % 3 == 1) {
								$buff .= '<div class="col-lg-12 col-md-12 col-sm-12">';
							}
							$buff .= '<div class="row" class="downloadLink downloadVideo download'.$d->id.'"><div class="col-lg-12 col-md-12 col-sm-12">
								<ul class="related-items">
									<li><img <img src="'.$d->thumbnail.'" align="left" alt="'.$d->title.'" /></li>
									<li>
										<h4><a href="/ca/resources/?did='.$d->id.'" title="'.$d->title.'">'.neat_trim($d->title,$char_count_video).' <span class="glyphicon glyphicon-play"></span></a></h4>
									</li>	                		
								</ul>';
							//if this is third value in row, end row
							if($i % 3 == 0) {
								$buff .= '</div>';
							}
							// $buff .= $i;
						}
						//if the counter is not divisible by 3, we have an open row
						$spacercells = 3 - ($i % 3);
						if ($spacercells < 3) {							
							$buff .= "</div>";
						}
						
						$buff .= '</div>';
						
					}
					$i = 0;
					
	/* $buff .= '<!-- Related Resources -->


        	<div class="row">
	        	<div class="col-lg-12 col-md-12 col-sm-12">
				
				
	        		<!-- Resource 1 -->
		        	<div class="col-lg-3 col-md-3 col-sm-3">
					
			        	<ul class="related-items">
		                	<li><img src="http://placehold.it/300x200/cccccc/ffffff/"></li>
							<li>
								<h4>'.$title.' <span class="glyphicon glyphicon-play"></span></h4>
								<p>'.$excerpt.'<br><br><a href="'.$permalink.'">View Resource</a></p>
							</li>	                		
	                	</ul>	
						
		        	</div>	
		        	
					
					
					
        		</div>	        		        		        	
        	</div>	

	<!-- /Related Resources -->	';	*/			
					
					
					
					
					
					// white papers					
					if (!empty($dl_whitepaper)) {						
						$buff .= '<div class="row">';
						$buff .= '<h4>'.$title.'Whitepapers</h4>';
						foreach($dl_whitepaper as $d) { 
							$i++;
							//if this is first value in row, create new row
							if($i % 3 == 1) {
								$buff .= '<div class="col-lg-12 col-md-12 col-sm-12">';
							}
							$buff .= '<div class="row" class="downloadLink download'.$d->id.'"><div class="col-lg-12 col-md-12 col-sm-12">
								<ul class="related-items">
									<li><img <img src="'.$d->thumbnail.'" align="left" alt="'.$d->title.'" /></li>
									<li>
										<h4><a href="/ca/resources/?did='.$d->id.'" title="'.$d->title.'">'.neat_trim($d->title,$char_count).' <span class="glyphicon glyphicon-play"></span></a></h4>
									</li>	                		
								</ul>';
							//if this is third value in row, end row
							if($i % 3 == 0) {
								$buff .= '</div>';
							}
							// $buff .= $i;
						}
						//if the counter is not divisible by 3, we have an open row
						$spacercells = 3 - ($i % 3);
						if ($spacercells < 3) {							
							$buff .= "</div>";
						}
						
						$buff .= '</div>';
						
					}
					$i = 0;					
					
					// case studies
					if (!empty($dl_casestudy)) {						
						$buff .= '<div class="row">';
						$buff .= '<h4>'.$title.'Case Studies</h4>';
						foreach($dl_casestudy as $d) { 
							$i++;
							//if this is first value in row, create new row
							if($i % 3 == 1) {
								$buff .= '<div class="col-lg-12 col-md-12 col-sm-12">';
							}
							$buff .= '<div class="row" class="downloadLink download'.$d->id.'"><div class="col-lg-12 col-md-12 col-sm-12">
								<ul class="related-items">
									<li><img <img src="'.$d->thumbnail.'" align="left" alt="'.$d->title.'" /></li>
									<li>
										<h4><a href="/ca/resources/?did='.$d->id.'" title="'.$d->title.'">'.neat_trim($d->title,$char_count).' <span class="glyphicon glyphicon-play"></span></a></h4>
									</li>	                		
								</ul>';
							//if this is third value in row, end row
							if($i % 3 == 0) {
								$buff .= '</div>';
							}
							// $buff .= $i;
						}
						//if the counter is not divisible by 3, we have an open row
						$spacercells = 3 - ($i % 3);
						if ($spacercells < 3) {							
							$buff .= "</div>";
						}
						
						$buff .= '</div>';
						
					}
					$i = 0;		
					
					// Brochure
					if (!empty($dl_brochure)) {						
						$buff .= '<div class="row">';
						$buff .= '<h4>'.$title.'Brochures</h4>';
						foreach($dl_brochure as $d) { 
							$i++;
							//if this is first value in row, create new row
							if($i % 3 == 1) {
								$buff .= '<div class="col-lg-12 col-md-12 col-sm-12">';
							}
							$buff .= '<div class="row" class="downloadLink download'.$d->id.'"><div class="col-lg-12 col-md-12 col-sm-12">
								<ul class="related-items">
									<li><img <img src="'.$d->thumbnail.'" align="left" alt="'.$d->title.'" /></li>
									<li>
										<h4><a href="/ca/resources/?did='.$d->id.'" title="'.$d->title.'">'.neat_trim($d->title,$char_count).' <span class="glyphicon glyphicon-play"></span></a></h4>
									</li>	                		
								</ul>';
							//if this is third value in row, end row
							if($i % 3 == 0) {
								$buff .= '</div>';
							}
							// $buff .= $i;
						}
						//if the counter is not divisible by 3, we have an open row
						$spacercells = 3 - ($i % 3);
						if ($spacercells < 3) {							
							$buff .= "</div>";
						}
						
						$buff .= '</div>';
						
					}
					$i = 0;		
					
					
				$buff .= '        </div>
    </div>
<!-- /Related Resources -->	';

				// collect buffer
				return $buff;
				} 
			}
		}
		add_shortcode("list_downloads", "list_downloads");  

		/* [list_download] for individual downloads */
		function list_download($atts, $content = null) {  
			extract(shortcode_atts(array(  
				"id" => null,
				"headline" => null,
				"verb" => 'Download',
				"style"=> 'default',
				"tag" => 'all'
			), $atts)); 	
			
			$char_count = 135;
			$format_url = 7;
			$format_image = 6;
			$format_title = 8;
			$format_description = 10;
			$format_count = 9;
			$path = get_bloginfo('template_directory');

			if($style == 'default') {
			
				$buff .= '<div class="row-fluid download_cta">';
				$buff .= '	<div class="span2">';
				$buff .= '		<a href="'.do_shortcode('[download id="'.$id.'" format="'.$format_url.'"]').'" class="downloadLink">'.do_shortcode('[download id="'.$id.'" format="'.$format_image.'"]').'</a>';
				$buff .= '	</div>';
				$buff .= '	<div class="span10">';
				$buff .= '		<h3>'.$headline.'</h3>';
				// $buff .= '		<h5>'.do_shortcode('[download id="'.$id.'" format="'.$format_title.'"]').'</h5>';
				$buff .= '		<p class="description">'.neat_trim_code(do_shortcode('[download id="'.$id.'" format="'.$format_description.'"]'),$char_count).'</p>';
				//$buff .= '		<p class="description">'.do_shortcode('[download id="'.$id.'" format="'.$format_description.'"]').'</p>';
				// $buff .= '		<p class="meta">'.do_shortcode('[download id="'.$id.'" format="'.$format_count.'"]').'</p>';
				$buff .= '		<a href="'.do_shortcode('[download id="'.$id.'" format="'.$format_url.'"]').'" class="btn">'.$verb.' "'.do_shortcode('[download id="'.$id.'" format="'.$format_title.'"]').'"</a>';
				
				
				$buff .= '	</div>';
				$buff .= '</div>';
			}
				
			
			return $buff;
			
		}
		add_shortcode("list_download", "list_download");  

		
	}
}
add_action('plugins_loaded','init_my_plugin');


/* 

widget code 


		// output
				$buff = '<div class="widget"><div class="wrap">';
				$buff .= '<h4><span>Related Resources</span></h4>';
				$buff .= '<div class="textwidget">';
				$buff .= '<ul class="dlm_download_list">';
				// check if individual categories contain resources, if so show subnav
				// white papers
				$dl = get_downloads('limit='.$qty.'&category=3&tags='.$tag.'&order=ASC&orderby='.$orderby);
				if (!empty($dl)) {
					$buff .= '<li><h5>Whitepapers</h5>';
					$buff .= '<ul>';
					foreach($dl as $d) { 
						$buff .= '<h5><a href="/resources/?did='.$d->id.'" title="'.$d->title.'" class="downloadLink download'.$d->id.'"><img src="'.$d->thumbnail.'" alt="'.$d->title.'" />'.$d->title.'</a></h5>';
						}
					$buff .= '</ul></li>';
				}
				// case studies
				$dl = get_downloads('limit='.$qty.'&category=2&tags=case study&order=ASC&orderby='.$orderby);
				if (!empty($dl)) {
					$buff .= '<li><h5>Case Studies</h5>';
					$buff .= '<ul>';
					foreach($dl as $d) {
						$path = get_bloginfo('template_directory');
						$buff .= '<h5><a href="/resources/?did='.$d->id.'" title="'.$d->title.'" class="downloadLink download'.$d->id.'"><img src="'.$d->thumbnail.'" alt="'.$d->title.'" />'.$d->title.'</a></h5>';
						}
					$buff .= '</ul></li>';
				}
				// Brochure
				$dl = get_downloads('limit='.$qty.'&category=4&tags=brochure&order=ASC&orderby='.$orderby);
				if (!empty($dl)) {
					$buff .= '<li><h5>Brochures</h5>';
					$buff .= '<ul>';
					foreach($dl as $d) {
						$path = get_bloginfo('template_directory');
						$buff .= '<h5><a href="/resources/?did='.$d->id.'" title="'.$d->title.'" class="downloadLink download'.$d->id.'"><img src="'.$d->thumbnail.'" alt="'.$d->title.'" />'.$d->title.'</a></h5>';
						}
					$buff .= '</ul></li>';
				}
				// demos
				$dl = get_downloads('limit='.$qty.'&category=5&tags=demo&order=ASC&orderby='.$orderby);
				if (!empty($dl)) {
					$buff .= '<li><h5>Demos</h5>';
					$buff .= '<ul>';
					foreach($dl as $d) {
						$path = get_bloginfo('template_directory');
						$buff .= '<h5><a href="/resources/?did='.$d->id.'" title="'.$d->title.'" class="downloadLink download'.$d->id.'"><img src="'.$d->thumbnail.'" alt="'.$d->title.'" />'.$d->title.'</a></h5>';
						}
					$buff .= '</ul></li>';
				}

			$buff .= '<br class="clear" />';
			$buff .= '</ul>';        
			$buff .= '</div>';
			$buff .= '</div></div><!--widget-->';   
			
*/

/*-----------------------------------------------------------------------------------*/
/*	 WP Download Monitor Hacks
/*   http://wordpress.org/support/topic/seo-titles-for-download-monitor-file-and-category-pages
/*   Usage: Title rewrite
/*-----------------------------------------------------------------------------------*/


// SEO titles for Download Monitor pages
function dm_seo_title_tag($title) {
	// Set the separator for our title tag
	global $sep;
	if ( !isset( $sep ) || empty( $sep ) )
		$sep = '-';
	// SEO titles for Download Monitor single file pages
	// Check that the "did" (download ID) variable is set, valid, and that the get_downloads function exists
	if (isset($_GET['did']) && is_numeric($_GET['did']) && $_GET['did']>0 && function_exists(get_downloads)) {
		$did = $_GET['did'];
		// Grab the file info and, if non-empty, adjust the title tag accordingly
		$dl = get_downloads('limit=1&include='.$did);
		if (!empty($dl)) {
			foreach($dl as $d) {
				$title = $d->title.' '.$sep.' '.$title;
			}
		}
	}
	// SEO titles for Download Monitor category pages
	elseif (isset($_GET['category'])) {
		$catID = $_GET['category'];
		// First need to get category name using $catID
		global $wpdb, $wp_dlm_db_taxonomies;
		if (isset($wp_dlm_db_taxonomies)) {
			$cat = $wpdb->get_var( "SELECT name FROM $wp_dlm_db_taxonomies WHERE id = $catID;" );
			// Find out if we're on a paginated page (but not page 1), and if so, set the variable
			if (isset($_GET['dlpage']) && is_numeric($_GET['dlpage']) && $_GET['dlpage'] != 1) $dlpage = $_GET['dlpage'];
			// Then we can tack the category name and, if set, the pagination page, onto the title
			$oldTitle = $title;
			$title = $cat;
			if ($dlpage) $title .= ' (Page '.$dlpage.') ';
			$title .= ' '.$sep.' '.$oldTitle;
		}
	}
	return $title;
}

// We give this a low priority so that it springs into action after any other SEO plugins have played with the title tag
add_filter('wp_title', 'dm_seo_title_tag', 100);

?>