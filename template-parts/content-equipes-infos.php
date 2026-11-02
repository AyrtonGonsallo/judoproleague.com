<?php
/**
 * Template Name: Modèle equipe JPL
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

date_default_timezone_set('Europe/Paris');

get_header();

$team_id = get_queried_object_id();

$saison_value = isset($_GET['saison_value'])
    ? sanitize_text_field($_GET['saison_value'])
    : '2026-2027';

/* =========================================================
 * DONNÉES ÉQUIPE
 * ========================================================= */

$title       = get_field('titre_de_la_page', $team_id);
$description = get_field('presentation', $team_id);
$directeur   = get_field('directeur', $team_id);
$entraineur  = get_field('entraineur', $team_id);
$partenaires = get_field('partenaires', $team_id);
$reseaux     = get_field('reseaux_sociaux', $team_id);

$couleur1 = get_field('couleur1', $team_id);
$couleur2 = get_field('couleur2', $team_id);

$couleur1 = $couleur1 ? $couleur1 : '#7c3aed';
$couleur2 = $couleur2 ? $couleur2 : '#111111';

$logo_principal = get_field('logo_principal', $team_id);
$logo_circle    = get_field('logo_circle', $team_id);

$logo_principal_url = $logo_principal
    ? $logo_principal
    : get_the_post_thumbnail_url($team_id, 'full');

$logo_circle_url = $logo_circle
    ? $logo_circle
    : $logo_principal_url;

$team_permalink = trailingslashit(get_permalink($team_id));
$team_name      = get_the_title($team_id);
$photo_du_staff = get_field('photo_du_staff', $team_id);
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
 * VIDÉOS
 * ========================================================= */

$args1 = array(
    'post_type'      => 'video_youtube',
    'posts_per_page' => 3,
    'order'          => 'DESC',
    'orderby'        => 'date',
    'meta_query'     => array(
        array(
            'key'     => 'equipe1',
            'value'   => '"' . $team_id . '"',
            'compare' => 'LIKE'
        )
    ),
);

$videos = get_posts($args1);

/* =========================================================
 * GALERIES
 * ========================================================= */

$args2 = array(
    'post_type'      => 'galerie',
    'posts_per_page' => 3,
    'orderby'        => 'date',
    'order'          => 'DESC',
    'meta_query'     => array(
        array(
            'key'     => 'equipes',
            'value'   => '"' . $team_id . '"',
            'compare' => 'LIKE'
        )
    ),
);

$galeries = get_posts($args2);

/* =========================================================
 * ACTUALITÉS
 * ========================================================= */

$args3 = array(
    'post_type'      => 'post',
    'posts_per_page' => 3,
    'orderby'        => 'date',
    'order'          => 'DESC',
    'meta_query'     => array(
        array(
            'key'     => 'equipes',
            'value'   => '"' . $team_id . '"',
            'compare' => 'LIKE'
        )
    ),
);

$news = get_posts($args3);

/* =========================================================
 * DERNIÈRE RENCONTRE
 * ========================================================= */

$today_datetime = current_time('Y-m-d H:i:s');

$args4 = array(
    'post_type'      => 'rencontre',
    'posts_per_page' => 1,
    'meta_key'       => 'date_de_debut',
    'orderby'        => 'meta_value',
    'order'          => 'DESC',
    'meta_query'     => array(
        'relation' => 'AND',

        array(
            'key'     => 'date_de_debut',
            'value'   => $today_datetime,
            'compare' => '<=',
            'type'    => 'DATETIME',
        ),

        array(
            'relation' => 'OR',

            array(
                'key'     => 'equipe_1',
                'value'   => '"' . $team_id . '"',
                'compare' => 'LIKE'
            ),

            array(
                'key'     => 'equipe_2',
                'value'   => '"' . $team_id . '"',
                'compare' => 'LIKE'
            )
        )
    ),
);

$derniere_rencontre = get_posts($args4);

/* =========================================================
 * PROCHAINE RENCONTRE
 * ========================================================= */

$args5 = array(
    'post_type'      => 'rencontre',
    'posts_per_page' => 1,
    'meta_key'       => 'date_de_debut',
    'orderby'        => 'meta_value',
    'order'          => 'ASC',
    'meta_query'     => array(
        'relation' => 'AND',

        array(
            'key'     => 'date_de_debut',
            'value'   => $today_datetime,
            'compare' => '>=',
            'type'    => 'DATETIME',
        ),

        array(
            'relation' => 'OR',

            array(
                'key'     => 'equipe_1',
                'value'   => '"' . $team_id . '"',
                'compare' => 'LIKE'
            ),

            array(
                'key'     => 'equipe_2',
                'value'   => '"' . $team_id . '"',
                'compare' => 'LIKE'
            )
        )
    ),
);

$prochaine_rencontre = get_posts($args5);

/* =========================================================
 * 3 JUDOKAS ALÉATOIRES
 * ========================================================= */

global $wpdb;

/*
$judokas_random = $wpdb->get_results(
    $wpdb->prepare(
        "SELECT *
         FROM prol_judokas_saisons
         WHERE saison = %s
         AND equipe_id = %d
         ORDER BY RAND()
         LIMIT 3",
        $saison_value,
        $team_id
    )
);
*/


//au lieu de 
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

                    AND equipe.meta_key LIKE 'equipes_par_saisons_%_equipe_judoka'
                    AND saison.meta_key LIKE 'equipes_par_saisons_%_saisons'

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
         LIMIT 3
                    ",
                    '%' . $team_id . '%',
                    $saison_value
                )
            );

      
            
           $judokas = [];

            foreach ($ids as $id) {
                $judokas[] = [
                    'sexe'   => get_field('sexe', $id),
                    'prenom' => get_field('prenom_judoka', $id),
                    'nom'    => get_field('nom_judoka', $id),
                    'post'   => get_post($id),
                ];
            }

            usort($judokas, function ($a, $b) {
                return strcasecmp($a['sexe'], $b['sexe'])
                    ?: strcasecmp($a['prenom'], $b['prenom'])
                    ?: strcasecmp($a['nom'], $b['nom']);
            });

/* =========================================================
 * CLASSEMENT
 * ========================================================= */

require_once THEMEDIR . 'template-parts/content-stats-poules-equipes-requests-total.php';

$classement_total = get_classement($saison_value);
$datas = array();

if (
    $classement_total &&
    isset($classement_total['total'][$team_name][0])
) {
    $datas = $classement_total['total'][$team_name][0];
}

/* =========================================================
 * HELPER STATS
 * ========================================================= */

function jpl_team_stat_value($datas, $key) {
    return isset($datas[$key]) && $datas[$key] !== ''
        ? $datas[$key]
        : 0;
}

?>

<link
    href="https://cdn.jsdelivr.net/npm/@splidejs/splide@4.1.4/dist/css/splide.min.css"
    rel="stylesheet"
>

<script src="https://cdn.jsdelivr.net/npm/@splidejs/splide@4.1.4/dist/js/splide.min.js"></script>
<main
    id="primary"
    class="site-main jpl-team-page jpl-equipe-infos"
    style="
        --team-color-1: <?php echo esc_attr($couleur1); ?>;
        --team-color-2: <?php echo esc_attr($couleur2); ?>;
    "
>
    <!-- =====================================================
         HEADER ÉQUIPE
    ====================================================== -->
    <section class="jpl-team-header">
        <div class="jpl-team-container">
            <div class="jpl-team-identity">
				<div class="menu-equipe">
                <div class="jpl-team-main-logo">
                    <?php if ($logo_principal_url): ?>
                        <img
                            src="<?php echo esc_url($logo_principal_url); ?>"
                            alt="<?php echo esc_attr($team_name); ?>"
                        >
<!--                     <?php endif; ?>
                </div>
                <div class="jpl-team-identity-content">
                    <span class="jpl-team-eyebrow">
                        Judo Pro League
                    </span>
                    <h1>
                        <?php echo esc_html($team_name); ?>
                    </h1>
                    <?php if ($saison_value): ?>
                        <span class="jpl-team-season">
                            Saison <?php echo esc_html($saison_value); ?>
                        </span>
                    <?php endif; ?> -->
                </div>
            </div>
			            <!-- MENU ÉQUIPE -->
            <nav class="jpl-team-menu">
                <?php foreach ($menu_items as $key => $item): ?>
                    <a
                        href="<?php echo esc_url($item['url']); ?>"
                        class="jpl-team-menu-link <?php echo $key === 'infos' ? 'is-active' : ''; ?>"
                        <?php if ($key === 'infos'): ?>
                            style="
                                --menu-color: <?php echo esc_attr($couleur1); ?>;
                                --menu-color-hover: <?php echo esc_attr($couleur2); ?>;
                            "
                        <?php else: ?>
                            style="
                                --menu-color: <?php echo esc_attr($couleur2); ?>;
                                --menu-color-hover: <?php echo esc_attr($couleur1); ?>;
                            "
                        <?php endif; ?>
                    >
                        <?php echo esc_html($item['label']); ?>
                    </a>
                <?php endforeach; ?>
            </nav>
		  </div>
        </div>
    </section>


    <!-- =====================================================
         CONTENU PRINCIPAL
    ====================================================== -->

    <section class="jpl-team-content">

        <div class="jpl-team-container">
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
                    <span>›</span>
                    <strong>
                        <?php echo esc_html($team_name); ?>
                    </strong>
                </div>
            </div>
            <div class="jpl-team-layout">

                <!-- =================================================
                     COLONNE GAUCHE
                ================================================== -->

                <aside class="jpl-team-sidebar">


                    <!-- STAFF -->

                    <div class="jpl-team-card jpl-staff-card">

                        <div
                            class="jpl-team-card-heading"
                            style="background: <?php echo esc_attr($couleur1); ?>;"
                        >
                            <span>STAFF</span>
                        </div>

                        <div class="jpl-staff-logo">

                            <?php if ($photo_du_staff): ?>

                                <img
                                    src="<?php echo esc_url($photo_du_staff); ?>"
                                    alt="<?php echo esc_attr($team_name); ?>"
                                >

                            <?php endif; ?>

                        </div>

                        <div class="jpl-staff-info">

                            <div class="jpl-staff-row">

                                <span class="jpl-staff-label">
                                    Président(e)
                                </span>

                                <strong>
                                    <?php echo $directeur ? esc_html($directeur) : '—'; ?>
                                </strong>

                            </div>

                            <div
                                class="jpl-staff-separator"
                                style="background: <?php echo esc_attr($couleur1); ?>;"
                            ></div>

                            <div class="jpl-staff-row">

                                <span class="jpl-staff-label">
                                    Entraîneur(s)
                                </span>

                                <strong>
                                    <?php echo $entraineur ? esc_html($entraineur) : '—'; ?>
                                </strong>

                            </div>

                        </div>

                    </div>


                    <!-- CLASSEMENT -->

                    <div class="jpl-team-card jpl-ranking-card">

                        <div
                            class="jpl-team-card-heading"
                            style="background: <?php echo esc_attr($couleur1); ?>;"
                        >

                            <span>CLASSEMENT</span>

                            <?php if (isset($datas['classement'])): ?>

                                <strong
                                    style="background: <?php echo esc_attr($couleur2); ?>;"
                                >
                                    <?php
                                    echo esc_html($datas['classement']);

                                    if ((int)$datas['classement'] === 1) {
                                        echo 'er';
                                    } else {
                                        echo 'e';
                                    }
                                    ?>
                                </strong>

                            <?php endif; ?>

                        </div>


                        <div class="jpl-ranking-results">

                            <div>
                                <strong>
                                    <?php echo esc_html(jpl_team_stat_value($datas, 'victoires')); ?>
                                </strong>

                                <span>Victoires</span>
                            </div>

                            <div>
                                <strong>
                                    <?php echo esc_html(jpl_team_stat_value($datas, 'nuls')); ?>
                                </strong>

                                <span>Nuls</span>
                            </div>

                            <div>
                                <strong>
                                    <?php echo esc_html(jpl_team_stat_value($datas, 'defaites')); ?>
                                </strong>

                                <span>Défaites</span>
                            </div>

                        </div>


                        <div class="jpl-team-stats">

                            <div class="jpl-team-stats-title">
                                Statistiques
                            </div>

                            <?php
                            $stats = array(
                                'Ippon marqués'    => 'ippons_marqués',
                                'Ippon reçus'     => 'ippons_concédés',
                                'Waza-ari marqués' => 'wazaris_marqués',
                                'Waza-ari reçus'  => 'wazaris_concédés',
                            );
                            ?>

                            <?php foreach ($stats as $label => $key): ?>

                                <div class="jpl-team-stat-row">

                                    <span>
                                        <?php echo esc_html($label); ?>
                                    </span>

                                    <strong>
                                        <?php echo esc_html(jpl_team_stat_value($datas, $key)); ?>
                                    </strong>

                                </div>

                            <?php endforeach; ?>

                        </div>

                    </div>

                </aside>


                <!-- =================================================
                     COLONNE DROITE
                ================================================== -->

                <div class="jpl-team-main">


                    <!-- PROCHAINE / DERNIÈRE RENCONTRE -->

                    <?php if ($prochaine_rencontre || $derniere_rencontre): ?>

                        <div class="jpl-team-card jpl-match-card">

                            <?php if ($prochaine_rencontre): ?>

                                <?php
                                $rencontre = $prochaine_rencontre[0];

                                $niveau = get_field('niveau', $rencontre->ID);
                                $journee = get_field('journee', $rencontre->ID);
                                $lieu = get_field('lieu_rencontre', $rencontre->ID);

                                $combat = get_field('les_combat', $rencontre->ID);
                                $combat = is_array($combat) && isset($combat[0]) ? $combat[0] : array();

                                $equipe1_field = get_field('equipe_1', $rencontre->ID);
                                $equipe2_field = get_field('equipe_2', $rencontre->ID);

                                $equipe1 = is_array($equipe1_field) && isset($equipe1_field[0])
                                    ? $equipe1_field[0]
                                    : null;

                                $equipe2 = is_array($equipe2_field) && isset($equipe2_field[0])
                                    ? $equipe2_field[0]
                                    : null;

                                $date_debut = get_field(
                                    'date_de_debut',
                                    $rencontre->ID,
                                    false,
                                    false
                                );

                                $image1_url = $equipe1
                                    ? (get_field('logo_principal', $equipe1->ID)
                                        ?: get_the_post_thumbnail_url($equipe1->ID))
                                    : '';

                                $image2_url = $equipe2
                                    ? (get_field('logo_principal', $equipe2->ID)
                                        ?: get_the_post_thumbnail_url($equipe2->ID))
                                    : '';

                                $lien = get_permalink($rencontre->ID);
                                ?>

                                <div class="jpl-match-header">

                                    <div>

                                        <span class="jpl-section-eyebrow">
                                            Prochaine rencontre /
                                        </span>

                                        <span class="jpl-section-eyebrow">
                                            <?php echo esc_html($journee ?: $niveau); ?>
                                        </span>
                                <div class="jpl-match-meta">

                                    <?php if ($date_debut): ?>

                                        <span>
                                            <i class="fa-regular fa-calendar"></i>

                                            <?php
                                            echo esc_html(
                                                wp_date(
                                                    'l d F Y',
                                                    strtotime($date_debut),
                                                    wp_timezone()
                                                )
                                            );
                                            ?>
                                        </span>

                                    <?php endif; ?>

                                    <?php if ($lieu): ?>

                                        <span>
                                            <i class="fa-solid fa-location-dot"></i>
                                            <?php echo esc_html($lieu); ?>
                                        </span>

                                    <?php endif; ?>

                                </div>
                                    </div>

                                    <a
                                        href="<?php echo esc_url($lien); ?>"
                                        class="jpl-match-more"
                                        style="background: <?php echo esc_attr($couleur1); ?>;"
                                    >
                                        Voir le match
                                        <i class="fa-solid fa-arrow-right"></i>
                                    </a>

                                </div>





                                <div class="jpl-match-versus">

                                    <div class="jpl-match-team">

                                        <?php if ($image1_url): ?>

                                            <div class="jpl-match-logo">
                                                <img
                                                    src="<?php echo esc_url($image1_url); ?>"
                                                    alt=""
                                                >
                                            </div>

                                        <?php endif; ?>

                                        <strong>
                                            <?php echo $equipe1 ? esc_html($equipe1->post_title) : ''; ?>
                                        </strong>

                                    </div>


                                    <div class="jpl-match-score">
                                        <span>0</span>
                                        <b>—</b>
                                        <span>0</span>
                                    </div>


                                    <div class="jpl-match-team">

                                        <?php if ($image2_url): ?>

                                            <div class="jpl-match-logo">
                                                <img
                                                    src="<?php echo esc_url($image2_url); ?>"
                                                    alt=""
                                                >
                                            </div>

                                        <?php endif; ?>

                                        <strong>
                                            <?php echo $equipe2 ? esc_html($equipe2->post_title) : ''; ?>
                                        </strong>

                                    </div>

                                </div>

                            <?php else: ?>

                                <?php
                                $rencontre = $derniere_rencontre[0];

                                $niveau = get_field('niveau', $rencontre->ID);
                                $journee = get_field('journee', $rencontre->ID);
                                $lieu = get_field('lieu_rencontre', $rencontre->ID);

                                $combat = get_field('les_combat', $rencontre->ID);
                                $combat = is_array($combat) && isset($combat[0]) ? $combat[0] : array();

                                $equipe1_field = get_field('equipe_1', $rencontre->ID);
                                $equipe2_field = get_field('equipe_2', $rencontre->ID);

                                $equipe1 = is_array($equipe1_field) && isset($equipe1_field[0])
                                    ? $equipe1_field[0]
                                    : null;

                                $equipe2 = is_array($equipe2_field) && isset($equipe2_field[0])
                                    ? $equipe2_field[0]
                                    : null;

                                $score1 = isset($combat['nombre_de_combat_gagne_equipe_1'])
                                    ? $combat['nombre_de_combat_gagne_equipe_1']
                                    : 0;

                                $score2 = isset($combat['nombre_de_combat_gagne_equipe_2'])
                                    ? $combat['nombre_de_combat_gagne_equipe_2']
                                    : 0;

                                $image1_url = $equipe1
                                    ? (get_field('logo_principal', $equipe1->ID)
                                        ?: get_the_post_thumbnail_url($equipe1->ID))
                                    : '';

                                $image2_url = $equipe2
                                    ? (get_field('logo_principal', $equipe2->ID)
                                        ?: get_the_post_thumbnail_url($equipe2->ID))
                                    : '';

                                $date_debut = get_field(
                                    'date_de_debut',
                                    $rencontre->ID,
                                    false,
                                    false
                                );

                                $lien = get_permalink($rencontre->ID);
                                ?>

                                <div class="jpl-match-header">

                                    <div>

                                        <span class="jpl-section-eyebrow">
                                            Dernière rencontre
                                        </span>

                                        <h2>
                                            <?php echo esc_html($journee ?: $niveau); ?>
                                        </h2>

                                    </div>

                                    <a
                                        href="<?php echo esc_url($lien); ?>"
                                        class="jpl-match-more"
                                        style="background: <?php echo esc_attr($couleur1); ?>;"
                                    >
                                        Voir le match
                                        <i class="fa-solid fa-arrow-right"></i>
                                    </a>

                                </div>


                                <div class="jpl-match-meta">

                                    <?php if ($date_debut): ?>

                                        <span>
                                            <i class="fa-regular fa-calendar"></i>

                                            <?php
                                            echo esc_html(
                                                wp_date(
                                                    'l d F Y',
                                                    strtotime($date_debut),
                                                    wp_timezone()
                                                )
                                            );
                                            ?>
                                        </span>

                                    <?php endif; ?>

                                    <?php if ($lieu): ?>

                                        <span>
                                            <i class="fa-solid fa-location-dot"></i>
                                            <?php echo esc_html($lieu); ?>
                                        </span>

                                    <?php endif; ?>

                                </div>


                                <div class="jpl-match-versus">

                                    <div class="jpl-match-team">

                                        <?php if ($image1_url): ?>

                                            <div class="jpl-match-logo">
                                                <img
                                                    src="<?php echo esc_url($image1_url); ?>"
                                                    alt=""
                                                >
                                            </div>

                                        <?php endif; ?>

                                        <strong>
                                            <?php echo $equipe1 ? esc_html($equipe1->post_title) : ''; ?>
                                        </strong>

                                    </div>


                                    <div class="jpl-match-score">
                                        <span style="color: <?php echo esc_attr($couleur1); ?>;">
                                            <?php echo esc_html($score1); ?>
                                        </span>

                                        <b>—</b>

                                        <span style="color: <?php echo esc_attr($couleur1); ?>;">
                                            <?php echo esc_html($score2); ?>
                                        </span>
                                    </div>


                                    <div class="jpl-match-team">

                                        <?php if ($image2_url): ?>

                                            <div class="jpl-match-logo">
                                                <img
                                                    src="<?php echo esc_url($image2_url); ?>"
                                                    alt=""
                                                >
                                            </div>

                                        <?php endif; ?>

                                        <strong>
                                            <?php echo $equipe2 ? esc_html($equipe2->post_title) : ''; ?>
                                        </strong>

                                    </div>

                                </div>

                            <?php endif; ?>

                        </div>

                    <?php endif; ?>


                    <!-- 3 JUDOKAS RANDOM -->

                    <?php if (!empty($judokas)): ?>

                        <div
                            class="jpl-random-judokas"
                            style="
                                --random-color-1: <?php echo esc_attr($couleur1); ?>;
                                --random-color-2: <?php echo esc_attr($couleur2); ?>;
                            "
                        >

                            <div class="jpl-random-avatars">

                                <?php foreach ($judokas as $judoka_array):

                        $judoka = $judoka_array['post'];


                                    if (!$judoka) {
                                        continue;
                                    }

                                    if (get_field('masquer', $judoka->ID)) {
                                        continue;
                                    }

                                    $nom = get_field('nom_judoka', $judoka->ID);
                                    $prenom = get_field('prenom_judoka', $judoka->ID);

                                    $judoka_image = get_the_post_thumbnail_url(
                                        $judoka->ID,
                                        'thumbnail'
                                    );

                                    if (!$judoka_image) {
                                        $judoka_image = get_site_url() . '/wp-content/uploads/2023/09/profil.jpg';
                                    }
                                    ?>

                                    <a
                                        href="<?php echo esc_url(get_permalink($judoka->ID)); ?>"
                                        class="jpl-random-avatar"
                                        title="<?php echo esc_attr(trim($prenom . ' ' . $nom)); ?>"
                                    >

                                        <img
                                            src="<?php echo esc_url($judoka_image); ?>"
                                            alt="<?php echo esc_attr(trim($prenom . ' ' . $nom)); ?>"
                                        >

                                    </a>

                                <?php endforeach; ?>

                            </div>


                            <a
                                href="<?php echo esc_url($team_permalink . 'judokas/'); ?>"
                                class="jpl-random-judokas-link"
                            >

                                <span>
                                    Découvrir l'effectif complet de <?php echo esc_html($team_name); ?>
                                </span>

                                <i class="fa-solid fa-arrow-right"></i>

                            </a>

                        </div>

                    <?php endif; ?>


                    <!-- PRÉSENTATION -->
                    <?php if ($description): ?>
                        <div class="jpl-team-card jpl-presentation-card">
                            <div class="jpl-section-heading">
                                <h2>
                                    Présentation de <?php echo esc_html($team_name); ?>
                                </h2>
                            </div>
                            <div class="jpl-presentation-content">
                                <?php echo wp_kses_post($description); ?>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
            <!-- =====================================================
                 ACTUALITÉS
            ====================================================== -->

            <?php if ($news): ?>

                <section class="jpl-content-section">

                    <div class="jpl-section-title-row">

                        <div>
                            <span class="jpl-section-eyebrow">
                                Actualités
                            </span>

                            <h2>
                                Les dernières nouvelles
                            </h2>
                        </div>

                        <a
                            href="<?php echo esc_url($team_permalink . 'actus/'); ?>"
                            class="jpl-section-link"
                            style="--link-color: <?php echo esc_attr($couleur1); ?>;"
                        >
                            Toutes les actualités
                            <i class="fa-solid fa-arrow-right"></i>
                        </a>
                    </div>
                    <div class="jpl-news-grid">
                        <?php foreach ($news as $my_post): ?>
                            <?php
                            $img = get_the_post_thumbnail_url($my_post->ID, 'large');
                            $url = get_permalink($my_post->ID);
                            ?>
                            <article class="jpl-news-card">
                                <a href="<?php echo esc_url($url); ?>">
                                    <div class="jpl-news-image">
                                        <?php if ($img): ?>
                                            <img
                                                src="<?php echo esc_url($img); ?>"
                                                alt=""
                                            >
                                        <?php endif; ?>
                                    </div>
                                    <div class="jpl-news-content">
										                                        <h3>
                                            <?php echo esc_html($my_post->post_title); ?>
                                        </h3>
                                        <span
                                            class="jpl-news-date"
                                        >
                                            <?php echo esc_html(get_the_date('j F Y', $my_post->ID)); ?>
                                        </span>
                                    </div>
                                </a>

                            </article>

                        <?php endforeach; ?>

                    </div>

                </section>

            <?php endif; ?>


            <!-- =====================================================
                 GALERIES
            ====================================================== -->

            <?php if ($galeries): ?>

                <section class="jpl-content-section">

                    <div class="jpl-section-title-row">

                        <div>

                            <span class="jpl-section-eyebrow">
                                Photos
                            </span>

                            <h2>
                                Les dernières galeries
                            </h2>

                        </div>

                        <a
                            href="<?php echo esc_url($team_permalink . 'photos/'); ?>"
                            class="jpl-section-link"
                            style="--link-color: <?php echo esc_attr($couleur1); ?>;"
                        >
                            Toutes les photos
                            <i class="fa-solid fa-arrow-right"></i>
                        </a>

                    </div>


                    <div class="jpl-gallery-grid">

                        <?php foreach ($galeries as $image_galerie): ?>

                            <?php
                            $photos = get_field('photos', $image_galerie->ID);
                            $titre  = get_field('titre', $image_galerie->ID);

                            if (empty($photos)) {
                                continue;
                            }

                            $cover = $photos[0];

                            $cover_url = isset($cover['sizes']['large'])
                                ? $cover['sizes']['large']
                                : $cover['url'];

                            $link = get_permalink($image_galerie->ID)
                                . '?equipeID=' . $team_id;
                            ?>

                            <a
                                href="<?php echo esc_url($link); ?>"
                                class="jpl-gallery-card"
                            >

                                <div
                                    class="jpl-gallery-image"
                                    style="background-image:url('<?php echo esc_url($cover_url); ?>');"
                                ></div>

                                <div class="jpl-gallery-content">

                                    <h3>
                                        <?php echo esc_html($titre); ?>
                                    </h3>

                                    <span>
                                        <?php echo esc_html(get_the_date('Y', $image_galerie->ID)); ?>
                                    </span>

                                </div>

                            </a>

                        <?php endforeach; ?>

                    </div>

                </section>

            <?php endif; ?>


            <!-- =====================================================
                 VIDÉOS
            ====================================================== -->

            <?php if ($videos): ?>

                <section class="jpl-content-section">

                    <div class="jpl-section-title-row">

                        <div>

                            <span class="jpl-section-eyebrow">
                                Vidéos
                            </span>

                            <h2>
                                Les dernières vidéos
                            </h2>

                        </div>

                        <a
                            href="<?php echo esc_url($team_permalink . 'videos/'); ?>"
                            class="jpl-section-link"
                            style="--link-color: <?php echo esc_attr($couleur1); ?>;"
                        >
                            Toutes les vidéos
                            <i class="fa-solid fa-arrow-right"></i>
                        </a>

                    </div>


                    <div class="jpl-video-grid">

                        <?php foreach ($videos as $video_object): ?>

                            <?php
                            $video_id = get_field('id', $video_object->ID);
                            $video_title = get_field('titre', $video_object->ID);

                            $image_url = get_the_post_thumbnail_url(
                                $video_object->ID,
                                'large'
                            );

                            if (!$image_url && $video_id) {
                                $image_url = 'https://i.ytimg.com/vi/' . $video_id . '/hqdefault.jpg';
                            }

                            $video_url = $video_id
                                ? 'https://youtu.be/' . $video_id
                                : '#';
                            ?>

                            <article class="jpl-video-card">

                                <div
                                    class="jpl-video-image"
                                    style="background-image:url('<?php echo esc_url($image_url); ?>');"
                                >

                                    <?php if ($video_id): ?>

                                        <div class="jpl-video-play">

                                            <?php
                                            echo do_shortcode(
                                                '[video_popup url="' .
                                                esc_url($video_url) .
                                                '" img="' .
                                                esc_url(get_site_url() . '/wp-content/uploads/2022/11/play.webp') .
                                                '"]'
                                            );
                                            ?>

                                        </div>

                                    <?php endif; ?>

                                </div>

                                <div class="jpl-video-content">

                                    <h3>
                                        <?php echo esc_html($video_title ?: get_the_title($video_object->ID)); ?>
                                    </h3>

                                    <span>
                                        <?php echo esc_html(get_the_date('j F Y', $video_object->ID)); ?>
                                    </span>

                                </div>

                            </article>

                        <?php endforeach; ?>

                    </div>

                </section>

            <?php endif; ?>


            <!-- =====================================================
                 PARTENAIRES
            ====================================================== -->

            <?php if ($partenaires): ?>

                <section class="jpl-content-section jpl-partners-section">

                    <div class="jpl-section-title-row">

                        <div>

                            <span class="jpl-section-eyebrow">
                                Partenaires
                            </span>

                            <h2>
                                Ils nous accompagnent
                            </h2>

                        </div>

                    </div>


                    <div class="jpl-partners-grid">

                        <?php foreach ($partenaires as $partenaire): ?>

                            <?php
                            $logo_partenaire = get_field(
                                'logo_partenaire',
                                $partenaire->ID
                            );

                            if (!$logo_partenaire) {
                                continue;
                            }
                            ?>

                            <div class="jpl-partner-card">

                                <img
                                    src="<?php echo esc_url($logo_partenaire['url']); ?>"
                                    alt="<?php echo esc_attr($partenaire->post_title); ?>"
                                >

                            </div>

                        <?php endforeach; ?>

                    </div>

                </section>

            <?php endif; ?>
        </div>
    </section>
</main>
<!-- <style>
/* =========================================================
   VARIABLES
========================================================= */
.jpl-team-page {
    --jpl-bg: #f7f7fa;
    --jpl-text: #111318;
    --jpl-muted: #727681;
    --jpl-border: #e8e8ed;
    --jpl-card-radius: 18px;
    background: var(--jpl-bg);
    color: var(--jpl-text);
    padding-bottom: 80px;
}
/* =========================================================
   CONTAINER
========================================================= */
.jpl-team-page .jpl-team-container {
    width: min(1413px, calc(100% - 40px));
    margin: 0 auto;
}
/* =========================================================
   HEADER
========================================================= */
.jpl-team-page .jpl-team-header {
    background:var(--team-color-2);
}

.jpl-team-page .jpl-team-topbar {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 20px;
    padding: 22px 0 15px;
}

.jpl-team-page .jpl-team-back {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    color: #fff !important;
    background: #111;
    border-radius: 999px;
    padding: 9px 16px;
    font-size: 16px;
    font-weight: 600;
    text-decoration: none !important;
    transition: .2s ease;
}

.jpl-team-page .jpl-team-back:hover {
    transform: translateX(-2px);
    color: #fff !important;
}

.jpl-team-page .jpl-team-breadcrumb {
    display: flex;
    align-items: center;
    gap: 8px;
    font-size: 16px;
    color: var(--jpl-muted);
}

.jpl-team-page .jpl-team-breadcrumb a {
    color: var(--jpl-muted);
    text-decoration: none;
}

.jpl-team-page .jpl-team-breadcrumb strong {
    color: var(--jpl-text);
}
/* =========================================================
   IDENTITY
========================================================= */
.jpl-team-page .jpl-team-identity {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 22px;
    padding: 6px 0px;
    text-align: left;
}
.jpl-team-page .jpl-team-main-logo {
    width: 148px;
    display: flex;
    align-items: center;
    justify-content: center;
}
.jpl-team-page .jpl-team-main-logo img {
    max-width: 100%;
    max-height: 100%;
    object-fit: contain;
	border-radius:8px;
}
.jpl-team-page .jpl-team-eyebrow,
.jpl-team-page .jpl-section-eyebrow {
    display: block;
    font-size: 19px;
    font-weight: 800;
    text-transform: uppercase;
    letter-spacing: .12em;
    color: var(--team-color-1);
    margin-bottom: 6px;
}
.jpl-team-page .jpl-team-identity h1 {
    margin: 0;
    font-size: clamp(28px, 4vw, 46px);
    line-height: 1.05;
    font-weight: 800;
    letter-spacing: -.04em;
}

.jpl-team-page .jpl-team-season {
    display: inline-block;
    margin-top: 8px;
    font-size: 13px;
    color: var(--jpl-muted);
}
/* =========================================================
   MENU
========================================================= */
.jpl-team-page .jpl-team-menu {
    display: flex;
    align-items: stretch;
    gap: 20px;
    overflow-x: auto;
    scrollbar-width: none;
}
.jpl-team-page .jpl-team-menu::-webkit-scrollbar {
    display: none;
}
.jpl-team-page .jpl-team-menu-link {
    position: relative;
    flex: 1 0 auto;
    min-height: 52px;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 0 18px;
    color: #fff !important;
    text-decoration: none !important;
    font-size: 17px;
    font-weight: 700;
    white-space: nowrap;
    transition: .2s ease;
}
.jpl-team-page .jpl-team-menu-link::after {
    content: "";
    position: absolute;
    left: 15px;
    right: 15px;
    bottom: 0;
    height: 3px;
    border-radius: 3px 3px 0 0;
    background: transparent;
    transition: .2s ease;
}
.jpl-team-page .jpl-team-menu-link:hover {
    color: var(--menu-color-hover) !important;
}
.jpl-team-page .jpl-team-menu-link.is-active {
    color: var(--menu-color) !important;
}
.jpl-team-page .jpl-team-menu-link.is-active::after {
    background: var(--menu-color);
}
/* =========================================================
   CONTENT
========================================================= */
.jpl-team-page .jpl-team-content {
    padding: 0px 0px 38px;
}
.jpl-team-page .jpl-team-layout {
    display: grid;
    grid-template-columns: 280px minmax(0, 1fr);
    gap: 20px;
    align-items: start;
}
.jpl-team-page .jpl-team-sidebar,
.jpl-team-page .jpl-team-main {
    min-width: 0;
}
.jpl-team-page .jpl-team-sidebar {
    display: flex;
    flex-direction: column;
    gap: 20px;
}
/* =========================================================
   CARD
========================================================= */
.jpl-team-page .jpl-team-card {
    background: #fff;
    border: 1px solid var(--jpl-border);
    border-radius: var(--jpl-card-radius);
    overflow: hidden;
    box-shadow: 0 5px 20px rgba(17,19,24,.035);
}
/* =========================================================
   STAFF
========================================================= */
	.jpl-team-page .jpl-team-card{position:relative;}
	.jpl-team-page .jpl-team-card::before {
    content: "";
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 3px;
    background: linear-gradient(
    90deg,
    <?php echo esc_attr($couleur1); ?> 0%,
    <?php echo esc_attr($couleur2); ?> 100%
);
}	
.jpl-team-page .jpl-team-card-heading {
    min-height: 46px;
    padding: 0 18px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    color: #fff;
    font-size: 21px;
    font-weight: 800;
    letter-spacing: .08em;
	border-radius: 8px;
}

.jpl-team-page .jpl-staff-logo {
    height: 150px;
    margin: 15px;
    border-radius: 12px;
    background: #f5f5f7;
    display: flex;
    align-items: center;
    justify-content: center;
    overflow: hidden;
}
.jpl-team-page .jpl-staff-logo img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    padding: 0px;
}
.jpl-team-page .jpl-staff-info {
    padding: 0 15px 18px;
}
.jpl-team-page .jpl-staff-row {
    display: flex;
    flex-direction: column;
    gap: 5px;
}
.jpl-team-page .jpl-staff-label {
    color: var(--jpl-muted);
    font-size: 17px;
    text-transform: uppercase;
    letter-spacing: .06em;
}
.jpl-team-page .jpl-staff-row strong {
    font-size: 14px;
    line-height: 1.4;
}
.jpl-team-page .jpl-staff-separator {
    height: 2px;
    width: 100%;
    margin: 15px 0;
    opacity: .8;
}
/* =========================================================
   CLASSEMENT
========================================================= */
.jpl-team-page .jpl-ranking-card {
    overflow: hidden;
}
.jpl-team-page .jpl-ranking-card .jpl-team-card-heading strong {
    display: flex;
    align-items: center;
    justify-content: center;
    min-width: 38px;
    height: 28px;
    border-radius: 999px;
    font-size: 12px;
}
.jpl-team-page .jpl-ranking-results {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    padding: 18px 12px 12px;
    text-align: center;
}
.jpl-team-page .jpl-ranking-results > div {
    display: flex;
    flex-direction: column;
    gap: 3px;
}
.jpl-team-page .jpl-ranking-results strong {
    font-size: 24px;
    line-height: 1;
}
.jpl-team-page .jpl-ranking-results span {
    font-size: 15px;
    color: var(--jpl-muted);
}
.jpl-team-page .jpl-team-stats {
    padding: 0 15px 18px;
}
.jpl-team-page .jpl-team-stats-title {
    font-size: 19px;
    font-weight: 800;
    padding: 8px 0 10px;
}
.jpl-team-page .jpl-team-stat-row {
    min-height: 42px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 10px;
    border-top: 1px solid var(--jpl-border);
}
.jpl-team-page .jpl-team-stat-row span {
    font-size: 17px;
    color: var(--jpl-muted);
}
.jpl-team-page .jpl-team-stat-row strong {
    font-size: 14px;
}
/* =========================================================
   MATCH
========================================================= */
.jpl-team-page .jpl-team-main {
    display: flex;
    flex-direction: column;
    gap: 20px;
}
.jpl-team-page .jpl-match-card {
    padding: 25px;
}
.jpl-team-page .jpl-match-header {
    display: flex;
    align-items: flex-start;
    justify-content: space-between;
    gap: 20px;
}
.jpl-team-page .jpl-match-header h2 {
    margin: 0;
    font-size: 24px;
    font-weight: 800;
    letter-spacing: -.025em;
}
.jpl-team-page .jpl-match-more {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    color: #fff !important;
    padding: 10px 16px;
    border-radius: 999px;
    font-size: 18px;
    font-weight: 700;
    text-decoration: none !important;
    white-space: nowrap;
}
.jpl-team-page .jpl-match-more:hover{
	background:var(--team-color-2) !important;
	}		
.jpl-team-page .jpl-match-meta {
    display: flex;
    flex-wrap: wrap;
    gap: 10px 18px;
    margin-top: 15px;
    color: var(--jpl-muted);
    font-size: 14px;
}
.jpl-team-page .jpl-match-meta span {
    display: inline-flex;
    align-items: center;
    gap: 6px;
	text-transform: capitalize;
}
.jpl-team-page .jpl-match-versus {
    display: grid;
    grid-template-columns: 1fr 120px 1fr;
    align-items: center;
    gap: 20px;
    margin-top: 28px;
}
.jpl-team-page .jpl-match-team {
    display: flex;
    align-items: center;
    gap: 14px;
}
.jpl-team-page .jpl-match-team:last-child {
    flex-direction: row-reverse;
    text-align: right;
}
.jpl-team-page .jpl-match-logo {
    flex: 0 0 219px;
}
.jpl-team-page .jpl-match-logo img {
    max-width: 100%;
    max-height: 100%;
    object-fit: cover;
	border-radius:8px;
}
.jpl-team-page .jpl-match-team strong {
    font-size: 19px;
    line-height: 1.25;
}
.jpl-team-page .jpl-match-score {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    font-size: 36px;
    font-weight: 800;
    letter-spacing: -.04em;
}
.jpl-team-page .jpl-match-score b {
    font-size: 23px;
    color: #aaaeb6;
}
/* =========================================================
   RANDOM JUDOKAS
========================================================= */
.jpl-team-page .jpl-random-judokas {
    min-height: 70px;
    background: var(--random-color-2);
    border-radius: 16px;
    padding: 8px 12px;
    display: flex;
    align-items: center;
    gap: 15px;
}
.jpl-team-page .jpl-random-avatars {
    display: flex;
    align-items: center;
    padding-left: 3px;
}
.jpl-team-page .jpl-random-avatar {
    width: 50px;
    height: 50px;
    border-radius: 50%;
    overflow: hidden;
    border: 3px solid var(--random-color-2);
    background: #fff;
    margin-left: -7px;
    position: relative;
    transition: .2s ease;
}
.jpl-team-page .jpl-random-avatar:first-child {
    margin-left: 0;
}
.jpl-team-page .jpl-random-avatar:hover {
    transform: translateY(-3px);
    z-index: 5;
}
.jpl-team-page .jpl-random-avatar img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}
.jpl-team-page .jpl-random-judokas-link {
    flex: 1;
    min-width: 0;
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 12px;
    color: #fff !important;
    text-decoration: none !important;
    font-size: 17px;
    font-weight: 800;
}
.jpl-team-page .jpl-random-judokas-link i {
    width: 38px;
    height: 38px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    background: var(--random-color-1);
    flex: 0 0 38px;
}
/* =========================================================
   PRÉSENTATION
========================================================= */
.jpl-team-page .jpl-presentation-card {
    padding: 26px;
}
.jpl-team-page .jpl-section-heading h2,
.jpl-team-page .jpl-section-title-row h2 {
    margin: 0;
    font-size: 24px;
    font-weight: 800; 
    letter-spacing: -.025em;
}
.jpl-team-page .jpl-presentation-content {
	padding: 0px;
    margin-top: 18px;
    color: #565b65;
    font-size: 14px;
    line-height: 1.75;
}

.jpl-team-page .jpl-presentation-content p {
    margin: 0 0 12px;
	font-size:18px;
}
.jpl-team-page .jpl-presentation-content p:last-child {
    margin-bottom: 0;
}
/* =========================================================
   SECTIONS
========================================================= */
.jpl-team-page .jpl-content-section {
    margin-top: 55px;
}
.jpl-team-page .jpl-section-title-row {
    display: flex;
    align-items: flex-end;
    justify-content: space-between;
    gap: 20px;
    margin-bottom: 22px;
}
.jpl-team-page .jpl-section-link {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    color: var(--link-color) !important;
    font-size: 22px;
    font-weight: 700;
    text-decoration: none !important;
}
.jpl-team-page .jpl-section-link i {
    transition: .2s ease;
}
.jpl-team-page .jpl-section-link:hover i {
    transform: translateX(4px);
}
/* =========================================================
   NEWS
========================================================= */
.jpl-team-page .jpl-news-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 18px;
}
.jpl-team-page .jpl-news-card {
    background: #fff;
    border: 1px solid var(--jpl-border);
    border-radius: 16px;
    overflow: hidden;
    transition: .2s ease;
}
.jpl-team-page .jpl-news-card:hover {
    transform: translateY(-3px);
    box-shadow: 0 12px 30px rgba(17,19,24,.07);
}
.jpl-team-page .jpl-news-card a {
    color: inherit;
    text-decoration: none;
}
.jpl-team-page .jpl-news-image {
    height: 180px;
	min-height:auto;
    background: #eee;
    overflow: hidden;
}
.jpl-team-page .jpl-news-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
	border-radius:16px;
}
.jpl-team-page .jpl-news-content {
    padding: 16px;
}
.jpl-team-page .jpl-news-date {
    font-size: 10px;
    font-weight: 800;
    text-transform: uppercase;
    letter-spacing: .08em;
}
.jpl-team-page .jpl-news-content h3 {
    margin:  0 0 7px;
    font-size: 20px;
    line-height: 1.35;
}
/* =========================================================
   GALLERY
========================================================= */
.jpl-team-page .jpl-gallery-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 18px;
}
.jpl-team-page .jpl-gallery-card {
    background: #fff;
    border: 1px solid var(--jpl-border);
    border-radius: 16px;
    overflow: hidden;
    transition: .2s ease;
}
.jpl-team-page .jpl-gallery-card:hover{
	transform: translateY(-3px);
	box-shadow: 0 12px 30px rgba(17, 19, 24, .07);}
.jpl-team-page .jpl-gallery-image {
    height: 180px;
    border-radius: 16px;
    background-size: cover;
    background-position: center;
    transition: .25s ease;
}
.jpl-team-page .jpl-gallery-content {
    padding: 15px;
}

.jpl-team-page .jpl-gallery-content h3 {
    margin: 0 0 4px;
    font-size: 20px;
	font-family:'Futura' !important;
}
.jpl-team-page .jpl-gallery-content span {
    font-size: 11px;
    color: var(--jpl-muted);
}
/* =========================================================
   VIDEOS
========================================================= */
.jpl-team-page .jpl-video-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 18px;
}
.jpl-team-page .jpl-video-card {
    background: #fff;
    border: 1px solid var(--jpl-border);
    border-radius: 16px;
    overflow: hidden;
    transition: .2s ease;
}
.jpl-team-page .jpl-video-card:hover{
	transform: translateY(-3px);
	box-shadow: 0 12px 30px rgba(17, 19, 24, .07);}
.jpl-team-page .jpl-video-image {
    height: 180px;
    border-radius: 16px;
    background-size: cover;
    background-position: center;
    position: relative;
}
.jpl-team-page .jpl-video-play {
    position: absolute;
    inset: 0;
    display: flex;
    align-items: center;
    justify-content: center;
}
.jpl-team-page .jpl-video-content {
    padding: 15px;
}
.jpl-team-page .jpl-video-content h3 {
    margin: 0 0 5px;
    font-size: 20px;
    line-height: 1.35;
	font-family:'Futura'!important;
}
.jpl-team-page .jpl-video-content span, .jpl-news-date {
    color: var(--jpl-muted);
    font-size: 13px;
	text-transform: capitalize;
}
/* =========================================================
   PARTENAIRES
========================================================= */
.jpl-team-page .jpl-partners-grid {
    display: grid;
    grid-template-columns: repeat(5, 1fr);
    gap: 15px;
}
.jpl-team-page .jpl-partner-card {
    height: 110px;
    border: 1px solid var(--jpl-border);
    border-radius: 14px;
    background: #fff;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 15px;
}
.jpl-team-page .jpl-partner-card img {
    max-width: 100%;
    max-height: 70px;
    object-fit: contain;
}
/* =========================================================
   TABLET
========================================================= */
@media (max-width: 900px) {

    .jpl-team-page .jpl-team-page .jpl-team-layout {
        grid-template-columns: 1fr;
    }
    .jpl-team-page .jpl-team-page .jpl-team-sidebar {
        display: grid;
        grid-template-columns: 1fr 1fr;
    }
    .jpl-team-page .jpl-team-page .jpl-news-grid,
    .jpl-team-page .jpl-team-page .jpl-gallery-grid,
    .jpl-team-page .jpl-team-page .jpl-video-grid {
        grid-template-columns: repeat(2, 1fr);
    }
    .jpl-team-page .jpl-team-page .jpl-partners-grid {
        grid-template-columns: repeat(4, 1fr);
    }
}
/* =========================================================
   MOBILE
========================================================= */
@media (max-width: 640px) {

    .jpl-team-page .jpl-team-container {
        width: min(100% - 24px, 1180px);
    }

    .jpl-team-page .jpl-team-page {
        padding-bottom: 50px;
    }

    .jpl-team-page .jpl-team-topbar {
        align-items: flex-start;
        flex-direction: column;
        gap: 12px;
    }

    .jpl-team-page .jpl-team-breadcrumb {
        font-size: 12px;
        line-height: 1.4;
    }

    .jpl-team-page .jpl-team-identity {
        justify-content: flex-start;
        gap: 14px;
        padding: 0px;
    }

    .jpl-team-page .jpl-team-main-logo {
        width: 65px;
        height: 65px;
        border-radius: 12px;
    }

    .jpl-team-page .jpl-team-identity h1 {
        font-size: 27px;
    }

    .jpl-team-page .jpl-team-menu {
        margin: 0 -12px;
        padding: 0 12px;
    }

    .jpl-team-page .jpl-team-menu-link {
        min-height: 46px;
        padding: 0 13px;
        font-size: 11px;
    }

    .jpl-team-page .jpl-team-content {
        padding-top: 24px;
    }

    .jpl-team-page .jpl-team-sidebar {
        display: flex;
    }

    .jpl-team-page .jpl-staff-logo {
        height: 130px;
    }

    .jpl-team-page .jpl-match-card {
        padding: 18px;
    }

    .jpl-team-page .jpl-match-header {
        flex-direction: column;
        gap: 12px;
    }

    .jpl-team-page .jpl-match-more {
        width: 100%;
        justify-content: center;
    }

    .jpl-team-page .jpl-match-versus {
        grid-template-columns: 1fr;
        gap: 12px;
    }

    .jpl-team-page .jpl-match-team,
    .jpl-team-page .jpl-match-team:last-child {
        justify-content: center;
        flex-direction: column;
        text-align: center;
    }

    .jpl-team-page .jpl-match-score {
        order: 2;
        font-size: 32px;
    }

    .jpl-team-page .jpl-match-team:first-child {
        order: 1;
    }

    .jpl-team-page .jpl-match-team:last-child {
        order: 3;
    }

    .jpl-team-page .jpl-random-judokas {
        padding: 8px;
        gap: 8px;
    }

    .jpl-team-page .jpl-random-avatar {
        width: 42px;
        height: 42px;
    }

    .jpl-team-page .jpl-random-judokas-link {
        font-size: 13px;
    }

    .jpl-team-page .jpl-random-judokas-link i {
        width: 32px;
        height: 32px;
        flex-basis: 32px;
    }

    .jpl-team-page .jpl-section-title-row {
        align-items: flex-start;
        flex-direction: column;
        gap: 10px;
    }

    .jpl-team-page .jpl-news-grid,
    .jpl-team-page .jpl-gallery-grid,
    .jpl-team-page .jpl-video-grid {
        grid-template-columns: 1fr;
    }

    .jpl-team-page .jpl-news-image {
        height: 210px;
    }

    .jpl-team-page .jpl-gallery-image {
        height: 220px;
    }

    .jpl-team-page .jpl-partners-grid {
        grid-template-columns: repeat(2, 1fr);
    }

}
@media (max-width: 497px) {
	.jpl-team-page .jpl-team-menu {gap: 0px;}	
	.jpl-team-page .jpl-match-logo {flex: 0 0 0px; width: 179px;}
	.jpl-team-page .jpl-news-card { grid-template-columns: 1fr;}
	.jpl-team-page .jpl-team-layout { display: grid; grid-template-columns: 1fr;}
	.jpl-team-page .jpl-content-section {margin-top: 38px;}
	.jpl-team-page .jpl-team-menu-link {padding: 0 7px; font-size: 14px; }
	
	
	
	}
</style> -->
<style>
	.jpl-team-page .jpl-team-card::before {
    content: "";
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 3px;
    background: linear-gradient( 90deg, <?php echo esc_attr($couleur1); ?> 0%, <?php echo esc_attr($couleur2); ?> 100% );
}
</style>
</main>
<?php get_footer(); ?>