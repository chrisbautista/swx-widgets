<?php

if (!defined('ABSPATH')) {
	exit;
} // Exit if accessed directly

/**
 * Register taxonomies
 *
 * @link       http://randgroup.com
 * @since      1.0.0
 *
 * @package    RG_Awesome
 * @subpackage RG_Awesome/includes/taxonomies
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    RG_Awesome
 * @subpackage RG_Awesome/includes
 * @author     Chris Bautista <cbautista@randgroup.com>
 */
class CLASS_DM_Taxonomy {

	/**
	 * Setup hooks
	 */
	public function setup() {
		add_action('init', array($this, 'register_taxonomy'), 1000);

		// buying phase metaboxes
		add_action('admin_menu', array($this, 'bp_remove_old_meta_box'));
		//add_action('add_meta_boxes', array($this, 'bp_add_meta_box'));
		$this->bp_add_meta_box();

		add_action('admin_menu', array($this, 'remove_menus'), 1000);

		//add_action('admin_print_footer_scripts', array($this, 'my_publish_admin_hook'), 1000);

		//add_action('wp_ajax_my_pre_submit_validation', array($this, 'pre_submit_validation'));

	}

	function my_publish_admin_hook() {

		//echo "MARKER";
		if (is_admin()) {
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

	// Remove menu
	function remove_menus() {
		remove_menu_page('edit-tags.php?taxonomy=dlm_download_tag'); // Post tags
	}

	/**
	 * Register Taxonomies
	 */
	public function register_taxonomy() {

		// remove taxonomies
		//
		global $wp_taxonomies;

		if (isset($wp_taxonomies['dlm_download_tag'])) {
			//unset($wp_taxonomies['dlm_download_tag']);
		}

		// Register Download Content Type
		register_taxonomy('dlm_download_buying_phase',
			array('dlm_download'),
			apply_filters('dlm_download_buying_phase_args', array(
				'hierarchical' => true,
				'label' => __('Buying Phase', 'rg_awesome'),
				'labels' => array(
					'name' => __('Buying Phase', 'rg_awesome'),
					'singular_name' => __('Buying Phase', 'rg_awesome'),
					'search_items' => __('Search Buying Phases', 'rg_awesome'),
					'all_items' => __('All Buying Phases', 'rg_awesome'),
					'parent_item' => __('Parent Buying Phase', 'rg_awesome'),
					'parent_item_colon' => __('Parent Buying Phase', 'rg_awesome'),
					'edit_item' => __('Edit Buying Phase', 'rg_awesome'),
					'popular_items' => __('Popular Buying Phase', 'rg_awesome'),
					'update_item' => __('Update Buying Phase', 'rg_awesome'),
					'add_new_item' => __('Add New Buying Phase', 'rg_awesome'),
					'new_item_name' => __('New Buying Phase', 'rg_awesome'),
					'add_or_remove_items' => __(' Add or remove "Buying Phase"', 'rg_awesome'),
					'not_found' => __('No items found.', 'rg_awesome'),
				),
				'show_ui' => true,
				'query_var' => true,
				'capabilities' => array(
					'manage_terms' => 'manage_downloads',
					'edit_terms' => 'manage_downloads',
					'delete_terms' => 'manage_downloads',
					'assign_terms' => 'manage_downloads',
				),
				'rewrite' => false,
				'show_in_nav_menus' => false,
			))
		);
		// Register Download Content Type
		register_taxonomy('dlm_download_topic',
			array('post', 'page', 'dlm_download', 'awards', 'news', 'testimonials', 'staff_testimonials', 'events'),
			apply_filters('dlm_download_topic_args', array(
				'hierarchical' => true,
				'label' => __('Topic', 'rg_awesome'),
				'labels' => array(
					'name' => __('Topic', 'rg_awesome'),
					'singular_name' => __('Topic', 'rg_awesome'),
					'search_items' => __('Search Topics', 'rg_awesome'),
					'all_items' => __('All Topics', 'rg_awesome'),
					'parent_item' => __('Parent Topic', 'rg_awesome'),
					'parent_item_colon' => __('Parent Topic', 'rg_awesome'),
					'edit_item' => __('Edit Topic', 'rg_awesome'),
					'popular_items' => __('Popular Topic', 'rg_awesome'),
					'update_item' => __('Update Topic', 'rg_awesome'),
					'add_new_item' => __('Add New Topic', 'rg_awesome'),
					'new_item_name' => __('New Topic', 'rg_awesome'),
					'add_or_remove_items' => __(' Add or remove "Topic"', 'rg_awesome'),
					'not_found' => __('No items found.', 'rg_awesome'),
				),
				'show_ui' => true,
				'query_var' => true,
				'capabilities' => array(
					'manage_terms' => 'manage_downloads',
					'edit_terms' => 'manage_downloads',
					'delete_terms' => 'manage_downloads',
					'assign_terms' => 'manage_downloads',
				),
				'rewrite' => false,
				'show_in_nav_menus' => false,
			))
		);

		//unregister('dlm_download_category');
		//
		//global $wp_taxonomies;
		//var_log($wp_taxonomies['dlm_download_category']);

		register_taxonomy('dlm_download_category',
			array('dlm_download'),
			apply_filters('dlm_download_category_args', array(
				'hierarchical' => true,
				'update_count_callback' => '_update_post_term_count',
				'label' => __('Content Types', 'download-monitor'),
				'labels' => array(
					'name' => __('Content Types', 'download-monitor'),
					'singular_name' => __('Download Content Type', 'download-monitor'),
					'search_items' => __('Search Download Content Types', 'download-monitor'),
					'all_items' => __('All Download Content Types', 'download-monitor'),
					'parent_item' => __('Parent Download Content Type', 'download-monitor'),
					'parent_item_colon' => __('Parent Download Content Type', 'download-monitor'),
					'edit_item' => __('Edit Download Content Type', 'download-monitor'),
					'update_item' => __('Update Download Content Type', 'download-monitor'),
					'add_new_item' => __('Add New Download Content Type', 'download-monitor'),
					'new_item_name' => __('New Download Content Type Name', 'download-monitor'),
				),
				'show_ui' => true,
				'query_var' => true,
				'capabilities' => array(
					'manage_terms' => 'manage_downloads',
					'edit_terms' => 'manage_downloads',
					'delete_terms' => 'manage_downloads',
					'assign_terms' => 'manage_downloads',
				),
				'rewrite' => false,
				'show_in_nav_menus' => false,
			))
		);

		// remove tags
		//

	}

	function add_dlm_columns($columns) {
		//unset($columns['col]);
		//var_log($columns);
		$columns = array_merge($columns, array('buying_phase' => _("Buying Phase", 'rg_awesome')));

		return $columns;

	}

	/**
	 * Meta box
	 * replace existing Buying Phase metabox with checklist style form
	 */

	function bp_remove_old_meta_box() {
		//remove_meta_box('tagsdiv-dlm_download_buying_phase', 'dlm_download', 'side');
	}

	//Add new taxonomy meta box
	function bp_add_meta_box() {
		/*add_meta_box('dlm_download_buying_phase',
			'Buying Phase',
			array($this, 'bp_my_meta_box'),
			'dlm_download',
			'side',
			'core');
	    */

		$custom_tax_mb = new WDS_Taxonomy_Radio('dlm_download_buying_phase');
		$custom_tax_mb->context = 'side';
		$custom_tax_mb->priority = 'core';
		$custom_tax_mb->force_selection = true;

		$custom_tax_mb = new WDS_Taxonomy_Radio('dlm_download_category');
		$custom_tax_mb->priority = 'core';
		$custom_tax_mb->context = 'side';
		$custom_tax_mb->force_selection = true;

		/*$custom_tax_mb = new WDS_Taxonomy_Radio('dlm_download_topic');
			$custom_tax_mb->priority = 'core';
			$custom_tax_mb->context = 'side';
			$custom_tax_mb->force_selection = true;
		*/
	}

}

if (!class_exists('WDS_Taxonomy_Radio')) {
	/**
	 * Removes and replaces the built-in taxonomy metabox with our radio-select metabox.
	 * @link  http://codex.wordpress.org/Function_Reference/add_meta_box#Parameters
	 */
	class WDS_Taxonomy_Radio {

		// Post types where metabox should be replaced (defaults to all post_types associated with taxonomy)
		public $post_types = array();
		// Taxonomy slug
		public $slug = '';
		// Taxonomy object
		public $taxonomy = false;
		// New metabox title. Defaults to Taxonomy name
		public $metabox_title = '';
		// Metabox priority. (vertical placement)
		// 'high', 'core', 'default' or 'low'
		public $priority = 'high';
		// Metabox position. (column placement)
		// 'normal', 'advanced', or 'side'
		public $context = 'side';
		// Set to true to hide "None" option & force a term selection
		public $force_selection = false;

		/**
		 * Initiates our metabox action
		 * @param string $tax_slug      Taxonomy slug
		 * @param array  $post_types    post-types to display custom metabox
		 */
		public function __construct($tax_slug, $post_types = array()) {

			$this->slug = $tax_slug;
			$this->post_types = is_array($post_types) ? $post_types : array($post_types);

			add_action('add_meta_boxes', array($this, 'add_radio_box'));
		}

		/**
		 * Removes and replaces the built-in taxonomy metabox with our own.
		 */
		public function add_radio_box() {
			foreach ($this->post_types() as $key => $cpt) {
				// remove default category type metabox
				remove_meta_box($this->slug . 'div', $cpt, 'side');
				// remove default tag type metabox
				remove_meta_box('tagsdiv-' . $this->slug, $cpt, 'side');
				// add our custom radio box
				add_meta_box($this->slug . '_radio', $this->metabox_title(), array($this, 'radio_box'), $cpt, $this->context, $this->priority);
			}
		}

		/**
		 * Displays our taxonomy radio box metabox
		 */
		public function radio_box() {

			// uses same noncename as default box so no save_post hook needed
			wp_nonce_field('taxonomy_' . $this->slug, 'taxonomy_noncename');

			// get terms associated with this post
			$names = wp_get_object_terms(get_the_ID(), $this->slug);
			// get all terms in this taxonomy
			$terms = (array) get_terms($this->slug, 'hide_empty=0');
			// filter the ids out of the terms
			$existing = (!is_wp_error($names) && !empty($names))
			? (array) wp_list_pluck($names, 'term_id')
			: array();
			// Check if taxonomy is hierarchical
			// Terms are saved differently between types
			$h = $this->taxonomy()->hierarchical;

			// default value
			$default_val = $h ? 0 : '';
			// input name
			$name = $h ? 'tax_input[' . $this->slug . '][]' : 'tax_input[' . $this->slug . ']';

			echo '<div style="margin-bottom: 5px;">
         <ul id="' . $this->slug . '_taxradiolist" data-wp-lists="list:' . $this->slug . '_tax" class="categorychecklist form-no-clear">';

			// If 'category,' force a selection, or force_selection is true
			if ($this->slug != 'category' && !$this->force_selection) {
				// our radio for selecting none
				echo '<li id="' . $this->slug . '_tax-0"><label><input value="' . $default_val . '" type="radio" name="' . $name . '" id="in-' . $this->slug . '_tax-0" ';
				checked(empty($existing));
				echo '> ' . sprintf(__('No %s', 'wds'), $this->taxonomy()->labels->singular_name) . '</label></li>';
			}

			// loop our terms and check if they're associated with this post
			foreach ($terms as $term) {

				$val = $h ? $term->term_id : $term->slug;

				echo '<li id="' . $this->slug . '_tax-' . $term->term_id . '"><label><input value="' . $val . '" type="radio" name="' . $name . '" id="in-' . $this->slug . '_tax-' . $term->term_id . '" ';
				// if so, they get "checked"
				checked(!empty($existing) && in_array($term->term_id, $existing));
				echo '> ' . $term->name . '</label></li>';
			}
			echo '</ul></div>';

		}

		/**
		 * Gets the taxonomy object from the slug
		 * @return object Taxonomy object
		 */
		public function taxonomy() {
			$this->taxonomy = $this->taxonomy ? $this->taxonomy : get_taxonomy($this->slug);
			return $this->taxonomy;
		}

		/**
		 * Gets the taxonomy's associated post_types
		 * @return array Taxonomy's associated post_types
		 */
		public function post_types() {
			$this->post_types = !empty($this->post_types) ? $this->post_types : $this->taxonomy()->object_type;
			return $this->post_types;
		}

		/**
		 * Gets the metabox title from the taxonomy object's labels (or uses the passed in title)
		 * @return string Metabox title
		 */
		public function metabox_title() {
			$this->metabox_title = !empty($this->metabox_title) ? $this->metabox_title : $this->taxonomy()->labels->name;
			return $this->metabox_title;
		}

	}


}


$dlm_taxonomy = new CLASS_DM_Taxonomy();
$dlm_taxonomy->setup();