<?php 

/*-----------------------------------------------------------------------------------*/
/*	 Contextual Category  Authors 
/*   http://pointandstare.com
/*   Usage: Widget
/*-----------------------------------------------------------------------------------*/

class socialite_widget extends WP_Widget {
	function socialite_widget() {
		$widget_ops = array( 'classname' => 'widget_socialite', 'description' => __( "Displays a list Social Icons" ) );
		$this->WP_Widget('Socialite', __('Socialite Social Icons'), $widget_ops);
	}
	function widget($args, $instance) {
		extract($args);
		echo $before_widget; 
		wpsocialite_markup();	
		echo $after_widget;
	} // function widget
}
add_action('widgets_init', create_function('', 'return register_widget("socialite_widget");'));


?>