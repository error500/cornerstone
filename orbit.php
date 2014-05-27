
<div class="row">
	<div id="primary" class="site-content small-12 medium-12 large-12 columns large-centered">
		<div id="content" role="main">
			<?php 

			$args = array( 'post_type' => 'Orbit');
			$loop = new WP_Query( $args );

			if($orbitparam != '') {
				echo '<ul data-orbit data-options="' . $orbitparam . '">';
			} else {
				echo '<ul data-orbit>';
			}

				while ( $loop->have_posts() ) : $loop->the_post();

					if(has_post_thumbnail()) {

						if($orbitsize != '') {
							$orbitimagethumbnail = wp_get_attachment_image_src( get_post_thumbnail_id(), $orbitsize);
							$orbitimage = $orbitimagethumbnail['0'];
						} else {
							$orbitimagefull = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), 'thumbnail_size');
							$orbitimage = $orbitimagefull['0'];
						}
						$orbitimagealttext = get_post_meta(get_post_thumbnail_id($post->ID), '_wp_attachment_image_alt', true);
						$orbitcaption = get_post_meta(get_the_ID(), '_orbit_meta_box_caption_text', true );
						$orbitlink = get_post_meta(get_the_ID(), '_orbit_meta_box_link_text', true );
						echo '<li>';
						if($orbitlink != '') {echo '<a href="' . $orbitlink . '">';}
						echo '<img src="'. $orbitimage . '" alt="' . $orbitimagealttext . '"/>';
						if($orbitcaption != '') {echo '<div class="orbit-caption">' . $orbitcaption . '</div>';}
						if($orbitlink != '') {echo '</a>';}
						echo '</li>';

					} else {

						echo '<li><h2>';
						the_title();
						echo '</h2>';
						the_content();
						echo '</li>';

					}

				endwhile;

				echo '</ul>';

			 ?>
		</div>
	</div>
</div>

<?php get_footer(); ?>