<?php

// Shortcodes
function cornerstone_shortcode_col2($atts, $content=null){

return '<div class="small-12 large-6 columns"><p>' . $content . '</p></div>';

}

add_shortcode( 'col2', 'cornerstone_shortcode_col2' );


// Shortcodes
function cornerstone_display_video($atts){
	extract( shortcode_atts( array(
		'code' => 'undefined',
		'type' => 'youtube',
	), $atts ) );
	if ($type=='youtube' && $code!="undefined") {
		$retval ='<div class="row">
	<div class="flex-video small-11 small-centered columns">
	<iframe width="560" height="315" src="//www.youtube.com/embed/' . $code . '" frameborder="0" allowfullscreen></iframe>
	</div></div>';
	} else {
		$retval="Pas de support pour les vidéos de type {$type}";
	}
	return $retval;

}

add_shortcode( 'video', 'cornerstone_display_video' );

?>