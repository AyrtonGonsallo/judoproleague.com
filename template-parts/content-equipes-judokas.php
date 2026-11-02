<?php
/**
 * Template part for displaying team judokas
 *
 * @package pro-league
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/* =========================================================
 * DONNÉES DE BASE
 * ========================================================= */

$team_id = get_the_ID();

$saison_value = isset( $_GET['saison_value'] )
    ? sanitize_text_field( wp_unslash( $_GET['saison_value'] ) )
    : '2026-2027';

$site           = get_field( 'site_web', $team_id );
$description    = get_field( 'presentation', $team_id );
$saisons        = get_field( 'saisons', $team_id );
$directeur      = get_field( 'directeur', $team_id );
$entraineur     = get_field( 'entraineur', $team_id );
$date_creation  = get_field( 'date_de_creation', $team_id );
$reseaux        = get_field( 'reseaux_sociaux', $team_id );
$palmares       = get_field( 'palmares', $team_id );
$galerie_photos = get_field( 'galerie_photos', $team_id );
$gender         = get_field( 'genre', $team_id );
$partenaires    = get_field( 'partenaires', $team_id );

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

/* =========================================================
 * CORRECTION CATÉGORIES
 * ========================================================= */

if ( ! function_exists( 'get_correct_categorie' ) ) {

    function get_correct_categorie( $saison_value, $cat ) {

        if ( $saison_value === '2024-2025' ) {

            switch ( $cat ) {

                case '-65':
                    return '-66';

                case '-75':
                    return '-73';

                case '-85':
                    return '-81';

                case '-95':
                    return '-90';

                case '+95':
                    return '+90';

                default:
                    return $cat;
            }
        }

        return $cat;
    }
}

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

/* =========================================================
 * RÉCUPÉRATION DES JUDOKAS
 * ========================================================= */

global $wpdb;

$ids = $wpdb->get_col(
    $wpdb->prepare(
        "
        SELECT DISTINCT equipe.post_id

        FROM {$wpdb->postmeta} AS equipe

        INNER JOIN {$wpdb->postmeta} AS saison
            ON saison.post_id = equipe.post_id

        INNER JOIN {$wpdb->posts} AS p
            ON p.ID = equipe.post_id

        WHERE p.post_type = 'judoka'

        AND equipe.meta_key LIKE
            'equipes_par_saisons_%%_equipe_judoka'

        AND saison.meta_key LIKE
            'equipes_par_saisons_%%_saisons'

        AND equipe.meta_key REGEXP
            '^equipes_par_saisons_[0-9]+_equipe_judoka$'

        AND saison.meta_key = CONCAT(
            SUBSTRING_INDEX(
                equipe.meta_key,
                '_equipe_judoka',
                1
            ),
            '_saisons'
        )

        AND equipe.meta_value LIKE %s

        AND saison.meta_value = %s

        ORDER BY RAND()
        ",
        '%' . $team_id . '%',
        $saison_value
    )
);

$judokas = array();

if ( ! empty( $ids ) ) {

    foreach ( $ids as $id ) {

        $judokas[] = array(
            'sexe'   => get_field( 'sexe', $id ),
            'prenom' => get_field( 'prenom_judoka', $id ),
            'nom'    => get_field( 'nom_judoka', $id ),
            'post'   => get_post( $id ),
        );
    }
}

/* =========================================================
 * TRI DES JUDOKAS
 * ========================================================= */

usort(
    $judokas,
    function ( $a, $b ) {

        $sexe_compare = strcasecmp(
            (string) $a['sexe'],
            (string) $b['sexe']
        );

        if ( $sexe_compare !== 0 ) {
            return $sexe_compare;
        }

        $prenom_compare = strcasecmp(
            (string) $a['prenom'],
            (string) $b['prenom']
        );

        if ( $prenom_compare !== 0 ) {
            return $prenom_compare;
        }

        return strcasecmp(
            (string) $a['nom'],
            (string) $b['nom']
        );
    }
);

?>

<!-- =========================================================
     PAGE
========================================================= -->

<article
    id="post-<?php the_ID(); ?>"
    <?php post_class( 'jpl-team-page jpl-judokas-page' ); ?>
    style="
        --team-color-1: <?php echo esc_attr( $couleur1 ); ?>;
        --team-color-2: <?php echo esc_attr( $couleur2 ); ?>;
        --team-gradient: linear-gradient(
            90deg,
            <?php echo esc_attr( $couleur1 ); ?> 0%,
            <?php echo esc_attr( $couleur2 ); ?> 100%
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
                            class="jpl-team-menu-link <?php echo ( 'judokas' === $key ) ? 'is-active' : ''; ?>"
                            style="
                                --menu-color: <?php echo esc_attr( 'judokas' === $key ? $couleur1 : $couleur2 ); ?>;
                                --menu-color-hover: <?php echo esc_attr( 'judokas' === $key ? $couleur2 : $couleur1 ); ?>;
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
         CONTENU
    ====================================================== -->

    <section class="jpl-judokas-content">

        <div class="jpl-team-container">
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
                    <strong>Judokas</strong>
                </div>	
            </div>
            <!-- =================================================
                 HEADER PAGE
            ================================================== -->

            <div class="jpl-judokas-header">

                <div>

                    <span class="jpl-page-eyebrow">
                        <?php echo esc_html( $team_name ); ?>
                    </span>

                    <h1 class="jpl-page-title">
                        Les judokas
                    </h1>

                    <p class="jpl-page-description">
                        Découvrez les judokas de l'équipe pour la saison
                        <?php echo esc_html( $saison_value ); ?>.
                    </p>

                </div>


<!-- SÉLECTEUR SAISON -->

<?php if ( ! empty( $saisons ) && is_array( $saisons ) ) : ?>

    <form
        method="GET"
        action="<?php echo esc_url( $team_permalink . 'judokas/' ); ?>"
        class="jpl-season-form"
    >

        <div class="jpl-season-select-wrap">

            <select
                name="saison_value"
                id="saison_value"
                class="season-selector-select"
            >

                <?php foreach ( $saisons as $saison ) : ?>

                    <option
                        value="<?php echo esc_attr( $saison ); ?>"
                        <?php selected( $saison_value, $saison ); ?>
                    >
                        Saison <?php echo esc_html( $saison ); ?>
                    </option>

                <?php endforeach; ?>

            </select>

        </div>

    </form>

<?php endif; ?>

            </div>


            <!-- =================================================
                 META
            ================================================== -->

            <div class="jpl-judokas-meta">

                <span>
                    <strong><?php echo count( $judokas ); ?></strong>
                    judoka<?php echo count( $judokas ) > 1 ? 's' : ''; ?>
                </span>

                <span class="jpl-meta-dot"></span>

                <span>
                    Saison <?php echo esc_html( $saison_value ); ?>
                </span>

            </div>


            <!-- =================================================
                 GRID JUDOKAS
            ================================================== -->

            <?php if ( ! empty( $judokas ) ) : ?>

                <div class="jpl-judokas-grid">

                    <?php foreach ( $judokas as $judoka_array ) : ?>

                        <?php

                        $judoka = $judoka_array['post'];

                        if ( ! $judoka ) {
                            continue;
                        }

                        if ( get_field( 'masquer', $judoka->ID ) ) {
                            continue;
                        }

                        $nom = get_field(
                            'nom_judoka',
                            $judoka->ID
                        );

                        $prenom = get_field(
                            'prenom_judoka',
                            $judoka->ID
                        );

                        $cat_poids = get_field(
                            'categorie_de_poids',
                            $judoka->ID
                        );

                        $pays = get_field(
                            'pays',
                            $judoka->ID
                        );

                        $cat_age = get_field(
                            'categorie_dage',
                            $judoka->ID
                        );

                        $date_naissance = get_field(
                            'date_de_naissance',
                            $judoka->ID
                        );

                        $image = get_the_post_thumbnail_url(
                            $judoka->ID,
                            'large'
                        );

                        if ( ! $image ) {
                            $image = home_url(
                                '/wp-content/uploads/2023/09/profil.jpg'
                            );
                        }

                        $judoka_url = get_permalink( $judoka->ID );

                        ?>

                        <article class="jpl-judoka-card">

                            <!-- PHOTO -->

                            <a
                                href="<?php echo esc_url( $judoka_url ); ?>"
                                class="jpl-judoka-image-link"
                            >

                                <div class="jpl-judoka-image">

                                    <img
                                        src="<?php echo esc_url( $image ); ?>"
                                        alt="<?php echo esc_attr( $prenom . ' ' . $nom ); ?>"
                                        loading="lazy"
                                    >

                                </div>

                            </a>


                            <!-- INFORMATIONS -->

                            <div class="jpl-judoka-card-content">

                                <h2 class="jpl-judoka-name">

                                    <?php echo esc_html( trim( $prenom . ' ' . $nom ) ); ?>

                                </h2>


                                <?php if ( $cat_poids ) : ?>

                                    <div class="jpl-judoka-category">

                                        <span>Catégorie</span>

                                        <strong>
                                            <?php
                                            echo esc_html(
                                                get_correct_categorie(
                                                    $saison_value,
                                                    $cat_poids
                                                )
                                            );
                                            ?>kg
                                        </strong>

                                    </div>

                                <?php endif; ?>


                                <a
                                    href="<?php echo esc_url( $judoka_url ); ?>"
                                    class="jpl-judoka-link"
                                >

                                    <span>Voir la fiche</span>

                                    <i class="fa-solid fa-arrow-right"></i>

                                </a>

                            </div>

                        </article>

                    <?php endforeach; ?>

                </div>

            <?php else : ?>

                <div class="jpl-judokas-empty">

                    <div class="jpl-empty-icon">
                        <i class="fa-solid fa-user-slash"></i>
                    </div>

                    <h2>
                        Aucun judoka
                    </h2>

                    <p>
                        Aucun judoka n'est disponible pour la saison
                        <?php echo esc_html( $saison_value ); ?>.
                    </p>

                </div>

            <?php endif; ?>


        </div>

    </section>

</article>


<!-- =========================================================
     JAVASCRIPT
========================================================= -->

<script>
document.addEventListener('DOMContentLoaded', function () {

    const select = document.getElementById('saison_value');
    const form = document.querySelector('.jpl-season-form');

    if (!select || !form) {
        return;
    }

    select.addEventListener('change', function () {
        form.submit();
    });

});
</script>

<style>
/* =========================================================
   VARIABLES
========================================================= */
.jpl-judokas-page {
    --team-gradient:
        linear-gradient(
            90deg,
            var(--team-color-1),
            var(--team-color-2)
        );
}
/* =========================================================
   CONTAINER
========================================================= */
.jpl-judokas-page .jpl-team-container {
    width: min(1400px, calc(100% - 60px));
    margin: 0 auto;
}
.jpl-judokas-content {
    background: #f7f7f9;
    padding: 28px 0 80px;
}
/* =========================================================
   PAGE HEADER
========================================================= */
.jpl-judokas-header {
    display: flex;
    align-items: flex-end;
    justify-content: space-between;
    gap: 30px;
    margin-bottom: 18px;
}
.jpl-page-eyebrow {
    display: block;
    margin-bottom: 8px;
    color: var(--team-color-1);
    font-size: 12px;
    font-weight: 800;
    text-transform: uppercase;
    letter-spacing: .12em;
}
.jpl-page-title {
    margin: 0;
    color: #16161b;
    font-size: clamp(32px, 4vw, 50px);
    font-weight: 800;
    line-height: 1.05;
}
.jpl-page-description {
    max-width: 620px;
    margin: 14px 0 0;
    color: #777780;
    font-size: 15px;
    line-height: 1.7;
}
/* =========================================================
   META
========================================================= */
.jpl-judokas-meta {
    display: flex;
    align-items: center;
    gap: 10px;
    margin-bottom: 25px;
    color: #85858e;
    font-size: 13px;
}
.jpl-judokas-meta strong {
    color: #17171c;
}
.jpl-meta-dot {
    width: 4px;
    height: 4px;
    border-radius: 50%;
    background: var(--team-color-1);
}
/* =========================================================
   GRID
========================================================= */
.jpl-judokas-grid {
    display: grid;
    grid-template-columns: repeat(5, minmax(0, 1fr));
    gap: 22px;
}
/* =========================================================
   CARTE
========================================================= */

.jpl-judoka-card {
    position: relative;
    overflow: hidden;
    background: #fff;
    border: 1px solid #e8e8ed;
    border-radius: 18px;
    box-shadow: 0 8px 30px rgba(20,20,40,.055);
    transition:
        transform .3s ease,
        box-shadow .3s ease,
        border-color .3s ease;
}

.jpl-judoka-card::before {
    content: "";
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 3px;
    background: var(--team-gradient);
    z-index: 2;
}

.jpl-judoka-card:hover {
    transform: translateY(-6px);
    box-shadow: 0 16px 35px rgba(20,20,40,.10);
    border-color: rgba(0,0,0,.08);
}
/* =========================================================
   PHOTO
========================================================= */
.jpl-judoka-image-link {
    display: block;
    text-decoration: none !important;
}
.jpl-judoka-image {
    width: 100%;
    aspect-ratio: 1 / 1.08;
    overflow: hidden;
    background: #f0f0f3;
}

.jpl-judoka-image img {
    width: 100%;
    height: 100%;
    display: block;
    object-fit: cover;
    transition: transform .4s ease;
}
.jpl-judoka-card:hover .jpl-judoka-image img {
    transform: scale(1.04);
}
/* =========================================================
   CARD CONTENT
========================================================= */
.jpl-judoka-card-content {
    padding: 20px;
    min-height: 195px;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
}
.jpl-judoka-number {
    display: block;
    margin-bottom: 7px;
    color: var(--team-color-1);
    font-size: 10px;
    font-weight: 800;
    letter-spacing: .12em;
    text-transform: uppercase;
}

.jpl-judoka-name {
    margin: 0 0 18px;
    color: #16161b;
    font-size: 20px;
    font-weight: 800;
    line-height: 1.15;
}
/* =========================================================
   CATÉGORIE
========================================================= */
.jpl-judoka-category {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding-top: 13px;
    margin-bottom: 18px;
    border-top: 1px solid #eeeeF1;
    color: #85858e;
    font-size: 18px;
}

.jpl-judoka-category strong {
    padding: 6px 10px;
    border-radius: 50px;
    background: rgba(0,0,0,.04);
    color: #17171c;
    font-size: 18px;
}
/* =========================================================
   BOUTON
========================================================= */

.jpl-judoka-link {
    display: flex;
    align-items: center;
    justify-content: space-between;
    width: 100%;
    padding: 6px 14px;
    border-radius: 10px;
    background: var(--team-gradient);
    color: #fff !important;
    font-size: 21px;
    font-weight: 700;
    text-decoration: none !important;
    transition:
        transform .25s ease,
        box-shadow .25s ease;
}

.jpl-judoka-link i {
    font-size: 11px;
    transition: transform .25s ease;
}

.jpl-judoka-link:hover {
    color: #fff !important;
    transform: translateY(-2px);
    box-shadow: 0 7px 18px rgba(0,0,0,.12);
}

.jpl-judoka-link:hover i {
    transform: translateX(3px);
}

/* =========================================================
   EMPTY
========================================================= */

.jpl-judokas-empty {
    padding: 70px 30px;
    text-align: center;
    background: #fff;
    border: 1px solid #e7e7ec;
    border-radius: 18px;
}

.jpl-empty-icon {
    width: 55px;
    height: 55px;
    margin: 0 auto 15px;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 50%;
    background: rgba(0,0,0,.04);
    color: var(--team-color-1);
    font-size: 20px;
}

.jpl-judokas-empty h2 {
    margin: 0 0 8px;
    color: #17171c;
    font-size: 22px;
}

.jpl-judokas-empty p {
    margin: 0;
    color: #888;
    font-size: 14px;
}

</style>