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
				"style" => 'default',
				"limit" => 4,
				"tag" => 'all'
			), $atts));

			/* Get Custom Site Options */
			$site_options = _s_get_theme_options();


			$catname = basename(get_permalink());

			// match url to catid array
			// echo "Test";
			// print_r($site_options);
			// echo $site_options['resource_mapping'];
			// use options panel
			if(empty($site_options['resource_mapping'])) {
				$cat_list = array (
					 "25" => "oil-gas",

					 /*
					"25" => "oil-gas",
					"4" => "dynamics-ax",
					*/
				);
			} else {
				$str = $site_options['resource_mapping'];
				// echo 'DEBUG1';
				// echo '<pre>'; print_r($str); echo '</pre>';
				// $cat_list = array( "0" => "test" );
				$rows = explode("\n", $str);
				foreach($rows as $row) {
					$data = array_filter(explode(',', $row));
					// echo 'DATA<BR/>';
					// echo $data[0].' => '.$data[1];
					$cat_list[$data[0]] = rtrim($data[1]);
					// $cat_list['1'] = 'a';
					//array_push ($cat_list,$data[0],$data[1]);
					//$array1 .= $data[0].' => '.$data[1];
				}
				//$cat_list = array ($array1);
				// echo 'DEBUG2<BR/>';
				// echo '<pre>'; print_r($cat_list); echo '</pre>';
				// echo 'DEBUG3<BR/>';
				// print_r($cat_list);
				// echo $cat_list;



			}


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
					// echo "no".$sub_folder[$i].": ".$temp_catid."<br/>";
				  } else {
					$catid = $temp_catid;
					// echo "yes".$sub_folder[$i].": ".$temp_catid."<br/>";
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
				$char_title = 37;
				$char_count_video = 40;
				$char_count_desc = 140;
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
						$buff = '</div>
								<div class="download_list">
								<!-- /Related Resources -->
								<div class="row">
									<div class="dark-gray">
										<div class="container">


												<div class="col-lg-9 col-md-9 col-sm-9 no-padding">
													<h3>Related Resources</h3>
												</div>
												<div class="col-sm-3">
													<a href="'.get_site_url().'/resources/"><h4>See All Resources <span class="glyphicon glyphicon-play"></span></h4></a>
												</div>

										</div>';

						// check if individual categories contain resources, if so show subnav
						$i = 0;
						// demos
						if (!empty($dl_demo)) {
							$buff .= '<div class="container">';
							$buff .= '<h4>'.$title.'Demos</h4>';
							$buff .= '<div class="col-lg-12 col-md-12 col-sm-12 no-padding">';
							foreach($dl_demo as $d) {
									$i++;

								$buff .= '<div class="col-lg-3 col-md-3 col-sm-6">
									<ul class="list-unstyled related-items">
										<li><img src="'.get_site_url().'/wp-content/plugins/timthumb/timthumb.php?src='.$d->thumbnail.'&w=300&h=200&a=t" class="img-responsive" align="left" alt="'.$d->title.'" /></li>
										<li>
											<a href="/ca/resources/?did='.$d->id.'" title="'.$d->title.'" class="bigTarget"><h4>'.neat_trim($d->title,$char_title).' <span class="glyphicon glyphicon-play"></span></h4></a>
										</li>
									</ul>
								</div>';

							}

							$buff .= '</div></div>';

						}


						// white papers
						if (!empty($dl_whitepaper)) {
							$buff .= '<div class="container">';
							$buff .= '<h4>'.$title.'Whitepapers</h4>';
							$buff .= '<div class="col-lg-12 col-md-12 col-sm-12 no-padding">';
							foreach($dl_whitepaper as $d) {
								$i++;

								$buff .= '<div class="col-lg-3 col-md-3 col-sm-6">
									<ul class="list-unstyled related-items">
										<li><img src="'.get_site_url().'/wp-content/plugins/timthumb/timthumb.php?src='.$d->thumbnail.'&w=300&h=200&a=t" class="img-responsive" align="left" alt="'.$d->title.'" /></li>
										<li>
											<a href="/ca/resources/?did='.$d->id.'" title="'.$d->title.'" class="bigTarget"><h4 class="rel_title">'.neat_trim($d->title,$char_title).' <span class="glyphicon glyphicon-play"></span></h4></a>
										</li>
									</ul>
								</div>';

							}

							$buff .= '</div></div>';

						}

						// case studies
						if (!empty($dl_casestudy)) {
							$buff .= '<div class="container">';
							$buff .= '<h4>'.$title.'Case Studies</h4>';
							$buff .= '<div class="col-lg-12 col-md-12 col-sm-12 no-padding">';
							foreach($dl_casestudy as $d) {
								$i++;

								$buff .= '<div class="col-lg-3 col-md-3 col-sm-6">
									<ul class="list-unstyled related-items">
										<li><img src="'.get_site_url().'/wp-content/plugins/timthumb/timthumb.php?src='.$d->thumbnail.'&w=300&h=200&a=t" class="img-responsive" align="left" alt="'.$d->title.'" /></li>
										<li>
											<a href="/ca/resources/?did='.$d->id.'" title="'.$d->title.'" class="bigTarget"><h4 class="rel_title">'.neat_trim($d->title,$char_title).' <span class="glyphicon glyphicon-play"></span></h4></a>
										</li>
									</ul>
								</div>';

							}

							$buff .= '</div></div>';

						}


						// Brochure
						if (!empty($dl_brochure)) {
							$buff .= '<div class="container">';
							$buff .= '<h4>'.$title.'Brochures</h4>';
							$buff .= '<div class="col-lg-12 col-md-12 col-sm-12 no-padding">';
							foreach($dl_brochure as $d) {
									$i++;

								$buff .= '<div class="col-lg-3 col-md-3 col-sm-6">
									<ul class="list-unstyled related-items">
										<li><img src="'.get_site_url().'/wp-content/plugins/timthumb/timthumb.php?src='.$d->thumbnail.'&w=300&h=200&a=t" class="img-responsive" align="left" alt="'.$d->title.'" /></li>
										<li>
											<a href="/ca/resources/?did='.$d->id.'" title="'.$d->title.'" class="bigTarget"><h4 class="rel_title">'.neat_trim($d->title,$char_title).' <span class="glyphicon glyphicon-play"></span></h4></a>
										</li>
									</ul>
								</div>';

							}

							$buff .= '</div></div>';

						}
						$i = 0;


					$buff .= '        </div>
				</div>
			</div>
		</div>
	<!-- /Related Resources -->';

					// collect buffer

					}


			} // end if cat

			if($style == 'inline') {


						$orderby = 'date';
						$char_count = 105;
						$char_title = 37;
						$char_count_video = 40;
						$char_count_desc = 140;
						$path = get_bloginfo('template_directory');
						$title = get_the_title().' ';
						if($limit != 0) { 
							$limit_code = '&limit='.$limit; 
						} else {
							$limit_code = '&limit=99999'; 
						}



						// build and process (ASC or desc)
						if($tag != 'all') { 
							$dl_all = get_downloads('order=desc&orderby=date&tags='.$tag.$limit_code); 
						} else {
							$dl_all = get_downloads('order=desc&orderby=date'.$limit_code);
						}
						// check if all 4 have results, adjust span size accordingly

						// output
						$buff = '


						</div>
								<div class="download_list">
								<!-- /Related Resources -->
								<div class="row">
									<div class="dark-gray">
										<div class="container">


										</div>';

						// demos
						if (!empty($dl_all)) {
							$buff .= '<div class="container">';
							$buff .= '<div class="col-lg-12 col-md-12 col-sm-12 no-padding">';
							foreach($dl_all as $d) {


								$buff .= '<div class="col-lg-3 col-md-3 col-sm-3">
									<ul class="list-unstyled related-items">
										<li><img src="'.get_site_url().'/wp-content/plugins/timthumb/timthumb.php?src='.$d->thumbnail.'&w=300&h=200&a=t" class="img-responsive" align="left" alt="'.$d->title.'" /></li>
										<li>
											<a href="/ca/resources/?did='.$d->id.'" title="'.$d->title.'" class="bigTarget"><h4 class="rel_title">'.neat_trim($d->title,$char_title).' <span class="glyphicon glyphicon-play"></span></h4></a>
										</li>
									</ul>
								</div>';

							}

							$buff .= '</div></div>';

						}


					$buff .= '        </div>
				</div>
			</div>
		</div>
	<!-- /Related Resources -->';



				} // end style

			
			return $buff;

		} // end shortcode
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

			//Match format variable numbers to ID numbers in WordPress > Downloads > Configuration > Custom Output Formats
			$char_count = 135;
			$format_url = 6;
			$format_image = 5;
			$format_title = 7;
			$format_description = 9;
			$format_count = 8;
			$path = get_bloginfo('template_directory');

			if($style == 'default') {

				$buff .= '</div>';
				$buff .= '<div class="row light-gray">';
				$buff .= '<div class="container">';
				$buff .= '	<div class="col-lg-12 col-md-12 col-sm-12 no-padding bigTargetBox">';
				$buff .= '		<div class="col-lg-8 col-md-8 col-sm-8 cta-desc">';
				$buff .= '			<h3>'.$headline.'</h3>';
				$buff .= '			<p class="description">'.neat_trim_code(do_shortcode('[download id="'.$id.'" format="'.$format_description.'"]'),$char_count,$delim="").'</p><a  class="btn btn-cta bigTarget" href="'.do_shortcode('[download id="'.$id.'" format="'.$format_url.'"]').'">'.$verb.' "'.do_shortcode('[download id="'.$id.'" format="'.$format_title.'"]"').'</a>';
				$buff .= '		</div>';
				$buff .= '		<div class="col-lg-4 col-md-4 col-sm-4 cta-resource">';
				$buff .= '			<a href="'.do_shortcode('[download id="'.$id.'" format="'.$format_url.'"]').'" class="img-responsive">'.do_shortcode('[download id="'.$id.'" format="'.$format_image.'"]').'</a>';
				$buff .= '		</div>';
				$buff .= '	</div>';
				$buff .= '</div>';
				$buff .= '</div>';
				$buff .= '<div class="container section">';

/* 				$buff .= '<div class="row-fluid download_cta">';
				$buff .= '	<div class="span2">';
				$buff .= '		<a href="'.do_shortcode('[download id="'.$id.'" format="'.$format_url.'"]').'" class="downloadLink">'.do_shortcode('[download id="'.$id.'" format="'.$format_image.'"]').'</a>';
				$buff .= '	</div>';
				$buff .= '	<div class="span10">';
				$buff .= '		<h3>'.$headline.'</h3>';
				// $buff .= '		<h5>'.do_shortcode('[download id="'.$id.'" format="'.$format_title.'"]').'</h5>';
				$buff .= '		<p class="description">'.neat_trim_code(do_shortcode('[download id="'.$id.'" format="'.$format_description.'"]'),$char_count).'</p>';
				// $buff .= '		<p class="description">'.do_shortcode('[download id="'.$id.'" format="'.$format_description.'"]').'</p>';
				// $buff .= '		<p class="meta">'.do_shortcode('[download id="'.$id.'" format="'.$format_count.'"]').'</p>';
				$buff .= '		<a href="'.do_shortcode('[download id="'.$id.'" format="'.$format_url.'"]').'" class="btn">'.$verb.' "'.do_shortcode('[download id="'.$id.'" format="'.$format_title.'"]').'"</a>';


				$buff .= '	</div>';
				$buff .= '</div>'; */
			}
			elseif($style == 'image-left'){

				$buff .= '</div>';
				$buff .= '<div class="row light-gray">';
				$buff .= '<div class="container">';
				$buff .= '	<div class="col-lg-12 col-md-12 col-sm-12 no-padding bigTargetBox">';
				$buff .= '		<div class="col-lg-8 col-md-8 col-sm-8 cta-desc pull-right">';
				$buff .= '			<h3>'.$headline.'</h3>';
				$buff .= '			<p class="description">'.neat_trim_code(do_shortcode('[download id="'.$id.'" format="'.$format_description.'"]'),$char_count,$delim="").'</p><a class="btn btn-cta bigTarget" href="'.do_shortcode('[download id="'.$id.'" format="'.$format_url.'"]').'">'.$verb.' "'.do_shortcode('[download id="'.$id.'" format="'.$format_title.'"]"').'</a>';
				$buff .= '		</div>';
				$buff .= '		<div class="col-lg-4 col-md-4 col-sm-4 cta-resource pull-left">';
				$buff .= '			<a href="'.do_shortcode('[download id="'.$id.'" format="'.$format_url.'"]').'" class="img-responsive">'.do_shortcode('[download id="'.$id.'" format="'.$format_image.'"]').'</a>';
				$buff .= '		</div>';
				$buff .= '	</div>';
				$buff .= '</div>';
				$buff .= '</div>';
				$buff .= '<div class="container section">';
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