<?php
/**
 * Template part for displaying posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package pro-league
 */
?>
<?php 
	$args=array(
		'post_type'=> 'rencontre',
		'posts_per_page' => -1,
		'meta_key' => 'date_de_debut',
		'orderby' => 'meta_value_num',
		'order' => 'DESC',
		'meta_query' => array(
			'relation' => 'AND',
			array(
				'key' => 'phase', // recherche sur le champ équipe de type relation
				'value' => '"' . get_the_ID() . '"', // id de l'équipe
				'compare' => 'LIKE'
			)
		),
	);
	$rencontres=get_posts($args);
	
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
			<?php		
				$texte_descriptif = get_field( "texte_descriptif");
			 ?>
				<div class="tab-pane fade show active " id="<?= str_replace(" ","-",$poule);?>" role="tabpanel" aria-labelledby="<?= str_replace(" ","-",$poule);?>-tab" tabindex="0">
					
					
				
					<div class="accordion" id="accordionExample">
						<?php echo $texte_descriptif;?>
					</div>
					
					<!-- fin galerie d'images-->
				
	</div><!-- .entry-content -->
</article>