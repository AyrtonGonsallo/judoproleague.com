<?php
        $equipe_id=$_GET["equipeID"];
        $photos=get_field('photos');
        $credit_images = get_field('credit_images');
		$titre = get_field('titre');
        $equipe = get_field('equipes');
		$date=get_the_date('j F Y', $my_post->ID );
		$couleur1 = get_field('couleur1',$equipe_id);
		$site = get_field('site_web',$equipe_id);
		$style_couleur1=($couleur1)?'style="background: '.$couleur1.';"':'style="background: #e5332a;"';
		$image=get_field('logo_principal')?get_field('logo_principal'):get_the_post_thumbnail_url($equipe_id,"thumbnail");
		$couleur2 = get_field('couleur2',$equipe_id); 
		$style_couleur2=($couleur2)?'style="background: '.$couleur2.';"':'style="background: #990021;"';
		$team_permalink = get_the_permalink($equipe_id);
        $reseaux= get_field('reseaux_sociaux',$equipe_id);
        $rencontre=get_field('rencontre')[0];
        $equipe1 = get_field('equipe_1',$rencontre->ID)[0];
        $equipe2 = get_field('equipe_2',$rencontre->ID)[0];

        // Récupère la saison si la rencontre existe
        $saison = get_field("saisons", $rencontre->ID ?? null);

        // Si pas de rencontre ou saison vide → valeur par défaut
        if (!$rencontre || empty($saison)) {
            $saison = "2025-2026";
        }

        // Construction des titres
        $title  = "Photos de " . get_the_title($equipe1->ID) . "<br>" . " vs " . get_the_title($equipe2->ID) . " " . "<br>" . $saison;
        $title2 = get_the_title($equipe1->ID) . " vs " . get_the_title($equipe2->ID) . " " . $saison;

$team_id = $_GET["equipeID"];
$logo_principal = get_field( 'logo_principal', $equipe_id );
$logo_principal_url = $logo_principal
    ? $logo_principal
    : get_the_post_thumbnail_url( $team_id, 'full' );
$team_permalink = trailingslashit( get_permalink( $team_id ) );
$team_name      = get_the_title( $team_id );

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


<?php if($equipe_id){ ?>


<main id="primary" class="site-main  main-info-eq jpl-team-page">
<header class="nv.team-header">

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
                            class="jpl-team-menu-link <?php echo ( 'photos' === $key ) ? 'is-active' : ''; ?>"
                            style="
                                --menu-color: <?php echo esc_attr( 'photos' === $key ? $couleur1 : $couleur2 ); ?>;
                                --menu-color-hover: <?php echo esc_attr( 'photos' === $key ? $couleur2 : $couleur1 ); ?>;
                            "
                        >
                            <?php echo esc_html( $item['label'] ); ?>
                        </a>
                    <?php endforeach; ?>
                </nav>
            </div>
        </div>
    </section>



			<div class="jpl-team-topbar" style="max-width:1401px;margin:auto;">
                <a
                    href="<?php echo esc_url(home_url('/equipes-judo-pro-league/')); ?>"
                    class="jpl-team-back"
                >
                    <i class="fa-solid fa-arrow-left"></i>
                    <span>Retour aux équipes</span>
                </a>
				                <div class="jpl-team-breadcrumb">
        <span><a href="/equipes-judo-pro-league/">Equipes</a> > <a href="<?php echo $team_permalink;?>infos"><?php echo get_the_title($equipe_id);?></a> > <a href="<?php echo $team_permalink;?>photos">Photos</a> > <?php echo $title2;?></span>
                </div>	
            </div>



</header>
<?php }?>

<section class="jpl-team-section-header" style="max-width:1401px;margin:auto;">
                            <div>

                    <span class="jpl-page-eyebrow">
                        <?php echo esc_html( $team_name ); ?>
                    </span>

                       <h1 class="jpl-page-title"><?php echo $title;?></h1>

                    <p class="jpl-page-description">
                        Découvrez la gallerie de l'équipe.
                    </p>

                </div>
        </section>

					<div class="galerie-images-resultat">
						            
					<div class="liste-images-galerie judo_pro_league page-eq-gal" >

								<?php foreach($photos as $image){?>

								<div class="liste-images-element dld-btn-container" style="background-image: url(<?php echo '\''.esc_url($image['sizes']['medium_large']).'\'';?>);">

									<img class="diaporama" src="<?php echo esc_url($image['sizes']['large']); ?>" alt="<?php echo esc_attr($image['alt']); ?>" />
                                    <div class="dld-tnt-on-lightbox"><a href="<?php echo $image['sizes']['2048x2048'];?>" download class="btn-telhd">Télécharger en HD</a></div>

								</div>

								<?php } ?>

						</div>

					</div>

        <?php  if($credit_images){

            echo '<div class="txt-credit text-center"> <p>Crédit photos :  '.$credit_images.'<p></div>';

        }?>



