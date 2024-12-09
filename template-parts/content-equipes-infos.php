<?php






date_default_timezone_set('Europe/Paris');




get_header();

$saison_value=($_GET["saison_value"])?$_GET["saison_value"]:"2024-2025";

$titlebar   = get_field('header_de_la_page');



$title   = get_field('titre_de_la_page');



$site = get_field('site_web');



$this_team = get_post($post->ID);







$description = get_field('presentation'); 




$premiere_galerie = get_field('galerie_photos'); 






$directeur = get_field('directeur'); 





$saisons = get_field('saisons'); 





$couleur1 = get_field('couleur1'); 











$style_couleur1=($couleur1)?'style="background: '.$couleur1.';"':'style="background: #e5332a;"';





$image=get_field('logo_principal')?get_field('logo_principal'):get_the_post_thumbnail_url($post->ID,"thumbnail");



$couleur2 = get_field('couleur2'); 











$style_couleur2=($couleur2)?'style="background: '.$couleur2.';"':'style="background: #990021;"';











$entraineur = get_field('entraineur'); 











$date_creation = get_field('date_de_creation'); 











$reseaux= get_field('reseaux_sociaux');











$partenaires = get_field('partenaires');











$galerie_photos = get_field('galerie_photos');











$gender=  get_field('genre');



$current_fp = get_query_var('fpage');



$team_permalink = get_the_permalink($post->ID);







// -----------  videos



$args1=array('post_type'=> 'video_youtube','posts_per_page' => 3,'order' => 'ASC','orderby' => 'title',	'meta_query' => array(



    'relation' => 'AND',



    array(



    'key' => 'equipe1', // recherche sur le champ équipe de type relation



    'value' => '"' . get_the_ID() . '"', // id de l'équipe



    'compare' => 'LIKE'



    )



    ),



    );



    $videos=get_posts($args1);











// -----------  photos



    $args2=array(



        'post_type'=> 'galerie',



        'posts_per_page' => 3,



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



    $galeries=get_posts($args2);











// -----------  articles



$args3=array(



        'post_type'=> 'post',



        'posts_per_page' => 3,



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



    $news=get_posts($args3);







//------ derniere rencontre

$today = date('Y-m-d');

$args4=array(



    'post_type'=> 'rencontre',



    'posts_per_page' => 1,



    'meta_key' => 'date_de_debut', // Spécifiez la clé meta par laquelle vous souhaitez trier
    'orderby' => array(
        'meta_value' => 'DESC', // Tri par la valeur du champ meta
    ),
    'order' => 'DESC',
    'meta_query' => array(
        'relation' => 'AND',
        array(
            'key' => 'date_de_debut',
            'value' => $today.' '.date("H:i:s"),
            'compare' => '<=',
            
        ),
		array(
            'relation' => 'OR',
            array(
                'key' => 'equipe_1', // recherche sur le champ équipe de type relation
                'value' => '"' . get_the_ID() . '"', // id de l'équipe
                'compare' => 'LIKE'
            ),
            array(
                'key' => 'equipe_2', // recherche sur le champ équipe de type relation
                'value' => '"' . get_the_ID() . '"', // id de l'équipe
                'compare' => 'LIKE'
            )
        )
    ),

    





);



$derniere_rencontre=get_posts($args4);

$args5=array(



    'post_type'=> 'rencontre',



    'posts_per_page' => 1,



    'orderby' => 'post_date', 



    'order' => 'ASC',



    'meta_query' => array(
        'relation' => 'AND',
        array(
            'key' => 'date_de_debut',
            'value' => $today.' '.date("H:i:s"),
            'compare' => '>=',
        ),
		array(
            'relation' => 'OR',
            array(
                'key' => 'equipe_1', // recherche sur le champ équipe de type relation
                'value' => '"' . get_the_ID() . '"', // id de l'équipe
                'compare' => 'LIKE'
            ),
            array(
                'key' => 'equipe_2', // recherche sur le champ équipe de type relation
                'value' => '"' . get_the_ID() . '"', // id de l'équipe
                'compare' => 'LIKE'
            )
        )
    ),



);



$prochaine_rencontre=get_posts($args5);

?>



<script src="https://cdn.jsdelivr.net/npm/@splidejs/splide@4.1.4/dist/js/splide.min.js"></script>
<link href="https://cdn.jsdelivr.net/npm/@splidejs/splide@4.1.4/dist/css/splide.min.css" rel="stylesheet">




<main id="primary" class="site-main home main-info-eq">



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

            <a href="<?php echo $team_permalink;?>infos" class="team-link nvtl-active ">Infos générales</a>

            <a href="<?php echo $team_permalink;?>actus" class="team-link">Actualités</a>

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






<section class="pdt-30 pdb-30" style="min-height: 410px; position: relative;">
           <div class="container">
            <div class="">
                <div class="">

                    <div class="splide splide5 nv-decalage-bandeau nv-sllide"  aria-label="Slide Container Example">
                        <div class="splide__track carte-slide-partenaires">
                            <ul class="splide__list ul-style-eqp">
                                <?php if($prochaine_rencontre):?>
                                <li class="rencontre-1 flip-card splide__slide" style="margin:0px !important;">
                                                    
                                                    
                                <?php 
                                    $rencontre=$prochaine_rencontre[0];
                                    $niveau = get_field('niveau',$prochaine_rencontre[0]->ID);
                                    $journee = get_field('journee',$prochaine_rencontre[0]->ID); 
                                    $lieu = get_field('lieu_rencontre',$prochaine_rencontre[0]->ID); 
                                    $combat=get_field('les_combat', $rencontre->ID)[0];
                                    $equipe1 =get_field('equipe_1', $rencontre->ID)[0];
                                    $equipe2 =get_field('equipe_2', $rencontre->ID)[0];
                                    $score_equipe1 =$combat['nombre_de_combat_gagne_equipe_1'][0];
                                    $image1_url=(get_field('logo_circle', $equipe1->ID))?get_field('logo_circle', $equipe1->ID):get_the_post_thumbnail_url($equipe1->ID);
                                    $image2_url=(get_field('logo_circle', $equipe2->ID))?get_field('logo_circle', $equipe2->ID):get_the_post_thumbnail_url($equipe2->ID);
                                    $score_equipe2 =$combat['nombre_de_combat_gagne_equipe_2'][0];
                                    $date_debut=get_field('date_de_debut', $rencontre->ID, false, false);
                                    $date_fin=get_field('date_de_fin', $rencontre->ID, false, false);
                                    $lien = get_the_permalink($rencontre->ID);
                                    setlocale(LC_ALL, 'fr_FR.UTF8', 'fr_FR','fr','fr','fra','fr_FR@euro');
                                    ?>
                                    <div class="">
                                        <div class="center">
                                            <h2 class="nv-title-clsm mrg-0">PROCHAINE RENCONTRE</h2>

                                            <span class="nv-name-pers"><?php if($niveau=="Phase de poules"){echo $journee;}else{echo $niveau;}?> - <?php echo strftime('%A %d %B %Y',strtotime($date_debut)) ;?> - <?php echo $lieu;?></span>

                                        </div>
                                        <div class="nv-rencontre-equipe">
                                            <div class="nv-equip-1">
                                                <img src="<?php echo $image1_url;?>" class="logo-eqi">
                                                <span class="nv-equip-name"><?php echo $equipe1->post_title;?></span>
                                            </div>
                                            <div class="nv-rslt-fix">
                                                <div class="nv-result-rctr">
                                                    <span class="nv-number">0</span><span class="nv-number">-</span><span class="nv-number">0</span>
                                                </div>
                                            </div>
                                            <div class="nv-equip-1">
                                                <span class="nv-equip-name"><?php echo $equipe2->post_title;?></span>
                                                <img src="<?php echo $image2_url;?>" class="logo-eqi">
                                            </div>
                                        </div>
                                        <div class="center"><a href="<?php echo $lien;?>" class="btn-tts"> <span>Tout savoir</span> <i class="fa-solid fa-arrow-right-long"></i></a></div>
                                    </div>
                                
                                </li><?php endif;
                                if($derniere_rencontre):
                                ?>
                                <li class="rencontre-1 flip-card splide__slide" style="margin:0px !important;">
                                <?php 
                                $rencontre=$derniere_rencontre[0];
                                $niveau = get_field('niveau',$derniere_rencontre[0]->ID);
                                $journee = get_field('journee',$derniere_rencontre[0]->ID); 
                                $lieu = get_field('lieu_rencontre',$derniere_rencontre[0]->ID); 
                                $combat=get_field('les_combat', $rencontre->ID)[0];
                                $equipe_gagnante =  $combat['equipe_gagnante'];
                                $equipe1 =get_field('equipe_1', $rencontre->ID)[0];
                                $equipe2 =get_field('equipe_2', $rencontre->ID)[0];
                                $score_equipe1 =$combat['nombre_de_combat_gagne_equipe_1'][0];
                                $image1_url=(get_field('logo_circle', $equipe1->ID))?get_field('logo_circle', $equipe1->ID):get_the_post_thumbnail_url($equipe1->ID);
                                $image2_url=(get_field('logo_circle', $equipe2->ID))?get_field('logo_circle', $equipe2->ID):get_the_post_thumbnail_url($equipe2->ID);
                                $score_equipe2 =$combat['nombre_de_combat_gagne_equipe_2'][0];
                                $date_debut=get_field('date_de_debut', $rencontre->ID, false, false);
                                $date_fin=get_field('date_de_fin', $rencontre->ID, false, false);
                                $lien = get_the_permalink($rencontre->ID);
                                setlocale(LC_ALL, 'fr_FR.UTF8', 'fr_FR','fr','fr','fra','fr_FR@euro');
                                ?>
                                <div class="">
                                    <div class="center">
                                        <h2 class="nv-title-clsm mrg-0">DERNIÈRE RENCONTRE</h2>

                                        <span class="nv-name-pers"><?php if($niveau=="Phase de poules"){echo $journee;}else{echo $niveau;}?> - <?php echo strftime('%A %d %B %Y',strtotime($date_debut)) ;?> - <?php echo $lieu;?></span>

                                    </div>
                                    <div class="nv-rencontre-equipe">
                                        <div class="nv-equip-1 <?php if($equipe_gagnante=='équipe 2'){echo "beaten";}?>">
                                            <img src="<?php echo $image1_url;?>" class="logo-eqi">
                                            <span class="nv-equip-name"><?php echo $equipe1->post_title;?></span>
                                        </div>
                                        <div class="nv-rslt-fix">
                                            <div class="nv-result-rctr">
                                            <span class="nv-number"><?php echo $score_equipe1;?></span><span class="nv-number">-</span><span class="nv-number"><?php echo $score_equipe2;?></span>                  </div>
                                        </div>
                                        <div class="nv-equip-1 <?php if($equipe_gagnante=='équipe 1'){echo "beaten";}?>">
                                            <img src="<?php echo $image2_url;?>" class="logo-eqi">
                                            <span class="nv-equip-name"><?php echo $equipe2->post_title;?></span>
                                            
                                        </div>
                                    </div>
                                    <div class="center"><a href="<?php echo $lien;?>" class="btn-tts">Tout savoir <i class="fa-solid fa-arrow-right-long"></i></a></div>
                                </div>
                               

                                </li>
                            <?php endif;?>
                            </ul>
                        </div> 
                    </div>
                </div>
            </div>
        </div>
           
    </section>

 




    <section class="nv-liste-judoka bg-gt bg-clss-season">


   

        <div class="container">

            <div class="nv-judokas">



                <div class="div-jdk-tabs">



                    <div class="nv-team-hdr" <?php echo $style_couleur1;?>>



                        <h3 class="title-info">EFFECTIF<span><?php echo $title;?></span></h3>



                    </div>



                    <div class="div-eff">



                        <div class="nv-effectif">



                            <h4 class="nv-name-eff">Président :</h4>



                            <span class="nv-name-pers"><?php echo $directeur;?></span>



                        </div>



                        <div class="nv-effectif">



                            <h4 class="nv-name-eff">Entraineur(s) :</h4>



                            <span class="nv-name-pers"><?php echo $entraineur;?></span>



                        </div>



                        <div class="nv-btn-decou">



                            <a href="<?php echo $team_permalink;?>judokas">Découvrir les judokas</a>



                        </div>



                    </div>



                </div>



                <?php if($derniere_rencontre):



                    $rencontre=$derniere_rencontre[0];



                    $lieu = get_field('lieu_rencontre',$derniere_rencontre[0]->ID); 



                    $combat=get_field('les_combat', $rencontre->ID)[0];



                    $equipe1 =get_field('equipe_1', $rencontre->ID)[0];



                    $equipe2 =get_field('equipe_2', $rencontre->ID)[0];



                    $score_equipe1 =$combat['nombre_de_combat_gagne_equipe_1'][0];



                    $image1_url=(get_field('logo_circle', $equipe1->ID))?get_field('logo_circle', $equipe1->ID):get_the_post_thumbnail_url($equipe1->ID);



                    $image2_url=(get_field('logo_circle', $equipe2->ID))?get_field('logo_circle', $equipe2->ID):get_the_post_thumbnail_url($equipe2->ID);



                    $score_equipe2 =$combat['nombre_de_combat_gagne_equipe_2'][0];



                    $date_debut=get_field('date_de_debut', $rencontre->ID, false, false);



                    $date_fin=get_field('date_de_fin', $rencontre->ID, false, false);



                    $lien = get_the_permalink($rencontre->ID);



                    setlocale(LC_ALL, 'fr_FR.UTF8', 'fr_FR','fr','fr','fra','fr_FR@euro');



                    ?>



                <?php endif;?>



                <?php 







					require_once (THEMEDIR.'template-parts/content-stats-poules-equipes-requests-total.php');







            		$classement_total=get_classement( $saison_value);
                    //var_dump($classement_total);exit(-1);






			    if($classement_total){



                    $datas=$classement_total['total'][$this_team->post_title][0];



					//$datas=$classement_total['total'][$judoka->post_title][0];



                   // prettyPrint($datas);



                }







				?>



                <div class="div-jdk-tabs">



                    <div class="nv-team-hdr classement-1" <?php echo $style_couleur1;?>>



                        <h3 class="title-info">CLASSEMENT</h3>



                        <span class="round" <?php echo $style_couleur2;?>><?php if(isset($datas['classement'])){echo $datas['classement'];if($datas['classement']==1){echo 'er';}else{echo 'eme';}}else{echo '';}?></span>



                    </div>



                    <div class="div-clsm">



                        <div class="nv-clsm">



                            <div class="nv-vict"><span class="nv-number-1"><?php if($datas['victoires']){echo $datas['victoires'];}else{echo '0';}?></span><span class="nv-txt">victoires</span></div>



                            <div class="nv-vict"><span class="nv-number-1"><?php  if($datas['nuls']){echo $datas['nuls'];}else{echo '0';}?></span><span class="nv-txt">nuls</span></div>



                            <div class="nv-vict"><span class="nv-number-1"><?php  if($datas['defaites']){echo $datas['defaites'];}else{echo '0';}?></span><span class="nv-txt">défaites</span></div>



                        </div>



                        <div class="nv-clsm-1">



                            <h4 class="nv-name-clsm">Statistiques</h4>



                            <div class="stat-bloc">



                                <span class="nv-clsm-jdk">Ippon marqués</span><span class="nv-num-jdk"><?php if($datas['ippons_marqués']){echo $datas['ippons_marqués'];}else{echo '0';}?></span>



                            </div>



                            <div class="stat-bloc">



                                <span class="nv-clsm-jdk">Ippon reçus</span><span class="nv-num-jdk"><?php if($datas['ippons_concédés']){ echo $datas['ippons_concédés'];}else{echo '0';}?></span>



                            </div>



                            <div class="stat-bloc">



                                <span class="nv-clsm-jdk">Waza-ari marqués</span><span class="nv-num-jdk"><?php  if($datas['wazaris_marqués']){echo $datas['wazaris_marqués'];}else{echo '0';}?></span>



                            </div>



                            <div class="stat-bloc">



                                <span class="nv-clsm-jdk">Waza-ari reçus</span><span class="nv-num-jdk"><?php  if($datas['wazaris_concédés']){echo $datas['wazaris_concédés'];}else{echo '0';}?></span>



                            </div>



                            



                        </div>



                    </div>



                </div>



                <?php if($partenaires):?>



                    <div class="div-jdk-tabs">



                        <div class="nv-team-hdr" <?php echo $style_couleur1;?>>



                            <h3 class="title-info">PARTENAIRES<span><?php echo $title;?></span></h3>



                        </div>



                        <div class="div-eff pd-0 ">
<<<<<<< HEAD
                            <div class="splide splide2 nv-decalage-bandeau nv-sllide splide--loop splide--ltr splide--draggable is-active is-overflow is-initialized"  aria-label="Slide Container Example">
=======
                            <div class="splide splide2 nv-decalage-bandeau nv-sllide"  aria-label="Slide Container Example">
>>>>>>> bb9a269b60d1b01722195fd603b0b6e6ebbf2367
                                <div class="splide__track carte-slide-partenaires">
                                    <ul class="splide__list" style="width:300px">
                                        <?php foreach ($partenaires as $partenaire):?>
                                            <li class="rencontre flip-card splide__slide" style="margin:0px !important;">
                                                <div style="background-image:url(<?php echo get_field('logo_partenaire',$partenaire->ID)['url'];?>)" class="nv-partenaire-eqp"></div>
                                            </li>
                                        <?php  endforeach; ?>
                                    </ul>
<div class="splide__arrows">
	<button class="splide__arrow splide__arrow--prev" type="button" aria-controls="splide01-track" aria-label="Go to last slide">
		<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 40 40" width="40" height="40"><path d="m15.5 0.932-4.3 4.38 14.5 14.6-14.5 14.5 4.3 4.4 14.6-14.6 4.4-4.3-4.4-4.4-14.6-14.6z"></path></svg>
	</button>
	<button class="splide__arrow splide__arrow--next" type="button" aria-controls="splide01-track" aria-label="Next slide">
		<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 40 40" width="40" height="40"><path d="m15.5 0.932-4.3 4.38 14.5 14.6-14.5 14.5 4.3 4.4 14.6-14.6 4.4-4.3-4.4-4.4-14.6-14.6z"></path></svg>
	</button>
</div>
                                </div> 
                            </div>
                        </div>



                    </div>



                <?php endif;?>



            </div>



        </div>



    </section>

    <?php if($description):?>

        <section class="nv-liste-judoka bg-gt bg-presenta" style="background-image: url(http://www.rimo0631.odns.fr/wp-content/uploads/2024/07/bg-presentation-equipe.jpg);background-size:cover;background-repeat:no-repeat; background-position:center;">

            <div class="container">

                <h2 class="nv-title-clsm-presenta" style='text-transform: uppercase'>Présentation de <?php echo $title;?></h2>

                <div class="presentation-equipes" style='text-align:center;margin-top:0px !important'>
                    <p><?php echo $description;?></p>
                </div>

            </div>

        </section>

    <?php endif; ?>

    <?php if($news):?>



        <section class="nv-liste-judoka bg-gt">



            <div class="container">
                <div class="div-flx-nv">
                <h2 class="nv-title-clsm">ACTUALITES</h2>
                <div style='text-align:center;margin-top:0px !important'>
                    <a href="<?php echo $team_permalink;?>actus" class="more-actu"><span>Toutes les actualités</span><i class="fa-solid fa-arrow-right-long"></i></a>
                </div></div>


                <div class="liste-images-galerie" id="videoscontainer">



                    



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







                                            <div class="liste-images-galerie-element">







                                                <?php if($video==null){?><a href="<?= $url; ?>" class="news-link-2-col"><?php }?>







                                                <div class="video-preview" style="background-image: url(<?= $img; ?>);">







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

                                                    <span class="nv-date"><?php $date=get_the_date('j F Y', $my_post->ID ); echo $date; ?></span>







                                                    







                                                </div>







                                            </div>







                        <?php endforeach; ?> 
                        
                    <?php endif; ?>   



                </div>
                


            </div>



        </section>



    <?php endif; ?>



    <?php if($galeries):?>



        <section class="nv-liste-judoka bg-gt bg-galerie">



            <div class="container">


             <div class="div-flx-nv">
                <h2 class="nv-title-clsm">GALERIES</h2>
                <div style='text-align:center;margin-top:0px !important'>
                    <a href="<?php echo $team_permalink;?>photos" class="more-actu"> <span>Toutes les photos</span>  <i class="fa-solid fa-arrow-right-long"></i></a>
                </div>
             </div>

                <div class=""><div class="liste-images-galerie" >


 
                <?php  //var_dump($images);exit(-1);







                    foreach ($galeries as $image_galerie):



                        $photos=get_field('photos',$image_galerie->ID);



                        $credit_images = get_field('credit_images',$image_galerie->ID);



                        $titre = get_field('titre',$image_galerie->ID);



                        $cover=$photos[0];



                        $link=get_the_permalink($image_galerie->ID)."?equipeID=".get_the_ID();



                ?>







                        



                            



                                <a href="<?php echo $link;?>">		



                                    <div class="liste-images-element" style="background-image: url(<?php echo '\''.esc_url($cover['sizes']['medium_large']).'\'';?>);">



                                        



                                        



                                    </div>



                                    <h2 class="nv-title-news-3-col">



                                            <?php echo $titre.' - '. get_the_date('Y', $image_galerie->ID);;?>



                                    </h2>



                                </a>		



                            



                        



                <?php endforeach;?></div></div>
                


            </div>



        </section>



    <?php endif;?>



    <?php if($videos):?>



        <section class="nv-liste-judoka bg-gt">



            <div class="container">


            <div class="div-flx-nv">
                <h2 class="nv-title-clsm">VIDEOS</h2>
                <div style='text-align:center;margin-top:0px !important'>
                    <a href="<?php echo $team_permalink;?>videos" class="more-actu"><span>Toutes les vidéos</span><i class="fa-solid fa-arrow-right-long"></i></a>
                </div>
            </div>

            



                    <div class="liste-images-galerie" id="videoscontainer">



                        <?php foreach ($videos as $video_object):



                            $video=get_field('video_url', $video_object->ID);



                            $id=get_field('id', $video_object->ID);



                            $date_dajout=get_the_date('j F Y', $video_object->ID );



                            $titre=get_field('titre', $video_object->ID);



                            $image_url=get_the_post_thumbnail_url($video_object->ID)?get_the_post_thumbnail_url ($video_object->ID):('https://i.ytimg.com/vi/'.get_field('id',$video_object->ID).'/hqdefault.jpg');


                        ?>



                            <div class="liste-images-galerie-element">



                                <div class="video-preview" style="background-image: url(<?php echo $image_url; ?>);">



                                    <?php 



                                        echo '<div class="button-play-video button-play-video-grande-taille">'.do_shortcode('[video_lightbox_youtube video_id="'.$id.'" width="640" height="480" anchor="'.get_site_url().'/wp-content/uploads/2022/11/play.webp"]').'</div>';



                                        echo '<div class="button-play-video button-play-video-mobile">'.do_shortcode('[video_lightbox_youtube video_id="'.$id.'" width="300" height="160" anchor="'.get_site_url().'/wp-content/uploads/2022/11/play.webp"]').'</div>';



                                    ?>



                                </div>



                                <div class="right-content">



                                    <a href="#" class="news-link-2-col"><h3 class="nv-title-news-3-col"><?= $titre?></h3></a>



<span class="nv-date"><?php $date=get_the_date('j F Y', $my_post->ID ); echo $date; ?></span>



                                </div>



                            </div>



                        <?php endforeach; ?>



                        



                </div>
                


            </div>



        </section>



    <?php endif;?>


    <script>
const splide2 = new Splide( '.splide2' , {
                type: 'loop',
                perPage: 1,
                rewind: false,
                pagination:true,
                perMove: 1,
                breakpoints: {
                    1200:{
                        perPage:1,
                    },
                    992:{
                        perPage:1,
                    },
                    640: {
                        perPage: 1,
                    }
                },
            });


            splide2.mount();

</script>

<script>
const splide5 = new Splide( '.splide5' , {
                type: 'loop',
                perPage: 1,
                rewind: false,
                pagination:true,
                perMove: 1,
                breakpoints: {
                    1200:{
                        perPage:1,
                    },
                    992:{
                        perPage:1,
                    },
                    640: {
                        perPage: 1,
                    }
                },
            });


            splide5.mount();

</script>
<script>
document.querySelector('.splide__arrow--prev').addEventListener('click', function() {
    console.log('Previous clicked');
});

document.querySelector('.splide__arrow--next').addEventListener('click', function() {
    console.log('Next clicked');
});
</script>
    <?php



   



get_footer();



?>
