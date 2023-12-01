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











$args=array('post_type'=> 'video_youtube','posts_per_page' => -1,'order' => 'ASC','orderby' => 'title',	'meta_query' => array(



'relation' => 'AND',



array(



'key' => 'equipe1', // recherche sur le champ équipe de type relation



'value' => '"' . get_the_ID() . '"', // id de l'équipe



'compare' => 'LIKE'



)



),



);



$videos=get_posts($args);



$img="http://iwtilfy.cluster027.hosting.ovh.net/wp-content/uploads/2022/12/image00011.webp";











$gender=  get_field('genre');



$current_fp = get_query_var('fpage');



$team_permalink = get_the_permalink($post->ID);







?>























<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>







<header class="nv.team-header">



		<section class="nv-header-team" <?php echo $style_couleur1;?>>



			<div class="container">



				<div class="nv-logo-team">



					<img src="<?php echo $image;?>">



				</div>



			</div>



		</section>



<section class="nv-header-nav" <?php echo $style_couleur2;?>>







        <div class="container">







            <div class="nv-nav">







                <a href="<?php echo $team_permalink;?>infos" class="team-link ">Infos générales</a>







                <a href="<?php echo $team_permalink;?>actus" class="team-link">Actualités</a>







                <a href="<?php echo $team_permalink;?>photos" class="team-link">Photos</a>







                <a href="<?php echo $team_permalink;?>videos" class="team-link nvtl-active">Vidéos</a>







                <a href="<?php echo $team_permalink;?>calendrier_resultats" class="team-link">Calendrier / Résultats</a>







                <a href="<?php echo $team_permalink;?>judokas" class="team-link">Judokas</a>



            </div>







        </div>







    </section>



       



	</header>



		<div id="">



			<div  class="blog site-main liste-videos judo_pro_league">

                <div class="team-videos">

                    <?php foreach ($videos as $video_object):



                    $video=get_field('video_url', $video_object->ID);



                    $id=get_field('id', $video_object->ID);



                    $date_dajout=get_the_date('j F Y', $video_object->ID );



                    $titre=get_field('titre', $video_object->ID);



                    $image_url=(get_field('image', $video_object->ID))?get_field('image', $video_object->ID):$img;



                    ?>



                    <div class="single-video-team">



                        <div class="news-img-2-col" style="background-image: url(<?php echo $image_url; ?>);">



                            <?php echo '<div class="video video-grande-taille">'.do_shortcode('[video_lightbox_youtube video_id="'.$id.'" width="640" height="480" anchor="'.get_site_url().'/wp-content/uploads/2022/11/play.webp"]').'</div>';



                            echo '<div class="video video-mobile">'.do_shortcode('[video_lightbox_youtube video_id="'.$id.'" width="300" height="160" anchor="'.get_site_url().'/wp-content/uploads/2022/11/play.webp"]').'</div>';



                            ?>



                        </div>



                        <div class="content-article">



                            <header class="entry-header news-content">



                            <h3 class="title-news-singular"><?php echo $titre;?></h3><span><?php echo $date_dajout;?></span>



                            </header>

                        </div>



                    </div>



                        <?php endforeach; ?>



            </div>

    </div>



  







	<div id="tabs-6">



		



    



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











