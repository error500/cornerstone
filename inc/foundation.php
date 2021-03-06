<?php

// Foundation Framwork specific functions

// Add Foundation 'active' class for the current menu item
if ( ! function_exists( 'cornerstone_active_nav_class' ) ) {
	function cornerstone_active_nav_class( $classes, $item ) {
	    if ( $item->current == 1 || $item->current_item_ancestor == true ) {
	        $classes[] = 'active';
	    }
	    return $classes;
	}
}
add_filter( 'nav_menu_css_class', 'cornerstone_active_nav_class', 10, 2 );

/**
 * Use the active class of ZURB Foundation on wp_list_pages output.
 * From required+ Foundation http://themes.required.ch
 */
if ( ! function_exists( 'cornerstone_active_list_pages_class' ) ) {
	function cornerstone_active_list_pages_class( $input ) {

		$pattern = '/current_page_item/';
	    $replace = 'current_page_item active';

	    $output = preg_replace( $pattern, $replace, $input );

	    return $output;
	}
}
add_filter( 'wp_list_pages', 'cornerstone_active_list_pages_class', 10, 2 );

/**
 * class cornerstone_walker
 * Custom output to enable the the ZURB Navigation style.
 * Courtesy of Kriesi.at. http://www.kriesi.at/archives/improve-your-wordpress-navigation-menu-output
 * From required+ Foundation http://themes.required.ch
 */
class cornerstone_walker extends Walker_Nav_Menu {

	/**
	 * Specify the item type to allow different walkers
	 * @var array
	 */
	var $nav_bar = '';

	function __construct( $nav_args = '' ) {

		$defaults = array(
			'item_type' => 'li',
			'in_top_bar' => false,
		);
		$this->nav_bar = apply_filters( 'req_nav_args', wp_parse_args( $nav_args, $defaults ) );
	}

	function display_element( $element, &$children_elements, $max_depth, $depth=0, $args, &$output ) {

        $id_field = $this->db_fields['id'];
        if ( is_object( $args[0] ) ) {
            $args[0]->has_children = ! empty( $children_elements[$element->$id_field] );
        }
        return parent::display_element( $element, $children_elements, $max_depth, $depth, $args, $output );
    }

	function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0 ) {

		global $wp_query;
		$indent = ( $depth ) ? str_repeat( "\t", $depth ) : '';

		$class_names = $value = '';

		$classes = empty( $item->classes ) ? array() : (array) $item->classes;
		$classes[] = 'menu-item-' . $item->ID;

		// Check for flyout
		$flyout_toggle = '';
		if ( $args->has_children && $this->nav_bar['item_type'] == 'li' ) {

			if ( $depth == 0 && $this->nav_bar['in_top_bar'] == false ) {

				$classes[] = 'has-flyout';
				$flyout_toggle = '<a href="#" class="flyout-toggle"><span>toto</span></a>';

			} else if ( $this->nav_bar['in_top_bar'] == true ) {

				$classes[] = 'has-dropdown';
				$flyout_toggle = '';
			}

		}

		$class_names = join( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item, $args ) );
		$class_names = $class_names ? ' class="' . esc_attr( $class_names ) . '"' : '';

		if ( $depth > 0 ) {
			$output .= $indent . '<li id="menu-item-'. $item->ID . '"' . $value . $class_names .'>';
		} else {
			$output .= $indent . ( $this->nav_bar['in_top_bar'] == true ? '<li class="divider"></li>' : '' ) . '<' . $this->nav_bar['item_type'] . ' id="menu-item-'. $item->ID . '"' . $value . $class_names .'>';
		}

		$attributes  = ! empty( $item->attr_title ) ? ' title="'  . esc_attr( $item->attr_title ) .'"' : '';
		$attributes .= ! empty( $item->target )     ? ' target="' . esc_attr( $item->target     ) .'"' : '';
		$attributes .= ! empty( $item->xfn )        ? ' rel="'    . esc_attr( $item->xfn        ) .'"' : '';
		$attributes .= ! empty( $item->url )        ? ' href="'   . esc_attr( $item->url        ) .'"' : '';

		$item_output  = $args->before;
		$item_output .= '<a '. $attributes .'>';
		$item_output .= $args->link_before . apply_filters( 'the_title', $item->title, $item->ID ) . $args->link_after;
		$item_output .= '</a>';
		$item_output .= $flyout_toggle; // Add possible flyout toggle
		$item_output .= $args->after;

		$output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
	}

	function end_el( &$output, $item, $depth = 0, $args = array() ) {

		if ( $depth > 0 ) {
			$output .= "</li>\n";
		} else {
			$output .= "</" . $this->nav_bar['item_type'] . ">\n";
		}
	}

	function start_lvl( &$output, $depth = 0, $args = array() ) {

		if ( $depth == 0 && $this->nav_bar['item_type'] == 'li' ) {
			$indent = str_repeat("\t", 1);
    		$output .= $this->nav_bar['in_top_bar'] == true ? "\n$indent<ul class=\"dropdown\">\n" : "\n$indent<ul class=\"flyout\">\n";
    	} else {
			$indent = str_repeat("\t", $depth);
    		$output .= $this->nav_bar['in_top_bar'] == true ? "\n$indent<ul class=\"dropdown\">\n" : "\n$indent<ul class=\"level-$depth\">\n";
		}
  	}
}

// Add a class to the wp_page_menu fallback
if ( ! function_exists( 'foundation_page_menu_class' ) ) {
	function foundation_page_menu_class($ulclass) {
		return preg_replace('/<ul>/', '<ul class="nav-bar">', $ulclass, 1);
	}
}
add_filter('wp_page_menu','foundation_page_menu_class');


// Slider, for WordPress
// Previously was Orbit
add_action('init', 'Slider');
if ( ! function_exists( 'Slider' ) ) {
	function Slider() {
		$Slider_args = array(
			'label'	=> __('Slider (owl)'),
			'singular_label' =>	__('Slider'),
			'public'	=>	true,
			'show_ui'	=>	true,
			'capability_type'	=>	'post',
			'hierarchical'	=>	false,
			'rewrite'	=>	true,
			'supports'	=>	array('title', 'editor','page-attributes','thumbnail','custom-fields'),
			'taxonomies' => array('category','post_tag')
			);
			register_post_type('Slider', $Slider_args);
	}
}

add_action( 'add_meta_boxes', 'slider_meta_box_add' );
if ( ! function_exists( 'slider_meta_box_add' ) ) {
	function slider_meta_box_add() {
		add_meta_box( 'slider-meta-box-id', 'Additional slider slider options', 'slider_meta_box', 'slider', 'normal', 'high' );
	}
}

if ( ! function_exists( 'slider_meta_box' ) ) {
	function slider_meta_box( $post ) {
		$values = get_post_custom( $post->ID );
		$caption = isset( $values['_slider_meta_box_caption_text'] ) ? esc_attr( $values['_slider_meta_box_caption_text'][0] ) : '';
		$link = isset( $values['_slider_meta_box_link_text'] ) ? esc_attr( $values['_slider_meta_box_link_text'][0] ) : '';
		wp_nonce_field( 'slider_meta_box_nonce', 'meta_box_nonce' );
		?>
		<p>
			<label for="_slider_meta_box_caption_text">Caption</label>
			<textarea id="slider_meta_box_caption_text" class="widefat" name="_slider_meta_box_caption_text"><?php echo esc_attr( $caption ); ?></textarea>
		</p>
		<p>
			<label for="_slider_meta_box_link_text">Link</label>
			<input type="text" id="slider_meta_box_link_text" class="widefat" name="_slider_meta_box_link_text" value="<?php echo $link; ?>" />
		</p>
		<?php
	}
}

add_action( 'save_post', 'slider_meta_box_save' );
if ( ! function_exists( 'slider_meta_box_save' ) ) {
	function slider_meta_box_save( $post_id ) {
		// Bail if we're doing an auto save
		if( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return;
		
		// if our nonce isn't there, or we can't verify it, bail
		if( !isset( $_POST['meta_box_nonce'] ) || !wp_verify_nonce( $_POST['meta_box_nonce'], 'slider_meta_box_nonce' ) ) return;
		
		// if our current user can't edit this post, bail
		if( !current_user_can( 'edit_post' ) ) return;
		
		// now we can actually save the data
		$allowed = array( 
			'a' => array( // on allow a tags
				'href' => array() // and those anchords can only have href attribute
			)
		);
		
		// Probably a good idea to make sure your data is set
		if( isset( $_POST['_slider_meta_box_caption_text'] ) )
			update_post_meta( $post_id, '_slider_meta_box_caption_text', wp_kses( $_POST['_slider_meta_box_caption_text'], $allowed ) );
		if( isset( $_POST['_slider_meta_box_link_text'] ) )
			update_post_meta( $post_id, '_slider_meta_box_link_text', wp_kses( $_POST['_slider_meta_box_link_text'], $allowed ) );
	}
}



/* Call OrbitSlider with no parameters. OrbitSlider was previously SliderContent.
Reduces errors on child themes not yet updated.
To be depreciated in a future version */
if ( ! function_exists( 'SliderContent' ) ) {
	function SliderContent() {
		SliderSlider();
	}
}

?>