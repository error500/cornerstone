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



function cornerstone_shortcode_miniloop ($atts) {
	global $cornerstone_displaying_loop ;

	if (!isset($cornerstone_displaying_loop)) {
		$cornerstone_displaying_loop = true;
		/* usage
		 [loop filter_by=post_type filter_value=post posts_per_page=3 orderby=date oreder=DESC]*/

		 //Default value for params
		$a = shortcode_atts( array(
	        'filter_by' => 'post_type',
	        'filter_value' => 'post',
	        'posts_per_page' =>'3',
	        'orderby' => 'date', 'order' => 'DESC'
	    ), $atts );
		
		$args = array( $a['filter_by'].'='.$a['filter_value'],
						 'posts_per_page' => $a['posts_per_page'],
						 'orderby' => $a['orderby'], 'order' => $a['order'] );
		ob_start();		
		$loop = new WP_Query( $args  );
		while ( $loop->have_posts() ) : $loop->the_post();

			?>
			<h2><a href="<?php the_permalink() ?>"><?php the_title();?></a></h2>
			<div class="entry-content">
			<?php strip_shortcodes(the_excerpt()); ?>
			</div>
			<?php
		endwhile;
	}
	return ob_get_clean();
}

add_shortcode( 'loop', 'cornerstone_shortcode_miniloop' );
?>