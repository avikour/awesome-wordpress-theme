<?php


// ====================================== SHORTCODES ====================================== //

	function say_hello($atts){ 
		$msg = "Hello ".$atts['name'] ;
		return $msg ; 
	} 
	add_shortcode( 'say_hi', 'say_hello' ); 
	


?>