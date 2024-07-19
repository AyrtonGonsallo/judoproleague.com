<?php





/**





 * Template part for displaying posts





 *





 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/





 *





 * @package pro-league





 */





$site = get_field('site_web');


$saison_value=($_GET["saison_value"])?$_GET["saison_value"]:"2023-2024";


$description = get_field('presentation'); 


$now=date('Y/m/d H:i:s');


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

$args_poules = array(		'post_type'=> 'rencontre',		'posts_per_page' => -1,'meta_query'     => array(  'relation' => 'and',   array(      'key'        => 'niveau',      'compare'    => '=',      'value'      => 'Phase de poules'    ),
array(
    'key'        => 'saisons',
    'compare'    => 'LIKE',
    'value'      => $saison_value
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
) ),		'meta_key' => 'date_de_debut',		'orderby' => 'meta_value_num',		'order' => 'DESC',			);
$args_quarts = array(		'post_type'=> 'rencontre',		'posts_per_page' => -1,'meta_query'     => array(  'relation' => 'and',   array(      'key'        => 'niveau',      'compare'    => '=',      'value'      => 'Quart de finale'    ),
array(
    'key'        => 'saisons',
    'compare'    => 'LIKE',
    'value'      => $saison_value
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
) ),		'meta_key' => 'date_de_debut',		'orderby' => 'meta_value_num',		'order' => 'DESC',			);

$args_f4 = array(		'post_type'=> 'rencontre',		'posts_per_page' => -1,'meta_query'     => array(  'relation' => 'and',   
array(      'key'        => 'niveau',      'compare'    => 'Like',      'value'      => 'Final four'    ),
array(
    'key'        => 'saisons',
    'compare'    => 'LIKE',
    'value'      => $saison_value
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
		  ),		'meta_key' => 'date_de_debut',		'orderby' => 'meta_value_num',		'order' => 'DESC',			);

$matchs_f4=get_posts($args_f4);
$matchs_quarts=get_posts($args_quarts);
$matchs_poules=get_posts($args_poules);

?>



<script>
        $(document).ready(function() {
            $('#saison_value').change(function() {
                $('.season-selector-form').submit();
            });
        });
    </script>







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

            <a href="<?php echo $team_permalink;?>actus" class="team-link">Actualités</a>

            <a href="<?php echo $team_permalink;?>photos" class="team-link">Photos</a>

            <a href="<?php echo $team_permalink;?>videos" class="team-link">Vidéos</a>

            <a href="<?php echo $team_permalink;?>calendrier_resultats" class="team-link  nvtl-active ">Calendrier / Résultats</a>

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

        <div class="season-selector-box">
			<form Method="GET" ACTION="" class="season-selector-form">
				<select name="saison_value" id="saison_value" class="season-selector-select">
					<option value="2021-2022" <?php echo ($saison_value=="2021-2022")?"selected":"";?>>2021-2022</option>
					<option value="2022-2023" <?php echo ($saison_value=="2022-2023")?"selected":"";?>>2022-2023</option>
					<option value="2023-2024" <?php echo ($saison_value=="2023-2024")?"selected":"";?>>2023-2024</option>
				</select>
			</form>
		</div>

  



	<div id="tabs-6">

		

    <?php if($matchs_poules):?>
        <section class="pd-5">
            <div class="judo_pro_league">
                <h2 class="crt-title">Phase de poules</h2>
                <div class="cal-res-poule">
                    <?php foreach ($matchs_poules as $rencontre):
                        $combat=get_field('les_combat', $rencontre->ID)[0];
                        $lieu=get_field('lieu_rencontre', $rencontre->ID);
                        $equipe1 =get_field('equipe_1', $rencontre->ID)[0];
                        $equipe2 =get_field('equipe_2', $rencontre->ID)[0];
                        $rencontre_permalink = get_the_permalink($rencontre->ID);
                        $score_equipe1 =$combat['nombre_de_combat_gagne_equipe_1'][0];
                        $score_equipe2 =$combat['nombre_de_combat_gagne_equipe_2'][0];
                        $image1_url=(get_field('logo_miniature', $equipe1->ID))?get_field('logo_miniature', $equipe1->ID):get_the_post_thumbnail_url($equipe1->ID);
                        $image2_url=(get_field('logo_miniature', $equipe2->ID))?get_field('logo_miniature', $equipe2->ID):get_the_post_thumbnail_url($equipe2->ID);
                        $date_debut=get_field('date_de_debut', $rencontre->ID, false, false);
                        $date_fin=get_field('date_de_fin', $rencontre->ID, false, false);
                        $statut=get_field('statut', $rencontre->ID)['label'];
                        $abreviation1=(get_field('abreviation', $equipe1->ID))?get_field('abreviation', $equipe1->ID):$equipe1->post_title;
                        $abreviation2=(get_field('abreviation', $equipe2->ID))?get_field('abreviation', $equipe2->ID):$equipe2->post_title;
                        if($statut=='en cours'){
                            $class_status='encours';
                            $equipe_gagnante =  'inconnue';
                            $texte_status='en cours';
                            $class_reservation="link-2";
                            $lien_live_ou_billet='<a href="'.get_field('video_live', $rencontre->ID).'"  target="_blank" class="nv-link-crt brd-right">Live</a>';
                        }else if($statut=='terminé'){
                            $equipe_gagnante =  ($combat)?$combat['equipe_gagnante']:'inconnue';
                            $class_status='terminer';
                            $texte_status='terminé';
                            $class_reservation="";
                            $lien_live_ou_billet="";
                        }
                        else if($statut=="à venir"){
                            $class_status='avenir';
                            $equipe_gagnante =  'inconnue';
                            $texte_status='à venir';
                            $class_reservation="link-2";
                            $lien_live_ou_billet='<a href="'.get_field("lien_de_reservation", $rencontre->ID).'" target="_blank" class="nv-link-crt brd-right">Billetterie</a>';
                        }
                        ?>
                            <div class="cal-res-poule-blc">
                                <div class="header-cal-res-poule">
                                    <span class="cal-res-poule-title"><?php echo $lieu;?></span>
                                    <span class="cal-res-poule-stat <?php echo $class_status;?>"><?php echo $texte_status;?></span>
                                </div>
                                <div class="horaire-jr" <?php if($texte_status=='terminé'){?>style="grid-template-columns: 100% !important;"<?php }?>>
                                    <div>
                                        <div class="cal-res-poule-team <?php if($equipe_gagnante=='équipe 2'){echo "beaten";}?>">
                                            <img src="<?php echo $image1_url;?>">
                                            <h3 class="cal-res-poule-eqp"><?php echo $equipe1->post_title;?></h3>
                                            <span class="cal-res-poule-rs"><?php echo $score_equipe1;?></span>
                                        </div>
                                        <div class="cal-res-poule-team <?php if($equipe_gagnante=='équipe 1'){echo "beaten";}?> brd-none">
                                            <img src="<?php echo $image2_url;?>">
                                            <h3 class="cal-res-poule-eqp "><?php echo $equipe2->post_title;?></h3>
                                            <span class="cal-res-poule-rs"><?php echo $score_equipe2;?></span>
                                        </div>
                                    </div>
                                    <div <?php if($texte_status=='terminé'){?>style="display : none !important;"<?php }?>>
                                        <span class="cal-res-poule-title"><?php echo substr($date_debut,8,2).'/'.substr($date_debut,5,2);?></span>
                                                <span class="cal-res-poule-title"><?php echo substr($date_debut,11,2).'h'.substr($date_debut,14,2);?></span>
                                    </div>
                                </div>
                                <div class="cal-res-poule-link <?php echo $class_reservation;?>">
                                    <?php echo $lien_live_ou_billet;?>
                                    <a href="<?php echo $rencontre_permalink;?>" class="nv-link-crt">Détails</a>
                                </div>
                            </div>
                    <?php endforeach; ?>
                </div>
                <div>
                    <a href="../../../calendrier-resultats-2023/poules/" class="more-classement">Classement Poules</a>
                </div>
            </div>
    </section>
    <?php endif;?>

    <?php if($matchs_quarts):?>
        <section class="pd-5">
            <div class="judo_pro_league">
                <h2 class="crt-title">Quarts</h2>
                <div class="cal-res-poule">
                    <?php foreach ($matchs_quarts as $rencontre):
                        $combat=get_field('les_combat', $rencontre->ID)[0];
                        $lieu=get_field('lieu_rencontre', $rencontre->ID);
                        $equipe1 =get_field('equipe_1', $rencontre->ID)[0];
                        $equipe2 =get_field('equipe_2', $rencontre->ID)[0];
                        $rencontre_permalink = get_the_permalink($rencontre->ID);
                        $score_equipe1 =$combat['nombre_de_combat_gagne_equipe_1'][0];
                        $score_equipe2 =$combat['nombre_de_combat_gagne_equipe_2'][0];
                        $image1_url=(get_field('logo_miniature', $equipe1->ID))?get_field('logo_miniature', $equipe1->ID):get_the_post_thumbnail_url($equipe1->ID);
                        $image2_url=(get_field('logo_miniature', $equipe2->ID))?get_field('logo_miniature', $equipe2->ID):get_the_post_thumbnail_url($equipe2->ID);
                        $date_debut=get_field('date_de_debut', $rencontre->ID, false, false);
                        $date_fin=get_field('date_de_fin', $rencontre->ID, false, false);
                        $abreviation1=(get_field('abreviation', $equipe1->ID))?get_field('abreviation', $equipe1->ID):$equipe1->post_title;
                        $abreviation2=(get_field('abreviation', $equipe2->ID))?get_field('abreviation', $equipe2->ID):$equipe2->post_title;
                        if(strtotime($now)<=strtotime($date_fin) && strtotime($now)>=strtotime($date_debut)){
                            $class_status='encours';
                            $equipe_gagnante =  'inconnue';
                            $texte_status='en cours';
                            $class_reservation="link-2";
                            $lien_live_ou_billet='<a href="'.get_field('video_live', $rencontre->ID).'"  target="_blank" class="nv-link-crt brd-right">Live</a>';
                        }else if(strtotime($now)>=strtotime($date_fin)){
                            $equipe_gagnante =  ($combat)?$combat['equipe_gagnante']:'inconnue';
                            $class_status='terminer';
                            $texte_status='terminé';
                            $class_reservation="";
                            $lien_live_ou_billet="";
                        }
                        else if(strtotime($now)<=strtotime($date_debut)){
                            $class_status='avenir';
                            $equipe_gagnante =  'inconnue';
                            $texte_status='à venir';
                            $class_reservation="link-2";
                            $lien_live_ou_billet='<a href="'.get_field("lien_de_reservation", $rencontre->ID).'" target="_blank" class="nv-link-crt brd-right">Billetterie</a>';
                        }
                        ?>
                            <div class="cal-res-poule-blc">
                                <div class="header-cal-res-poule">
                                    <span class="cal-res-poule-title"><?php echo $lieu;?></span>
                                    <span class="cal-res-poule-stat <?php echo $class_status;?>"><?php echo $texte_status;?></span>
                                </div>
                                <div class="horaire-jr" <?php if($texte_status=='terminé'){?>style="grid-template-columns: 100% !important;"<?php }?>>
                                    <div>
                                        <div class="cal-res-poule-team <?php if($equipe_gagnante=='équipe 2'){echo "beaten";}?>">
                                            <img src="<?php echo $image1_url;?>">
                                            <h3 class="cal-res-poule-eqp"><?php echo $equipe1->post_title;?></h3>
                                            <span class="cal-res-poule-rs"><?php echo $score_equipe1;?></span>
                                        </div>
                                        <div class="cal-res-poule-team <?php if($equipe_gagnante=='équipe 1'){echo "beaten";}?> brd-none">
                                            <img src="<?php echo $image2_url;?>">
                                            <h3 class="cal-res-poule-eqp "><?php echo $equipe2->post_title;?></h3>
                                            <span class="cal-res-poule-rs"><?php echo $score_equipe2;?></span>
                                        </div>
                                    </div>
                                    <div <?php if($texte_status=='terminé'){?>style="display none !important;"<?php }?>>
                                        <span class="cal-res-poule-title"><?php echo substr($date_debut,8,2).'/'.substr($date_debut,5,2);?></span>
                                                <span class="cal-res-poule-title"><?php echo substr($date_debut,11,2).'h'.substr($date_debut,14,2);?></span>
                                    </div>
                                </div>
                                <div class="cal-res-poule-link <?php echo $class_reservation;?>">
                                    <?php echo $lien_live_ou_billet;?>
                                    <a href="<?php echo $rencontre_permalink;?>" class="nv-link-crt">Détails</a>
                                </div>
                            </div>
                    <?php endforeach; ?>
                </div>
                <div>
                    <a href="../../../calendrier-resultats-2023/quarts/" class="more-classement">Classement Quarts</a>
                </div>
            </div>
    </section>
    <?php endif;?>

    <?php if($matchs_f4):?>
        <section class="pd-5">
            <div class="judo_pro_league">
                <h2 class="crt-title">Final Four</h2>
                <div class="cal-res-poule">
                    <?php foreach ($matchs_f4 as $rencontre):
                        $combat=get_field('les_combat', $rencontre->ID)[0];
                        $lieu=get_field('lieu_rencontre', $rencontre->ID);
                        $equipe1 =get_field('equipe_1', $rencontre->ID)[0];
                        $equipe2 =get_field('equipe_2', $rencontre->ID)[0];
                        $rencontre_permalink = get_the_permalink($rencontre->ID);
                        $score_equipe1 =$combat['nombre_de_combat_gagne_equipe_1'][0];
                        $score_equipe2 =$combat['nombre_de_combat_gagne_equipe_2'][0];
                        $image1_url=(get_field('logo_miniature', $equipe1->ID))?get_field('logo_miniature', $equipe1->ID):get_the_post_thumbnail_url($equipe1->ID);
                        $image2_url=(get_field('logo_miniature', $equipe2->ID))?get_field('logo_miniature', $equipe2->ID):get_the_post_thumbnail_url($equipe2->ID);
                        $date_debut=get_field('date_de_debut', $rencontre->ID, false, false);
                        $date_fin=get_field('date_de_fin', $rencontre->ID, false, false);
                        $abreviation1=(get_field('abreviation', $equipe1->ID))?get_field('abreviation', $equipe1->ID):$equipe1->post_title;
                        $abreviation2=(get_field('abreviation', $equipe2->ID))?get_field('abreviation', $equipe2->ID):$equipe2->post_title;
                        if(strtotime($now)<=strtotime($date_fin) && strtotime($now)>=strtotime($date_debut)){
                            $class_status='encours';
                            $equipe_gagnante =  'inconnue';
                            $texte_status='en cours';
                            $class_reservation="link-2";
                            $lien_live_ou_billet='<a href="'.get_field('video_live', $rencontre->ID).'"  target="_blank" class="nv-link-crt brd-right">Live</a>';
                        }else if(strtotime($now)>=strtotime($date_fin)){
                            $equipe_gagnante =  ($combat)?$combat['equipe_gagnante']:'inconnue';
                            $class_status='terminer';
                            $texte_status='terminé';
                            $class_reservation="";
                            $lien_live_ou_billet="";
                        }
                        else if(strtotime($now)<=strtotime($date_debut)){
                            $class_status='avenir';
                            $equipe_gagnante =  'inconnue';
                            $texte_status='à venir';
                            $class_reservation="link-2";
                            $lien_live_ou_billet='<a href="'.get_field("lien_de_reservation", $rencontre->ID).'" target="_blank" class="nv-link-crt brd-right">Billetterie</a>';
                        }
                        ?>
                            <div class="cal-res-poule-blc">
                                <div class="header-cal-res-poule">
                                    <span class="cal-res-poule-title"><?php echo $lieu;?></span>
                                    <span class="cal-res-poule-stat <?php echo $class_status;?>"><?php echo $texte_status;?></span>
                                </div>
                                <div class="horaire-jr" <?php if($texte_status=='terminé'){?>style="grid-template-columns: 100% !important;"<?php }?>>
                                    <div>
                                        <div class="cal-res-poule-team <?php if($equipe_gagnante=='équipe 2'){echo "beaten";}?>">
                                            <img src="<?php echo $image1_url;?>">
                                            <h3 class="cal-res-poule-eqp"><?php echo $equipe1->post_title;?></h3>
                                            <span class="cal-res-poule-rs"><?php echo $score_equipe1;?></span>
                                        </div>
                                        <div class="cal-res-poule-team <?php if($equipe_gagnante=='équipe 1'){echo "beaten";}?> brd-none">
                                            <img src="<?php echo $image2_url;?>">
                                            <h3 class="cal-res-poule-eqp "><?php echo $equipe2->post_title;?></h3>
                                            <span class="cal-res-poule-rs"><?php echo $score_equipe2;?></span>
                                        </div>
                                    </div>
                                    <div>
                                        <span class="cal-res-poule-title"><?php echo substr($date_debut,8,2).'/'.substr($date_debut,5,2);?></span>
                                        <span class="cal-res-poule-title"><?php echo substr($date_debut,11,2).'h'.substr($date_debut,14,2);?></span>
                                    </div>
                                </div>
                                <div class="cal-res-poule-link <?php echo $class_reservation;?>">
                                    <?php echo $lien_live_ou_billet;?>
                                    <a href="<?php echo $rencontre_permalink;?>" class="nv-link-crt">Détails</a>
                                </div>
                            </div>
                    <?php endforeach; ?>
                </div>
                <div>
                    <a href="../../../calendrier-resultats-2023/final4/" class="more-classement">Classement Final Four</a>
                </div>
            </div>
    </section>
    <?php endif;?>

	

    

  </div>

	





  </div>







		





	





</article>





