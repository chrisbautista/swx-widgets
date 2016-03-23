<?php
/*
Plugin Name: Hubspot Shortcodes
Plugin URI:
Description: Render Hubspot blocks
Version: 1.0
Author: Chris Bautista
Author URI: www.randgroup.com
 */

if (!defined('ABSPATH')) {
	die("Can't load this file directly");
}

function render_hubspot_cta_floated($atts) {
	if (have_rows('ctas', 'option')): $i = 1;
		// loop through the rows of data
		while (have_rows('ctas', 'option')): the_row();
			if ($atts['id'] == $i):
				return "<div style='float:left;'><div class='" . get_sub_field('css_class') . "' id='" . get_sub_field('css_id') . "'>" . get_sub_field('code') . "</div></div><div class='clearfix'></div>";
			endif;
			$i++;
		endwhile;
	endif;
}

function render_hubspot_cta($atts) {
	//var_dump($atts);
	if (have_rows('ctas', 'option')): $i = 1;
		// get CTA
		while (have_rows('ctas', 'option')): the_row();
			if ($atts['id'] == $i) {
				$class_attr = get_sub_field("css_class") !== "" ? "class='" . get_sub_field('css_class') . "'" : "";
				$id_attr = get_sub_field("css_id") !== "" ? "id='" . get_sub_field('css_id') . "'" : "";
				$cont_attr = isset($atts['block_type']) && ($atts['block_type'] !== "") ? $atts["block_type"] : "container-fluid";
				if ($cont_attr === "fluid") {
					$cont_attr = "container-fluid";
				} elseif ($cont_attr === "normal") {
				$cont_attr = "container";
			}

			//if (get_sub_field("block_type") !== "default") {
			return "<div $class_attr $id_attr ><div class='$cont_attr'>" . get_sub_field('code') . "</div></div>";
			//}
			//return "<div $class_attr $id_attr >" . get_sub_field('code') . "</div>";
		}
		$i++;
	endwhile;
	endif;
}

function register_hubspot_shortcodes() {

	add_shortcode('hubspotcta', 'render_hubspot_cta');
	add_shortcode('hubspot', 'render_hubspot_cta');

}

add_action('init', 'register_hubspot_shortcodes');
