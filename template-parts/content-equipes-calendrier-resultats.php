<?php

/**
 * Template part for displaying posts

 *

 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/

 *

 * @package pro-league

 */
$site = get_field('site_web');

$saison_value=($_GET["saison_value"])?$_GET["saison_value"]:"2026-2027";

$description = get_field('presentation'); 

$now=date('Y/m/d H:i:s');

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

$palmares = get_field('palmares');

$galerie_photos = get_field('galerie_photos');

$gender=  get_field('genre');

$current_fp = get_query_var('fpage');

$team_permalink = get_the_permalink($post->ID);

$args_poules = array(		
    'post_type'=> 'rencontre',		
    'posts_per_page' => -1,
    'meta_query'     => array(  
        'relation' => 'and',   
        array(      'key'        => 'niveau',      'compare'    => '=',      'value'      => 'Phase de poules'    ),
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
    ),		
    'meta_key' => 'date_de_debut',		
    'orderby' => 'meta_value',		
    'order' => 'ASC',			
);
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
) ),		'meta_key' => 'date_de_debut',		'orderby' => 'meta_value',		'order' => 'ASC',			);

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
		  ),		'meta_key' => 'date_de_debut',		'orderby' => 'meta_value',		'order' => 'ASC',			);

$matchs_f4=get_posts($args_f4);
$matchs_quarts=get_posts($args_quarts);
$matchs_poules=get_posts($args_poules);

/* =========================================================
 * DONNÉES ÉQUIPE
 * ========================================================= */

$team_id = get_the_ID();

$site          = get_field( 'site_web', $team_id );
$description   = get_field( 'presentation', $team_id );
$directeur     = get_field( 'directeur', $team_id );
$entraineur    = get_field( 'entraineur', $team_id );
$date_creation = get_field( 'date_de_creation', $team_id );
$reseaux       = get_field( 'reseaux_sociaux', $team_id );
$palmares      = get_field( 'palmares', $team_id );
$galerie_photos = get_field( 'galerie_photos', $team_id );
$partenaires   = get_field( 'partenaires', $team_id );
$gender        = get_field( 'genre', $team_id );

$current_fp = get_query_var( 'fpage' );

$title = get_field( 'titre_de_la_page', $team_id );

$couleur1 = get_field( 'couleur1', $team_id );
$couleur2 = get_field( 'couleur2', $team_id );

$logo_principal = get_field( 'logo_principal', $team_id );
$logo_circle    = get_field( 'logo_circle', $team_id );

$logo_principal_url = $logo_principal
    ? $logo_principal
    : get_the_post_thumbnail_url( $team_id, 'full' );

$logo_circle_url = $logo_circle
    ? $logo_circle
    : $logo_principal_url;

$team_permalink = trailingslashit( get_permalink( $team_id ) );
$team_name      = get_the_title( $team_id );

$photo_du_staff = get_field( 'photo_du_staff', $team_id );

/* =========================================================
 * MENU ÉQUIPE
 * ========================================================= */

$menu_items = array(
    'infos' => array(
        'label' => 'Infos générales',
        'url'   => $team_permalink,
    ),
    'actus' => array(
        'label' => 'Actualités',
        'url'   => $team_permalink . 'actus/',
    ),
    'photos' => array(
        'label' => 'Photos',
        'url'   => $team_permalink . 'photos/',
    ),
    'videos' => array(
        'label' => 'Vidéos',
        'url'   => $team_permalink . 'videos/',
    ),
    'calendrier_resultats' => array(
        'label' => 'Calendrier / Résultats',
        'url'   => $team_permalink . 'calendrier_resultats/',
    ),
    'judokas' => array(
        'label' => 'Judokas',
        'url'   => $team_permalink . 'judokas/',
    ),
);

?>



<script>
        $(document).ready(function() {
            $('#saison_value').change(function() {
                $('.season-selector-form').submit();
            });
        });
    </script>

<article
    id="post-<?php the_ID(); ?>"
    <?php post_class('jpl-team-page'); ?>
    style="
        --team-color-1: <?php echo esc_attr($couleur1); ?>;
        --team-color-2: <?php echo esc_attr($couleur2); ?>;
        --team-gradient: linear-gradient(
            90deg,
            <?php echo esc_attr($couleur1); ?> 0%,
            <?php echo esc_attr($couleur2); ?> 100%
        );
    "
>
    <!-- =====================================================
         HEADER ÉQUIPE
    ====================================================== -->

    <section
        class="jpl-team-header"
        style="
            --team-color-1: <?php echo esc_attr( $couleur1 ); ?>;
            --team-color-2: <?php echo esc_attr( $couleur2 ); ?>;
        "
    >

        <div class="jpl-team-container">

            <div class="jpl-team-identity">

                <!-- LOGO -->
                <div class="jpl-team-main-logo">

                    <?php if ( $logo_principal_url ) : ?>

                        <a
                            href="<?php echo esc_url( $team_permalink ); ?>"
                            class="jpl-team-logo-link"
                        >
                            <img
                                src="<?php echo esc_url( $logo_principal_url ); ?>"
                                alt="<?php echo esc_attr( $team_name ); ?>"
                            >
                        </a>

                    <?php endif; ?>

                </div>

                <!-- MENU ÉQUIPE -->
                <nav
                    class="jpl-team-menu"
                    aria-label="Navigation <?php echo esc_attr( $team_name ); ?>"
                >

                    <?php foreach ( $menu_items as $key => $item ) : ?>

                        <a
                            href="<?php echo esc_url( $item['url'] ); ?>"
                            class="jpl-team-menu-link <?php echo ( 'calendrier_resultats' === $key ) ? 'is-active' : ''; ?>"
                            style="
                                --menu-color: <?php echo esc_attr( 'calendrier_resultats' === $key ? $couleur1 : $couleur2 ); ?>;
                                --menu-color-hover: <?php echo esc_attr( 'calendrier_resultats' === $key ? $couleur2 : $couleur1 ); ?>;
                            "
                        >
                            <?php echo esc_html( $item['label'] ); ?>
                        </a>

                    <?php endforeach; ?>

                </nav>

            </div>

        </div>

    </section>


		<div id="" style="">

        <div class="season-selector-box">
			<div class="jpl-team-topbar" style="max-width:1401px;margin:auto;">
                <a
                    href="<?php echo esc_url(home_url('/equipes-judo-pro-league/')); ?>"
                    class="jpl-team-back"
                >
                    <i class="fa-solid fa-arrow-left"></i>
                    <span>Retour aux équipes</span>
                </a>
				                <div class="jpl-team-breadcrumb">
                    <a href="<?php echo esc_url(home_url('/equipes-judo-pro-league/')); ?>">
                        Équipes
                    </a>
                    <span>/</span>
                    <a href="<?php echo esc_url($team_permalink . 'infos/'); ?>">
                        <?php echo esc_html(get_the_title()); ?>
                    </a>
                    <span>/</span>
                    <strong>Calendrier / Résultats</strong>
                </div>	
            </div>
			<form Method="GET" ACTION="" class="season-selector-form">
                <select name="saison_value" id="saison_value" class="season-selector-select">
                    <?php foreach ($saisons as $saison) {?>
                        <option value="<?php echo $saison;?>" <?php echo ($saison_value==$saison)?"selected":"";?>><?php echo $saison;?></option>

                    <?php }?>
					
				</select>
			</form>
		</div>

  



	<div id="tabs-6" style="">

		

    <?php if($matchs_poules):?>
        <section class="pd-5 eq-reslt-div">
            <div class="judo_pro_league">
                <div class="eq-reslt-flx">
                     <h2 class="crt-title">Phase de poules</h2>
                     <!-- <a href="../../../calendrier-resultats-2023/poules/" class="more-classement">Classement Poules <i class="fa-solid fa-arrow-right-long"></i></a> -->
                </div>
                <div class="cal-res-poule">
                    <?php foreach ($matchs_poules as $rencontre):
                        $combat=get_field('les_combat', $rencontre->ID)[0];
                        $lieu=get_field('lieu_rencontre', $rencontre->ID);
                        $equipe1 =get_field('equipe_1', $rencontre->ID)[0];
                        $equipe2 =get_field('equipe_2', $rencontre->ID)[0];
                        $rencontre_permalink = get_the_permalink($rencontre->ID);
                        $score_equipe1 =$combat['nombre_de_combat_gagne_equipe_1'];
                        $score_equipe2 =$combat['nombre_de_combat_gagne_equipe_2'];
                        $image1_url=(get_field('logo_principal', $equipe1->ID))?get_field('logo_principal', $equipe1->ID):get_the_post_thumbnail_url($equipe1->ID);
                        $image2_url=(get_field('logo_principal', $equipe2->ID))?get_field('logo_principal', $equipe2->ID):get_the_post_thumbnail_url($equipe2->ID);
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
        $lien_live_ou_billet='<a href="'.get_field('video_live', $rencontre->ID).'"  target="_blank" class="nv-link-crt brd-right"><img style="width: 27px; margin-bottom: -4px;" src="/wp-content/uploads/2026/09/live-classement.svg"/></a>';
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
        $lien_live_ou_billet=(get_field("lien_de_reservation", $rencontre->ID))?'<a href="'.get_field("lien_de_reservation", $rencontre->ID).'" target="_blank" class="nv-link-crt brd-right"><img style="width: 33px;margin-bottom: -2px;" src="/wp-content/uploads/2026/09/ticket.svg"/></a>':'';
                        }
                        ?>
                            <div class="cal-res-poule-blc">
                    <div class="header-cal-res-poule">
                        <span class="cal-res-poule-title"><?php echo $lieu;?></span>
						<div class="cal-res-poule-link <?php echo $class_reservation;?>">
                        <?php echo $lien_live_ou_billet;?>
                        <a href="<?php echo $rencontre_permalink;?>" class="nv-link-crt"><!-- <img src="/wp-content/uploads/2026/09/Vector-3.svg"/> --><i class="fas fa-arrow-right"></i></a>
                    </div>
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
                            </div>
                    <?php endforeach; ?>
                </div>
                <div>
                </div>
            </div>
    </section>
    <?php endif;?>

    <?php if($matchs_quarts):?>
        <section class="pd-5 eq-reslt-div">
            <div class="judo_pro_league">
                 <div class="eq-reslt-flx">
                     <h2 class="crt-title">Quarts</h2>
                     <a href="../../../calendrier-resultats-2023/quarts/" class="more-classement">Classement Quarts <i class="fa-solid fa-arrow-right-long"></i></a>
                  </div>
                <div class="cal-res-poule">
                    <?php foreach ($matchs_quarts as $rencontre):
                        $combat=get_field('les_combat', $rencontre->ID)[0];
                        $lieu=get_field('lieu_rencontre', $rencontre->ID);
                        $equipe1 =get_field('equipe_1', $rencontre->ID)[0];
                        $equipe2 =get_field('equipe_2', $rencontre->ID)[0];
                        $rencontre_permalink = get_the_permalink($rencontre->ID);
                        $score_equipe1 =$combat['nombre_de_combat_gagne_equipe_1'][0];
                        $score_equipe2 =$combat['nombre_de_combat_gagne_equipe_2'][0];
                        $image1_url=(get_field('logo_principal', $equipe1->ID))?get_field('logo_principal', $equipe1->ID):get_the_post_thumbnail_url($equipe1->ID);
                        $image2_url=(get_field('logo_principal', $equipe2->ID))?get_field('logo_principal', $equipe2->ID):get_the_post_thumbnail_url($equipe2->ID);
                        $date_debut=get_field('date_de_debut', $rencontre->ID, false, false);
                        $date_fin=get_field('date_de_fin', $rencontre->ID, false, false);
                        $abreviation1=(get_field('abreviation', $equipe1->ID))?get_field('abreviation', $equipe1->ID):$equipe1->post_title;
                        $abreviation2=(get_field('abreviation', $equipe2->ID))?get_field('abreviation', $equipe2->ID):$equipe2->post_title;
                        if(strtotime($now)<=strtotime($date_fin) && strtotime($now)>=strtotime($date_debut)){
                            $class_status='encours';
                            $equipe_gagnante =  'inconnue';
                            $texte_status='en cours';
                            $class_reservation="link-2";
        $lien_live_ou_billet='<a href="'.get_field('video_live', $rencontre->ID).'"  target="_blank" class="nv-link-crt brd-right"><img style="width: 27px; margin-bottom: -4px;" src="/wp-content/uploads/2026/09/live-classement.svg"/></a>';
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
        $lien_live_ou_billet=(get_field("lien_de_reservation", $rencontre->ID))?'<a href="'.get_field("lien_de_reservation", $rencontre->ID).'" target="_blank" class="nv-link-crt brd-right"><img style="width: 33px;margin-bottom: -2px;" src="/wp-content/uploads/2026/09/ticket.svg"/></a>':'';
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
                                <div class="cal-res-poule-link <?php echo $class_reservation;?>" <?php echo $style_couleur1;?>>
                                    <?php echo $lien_live_ou_billet;?>
                                    <a href="<?php echo $rencontre_permalink;?>" class="nv-link-crt">Détails <i class="fa-solid fa-angles-right"></i></a>
                                </div>
                            </div>
                    <?php endforeach; ?>
                </div>
                <div>
                </div>
            </div>
    </section>
    <?php endif;?>

    <?php if($matchs_f4):?>
        <section class="pd-5 eq-reslt-div">
            <div class="judo_pro_league">
                <div class="eq-reslt-flx">
                     <h2 class="crt-title">Final Four</h2>
                     <a href="../../../calendrier-resultats-2023/final4/" class="more-classement">Classement Final Four <i class="fa-solid fa-arrow-right-long"></i></a>
                </div>
                <div class="cal-res-poule">
                    <?php foreach ($matchs_f4 as $rencontre):
                        $combat=get_field('les_combat', $rencontre->ID)[0];
                        $lieu=get_field('lieu_rencontre', $rencontre->ID);
                        $equipe1 =get_field('equipe_1', $rencontre->ID)[0];
                        $equipe2 =get_field('equipe_2', $rencontre->ID)[0];
                        $rencontre_permalink = get_the_permalink($rencontre->ID);
                        $score_equipe1 =$combat['nombre_de_combat_gagne_equipe_1'][0];
                        $score_equipe2 =$combat['nombre_de_combat_gagne_equipe_2'][0];
                        $image1_url=(get_field('logo_principal', $equipe1->ID))?get_field('logo_principal', $equipe1->ID):get_the_post_thumbnail_url($equipe1->ID);
                        $image2_url=(get_field('logo_principal', $equipe2->ID))?get_field('logo_principal', $equipe2->ID):get_the_post_thumbnail_url($equipe2->ID);
                        $date_debut=get_field('date_de_debut', $rencontre->ID, false, false);
                        $date_fin=get_field('date_de_fin', $rencontre->ID, false, false);
                        $abreviation1=(get_field('abreviation', $equipe1->ID))?get_field('abreviation', $equipe1->ID):$equipe1->post_title;
                        $abreviation2=(get_field('abreviation', $equipe2->ID))?get_field('abreviation', $equipe2->ID):$equipe2->post_title;
                        if(strtotime($now)<=strtotime($date_fin) && strtotime($now)>=strtotime($date_debut)){
                            $class_status='encours';
                            $equipe_gagnante =  'inconnue';
                            $texte_status='en cours';
                            $class_reservation="link-2";
        $lien_live_ou_billet='<a href="'.get_field('video_live', $rencontre->ID).'"  target="_blank" class="nv-link-crt brd-right"><img style="width: 27px; margin-bottom: -4px;" src="/wp-content/uploads/2026/09/live-classement.svg"/></a>';
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
        $lien_live_ou_billet=(get_field("lien_de_reservation", $rencontre->ID))?'<a href="'.get_field("lien_de_reservation", $rencontre->ID).'" target="_blank" class="nv-link-crt brd-right"><img style="width: 33px;margin-bottom: -2px;" src="/wp-content/uploads/2026/09/ticket.svg"/></a>':'';
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
                            </div>
                    <?php endforeach; ?>
                </div>
                <div>

                </div>
            </div>
    </section>
    <?php endif;?>   

  </div>

  </div>
</article>

<style>
	.cal-res-poule-blc::before {
    content: "";
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 3px;
    background: linear-gradient( 90deg, <?php echo esc_attr($couleur1); ?> 0%, <?php echo esc_attr($couleur2); ?> 100% );
}
	.cal-res-poule-link a{background: <?php echo esc_attr($couleur1); ?> !important;}
/* 	    .team-link:hover {
        background: <?php echo esc_attr($couleur1); ?> !important;
    } */
</style>
