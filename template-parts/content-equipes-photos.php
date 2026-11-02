<?php
/**
 * Template part for displaying posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package pro-league
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

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

$couleur1 = $couleur1 ? $couleur1 : '#040b89';
$couleur2 = $couleur2 ? $couleur2 : '#e00078';

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
	
    <!-- =====================================================
         GALERIES
    ====================================================== -->

    <div id="tabs-6" class="page-eq-phot">
<div class="jpl-team-topbar">
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
                    <strong>Photos</strong>
                </div>	
            </div>
        <?php

        $args = array(
            'post_type'      => 'galerie',
            'posts_per_page' => -1,
            'orderby'        => 'post_date',
            'order'          => 'DESC',
            'meta_query'     => array(
                'relation' => 'AND',
                array(
                    'key'     => 'equipes',
                    'value'   => '"' . get_the_ID() . '"',
                    'compare' => 'LIKE',
                ),
            ),
        );

        $galeries = get_posts( $args );

        if ( $galeries ) :
        ?>
        <!-- =====================================================
             HERO DE SECTION
        ====================================================== -->
        <section class="jpl-team-section-header">
                <div>

                    <span class="jpl-page-eyebrow">
                        <?php echo esc_html( $team_name ); ?>
                    </span>

                    <h1 class="jpl-page-title">
                        Photos
                    </h1>

                    <p class="jpl-page-description">
                        Découvrez les photoss de l'équipe.
                    </p>

                </div>
        </section>
            <div /*class="galerie-images-resultat"*/>

                <div class="liste-images-galerie judo_pro_league">

                    <?php foreach ( $galeries as $image_galerie ) : ?>

                        <?php

                        $photos = get_field( 'photos', $image_galerie->ID );

                        $credit_images = get_field(
                            'credit_images',
                            $image_galerie->ID
                        );

                        $titre = get_field(
                            'titre',
                            $image_galerie->ID
                        );

                        if ( empty( $photos ) || ! is_array( $photos ) ) {
                            continue;
                        }

                        $cover = $photos[0];

                        if ( empty( $cover ) ) {
                            continue;
                        }

                        $cover_url = '';

                        if ( isset( $cover['sizes']['medium_large'] ) ) {
                            $cover_url = $cover['sizes']['medium_large'];
                        } elseif ( isset( $cover['url'] ) ) {
                            $cover_url = $cover['url'];
                        }

                        if ( empty( $cover_url ) ) {
                            continue;
                        }

                        $link = add_query_arg(
                            'equipeID',
                            get_the_ID(),
                            get_permalink( $image_galerie->ID )
                        );

                        ?>

                        <a
                            href="<?php echo esc_url( $link ); ?>"
                            class="team-gallery-item jpl-video-card"
                        >

                            <div
                                class="liste-images-element"
                                style="background-image:url('<?php echo esc_url( $cover_url ); ?>');"
                            ></div>
<div class="jpl-video-content">	
                            <h3 class="">

                                <?php
                                echo esc_html(
                                    $titre . ' - ' . get_the_date(
                                        'Y',
                                        $image_galerie->ID
                                    )
                                );
                                ?>

                            </h3>
</div>
                        </a>

                    <?php endforeach; ?>

                </div>

            </div>

        <?php endif; ?>



    <!-- =====================================================
         LISTE DES ÉQUIPES
    ====================================================== -->

    <?php

    $args = array(
        'post_type'      => 'equipes',
        'posts_per_page' => -1,
    );

    $liste_equipes = get_posts( $args );

    ?>


    <!-- =====================================================
         PARTENAIRES
    ====================================================== -->

    <?php

    if ( have_rows( 'liste_des_partenaires' ) ) :

        while ( have_rows( 'liste_des_partenaires' ) ) :

            the_row();

            $style = get_row_layout();

            $section = false;

            switch ( $style ) {

                case 'partenaires':

                    require_once THEMEDIR . 'inc/acf-blocs/bloc-partenaires.php';

                    $section = bloc_partenaires();

                    break;
            }

        endwhile;

    endif;

    ?>

</article>