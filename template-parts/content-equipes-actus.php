<?php





/**





 * Template part for displaying posts





 *





 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/





 *





 * @package pro-league





 */





$site = get_field('site_web');





$description = get_field('presentation'); 





$directeur = get_field('directeur'); 





$couleur1 = get_field('couleur1'); 





$style_couleur1=($couleur1)?'style="background: '.$couleur1.';"':'style="background: #e5332a;"';



$image=get_field('logo_principal')?get_field('logo_principal'):get_the_post_thumbnail_url($post->ID,"thumbnail");

$couleur2 = get_field('couleur2'); 





$style_couleur2=($couleur2)?'style="background: '.$couleur2.';"':'style="background: #990021;"';





$entraineur = get_field('entraineur'); 





$date_creation = get_field('date_de_creation'); 





$reseaux= get_field('reseaux_sociaux');





$palmares = get_field('palmares');





$galerie_photos = get_field('galerie_photos');





$gender=  get_field('genre');

$current_fp = get_query_var('fpage');

$team_permalink = get_the_permalink($post->ID);



?>











<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>



<header class="nv.team-header">

<section class="nv-header-team" <?php echo $style_couleur1;?>>
    <div class="container">

        <div class="nv-logo-team-1" style="background-image:url(<?php echo (get_field('logo_principal'))?get_field('logo_principal'):get_the_post_thumbnail_url($post->ID)?>)">
        </div>
            <h2 class="blanc mrg-0 fs-30"><?php echo get_the_title();?></h2> 
        <?php if($site){?><a class="site-team-blanc" target="_blank"  href="<?php echo $site;?>"><?php echo str_replace("/","",str_replace("https://","",$site));?></a><?php }?> 
    </div>
</section>
<section class="nv-header-nav" <?php echo $style_couleur2;?>>

    <div class="container">

        <div class="nv-nav">

            <a href="<?php echo $team_permalink;?>infos" class="team-link">Infos générales</a>

            <a href="<?php echo $team_permalink;?>actus" class="team-link  nvtl-active ">Actualités</a>

            <a href="<?php echo $team_permalink;?>photos" class="team-link">Photos</a>

            <a href="<?php echo $team_permalink;?>videos" class="team-link">Vidéos</a>

            <a href="<?php echo $team_permalink;?>calendrier_resultats" class="team-link">Calendrier / Résultats</a>

            <a href="<?php echo $team_permalink;?>judokas" class="team-link">Judokas</a>

            <div class="nv-eqip-rs">

                <?php  if($reseaux){

                    foreach($reseaux as $rs){

                        $rs_link=$rs['lien_page'];

                        if($rs["type"]=="Facebook"){

                            echo '<a href="'.$rs_link.'" target="_blank"><i class="fa-brands fa-square-facebook"></i></a>';

                        }

                        elseif($rs["type"]=="Instagram"){

                            echo '<a href="'.$rs_link.'" target="_blank"><i class="fa-brands fa-instagram"></i></a>';

                        }

                        elseif($rs["type"]=="Tiktok"){

                            echo '<a href="'.$rs_link.'" target="_blank"><i class="fa-brands fa-tiktok"></i></a>';						}

                        elseif($rs["type"]=="YouTube"){

                            echo '<a href="'.$rs_link.'" target="_blank"><i class="fa-brands fa-youtube"></i></a>';

                        }

                        elseif($rs["type"]=="Twitter"){

                            echo '<a href="'.$rs_link.'" target="_blank"><i class="fa-brands fa-twitter"></i></a>';

                        }

                    }

                }?>

            </div>

        </div>

    </div>

</section>

       

	</header>

		<div id="">

			

  



	<div id="tabs-6">

		<?php 

$args=array(
	'post_type'=> 'post',
	'posts_per_page' => -1,
	'orderby' => 'post_date', 
	'order' => 'DESC',
	'meta_query' => array(
	'relation' => 'AND',
		array(
		'key' => 'equipes', // recherche sur le champ équipe de type relation
		'value' => '"' . get_the_ID() . '"', // id de l'équipe
		'compare' => 'LIKE'
		)
	),
);
$news=get_posts($args);

?>



       

	<?php //var_dump($news);?>

    <section class="section-bloc-articles">

            <div class="news-2-col">

            <?php 

                if( $news ): 

                    foreach( $news as $my_post ): 

						$video   = get_field('videos_a_la_une');

						$video = get_field( "videos_a_la_une", $my_post->ID );

                        $img= get_the_post_thumbnail_url($my_post->ID,'full');

                        $url_externe=get_field('activer_lien_poule', $my_post->ID);

                        if($url_externe=='Activer'){ 

                            $url=get_field('lien_classement', $my_post->ID);

                        }

                        else{

                            $url=get_permalink($my_post->ID);

                        }

                        $content = $my_post->post_content;

                        $excerpt = substr($content, 0, 230);

                    ?>

                    <div class="display-news-2-col">

						<?php if($video==null){?><a href="<?= $url; ?>" class="news-link-2-col"><?php }?>

                        <div class="news-img-2-col" style="background-image: url(<?= $img; ?>);">

							<?php

							    if($video!=null){

									$id = explode('watch?v=', $video)[1];//https://www.youtube.com/watch?v=EBmDX7MNHSI

									echo '<div class="video video-grande-taille">'.

                    do_shortcode('[video_lightbox_youtube video_id="'.$id.'" width="640" height="480" anchor="'.get_site_url().'/wp-content/uploads/2022/11/play.webp"]').

                '</div>';

							echo '<div class="video video-mobile">'.

                    do_shortcode('[video_lightbox_youtube video_id="'.$id.'" width="300" height="160" anchor="'.get_site_url().'/wp-content/uploads/2022/11/play.webp"]').

                '</div>';?>

								<?php

								}

							?>

						</div>

						<?php if($video==null){ ?></a><?php }?>

                        <div class="nv-right-content">

                            <a href="<?= $url; ?>" class="news-link-2-col"><h3 class="nv-title-news-3-col"><?= $my_post->post_title?></h3></a>

                            <span><?php $date=get_the_date('j F Y', $my_post->ID ); echo $date; ?></span>

                        </div>

                    </div>

<?php endforeach; ?>

<?php endif; ?>        

</div>

</section>

  </div>

	





  </div>







		<?php





			if($palmares){





		?>





		<div class="palmares">





            <h2>Palmarès</h2>





            <?php 





            foreach($palmares as $palma){





                echo '<p class="p-palmares">'.$palma["championnat"].'</p>';





            }}





            ?>





        </div>





		



	</div><!-- .entry-content -->





	





	<?php 





		$args=array(





			'post_type'=> 'equipes',





			'posts_per_page' => -1





		);





		$liste_equipes=get_posts($args);





	?>









    <?php





            while (have_rows('liste_des_partenaires'))





    {





        the_row();





        $style=get_row_layout();





        //site_debug("style=$style");





        $section=false;





        switch($style)





        {    





            case 'partenaires':





            require_once (THEMEDIR.'inc/acf-blocs/bloc-partenaires.php');





            $section=bloc_partenaires();





            break;





        }





    }





    ?>





	





</article>





