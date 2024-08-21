<?php
/**
 * Template part for displaying posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package pro-league
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

	<header class="result-header">
		<?php
        $mypost = get_post($post->ID);
		$args = array(
            'post_type' => 'judo_pro_league',
            'post_status' => 'publish',
            'posts_per_page' => '16'
        );
        $poule_loop = new WP_Query( $args );
		$poule=get_the_title($post->ID);
		$lieu = get_field('lieu');	
		echo '<div class="info-team">';
            if ( is_singular() ) :
							
                echo '<h1 class="result-h1">Résultats de la judo pro league 2022</h1>';
			
				
				echo '<span class="lieu">'.$poule.'</span>';
				echo '<h2 class="titre-lieu">'.$lieu.'</h2>';
            else :
                the_title( '<h2 class="team-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' );
				
            endif;
        echo '</div>';
        ?> 
       
	</header>
    <?php
        $args = array(
            'post_type' => 'judo_pro_league',
            'post_status' => 'publish',
            'posts_per_page' => '16'
        );
        $poule_loop = new WP_Query( $args );
		?>
		<div class="result-content">
			
	</div><!-- .entry-content -->
</article>