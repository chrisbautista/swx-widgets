<?php
if(!is_post_type_defined('dlm_download')) die();
class CLASS_DLM_Post_Type_Manager {

	/**
	 * Setup hooks
	 */
	public function setup() {
		add_action('init', array($this, 'register'), 11);
		//var_log('API');
		add_action('rest_api_init', array($this, 'register_api_custom_fields'));

		add_action('add_meta_boxes', array($this, 'add_custom_metabox'), 1000);

		add_action('admin_init', array(&$this, 'admin_init'));

		add_action('edit_form_after_title', array(&$this, 'edit_form_after_title_manager'));

		//add_action('admin_print_footer_scripts', array($this, 'my_publish_admin_hook'), 1000);

		//add_action('wp_ajax_my_pre_submit_validation', array($this, 'pre_submit_validation'));

	}

	function edit_form_after_title_manager($post) {
		//global $post;
		//
		$url = "";
		$postmeta = get_post_meta($post->ID);
		$postterm = wp_get_post_terms($post->ID, 'dlm_download_category');
		//var_log($post);
		//var_log($postmeta);
		//var_log($postterm);
		if (isset($postterm[0]->slug)) {
			$url = home_url() . "/" . $postterm[0]->slug . "/" . $post->post_name . "/";
			echo "<span style=\"display: inline-block;padding: 7px 12px 4px 12px;box-sizing: border-box;position: relative;left: 0;top: 0px;background: #DFDFDF;\">$url</span>";
			echo "<a href=\"$url\" class=\"button add_file\" target=\"_blank\">Preview Landing Page</a>";

		}
	}

	function add_custom_metabox() {
		// remove
		//
		remove_meta_box('postexcerpt', 'dlm_download', 'normal');
		remove_meta_box('download-monitor-options', 'dlm_download', 'side');
		// Download Options
		add_meta_box('download-monitor-options', __('Download Options', 'download-monitor'), array(
			$this,
			'download_options',
		), 'dlm_download', 'side', 'high');
	}

	function unregister_post_type($post_type) {
		global $wp_post_types;
		if (isset($wp_post_types[$post_type])) {
			unset($wp_post_types[$post_type]);
			return true;
		}
		return false;
	}

	/**
	 * Register Post Types
	 */
	public function register() {
		global $wp_post_types;
		//var_log($wp_post_types['dlm_download']);
		$this->unregister_post_type('dlm_download');
		//var_log($wp_post_types['dlm_download']);
		// Register Download Post Type
		register_post_type("dlm_download",
			apply_filters('dlm_cpt_dlm_download_args',
				array(
					'labels' => array(
						'all_items' => __('All Downloads', 'download-monitor'),
						'name' => __('Downloads', 'download-monitor'),
						'singular_name' => __('Download', 'download-monitor'),
						'add_new' => __('Add New', 'download-monitor'),
						'add_new_item' => __('Add Download', 'download-monitor'),
						'edit' => __('Edit', 'download-monitor'),
						'edit_item' => __('Edit Download', 'download-monitor'),
						'new_item' => __('New Download', 'download-monitor'),
						'view' => __('View Download', 'download-monitor'),
						'view_item' => __('View Download', 'download-monitor'),
						'search_items' => __('Search Downloads', 'download-monitor'),
						'not_found' => __('No Downloads found', 'download-monitor'),
						'not_found_in_trash' => __('No Downloads found in trash', 'download-monitor'),
						'parent' => __('Parent Download', 'download-monitor'),
					),
					'description' => __('This is where you can create and manage downloads for your site.', 'download-monitor'),
					'public' => false,
					'show_ui' => true,
					'show_in_rest' => true,
					'capability_type' => 'post',
					'capabilities' => array(
						'publish_posts' => 'manage_downloads',
						'edit_posts' => 'manage_downloads',
						'edit_others_posts' => 'manage_downloads',
						'delete_posts' => 'manage_downloads',
						'delete_others_posts' => 'manage_downloads',
						'read_private_posts' => 'manage_downloads',
						'edit_post' => 'manage_downloads',
						'delete_post' => 'manage_downloads',
						'read_post' => 'manage_downloads',
					),
					'publicly_queryable' => false,
					'exclude_from_search' => true,
					'hierarchical' => false,
					'rewrite' => false,
					'query_var' => false,
					'supports' => apply_filters('dlm_cpt_dlm_download_supports', array(
						'title',
						'editor',
						'excerpt',
						'thumbnail',
						/*'custom-fields',*/
					)),
					'has_archive' => false,
					'show_in_nav_menus' => false,
				)
			)
		);

	} // add post type

	function register_api_custom_fields() {
		//var_log('REGISTER');
		register_api_field('dlm_download',
			'_logo',
			array(
				'get_callback' => array($this, 'get_logo'),
				'update_callback' => null,
				'schema' => null,
			)
		);
	} // register custom fields

	/**
	 * Get the value of the "starship" field
	 *
	 * @param array $object Details of current post.
	 * @param string $field_name Name of field.
	 * @param WP_REST_Request $request Current request
	 *
	 * @return mixed
	 */
	function get_logo($object, $field_name, $request) {

		$image_upload = get_attached_media('featured_image', $object['id']);
		//var_log($image_upload);

		//return end($image_upload);

		//return get_attachment_image_src();
		return wp_get_attachment_image(get_post_meta($object['id'], 'featured_image', true), "full");
	}

	/**
	 * download_options function.
	 *
	 * @access public
	 *
	 * @param WP_Post $post
	 *
	 * @return void
	 */
	public function download_options($post) {
		global $post, $thepostid;

		$thepostid = $post->ID;

		echo '<div class="dlm_options_panel">';

		do_action('dlm_options_start', $thepostid);

		echo '<p class="form-field form-field-checkbox">
			<input type="checkbox" name="_featured" id="_featured" ' . checked(get_post_meta($thepostid, '_featured', true), 'yes', false) . ' />
			<label for="_featured">' . __('Featured download', 'download-monitor') . '</label>
			<span class="dlm-description">' . __('Mark this download as featured. Used by shortcodes and widgets.', 'download-monitor') . '</span>
		</p>';

		if (empty($post->post_title)) {

			echo '<p class="form-field form-field-checkbox">
			<input type="checkbox" name="_members_only" id="_members_only" checked="checked" />
			<label for="_members_only">' . __('Members only', 'download-monitor') . '</label>
			<span class="dlm-description">' . __('Only logged in users will be able to access the file via a download link if this is enabled.', 'download-monitor') . '</span>
		</p>';

			echo '<p class="form-field form-field-checkbox">
			<input type="checkbox" name="_redirect_only" id="_redirect_only" checked="checked" />
			<label for="_redirect_only">' . __('Redirect to file', 'download-monitor') . '</label>
			<span class="dlm-description">' . __('Don\'t force download. If the <code>dlm_uploads</code> folder is protected you may need to move your file.', 'download-monitor') . '</span>
		</p>';

		} else {

			echo '<p class="form-field form-field-checkbox">
			<input type="checkbox" name="_members_only" id="_members_only" ' . checked(get_post_meta($thepostid, '_members_only', true), 'yes', false) . ' />
			<label for="_members_only">' . __('Members only', 'download-monitor') . '</label>
			<span class="dlm-description">' . __('Only logged in users will be able to access the file via a download link if this is enabled.', 'download-monitor') . '</span>
		</p>';

			echo '<p class="form-field form-field-checkbox">
			<input type="checkbox" name="_redirect_only" id="_redirect_only" ' . checked(get_post_meta($thepostid, '_redirect_only', true), 'yes', false) . ' />
			<label for="_redirect_only">' . __('Redirect to file', 'download-monitor') . '</label>
			<span class="dlm-description">' . __('Don\'t force download. If the <code>dlm_uploads</code> folder is protected you may need to move your file.', 'download-monitor') . '</span>
		</p>';

		}

		do_action('dlm_options_end', $thepostid);

		echo '</div>';
	}

	public function admin_init() {
		global $pagenow;

		//if ($pagenow == 'post-new.php' || $pagenow == 'post.php' || $pagenow == 'edit.php') {

		add_action('add_meta_boxes', array($this, 'dlm_download_image_box'));

		add_action('admin_menu', array($this, 'remove_menus'), 1000);

		add_action('save_post', array($this, 'meta_boxes_save'), 1, 2);
		//}
	}

	function add_featured_image_instruction($content) {
		if (get_post_type() == 'dlm_download') {
			return $content .= '<p class="instruction">This will be used in related resources widget and on resource landing page </p>';

		}
	}

	function dlm_download_image_box() {
		if (get_post_type() == 'dlm_download') {
			remove_meta_box('postimagediv', 'dlm_download', 'side');
			add_filter('admin_post_thumbnail_html', array($this, 'add_featured_image_instruction'));
			add_meta_box('postimagediv', __('Resource Image'), 'post_thumbnail_meta_box', 'dlm_download', 'normal', 'high');
			add_meta_box('post_cta_image', __('Product Shot (Optional)'), array($this, 'cta_image_meta_box'), 'dlm_download', 'normal', 'low');

		}

	}

	// Remove menu
	function remove_menus() {
		remove_menu_page('edit-tags.php?taxonomy=dlm_download_tag'); // Post tags
	}

/**
 * Save meta boxes
 *
 * Runs when a post is saved and does an action which the write panel save scripts can hook into.
 */
	public function meta_boxes_save($post_id, $post) {
		if (empty($post_id) || empty($post) || empty($_POST)) {
			return;
		}

		if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
			return;
		}

		if (is_int(wp_is_post_revision($post))) {
			return;
		}

		if (is_int(wp_is_post_autosave($post))) {
			return;
		}

		if (!current_user_can('edit_post', $post_id)) {
			return;
		}

		if ($post->post_type != 'dlm_download') {
			return;
		}

		$this->process_dlm_download_meta($post_id, $post);
	}

	/**
	 * Function for processing and storing all book data.
	 */
	private function process_dlm_download_meta($post_id, $post) {
		update_post_meta($post_id, '_product_shot_id', $_POST['upload_image_id']);
	}

/**
 * Display the image meta box
 */
	public function cta_image_meta_box() {
		global $post;

		$uniq_id = uniqid();

		$image_src = '';

		$image_id = get_post_meta($post->ID, '_product_shot_id', true);
		$image_src = wp_get_attachment_url($image_id);

		?>
		<p class="instructions">
			When exists, will override the Resource Image within the Call-To-Action (CTA) widget within a landing page
		</p>
		<img id="cta_image" class="image-<?php echo $uniq_id ?>" src="<?php echo $image_src ?>" style="max-width:100%;" />
		<input type="hidden" name="upload_image_id" id="upload_image_id" value="<?php echo $image_id; ?>" />
		<p>
			<a title="<?php esc_attr_e('Set Image')?>" href="#" id="set-cta-image"><?php _e('Set Image')?>&nbsp;</a>
			<a title="<?php esc_attr_e('Remove Image')?>" href="#" id="remove-cta-image" style="<?php echo (!$image_id ? 'display:none;' : ''); ?>"><?php _e('Remove Image')?></a>
		</p>

		<script type="text/javascript">
		jQuery(document).ready(function($) {

			// save the send_to_editor handler function
			window.send_to_editor_default = window.send_to_editor;

			$('#set-cta-image').click(function(){

				// replace the default send_to_editor handler function with our own
				window.send_to_editor = window.attach_image;
				tb_show('', 'media-upload.php?post_id=<?php echo $post->ID ?>&amp;type=image&amp;TB_iframe=true');

				return false;
			});

			$('#remove-cta-image').click(function() {

				$('#upload_image_id').val('');
				$('img.image-<?php echo $uniq_id ?>').attr('src', '');
				$(this).hide();

				return false;
			});

			// handler function which is invoked after the user selects an image from the gallery popup.
			// this function displays the image and sets the id so it can be persisted to the post meta
			window.attach_image = function(html) {

				// turn the returned image html into a hidden image element so we can easily pull the relevant attributes we need
				$('body').append('<div id="temp_image">' + html + '</div>');

				var img = $('#temp_image').find('img');

				imgurl   = img.attr('src');
				imgclass = img.attr('class');
				imgid    = parseInt(imgclass.replace(/\D/g, ''), 10);

				$('#upload_image_id').val(imgid);
				$('#remove-cta-image').show();

				$('img#cta_image').attr('src', imgurl);
				try{tb_remove();}catch(e){};
				$('#temp_image').remove();

				// restore the send_to_editor handler function
				window.send_to_editor = window.send_to_editor_default;

			}

		});
		</script>
		<?php
}

	function my_publish_admin_hook() {
		global $post;
		echo "MARKER";
		//
		if (in_array(get_post_type($post), array('dlm_download'))) {
			if (is_admin()) {
				?>
				<script>
					(function($){

						$(document).ready(function(){

							//hide
							$('#download-monitor-information p').hide();
							$("#download-monitor-information p:first-child").show();



						});

					}(jQuery));
				</script>
				<?
			}
		}
		if (in_array(get_post_type($post), array('post', 'page', 'dlm_download'))) {
			if (is_admin() && false) {
				?>
	        <script language="javascript" type="text/javascript">
	            jQuery(document).ready(function() {
	                jQuery('#post').submit(function() {
	                    var form_data = jQuery('#post').serializeArray();
	                  //  console.log(form_data);
	                    form_data = jQuery.param(form_data);
	                    var data = {
	                        action: 'my_pre_submit_validation',
	                        security: '<?php echo wp_create_nonce('pre_publish_validation'); ?>',
	                        form_data: form_data
	                    };
	                    jQuery.post(ajaxurl, data, function(response) {
	                    	console.log(response);

	                        if (response.indexOf('True') > -1 || response.indexOf('true') > -1) {
	                          console.log('success:' + response);
	                          jQuery('#ajax-loading').hide();
	                          jQuery('#publish').removeClass('button-primary-disabled');
	                          return true;
	                        }else{
	                            alert(response);
	                            console.log("please correct the following errors: " + response);
	                            jQuery('#ajax-loading').hide();
	                            jQuery('#publish').removeClass('button-primary-disabled');
	                            return false;
	                        }
	                    });
	                    return false;
	                });
	            });
				        </script>
				        <?php
}
		}
	}

	function pre_submit_validation() {
		//simple Security check
		check_ajax_referer('pre_publish_validation', 'security');

		//do your validation here
		//all of the form fields are in $_POST['form_data'] array
		//and return true to submit: echo 'true'; die();
		//or your error message: echo 'bal bla bla'; die();
		//
		parse_str($_POST['form_data'], $form_data);

		if (count($form_data['tax_input']['dlm_download_topic']) > 1) {
			die('true');
		} else {
			die("Failed to save your post. Please check required field(Topic)");

		}

	}

}

$dlm_post_type = new CLASS_DLM_Post_Type_Manager();
$dlm_post_type->setup();