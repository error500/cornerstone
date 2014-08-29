
<div class="row">
	<div id="primary" class="site-content small-12 columns small-centered">
		<div id="content" role="main">
			<?php 
			// load Foundation initialisation script in footer
			if ( ! function_exists( 'cornerstone_owl_init' ) ) {
			 function cornerstone_owl_init() { ?>
			 	<script type="text/javascript">
				jQuery('.owl-carousel').owlCarousel({
					    loop:true,
					    margin:10,
					    nav:false,
					    autoplay:true,
						autoplayTimeout:5000,
					    responsive:{
					        0:{
					            items:1
					        },
					        600:{
					            items:1
					        },
					        1000:{
					            items:1
					        }
					    }
					});
			
			 	</script>
			 <?php }
			}
			add_action( 'wp_footer', 'cornerstone_owl_init', 9997 );
			
			$args = array( 'post_type' => 'Orbit');
			$loop = new WP_Query( $args );
			echo '<div class="owl-carousel">';
		
			while ( $loop->have_posts() ) : $loop->the_post();

				if(has_post_thumbnail()) {

					if($owlsize != '') {
						$owlimagethumbnail = wp_get_attachment_image_src( get_post_thumbnail_id(), $owlsize);
						$owlimage = $owlimagethumbnail['0'];
					} else {
						$owlimagefull = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), 'thumbnail_size');
						$owlimage = $owlimagefull['0'];
					}
					$owlimagealttext = get_post_meta(get_post_thumbnail_id($post->ID), '_wp_attachment_image_alt', true);
					$owlcaption = get_post_meta(get_the_ID(), '_owl_meta_box_caption_text', true );
					$owllink = get_post_meta(get_the_ID(), '_owl_meta_box_link_text', true );
					echo '<div class="item">';
						if($owllink != '') {echo '<a href="' . $owllink . '">';}
						echo '<img src="'. $owlimage . '" alt="' . $owlimagealttext . '"/>';
						if($owlcaption != '') {echo '<div class="owl-caption">' . $owlcaption . '</div>';}
						if($owllink != '') {echo '</a>';}
					echo '</div>'."\n";

				} else {

					echo '<div class="item"><h2>';
					the_title();
					echo '</h2>';
					the_content();
					echo '</div>';

				}
			endwhile;

			echo '</div>';

			 ?>
		</div>
	</div>
</div>

