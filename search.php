<?php
/**
 * The template for displaying search results pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#search-result
 *
 * @package pro-league
 */

function get_label($slug){
	switch ($slug) {
		case 'rencontre':
			return "Rencontres";
			break;
		case 'judo_pro_league':
			return "Phases de la compétition";
			break;
		case 'video_youtube':
			return "Vidéos";
			break;
		case 'post':
			return "Articles";
			break;
		case 'page':
			return "Pages du site";
			break;
		case 'judoka':
			return "Judokas";
			break;
		case 'galerie':
			return "Galeries";
			break;
		case 'equipes':
			return "Équipes";
			break;
		default:
			return "Autres";
			break;
	}
}
get_header();
?>
<main id="primary" class="site-main section-bloc-articles section-a-la-une">

<?php if ( have_posts() ) : ?>

	<header class="page-header">
		<h1 class="result-h1">
			<?php
			/* translators: %s: search query */
			printf( esc_html__( 'Search Results for: %s', 'pro-league' ), '<span>' . get_search_query() . '</span>' );
			?>
		</h1>
	</header><!-- .page-header -->

	
		<?php
		// Initialize an array to store posts by post type
		$posts_by_type = array();

		/* Start the Loop */
		while ( have_posts() ) : the_post();
			// Get the post type
			$post_type = get_post_type();

			// Initialize the array for this post type if not already done
			if ( ! isset( $posts_by_type[ $post_type ] ) ) {
				$posts_by_type[ $post_type ] = array();
			}

			// Add the post to the array for this post type
			$posts_by_type[ $post_type ][] = $post->ID;

		endwhile;

		// Loop through the array and display the posts by post type
		foreach ( $posts_by_type as $post_type => $posts ) {
			echo '<h3 class="nv-tableau-final-subtitle tab-phase tab-act2 px-40 title-mobile">' . get_label( esc_html($post_type) ) . '</h3>';
			echo '<div class="search-results-box">';
			foreach ( $posts as $post_id ) {
				// Set up the post data
				$post = get_post( $post_id );
				setup_postdata( $post );

				// Display the post
				get_template_part( 'template-parts/content', 'search' );
			}
			echo '</div>';
			wp_reset_postdata(); // Reset the global post object
		}
		?>
	

	<?php the_posts_navigation();

else :

	get_template_part( 'template-parts/content', 'none' );

endif;
?>

</main><!-- #primary -->

<?php
get_sidebar();
get_footer();


