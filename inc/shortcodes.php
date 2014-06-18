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
		'width' => 'small-12 medium-12 large-6',
		'position' => 'small-centered large-uncentered'
	), $atts ) );
	
	$retval .='<div class="row"><div class="'.$width.' columns '.$position.'">';
	if ($type=='youtube' && $code!="undefined") {
		$retval .='<div class="flex-video">';
		$retval .='<iframe "width="420" height="315" src="http://www.youtube.com/embed/' . $code . '" frameborder="0" allowfullscreen></iframe>
	</div>';
	} else {
		$retval="Pas de support pour les vidéos de type {$type}";
	}
	$retval .='</div></div>';
	return $retval;

}

add_shortcode( 'video', 'cornerstone_display_video' );


/**
*	Short code for creating a serie of excerpt dedicated to home pages
*	Based on a loop and displayed as a foundation block grid format
*   params :
* 	Codex params see http://codex.wordpress.org/wp_query
* 		filter_by : the item to filter on
*		filter_value : the value of the filter
*		posts_per_page : the nomber of items to load
*		orderby : the item for ordering
*		order : the choosed order
*	Foundation params:
*		class : ul class for displaying
*
*	Example ;
*		3 last post	
*		[loop filter_by=post_type filter_value=post posts_per_page=3 orderby=date order=DESC class=small-block-grid-3]
*		specified posts
*		[loop filter_by=post filter_value=16,18]
*
*  default values 
*		'filter_by' => 'post_type',
*		'filter_value' => 'post',
*		'posts_per_page' =>'3',
*		'orderby' => 'date', 'order' => 'DESC',
*		'class' => 'small-block-grid-3'
*/
function cornerstone_shortcode_miniloop ($atts) {
	global $cornerstone_displaying_loop ;

	if (!isset($cornerstone_displaying_loop)) {
		$cornerstone_displaying_loop = true;

		//Default value for params
		$a = shortcode_atts( array(
	        'filter_by' => 'post_type',
	        'filter_value' => 'post',
	        'post__in' => null,
	        'posts_per_page' =>'3',
	        'orderby' => 'date', 'order' => 'DESC',
	        'class' => 'small-block-grid-3'
	    ), $atts );
		extract($a);
		$query = array();
		if (isset($a['filter_by']) && isset($a['filter_value'])) {
			array_push ($query , $a['filter_by'].'='.$a['filter_value']);
		}
		if (isset($a['posts_per_page'])) {
			$query['posts_per_page']= $a['posts_per_page'];
		}
		if (isset($a['orderby']) && isset($a['order'])) {
			$query['orderby'] = $a['orderby'];
			$query['order'] = $a['order'];
		}
		if (isset($a['post__in'])) {
			//  match tool to verify that $a['post__in'] matches  ([0-9],)* eg. 15,58,69 or 4 
			if  ( preg_match ('/^([0-9]*,)*[0-9]*$/',$a['post__in'] )) {
				$query['post__in'] = explode(',',$a['post__in']);	
			} else {
				$shortcode_msg[] = 'Le champ post__in n\'est pas défini correctement : il doit correspondre à une succession d\'ID séparés par des virgules : 15,8,9';
			}
			
		}
		
		ob_start();		
		if (isset($shortcode_msg )) {
			// Error display
			?> <div data-alert class="alert-box alert round">
			<?php foreach($shortcode_msg as $single_msg ) { ?>
				<p><?php echo $single_msg; ?></p>

			<?php }
			?> </div><?php
		} else {
			$loop = new WP_Query( $query );
			?>
			<ul class="<?php echo $class; ?>">
			<?php


			while ( $loop->have_posts() ) : $loop->the_post();

				?>
				<li><h2><a href="<?php the_permalink() ?>"><?php the_title();?></a></h2>
				<div class="entry-content">
				<?php strip_shortcodes(the_excerpt()); ?>
				</div></li>
				<?php
			endwhile;
			}
		}
	return ob_get_clean();
}

add_shortcode( 'loop', 'cornerstone_shortcode_miniloop' );





?>