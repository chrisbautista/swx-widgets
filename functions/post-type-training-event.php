<?php
if(!is_post_type_defined('training_event')) die();
/**
 * Define Training Event Post Type
 *
 * @package default
 * @author codespud
 */ 

class CLASS_Training_Event
{
 
	function __construct()
	{
		add_action( 'init', array($this, 'define_post_type'), 0 );
		add_action('wp_ajax_pa_add_areas',  array($this,'area_by_country'));
		add_action('wp_ajax_nopriv_pa_add_areas',  array($this,'area_by_country')); 
		add_action( 'admin_enqueue_scripts',  array($this,'acf_admin_enqueue' ));
		add_filter('acf/load_field/key=field_52b1b7007bfa4',  array($this,'acf_load_select_country'));

	}

	// Register Custom Post Type
	function define_post_type() {

		$labels = array(
			'name'                  => _x( 'Training Events', 'Post Type General Name', 'swx_widgets' ),
			'singular_name'         => _x( 'Training Event', 'Post Type Singular Name', 'swx_widgets' ),
			'menu_name'             => __( 'Training Events', 'swx_widgets' ),
			'name_admin_bar'        => __( 'Training Events', 'swx_widgets' ),
			'archives'              => __( 'Training Events', 'swx_widgets' ),
			'parent_item_colon'     => __( 'Parent Event:', 'swx_widgets' ),
			'all_items'             => __( 'All Events', 'swx_widgets' ),
			'add_new_item'          => __( 'Add New Event', 'swx_widgets' ),
			'add_new'               => __( 'Add New', 'swx_widgets' ),
			'new_item'              => __( 'New Event', 'swx_widgets' ),
			'edit_item'             => __( 'Edit Event', 'swx_widgets' ),
			'update_item'           => __( 'Update Event', 'swx_widgets' ),
			'view_item'             => __( 'View Event', 'swx_widgets' ),
			'search_items'          => __( 'Search Event', 'swx_widgets' ),
			'not_found'             => __( 'Not found', 'swx_widgets' ),
			'not_found_in_trash'    => __( 'Not found in Trash', 'swx_widgets' ),
			'featured_image'        => __( 'Featured Image', 'swx_widgets' ),
			'set_featured_image'    => __( 'Set featured image', 'swx_widgets' ),
			'remove_featured_image' => __( 'Remove featured image', 'swx_widgets' ),
			'use_featured_image'    => __( 'Use as featured image', 'swx_widgets' ),
			'insert_into_item'      => __( 'Insert into item', 'swx_widgets' ),
			'uploaded_to_this_item' => __( 'Uploaded to this item', 'swx_widgets' ),
			'items_list'            => __( 'Events list', 'swx_widgets' ),
			'items_list_navigation' => __( 'Events list navigation', 'swx_widgets' ),
			'filter_items_list'     => __( 'Filter items list', 'swx_widgets' ),
		);
		$args = array(
			'label'                 => __( 'Training Events', 'swx_widgets' ),
			'description'           => __( 'Training Events ', 'swx_widgets' ),
			'labels'                => $labels,
			'supports'              => array( 'title', 'editor', 'author', 'thumbnail',  ),
			'taxonomies'            => array( 'category', 'post_tag' ),
			'hierarchical'          => false,
			'public'                => true,
			'show_ui'               => true,
			'show_in_menu'          => true,
			'menu_position'         => 5,
			'show_in_admin_bar'     => true,
			'show_in_nav_menus'     => true,
			'can_export'            => true,
			'has_archive'           => true,		
			'exclude_from_search'   => false,
			'publicly_queryable'    => true,
			'capability_type'       => 'page',
		);
		register_post_type( 'training_event', $args );

	}

	function setupFields(){
		if( function_exists('acf_add_local_field_group') ):

		acf_add_local_field_group(array (
			'key' => 'group_56f30e72ba98e',
			'title' => 'Training Events',
			'fields' => array (
				array (
					'key' => 'field_56f30e6cecd21',
					'label' => 'Status',
					'name' => 'status',
					'type' => 'select',
					'instructions' => '',
					'required' => 1,
					'conditional_logic' => 0,
					'wrapper' => array (
						'width' => '',
						'class' => '',
						'id' => '',
					),
					'choices' => array (
					),
					'default_value' => array (
						0 => 'Active',
						1 => 'Full',
						2 => 'Expired',
					),
					'allow_null' => 0,
					'multiple' => 0,
					'ui' => 0,
					'ajax' => 0,
					'placeholder' => '',
					'disabled' => 0,
					'readonly' => 0,
				),
				array (
					'key' => 'field_56f30eacecd22',
					'label' => 'Course ID',
					'name' => 'course_id',
					'type' => 'post_object',
					'instructions' => '',
					'required' => 1,
					'conditional_logic' => 0,
					'wrapper' => array (
						'width' => '',
						'class' => '',
						'id' => '',
					),
					'post_type' => array (
						0 => 'training_course',
					),
					'taxonomy' => array (
					),
					'allow_null' => 0,
					'multiple' => 0,
					'return_format' => 'object',
					'ui' => 1,
				),
				array (
					'key' => 'field_56f30f0aecd23',
					'label' => 'Event Type',
					'name' => 'event_type',
					'type' => 'text',
					'instructions' => '',
					'required' => 1,
					'conditional_logic' => 0,
					'wrapper' => array (
						'width' => '',
						'class' => '',
						'id' => '',
					),
					'default_value' => '',
					'placeholder' => '',
					'prepend' => '',
					'append' => '',
					'maxlength' => '',
					'readonly' => 0,
					'disabled' => 0,
				),
				array (
					'key' => 'field_56f30f5becd24',
					'label' => 'Start Date',
					'name' => 'event_start_date',
					'type' => 'date_picker',
					'instructions' => '',
					'required' => 1,
					'conditional_logic' => 0,
					'wrapper' => array (
						'width' => '',
						'class' => '',
						'id' => '',
					),
					'display_format' => 'F j, Y',
					'return_format' => 'd/m/Y',
					'first_day' => 1,
				),
				array (
					'key' => 'field_56f30fcdecd25',
					'label' => 'Start Time',
					'name' => 'event_start_time',
					'type' => 'date_picker',
					'instructions' => '',
					'required' => 0,
					'conditional_logic' => 0,
					'wrapper' => array (
						'width' => '',
						'class' => '',
						'id' => '',
					),
					'display_format' => 'F j, Y',
					'return_format' => 'd/m/Y',
					'first_day' => 1,
				),
				array (
					'key' => 'field_56f30ffeecd27',
					'label' => 'End Time',
					'name' => 'event_end_time',
					'type' => 'date_picker',
					'instructions' => '',
					'required' => 0,
					'conditional_logic' => 0,
					'wrapper' => array (
						'width' => '',
						'class' => '',
						'id' => '',
					),
					'display_format' => 'F j, Y',
					'return_format' => 'd/m/Y',
					'first_day' => 1,
				),
				array (
					'key' => 'field_56f30fe7ecd26',
					'label' => 'End Date',
					'name' => 'event_end_date',
					'type' => 'date_picker',
					'instructions' => '',
					'required' => 1,
					'conditional_logic' => 0,
					'wrapper' => array (
						'width' => '',
						'class' => '',
						'id' => '',
					),
					'display_format' => 'F j, Y',
					'return_format' => 'd/m/Y',
					'first_day' => 1,
				),
				array (
					'key' => 'field_56f31016ecd28',
					'label' => 'Timezone',
					'name' => 'event_timezone',
					'type' => 'timezone_picker',
					'instructions' => '',
					'required' => 1,
					'conditional_logic' => 0,
					'wrapper' => array (
						'width' => '',
						'class' => '',
						'id' => '',
					),
				),
				array (
					'key' => 'field_56f310d7ecd29',
					'label' => 'Address1',
					'name' => 'address1',
					'type' => 'text',
					'instructions' => '',
					'required' => 0,
					'conditional_logic' => 0,
					'wrapper' => array (
						'width' => '',
						'class' => '',
						'id' => '',
					),
					'default_value' => '',
					'placeholder' => '',
					'prepend' => '',
					'append' => '',
					'maxlength' => '',
					'readonly' => 0,
					'disabled' => 0,
				),
				array (
					'key' => 'field_56f310eeecd2a',
					'label' => 'Address2',
					'name' => 'address2',
					'type' => 'text',
					'instructions' => '',
					'required' => 0,
					'conditional_logic' => 0,
					'wrapper' => array (
						'width' => '',
						'class' => '',
						'id' => '',
					),
					'default_value' => '',
					'placeholder' => '',
					'prepend' => '',
					'append' => '',
					'maxlength' => '',
					'readonly' => 0,
					'disabled' => 0,
				),
				array (
					'key' => 'field_56f310f5ecd2b',
					'label' => 'Address3',
					'name' => 'address3',
					'type' => 'text',
					'instructions' => '',
					'required' => 0,
					'conditional_logic' => 0,
					'wrapper' => array (
						'width' => '',
						'class' => '',
						'id' => '',
					),
					'default_value' => '',
					'placeholder' => '',
					'prepend' => '',
					'append' => '',
					'maxlength' => '',
					'readonly' => 0,
					'disabled' => 0,
				),
				array (
					'key' => 'field_56f31bebe1223',
					'label' => 'City',
					'name' => 'city',
					'type' => 'select',
					'instructions' => 'list of cities here ',
					'required' => 0,
					'conditional_logic' => 0,
					'wrapper' => array (
						'width' => '',
						'class' => '',
						'id' => '',
					),
					'choices' => array (
					),
					'default_value' => array (
					),
					'allow_null' => 0,
					'multiple' => 0,
					'ui' => 0,
					'ajax' => 0,
					'placeholder' => '',
					'disabled' => 0,
					'readonly' => 0,
				),
				array (
					'key' => 'field_56f31db7eec32',
					'label' => 'State',
					'name' => 'state',
					'type' => 'select',
					'instructions' => 'list of states',
					'required' => 0,
					'conditional_logic' => 0,
					'wrapper' => array (
						'width' => '',
						'class' => '',
						'id' => '',
					),
					'choices' => array (
					),
					'default_value' => array (
					),
					'allow_null' => 0,
					'multiple' => 0,
					'ui' => 0,
					'ajax' => 0,
					'placeholder' => '',
					'disabled' => 0,
					'readonly' => 0,
				),
				array (
					'key' => 'field_56f31db8eec33',
					'label' => 'Country',
					'name' => 'country',
					'type' => 'select',
					'instructions' => 'list of countries here',
					'required' => 0,
					'conditional_logic' => 0,
					'wrapper' => array (
						'width' => '',
						'class' => '',
						'id' => '',
					),
					'choices' => array (
					),
					'default_value' => array (
					),
					'allow_null' => 0,
					'multiple' => 0,
					'ui' => 0,
					'ajax' => 0,
					'placeholder' => '',
					'disabled' => 0,
					'readonly' => 0,
				),
				array (
					'key' => 'field_56f31dd8eec34',
					'label' => 'Google Maps URL',
					'name' => 'google_maps_url',
					'type' => 'google_map',
					'instructions' => '',
					'required' => 0,
					'conditional_logic' => 0,
					'wrapper' => array (
						'width' => '',
						'class' => '',
						'id' => '',
					),
					'center_lat' => '',
					'center_lng' => '',
					'zoom' => '',
					'height' => '',
				),
				array (
					'key' => 'field_56f31df2eec35',
					'label' => 'Instructor',
					'name' => 'instructor',
					'type' => 'text',
					'instructions' => '',
					'required' => 0,
					'conditional_logic' => 0,
					'wrapper' => array (
						'width' => '',
						'class' => '',
						'id' => '',
					),
					'default_value' => '',
					'placeholder' => '',
					'prepend' => '',
					'append' => '',
					'maxlength' => '',
					'readonly' => 0,
					'disabled' => 0,
				),
				array (
					'key' => 'field_56f31e03eec36',
					'label' => 'Requirements',
					'name' => 'requirements',
					'type' => 'text',
					'instructions' => '',
					'required' => 0,
					'conditional_logic' => 0,
					'wrapper' => array (
						'width' => '',
						'class' => '',
						'id' => '',
					),
					'default_value' => '',
					'placeholder' => '',
					'prepend' => '',
					'append' => '',
					'maxlength' => '',
					'readonly' => 0,
					'disabled' => 0,
				),
				array (
					'key' => 'field_56f31e11eec37',
					'label' => 'Registration URL',
					'name' => 'registration_url',
					'type' => 'text',
					'instructions' => '',
					'required' => 0,
					'conditional_logic' => 0,
					'wrapper' => array (
						'width' => '',
						'class' => '',
						'id' => '',
					),
					'default_value' => '',
					'placeholder' => '',
					'prepend' => '',
					'append' => '',
					'maxlength' => '',
					'readonly' => 0,
					'disabled' => 0,
				),
				array (
					'key' => 'field_56f31e3feec38',
					'label' => 'Seats Remaining',
					'name' => 'seats_remaining',
					'type' => 'number',
					'instructions' => '',
					'required' => 0,
					'conditional_logic' => 0,
					'wrapper' => array (
						'width' => '',
						'class' => '',
						'id' => '',
					),
					'default_value' => '',
					'placeholder' => 'Searts Remaining',
					'prepend' => '',
					'append' => '',
					'min' => 0,
					'max' => '',
					'step' => '',
					'readonly' => 0,
					'disabled' => 0,
				),
			),
			'location' => array (
				array (
					array (
						'param' => 'post_type',
						'operator' => '==',
						'value' => 'training_event',
					),
				),
			),
			'menu_order' => 0,
			'position' => 'normal',
			'style' => 'default',
			'label_placement' => 'top',
			'instruction_placement' => 'label',
			'hide_on_screen' => '',
			'active' => 1,
			'description' => '',
			'is_acf_component' => 0,
		));

		endif;
	}

	function setupHelpers(){



	}




}

$training_event = new CLASS_Training_Event();

$training_event->setupFields();
