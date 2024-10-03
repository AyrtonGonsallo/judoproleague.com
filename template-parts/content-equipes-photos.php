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
        <?php if($site){?><a class="site-team-blanc" target="_blank" href="<?php echo $site;?>"><?php echo str_replace("/","",str_replace("https://","",$site));?></a><?php }?> 
    </div>
</section>
<section class="nv-header-nav" <?php echo $style_couleur2;?>>

    <div class="container">

        <div class="nv-nav">

            <a href="<?php echo $team_permalink;?>infos" class="team-link">Infos générales</a>

            <a href="<?php echo $team_permalink;?>actus" class="team-link">Actualités</a>

            <a href="<?php echo $team_permalink;?>photos" class="team-link  nvtl-active ">Photos</a>

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



			



  







	<div id="tabs-6" class="page-eq-phot">



		<?php 











					











						$args=array(
						'post_type'=> 'galerie',
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
					$galeries=get_posts($args);











					











					











					//var_dump($images);exit(-1);











					if($galeries):











					?>











						











							



















							










		<div class="galerie-images-resultat"><div class="liste-images-galerie judo_pro_league" >
			<?php  //var_dump($images);exit(-1);

				foreach ($galeries as $image_galerie):
					$photos=get_field('photos',$image_galerie->ID);
					$credit_images = get_field('credit_images',$image_galerie->ID);
					$titre = get_field('titre',$image_galerie->ID);
					$cover=$photos[0];
					$link=get_the_permalink($image_galerie->ID);
			?>
					
						
							<a href="<?php echo $link;?>">		
								<div class="liste-images-element" style="background-image: url(<?php echo '\''.esc_url($cover['sizes']['medium_large']).'\'';?>);">
									
									
								</div>
								<h2 class="nv-title-news-3-col">
										<?php echo $titre.' - '. get_the_date('Y', $image_galerie->ID);?>
								</h2>
							</a>		
						
					
			<?php endforeach;?></div>
		</div>










				











					<?php 











					











					endif;?>











	</div><!-- .entry-content -->



    



  </div>



	











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











