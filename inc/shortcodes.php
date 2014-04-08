<?php

// Shortcodes
function cornerstone_shortcode_col2($atts, $content=null){

return '<div class="small-12 large-6 columns"><p>' . $content . '</p></div>';

}

add_shortcode( 'col2', 'cornerstone_shortcode_col2' );

?>