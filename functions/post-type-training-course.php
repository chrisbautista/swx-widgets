<?php

/**
 * Define Training Course Post Type
 *
 * @package default
 * @author codespud
 */ 

class CLASS_Training_Course
{
 
	function __construct()
	{
		add_action( 'init', array($this, 'training_courses'), 0 );
	}

	// Register Custom Post Type
	function training_courses() {

		$labels = array(
			'name'                  => _x( 'Training Courses', 'Post Type General Name', 'swx_widgets' ),
			'singular_name'         => _x( 'Training Course', 'Post Type Singular Name', 'swx_widgets' ),
			'menu_name'             => __( 'Training Course', 'swx_widgets' ),
			'name_admin_bar'        => __( 'Training Course', 'swx_widgets' ),
			'archives'              => __( 'Training Courses', 'swx_widgets' ),
			'parent_item_colon'     => __( 'Parent Course:', 'swx_widgets' ),
			'all_items'             => __( 'All Courses', 'swx_widgets' ),
			'add_new_item'          => __( 'Add New Course', 'swx_widgets' ),
			'add_new'               => __( 'Add New', 'swx_widgets' ),
			'new_item'              => __( 'New Course', 'swx_widgets' ),
			'edit_item'             => __( 'Edit Course', 'swx_widgets' ),
			'update_item'           => __( 'Update Course', 'swx_widgets' ),
			'view_item'             => __( 'View Course', 'swx_widgets' ),
			'search_items'          => __( 'Search Course', 'swx_widgets' ),
			'not_found'             => __( 'Not found', 'swx_widgets' ),
			'not_found_in_trash'    => __( 'Not found in Trash', 'swx_widgets' ),
			'featured_image'        => __( 'Featured Image', 'swx_widgets' ),
			'set_featured_image'    => __( 'Set featured image', 'swx_widgets' ),
			'remove_featured_image' => __( 'Remove featured image', 'swx_widgets' ),
			'use_featured_image'    => __( 'Use as featured image', 'swx_widgets' ),
			'insert_into_item'      => __( 'Insert into item', 'swx_widgets' ),
			'uploaded_to_this_item' => __( 'Uploaded to this item', 'swx_widgets' ),
			'items_list'            => __( 'Courses list', 'swx_widgets' ),
			'items_list_navigation' => __( 'Courses list navigation', 'swx_widgets' ),
			'filter_items_list'     => __( 'Filter items list', 'swx_widgets' ),
		);
		$args = array(
			'label'                 => __( 'Training Course', 'swx_widgets' ),
			'description'           => __( 'Training Courses ', 'swx_widgets' ),
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
		register_post_type( 'training_course', $args );

	}

	function setupFields(){
		if( function_exists('acf_add_local_field_group') ):

		acf_add_local_field_group(array (
			'key' => 'group_56f30bd9ae61c',
			'title' => 'Training Course',
			'fields' => array (
				array (
					'key' => 'field_56f30bee8003a',
					'label' => 'Region IDs',
					'name' => 'region_ids',
					'type' => 'taxonomy',
					'instructions' => '',
					'required' => 0,
					'conditional_logic' => 0,
					'wrapper' => array (
						'width' => '',
						'class' => '',
						'id' => '',
					),
					'taxonomy' => 'regions',
					'field_type' => 'multi_select',
					'allow_null' => 0,
					'add_term' => 0,
					'save_terms' => 0,
					'load_terms' => 0,
					'return_format' => 'id',
					'multiple' => 0,
				),
				array (
					'key' => 'field_56f30c7c8003b',
					'label' => 'Course Name',
					'name' => 'course_name',
					'type' => 'text',
					'instructions' => 'Instructions here',
					'required' => 1,
					'conditional_logic' => 0,
					'wrapper' => array (
						'width' => '',
						'class' => '',
						'id' => '',
					),
					'default_value' => '',
					'placeholder' => 'Course Name',
					'prepend' => '',
					'append' => '',
					'maxlength' => '',
					'readonly' => 0,
					'disabled' => 0,
				),
				array (
					'key' => 'field_56f30cb08003c',
					'label' => 'Course Synopsis',
					'name' => 'course_synopsis',
					'type' => 'textarea',
					'instructions' => '',
					'required' => 1,
					'conditional_logic' => 0,
					'wrapper' => array (
						'width' => '',
						'class' => '',
						'id' => '',
					),
					'default_value' => '',
					'placeholder' => 'Course Synopsis',
					'maxlength' => '',
					'rows' => '',
					'new_lines' => 'wpautop',
					'readonly' => 0,
					'disabled' => 0,
				),
				array (
					'key' => 'field_56f30cde8003d',
					'label' => 'Course Details',
					'name' => 'course_details',
					'type' => 'textarea',
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
					'maxlength' => '',
					'rows' => '',
					'new_lines' => 'wpautop',
					'readonly' => 0,
					'disabled' => 0,
				),
			),
			'location' => array (
				array (
					array (
						'param' => 'post_type',
						'operator' => '==',
						'value' => 'training_course',
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




}


$training_courses = new CLASS_Training_Course();
$training_courses->setupFields();

/*

if( function_exists('acf_add_local_field_group') ):

acf_add_local_field_group(array (
	'key' => 'group_56f30bd9ae61c',
	'title' => 'Training Course',
	'fields' => array (
		array (
			'key' => 'field_56f30bee8003a',
			'label' => 'Region IDs',
			'name' => 'region_ids',
			'type' => 'taxonomy',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array (
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'taxonomy' => 'regions',
			'field_type' => 'multi_select',
			'allow_null' => 0,
			'add_term' => 0,
			'save_terms' => 0,
			'load_terms' => 0,
			'return_format' => 'id',
			'multiple' => 0,
		),
		array (
			'key' => 'field_56f30c7c8003b',
			'label' => 'Course Name',
			'name' => 'course_name',
			'type' => 'text',
			'instructions' => 'Instructions here',
			'required' => 1,
			'conditional_logic' => 0,
			'wrapper' => array (
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'default_value' => '',
			'placeholder' => 'Course Name',
			'prepend' => '',
			'append' => '',
			'maxlength' => '',
			'readonly' => 0,
			'disabled' => 0,
		),
		array (
			'key' => 'field_56f30cb08003c',
			'label' => 'Course Synopsis',
			'name' => 'course_synopsis',
			'type' => 'textarea',
			'instructions' => '',
			'required' => 1,
			'conditional_logic' => 0,
			'wrapper' => array (
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'default_value' => '',
			'placeholder' => 'Course Synopsis',
			'maxlength' => '',
			'rows' => '',
			'new_lines' => 'wpautop',
			'readonly' => 0,
			'disabled' => 0,
		),
		array (
			'key' => 'field_56f30cde8003d',
			'label' => 'Course Details',
			'name' => 'course_details',
			'type' => 'textarea',
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
			'maxlength' => '',
			'rows' => '',
			'new_lines' => 'wpautop',
			'readonly' => 0,
			'disabled' => 0,
		),
	),
	'location' => array (
		array (
			array (
				'param' => 'post_type',
				'operator' => '==',
				'value' => 'training_course',
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


*/