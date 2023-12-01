<?php



/**

 * Template Name: Modèle equipe

 */



get_header();

$titlebar   = get_field('header_de_la_page');

$title   = get_field('titre_de_la_page');

?>



<main id="primary" class="site-main home">

    <section class="listes-equipes">

        <div>

            <h1 class="h1-equipes"><?= $title; ?></h1>

        </div>

		<div class="img-fr">

			<img src="https://judoproleague.com/wp-content/uploads/2023/07/JPL-EQUIPES.webp">

		</div>

        <div class="team-4-col">

        <?php 

		$args=array(

			'post_type'=> 'equipes',

			'posts_per_page' => -1

		);

		$liste_des_equipes=get_posts($args);

	?>

            <?php 

                if( $liste_des_equipes ): 

                    foreach( $liste_des_equipes as $lde ): 

						$img= get_the_post_thumbnail_url($lde->ID,'thumbnail');

                        $url=get_permalink($lde->ID);

                        $title=get_the_title($lde->ID);

			?>

            <div class="equipe">

                <a href="<?= $url;?>">

                    <h3 class="text-white"><?= $title;?></h3>

                </a>

            </div>

            <?php 

                endforeach;    

                endif; 

            ?>

        </div>

    </section>



    <?php

   

get_footer();

?>