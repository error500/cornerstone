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
		'class' =>'small-12 medium-12 large-6 columns small-centered large-uncentered'
 	), $atts ) );
	
	$retval .='<div class="row"><div class="'.$class.'">';
	if ($type=='youtube' && $code!="undefined") {
		$retval .='<div class="flex-video">';
		$retval .='<iframe "width="420" height="315" src="http://www.youtube.com/embed/' . $code . '" frameborder="0" allowfullscreen></iframe></div>';
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
*		'class' => 'small-block-grid-1,medium-block-grid-3'
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
	        'class' => 'small-block-grid-1,medium-block-grid-3'
	    ), $atts );
		extract($a);
		$query = array();
		if (isset($a['filter_by']) && isset($a['filter_value'])) {
			$query[$a['filter_by']]=$a['filter_value'];
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
		if (isset($a['class'])) {
			
			//  match tool to verify that $a['class'] matches  ([0-9],)* eg. foo  or foo,bar
			if  ( preg_match ('/^([0-9a-z-]*,)*[0-9a-z-]*$/',$a['class'] )) {
				$class = str_replace(',',' ', $a['class']);
			} else {
				$shortcode_msg[] = 'Le champ class n\'est pas défini correctement : il doit correspondre à une succession de classes séparées par des virgules : 15,8,9';
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
			<section class="cs_section"><ul class="<?php echo $class; ?>">
			<?php


			while ( $loop->have_posts() ) : $loop->the_post();
				?><li><article class="cs_article">
				<?php if ( has_post_thumbnail() ) {?>
					<header><a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>" >
					<?php the_post_thumbnail('large'); ?>
					</a></header>
				<?php } ?>
				<h2><a href="<?php the_permalink() ?>"><?php the_title();?></a></h2><?php edit_post_link('Edit','','<strong>|</strong>'); ?>  
				<div class="cs_excerpt">
				<?php strip_shortcodes(the_excerpt()); ?>
				</div></article></li>
				<?php
			endwhile;
			?></ul></section>
			<?php
			wp_reset_postdata();

			}
		}
	$content = ob_get_contents();
	ob_end_clean();
	return $content;
}

add_shortcode( 'loop', 'cornerstone_shortcode_miniloop' );


/**
*	Short code for creating a serie of tabs
*	Based on foundation tabs syntax
*   params :
* 	Codex params see http://codex.wordpress.org/wp_query
* 		id : an id : needed if you use more than one tab system in a page
*		tab_list : tab list, seprated by comma
*		active : the name of the active tab
*	Foundation params:
*		class : %TODO% not implemented yet
*
*	Example ;
*		[tab id="le nom de l'onglet"  isactive=true] content of tab toto[/tab]
*		[tab id="le nom de l'onglet2"] content of tab tutu[/tab]
*		[tab id="le nom de l'onglet3" islast=true] content of tab tata[/tab]
*
*  default values 
*		'id'=>'name of tab',
*       'tab_list' => 'tab1,tab2,tab3,tab4',
*       'active' => ''
*/

function cornerstone_shortcode_tabs ($atts,$content) {
	global $cornerstone_displaying_tabs ;
	global $cornerstone_tabs ;

	//Default value for params
	$a = shortcode_atts( array(
        'id' =>'',
        'isactive'=>'',
        'islast'=>''
    ), $atts );
	extract($a);

	if (!isset($cornerstone_tabs)) {
		$cornerstone_tabs=array();
	} 

	$current_tab['id'] = $id;
	$current_tab['content'] = $content;
	$current_tab['isactive'] = $isactive;
	$current_tab['islast'] = $islast;
	$cornerstone_tabs[] = $current_tab;
	
	$render ="";
	if($islast) {
		//HTML rendering on last tab only
		ob_start();		
		?>	
		<ul class="tabs" data-tab>
			<?php 
			$i=0;
			foreach($cornerstone_tabs as $tab) { ?>
				<li class="tab-title<?php echo ($tab['isactive']==true)? ' active ' : '' ?>"><a href="#<?php echo $id.'-'.$i;?>"><?php echo $tab['id'];?></a></li>
				<?php 
				$i++;
			} ?>
		</ul>
		<div class="tabs-content">
			<?php 
			$i=0;
			foreach($cornerstone_tabs as $tab) { ?>
				<div class="content<?php echo ($tab['isactive']==true)? ' active ' : '' ?>" id="<?php echo $id.'-'.$i;?>"><p><?php echo do_shortcode($tab['content'])?></p></div>
				<?php
				$i++;
			} ?>
		</div>
		<?php
		$render = ob_get_contents();
		ob_end_clean();
		$cornerstone_tabs=array();
	}
	return $render;
}	

add_shortcode( 'tab', 'cornerstone_shortcode_tabs' );

/**
*	Short code for creating a serie of colums
*	Based on foundation columns syntax
*   params :
* 	foundation params see http://codex.wordpress.org/wp_query
* 		class : class for columns (see zurb foundation doc)
*		status : first|null|last tells if the columns is the first, the last or any one inside (null)
*
*	Example ;
*		[column status=first class="small-4"] The content of the first column[/column]
*		[column class="small-4"] The content of the second column[/column]
*		[column status=last class="small-4"] The content of the third column[/column]
*
*  default values 
*       'class' => 'small-12 medium-4'
*/

function cornerstone_shortcode_columns ($atts,$content) {

	//Default value for params
	$a = shortcode_atts( array(
        'class' =>'small-12 medium-4',
        'status'=>''
    ), $atts );
	extract($a);

	$render ="";

	//HTML rendering on last tab only
	ob_start();		
	echo ($status=='first')? ' <div class="row"> ' : '' ;
	echo '<div class="'.$class.' columns">'.do_shortcode($content).'</div>' ;
	echo ($status=='last')? ' </div> ' : '' ;
		
	$render = ob_get_contents();
	ob_end_clean();
	
	return $render;
}	
	
add_shortcode( 'column', 'cornerstone_shortcode_columns' );



/**
*	Short code for creating a grid
*	Based on foundation grid syntax
*   params :
* 	foundation params see http://codex.wordpress.org/wp_query
* 		class : class for grid (see zurb foundation doc)
*		status : first|null|last tells if the columns is the first, the last or any one inside (null)
*
*	Example ;
*		[grid status=first class="small-4"] The content of the first grid[/grid]
*		[grid class="small-block-grid-2 medium-block-grid-3 large-block-grid-4"] The content of the second grid[/grid]
*		[grid status=last class="small-4"] The content of the third grid[/grid]
*
*  default values 
*       'class' => 'small-12 medium-4'
*/

function cornerstone_shortcode_grid ($atts,$content) {

	//Default value for params
	$a = shortcode_atts( array(
        'class' =>'small-block-grid-2 medium-block-grid-3 large-block-grid-4',
        'status'=>''
    ), $atts );
	extract($a);

	$render ="";

	//HTML rendering on last tab only
	ob_start();		
	echo ($status=='first')? '<ul class="'.$class.'">' : '' ;
	echo '<li>'.do_shortcode($content).'</li>' ;
	echo ($status=='last')? ' </ul> ' : '' ;
		
	$render = ob_get_contents();
	ob_end_clean();
	
	return $render;
}	
	
add_shortcode( 'grid', 'cornerstone_shortcode_grid' );

/**
*	Short code for creating a magellan sticky nav bar
*	Based on foundation magellan syntax
*   params :
* 	foundation params see http://codex.wordpress.org/wp_query
*		no params available
*	Example ;
*		[magellan_bar anchor_list=anchor-1,anchor-2,anchor-3]
*  default values 
*		no default values
*/

function cornerstone_shortcode_magellan_bar ($atts,$content) {
	global $cornerstone_magellan;
	if (!isset($cornerstone_magellan)) {
		wp_enqueue_script(
			'magellan.foundation_js',
			get_template_directory_uri() . '/libs/foundation/js/foundation/foundation.magellan.js',
			array('foundation_js'),
			'5.3.0',
			true
		);
		$cornerstone_magellan = 'loaded';
	}
	//Default value for params
	$a = shortcode_atts( array(
        'anchor_list' =>'anchor-1,anchor-2,anchor-3'
    ), $atts );
	extract($a);
	$anchors =explode(',',$anchor_list);
	ob_start();		
	?>
	<div data-magellan-expedition="fixed"><dl class="sub-nav">
		<?php foreach($anchors as $anchor) { 
			echo '<dd data-magellan-arrival="'.$anchor.'"><a href="#'.$anchor.'">'.$anchor.'</a></dd>';
		} ?>
	</dl></div>
	<?php
	$render = ob_get_contents();
	ob_end_clean();
	
	return $render;
}
add_shortcode( 'magellan_bar', 'cornerstone_shortcode_magellan_bar' );
/**
*	Short code for creating a magellan sticky nav
*	Based on foundation magellan syntax
*   params :
* 	foundation params see http://codex.wordpress.org/wp_query
*		no params available
*	Example ;
*		[magellan] First[/magellan]
*		[magellan] second[/magellan]
*		[magellan] last[/magellan]
*  default values 
*		no default values
*/

function cornerstone_shortcode_magellan ($atts,$content) {
	
	//Default value for params
	
	global $cornerstone_magellan;
	if (!isset($cornerstone_magellan)) {
		
		echo "you should add [magellan_bar anchor_list=anchor-1,anchor-2,anchor-3]";
	}
	$render ="";

	
	ob_start();		
	echo '<h3 data-magellan-destination="'.$content.'">'.$content.'</h3><a name="'.$content.'"></a>' ;
		
	$render = ob_get_contents();
	ob_end_clean();
	
	return $render;
}	
	
add_shortcode( 'magellan', 'cornerstone_shortcode_magellan' );



/**
*	Short code for creating a clearing  clearing (gallery)
*	Based on foundation clearing syntax
*   params :
* 	foundation params see http://codex.wordpress.org/wp_query
* 		class : class for grid (see zurb foundation doc)
*		status : first|null|last tells if the columns is the first, the last or any one inside (null)
*
*	Example ;
*		[clearing status=first path=http://lorempixel.com/400/200/sports/ caption=sport1 paththumb=http://lorempixel.com/30/30/sports/ ]
*		[clearing  path=http://lorempixel.com/400/200/sports/ caption=sport1 paththumb=http://lorempixel.com/30/30/sports/ ]
*		[clearing status=last path=http://lorempixel.com/400/200/sports/ caption=sport1 paththumb=http://lorempixel.com/30/30/sports/ ]
*  default values 
*       no deafult class
*/

function cornerstone_shortcode_clearing ($atts,$content) {
	global $cornerstone_clearing;
	if (!isset($clearing)) {
		wp_enqueue_script(
			'clearing.foundation_js',
			get_template_directory_uri() . '/libs/foundation/js/foundation/foundation.clearing.js',
			array('foundation_js'),
			'5.3.0',
			true
		);
		$clearing = 'loaded';
	}
	//Default value for params
	$a = shortcode_atts( array(
        'path' =>'lorempixel.com/400/200/sports/',
        'paththumb'=>'lorempixel.com/30/30/sports/',
        'caption' => 'default text',
        'status'=>''
    ), $atts );
	extract($a);

	$render ="";

	//HTML rendering on last tab only
	ob_start();		
	echo ($status=='first')? '<ul class="clearing-thumbs" data-clearing>' : '' ;
	echo '<li><a href="'.$path.'"><img data-caption="'.$caption.'" src="'.$paththumb.'"></a></li>';
	echo '<li>'.do_shortcode($content).'</li>' ;
	echo ($status=='last')? ' </ul> ' : '' ;
		
	$render = ob_get_contents();
	ob_end_clean();
	
	return $render;
}	
	
add_shortcode( 'clearing', 'cornerstone_shortcode_clearing' );

add_action( 'init', 'cornerstone_buttons' );

function cornerstone_buttons() {
    add_filter( "mce_external_plugins", "cornerstone_add_buttons" );
    add_filter( 'mce_buttons', 'cornerstone_register_buttons' );
}
function cornerstone_add_buttons( $plugin_array ) {
	$plugin_array['cornerstone_buttons'] = get_bloginfo ('template_url').'/js/tinymcebuttons.js' ;
     return $plugin_array;
    
}
function cornerstone_register_buttons( $buttons ) {
    array_push( $buttons, 'cornerstone_column' , 'cornerstone_magellan'); 
    return $buttons;
}

?>