<?php  

//[locations] shortcode
function locations_func( $atts ){
	return "<p>BDO Solutions serves clients across Canada including: Alberta, British Columbia, Saskatchewan, Ontario, Manitoba and Nova Scotia. We serve the metro areas of Vancouver, Calgary, Edmonton, Winnipeg, Brandon, Mississauga, Toronto, Barrie, Markham, Kitchener, Waterloo, Guelph, London, Red Deer and Halifax.</p>";
}
add_shortcode( 'locations', 'locations_func' );

?>