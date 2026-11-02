<?php
/**
 * Template Name: Modèle classement 2024
 */

/* =========================================================
 * AFFICHAGE DES RENCONTRES PAR JOURNÉE
 * ========================================================= */

function display($rencontres_j1, $titre_journee) {
?>
    <?php if ($rencontres_j1): ?>

        <div class="judo_pro_league">

            <h2 class="crt-title">
                <?php echo esc_html($titre_journee); ?>
            </h2>

            <?php $count = count($rencontres_j1); ?>

            <div
                class="cal-res-poule"
                <?php if ($count == 1): ?>
                    style="grid-template-columns: repeat(1,1fr) !important; max-width:450px; margin:0 auto;"
                <?php endif; ?>
            >

                <?php foreach ($rencontres_j1 as $rencontre): ?>

                    <?php

                    $combat_data = get_field('les_combat', $rencontre->ID);
                    $combat = !empty($combat_data[0]) ? $combat_data[0] : array();

                    $lieu = get_field('lieu_rencontre', $rencontre->ID);

                    $equipe1_data = get_field('equipe_1', $rencontre->ID);
                    $equipe2_data = get_field('equipe_2', $rencontre->ID);

                    $equipe1 = !empty($equipe1_data[0]) ? $equipe1_data[0] : null;
                    $equipe2 = !empty($equipe2_data[0]) ? $equipe2_data[0] : null;

                    if (!$equipe1 || !$equipe2) {
                        continue;
                    }

                    $rencontre_permalink = get_permalink($rencontre->ID);

                    $score_equipe1 = !empty($combat['nombre_de_combat_gagne_equipe_1'][0])
                        ? $combat['nombre_de_combat_gagne_equipe_1'][0]
                        : 0;

                    $score_equipe2 = !empty($combat['nombre_de_combat_gagne_equipe_2'][0])
                        ? $combat['nombre_de_combat_gagne_equipe_2'][0]
                        : 0;

                    $image1_url = get_field('logo_miniature', $equipe1->ID);

                    if (!$image1_url) {
                        $image1_url = get_the_post_thumbnail_url($equipe1->ID);
                    }

                    $image2_url = get_field('logo_miniature', $equipe2->ID);

                    if (!$image2_url) {
                        $image2_url = get_the_post_thumbnail_url($equipe2->ID);
                    }

                    $date_debut = get_field(
                        'date_de_debut',
                        $rencontre->ID,
                        false,
                        false
                    );

                    $date_fin = get_field(
                        'date_de_fin',
                        $rencontre->ID,
                        false,
                        false
                    );

                    $abreviation1 = get_field('abreviation', $equipe1->ID)
                        ?: $equipe1->post_title;

                    $abreviation2 = get_field('abreviation', $equipe2->ID)
                        ?: $equipe2->post_title;

                    $statut_data = get_field('statut', $rencontre->ID);

                    $statut = !empty($statut_data['label'])
                        ? $statut_data['label']
                        : '';

                    $class_status = '';
                    $texte_status = '';
                    $class_reservation = '';
                    $lien_live_ou_billet = '';
                    $equipe_gagnante = 'inconnue';

                    /* -----------------------------
                     * STATUT : EN COURS
                     * ----------------------------- */

                    if ($statut === 'en cours') {

                        $class_status = 'encours';
                        $equipe_gagnante = 'inconnue';
                        $texte_status = 'en cours';
                        $class_reservation = 'link-2';

                        $video_live = get_field(
                            'video_live',
                            $rencontre->ID
                        );

                        if ($video_live) {
                            $lien_live_ou_billet =
                                '<a href="' . esc_url($video_live) . '" 
                                    target="_blank" 
                                    rel="noopener noreferrer"
                                    class="nv-link-crt brd-right">
                                    Live
                                </a>';
                        }

                    /* -----------------------------
                     * STATUT : TERMINÉ
                     * ----------------------------- */

                    } elseif ($statut === 'terminé') {

                        $equipe_gagnante = !empty($combat['equipe_gagnante'])
                            ? $combat['equipe_gagnante']
                            : 'inconnue';

                        $class_status = 'terminer';
                        $texte_status = 'terminé';
                        $class_reservation = '';
                        $lien_live_ou_billet = '';

                    /* -----------------------------
                     * STATUT : À VENIR
                     * ----------------------------- */

                    } elseif ($statut === 'à venir') {

                        $class_status = 'avenir';
                        $equipe_gagnante = 'inconnue';
                        $texte_status = 'à venir';
                        $class_reservation = 'link-2';

                        $lien_reservation = get_field(
                            'lien_de_reservation',
                            $rencontre->ID
                        );

                        if ($lien_reservation) {
                            $lien_live_ou_billet =
                                '<a href="' . esc_url($lien_reservation) . '"
                                    target="_blank"
                                    rel="noopener noreferrer"
                                    class="nv-link-crt brd-right">
                                    Billetterie
                                </a>';
                        }
                    }

                    ?>

                    <div class="cal-res-poule-blc">

                        <div class="header-cal-res-poule">

                            <span class="cal-res-poule-title">
                                <?php echo esc_html($lieu); ?>
                            </span>

                            <span class="cal-res-poule-stat <?php echo esc_attr($class_status); ?>">
                                <?php echo esc_html($texte_status); ?>
                            </span>

                        </div>

                        <div
                            class="horaire-jr"
                            <?php if ($texte_status === 'terminé'): ?>
                                style="grid-template-columns:100% !important;"
                            <?php endif; ?>
                        >

                            <div>

                                <div class="cal-res-poule-team <?php echo ($equipe_gagnante === 'équipe 2') ? 'beaten' : ''; ?>">

                                    <?php if ($image1_url): ?>
                                        <img
                                            src="<?php echo esc_url($image1_url); ?>"
                                            alt="<?php echo esc_attr($equipe1->post_title); ?>"
                                        >
                                    <?php endif; ?>

                                    <h3 class="cal-res-poule-eqp">
                                        <?php echo esc_html($equipe1->post_title); ?>
                                    </h3>

                                    <span class="cal-res-poule-rs">
                                        <?php echo esc_html($score_equipe1); ?>
                                    </span>

                                </div>

                                <div class="cal-res-poule-team <?php echo ($equipe_gagnante === 'équipe 1') ? 'beaten' : ''; ?> brd-none">

                                    <?php if ($image2_url): ?>
                                        <img
                                            src="<?php echo esc_url($image2_url); ?>"
                                            alt="<?php echo esc_attr($equipe2->post_title); ?>"
                                        >
                                    <?php endif; ?>

                                    <h3 class="cal-res-poule-eqp">
                                        <?php echo esc_html($equipe2->post_title); ?>
                                    </h3>

                                    <span class="cal-res-poule-rs">
                                        <?php echo esc_html($score_equipe2); ?>
                                    </span>

                                </div>

                            </div>

                            <div
                                <?php if ($texte_status === 'terminé'): ?>
                                    style="display:none !important;"
                                <?php endif; ?>
                            >

                                <?php if (!empty($date_debut)): ?>

                                    <span class="cal-res-poule-title">
                                        <?php
                                        echo esc_html(
                                            substr($date_debut, 8, 2)
                                            . '/'
                                            . substr($date_debut, 5, 2)
                                        );
                                        ?>
                                    </span>

                                    <span class="cal-res-poule-title">
                                        <?php
                                        echo esc_html(
                                            substr($date_debut, 11, 2)
                                            . 'h'
                                            . substr($date_debut, 14, 2)
                                        );
                                        ?>
                                    </span>

                                <?php endif; ?>

                            </div>

                        </div>

                        <div
                            class="cal-res-poule-link <?php echo esc_attr($class_reservation); ?>"
                            <?php if (!$lien_live_ou_billet): ?>
                                style="grid-template-columns:repeat(1,1fr) !important;"
                            <?php endif; ?>
                        >

                            <?php echo $lien_live_ou_billet; ?>

                            <a
                                href="<?php echo esc_url($rencontre_permalink); ?>"
                                class="nv-link-crt"
                            >
                                Détails
                                <i class="fa-solid fa-angles-right"></i>
                            </a>

                        </div>

                    </div>

                <?php endforeach; ?>

            </div>

        </div>

    <?php endif;
}


/* =========================================================
 * HEADER
 * ========================================================= */

get_header();

$saison_param = isset($_GET['saison_value'])
    ? '?saison_value=' . urlencode($_GET['saison_value'])
    : '';

/* =========================================================
 * SAISON
 * ========================================================= */

$saison_value = isset($_GET['saison_value'])
    ? sanitize_text_field(wp_unslash($_GET['saison_value']))
    : '2026-2027';


/* =========================================================
 * REDIRECTIONS ANCIENNES SAISONS
 * ========================================================= */

if ($saison_value === '2023-2024') {

    wp_safe_redirect(
        home_url('/classement-judo-pro-league-2023/?saison_value=2023-2024')
    );

    exit;
}

if ($saison_value === '2022-2023') {

    wp_safe_redirect(
        home_url('/classement-judo-pro-league-2023/?saison_value=2022-2023')
    );

    exit;
}


/* =========================================================
 * POULe
 * ========================================================= */

$pouleID = 488;

$team_permalink = get_permalink($post->ID);


/* =========================================================
 * JOURNÉES
 * ========================================================= */

$args_j1 = array(
    'post_type'      => 'rencontre',
    'posts_per_page' => -1,
    'meta_query'     => array(
        'relation' => 'AND',

        array(
            'key'     => 'saisons',
            'value'   => $saison_value,
            'compare' => 'LIKE',
        ),

        array(
            'key'     => 'niveau',
            'value'   => 'Phase de poules',
            'compare' => '=',
        ),

        array(
            'key'     => 'journee',
            'value'   => 'Journée 1',
            'compare' => 'LIKE',
        ),
    ),
    'meta_key'       => 'date_de_debut',
    'orderby'        => 'meta_value_num',
    'order'          => 'DESC',
);


$args_j2 = array(
    'post_type'      => 'rencontre',
    'posts_per_page' => -1,
    'meta_query'     => array(
        'relation' => 'AND',

        array(
            'key'     => 'saisons',
            'value'   => $saison_value,
            'compare' => 'LIKE',
        ),

        array(
            'key'     => 'niveau',
            'value'   => 'Phase de poules',
            'compare' => '=',
        ),

        array(
            'key'     => 'journee',
            'value'   => 'Journée 2',
            'compare' => 'LIKE',
        ),
    ),
    'meta_key'       => 'date_de_debut',
    'orderby'        => 'meta_value_num',
    'order'          => 'DESC',
);


$args_j3 = array(
    'post_type'      => 'rencontre',
    'posts_per_page' => -1,
    'meta_query'     => array(
        'relation' => 'AND',

        array(
            'key'     => 'saisons',
            'value'   => $saison_value,
            'compare' => 'LIKE',
        ),

        array(
            'key'     => 'niveau',
            'value'   => 'Phase de poules',
            'compare' => '=',
        ),

        array(
            'key'     => 'journee',
            'value'   => 'Journée 3',
            'compare' => 'LIKE',
        ),
    ),
    'meta_key'       => 'date_de_debut',
    'orderby'        => 'meta_value_num',
    'order'          => 'DESC',
);


$args_j4 = array(
    'post_type'      => 'rencontre',
    'posts_per_page' => -1,
    'meta_query'     => array(
        'relation' => 'AND',

        array(
            'key'     => 'saisons',
            'value'   => $saison_value,
            'compare' => 'LIKE',
        ),

        array(
            'key'     => 'niveau',
            'value'   => 'Phase de poules',
            'compare' => '=',
        ),

        array(
            'key'     => 'journee',
            'value'   => 'Journée 4',
            'compare' => 'LIKE',
        ),
    ),
    'meta_key'       => 'date_de_debut',
    'orderby'        => 'meta_value_num',
    'order'          => 'DESC',
);


$args_j5 = array(
    'post_type'      => 'rencontre',
    'posts_per_page' => -1,
    'meta_query'     => array(
        'relation' => 'AND',

        array(
            'key'     => 'saisons',
            'value'   => $saison_value,
            'compare' => 'LIKE',
        ),

        array(
            'key'     => 'niveau',
            'value'   => 'Phase de poules',
            'compare' => '=',
        ),

        array(
            'key'     => 'journee',
            'value'   => 'Journée 5',
            'compare' => 'LIKE',
        ),
    ),
    'meta_key'       => 'date_de_debut',
    'orderby'        => 'meta_value_num',
    'order'          => 'DESC',
);


$args_j6 = array(
    'post_type'      => 'rencontre',
    'posts_per_page' => -1,
    'meta_query'     => array(
        'relation' => 'AND',

        array(
            'key'     => 'saisons',
            'value'   => $saison_value,
            'compare' => 'LIKE',
        ),

        array(
            'key'     => 'niveau',
            'value'   => 'Phase de poules',
            'compare' => '=',
        ),

        array(
            'key'     => 'journee',
            'value'   => 'Journée 6',
            'compare' => 'LIKE',
        ),
    ),
    'meta_key'       => 'date_de_debut',
    'orderby'        => 'meta_value_num',
    'order'          => 'DESC',
);


$rencontres_j1 = get_posts($args_j1);
$rencontres_j2 = get_posts($args_j2);
$rencontres_j3 = get_posts($args_j3);
$rencontres_j4 = get_posts($args_j4);
$rencontres_j5 = get_posts($args_j5);
$rencontres_j6 = get_posts($args_j6);

?>

<script>
jQuery(document).ready(function($) {

    $('#saison_value').on('change', function() {
        $('.season-selector-form').submit();
    });

});
</script>


<main
    id="primary"
    class="site-main home classmnt-24 jpl-team-page jpl-classement-page"
>

    <section class="pd-5">

        <div class="judo_pro_league poules-col">

            <div class="journees">

                <h3 class="nv-journee-cl nv-jr-active">
                    <a href="<?php echo esc_url($team_permalink); ?>phase-eliminatoire/poule-A">
                        Poule A
                    </a>
                </h3>

                <h3 class="nv-journee-cl">
                    <a href="<?php echo esc_url($team_permalink); ?>phase-eliminatoire/poule-B">
                        Poule B
                    </a>
                </h3>

                <h3 class="nv-journee-cl">
                    <a href="<?php echo esc_url($team_permalink); ?>phase-eliminatoire/poule-C">
                        Poule C
                    </a>
                </h3>

                <h3 class="nv-journee-cl">
                    <a href="<?php echo esc_url($team_permalink); ?>phase-eliminatoire/poule-D">
                        Poule D
                    </a>
                </h3>

            </div>

        </div>


        <?php

        /* =====================================================
         * RÉCUPÉRER LES RENCONTRES DE LA SAISON
         * ===================================================== */

        $args = array(
            'post_type'      => 'rencontre',
            'posts_per_page' => -1,
            'meta_key'       => 'date_de_debut',
            'orderby'        => 'meta_value_num',
            'order'          => 'DESC',

            'meta_query'     => array(
                'relation' => 'AND',

                array(
                    'key'     => 'niveau',
                    'compare' => '=',
                    'value'   => 'Phase de poules',
                ),

                array(
                    'key'     => 'saisons',
                    'compare' => 'LIKE',
                    'value'   => $saison_value,
                ),
            ),
        );


        $rencontres = get_posts($args);


        require_once(
            THEMEDIR . 'template-parts/content-pro-league2-requests.php'
        );


        $classement = get_classement(
            $rencontres,
            $saison_value
        );

        ?>


        <?php if ($classement): ?>

            <div
                class="classement-23 classement-24 jpl-full-ranking"
                style="max-width:1401px;margin:auto;"
            >

                <!-- =================================================
                     HEADER
                ================================================== -->

                    <div class="jpl-stats-hero" style="margin-top:2%;">

                       <span class="jpl-stats-eyebrow" style="text-align:center;">JUDO PRO LEAGUE </span>

						<h1 class="" style="text-align:center;">Classement équipes <strong><?php echo esc_html($saison_value); ?></strong></h1>

                        <p class="jpl-teams-description" style="text-align:center;">
                            Le classement évolue en direct selon l’avancée des rencontres.
                            Chaque match étant soumis à une procédure de vérification des scores,
                            le classement n’est considéré comme définitif que deux heures après
                            la fin des rencontres.
                        </p>

                    </div>

                
                <!-- =================================================
                     TABLEAU CLASSEMENT
                ================================================== -->
                <div class="jpl-stats-card jpl-classmnt-card">	
					
						<div class="jpl-teams-header">
					<!-- =================================================
                     ONGLETS
                ================================================== -->
               
                    <div class="jpl-stats-tabs">
                        <span class="jpl-stats-tab active">
                            <a href="/classement-judo-pro-league/<?php echo $saison_param; ?>">
                                Phase éliminatoire
                            </a>
                        </span>

                        <span class="jpl-stats-tab">
                            <a <?php if($saison_value!="2026-2027"){ echo 'href="/tableau-principal-judo-pro-league/'.$saison_param.'"'; }?>>
                                Tableau principal
                            </a>
                        </span>

                    </div>
					
					                    <div class="season-selector-box">

                        <form
                            method="GET"
                            action=""
                            class="season-selector-form"
                        >

                            <select
                                name="saison_value"
                                id="saison_value"
                                class="season-selector-select"
                            >

                                <option
                                    value="2022-2023"
                                    <?php selected($saison_value, '2022-2023'); ?>
                                >
                                    2022-2023
                                </option>

                                <option
                                    value="2023-2024"
                                    <?php selected($saison_value, '2023-2024'); ?>
                                >
                                    2023-2024
                                </option>

                                <option
                                    value="2024-2025"
                                    <?php selected($saison_value, '2024-2025'); ?>
                                >
                                    2024-2025
                                </option>

                                <option
                                    value="2025-2026"
                                    <?php selected($saison_value, '2025-2026'); ?>
                                >
                                    2025-2026
                                </option>

                                <option
                                    value="2026-2027"
                                    <?php selected($saison_value, '2026-2027'); ?>
                                >
                                    2026-2027
                                </option>

                            </select>

                        </form>

                    </div>	
				</div>
					<div class="jpl-ranking-header">
															
                        <span>#</span>

                        <span class="jpl-ranking-team-heading">
                            Équipes
                        </span>

                           <span style="text-align:center;">
        <span class="desktop-label">Points</span>
        <span class="mobile-label">PTS</span>
    </span>

                        <span style="text-align:center;">
        <span class="desktop-label">Joués</span>
        <span class="mobile-label">J</span>
    </span>

                        <span style="text-align:center;">
        <span class="desktop-label">Victoires</span>
        <span class="mobile-label">V</span>
    </span>

    <span style="text-align:center;">
        <span class="desktop-label">Nuls</span>
        <span class="mobile-label">N</span>
    </span>

    <span style="text-align:center;">
        <span class="desktop-label">Défaites</span>
        <span class="mobile-label">D</span>
    </span>

    <span
        class="jpl-ranking-extra"
        style="text-align:center;"
    >
        <span class="desktop-label">Combats gagnés</span>
        <span class="mobile-label">CG</span>
    </span>

    <span
        class="jpl-ranking-extra"
        style="text-align:center;"
    >
        <span class="desktop-label">Points marqués</span>
        <span class="mobile-label">PM</span>
    </span>

    <span
        class="jpl-ranking-extra"
        style="text-align:center;"
    >
        <span class="desktop-label">Ippons</span>
        <span class="mobile-label">IPP</span>
    </span>

    <span
        class="jpl-ranking-extra"
        style="text-align:center;"
    >
        <span class="desktop-label">Shidos</span>
        <span class="mobile-label">SH</span>
    </span>

                    
</div>

                    <?php

                    /*
                     * =================================================
                     * CLASSEMENT SÉQUENTIEL
                     *
                     * IMPORTANT :
                     * On ne reprend plus la logique de rang basée
                     * sur les égalités.
                     *
                     * Le classement affichera toujours :
                     * 1, 2, 3, ... 14
                     * =================================================
                     */

                    $rang = 0;
                    $pos  = 0;


                    foreach ($classement as $clt):

                        if (empty($clt[0]['nom'])) {
                            continue;
                        }


                        /* Rang toujours séquentiel */

                        $pos++;
                        $rang = $pos;


                        /* =================================================
                         * DONNÉES ÉQUIPE
                         * ================================================= */

                        $team_id = !empty($clt[0]['id'])
                            ? intval($clt[0]['id'])
                            : 0;

                        $team_name = $clt[0]['nom'];


                        /* =================================================
                         * LOGO
                         *
                         * Priorité :
                         * 1. logo_principal
                         * 2. logo_miniature
                         * 3. thumbnail
                         * 4. image du classement
                         * ================================================= */
$team_id = !empty($clt[0]['id']) ? intval($clt[0]['id']) : 0;
$team_name = !empty($clt[0]['nom']) ? $clt[0]['nom'] : '';

// Vérifie que l'ID correspond bien à une équipe
if ($team_id && get_post_type($team_id) !== 'equipes') {
    $team_id = 0;
}

// Si l'ID n'est pas celui du CPT équipes,
// on recherche l'équipe avec son nom
if (!$team_id && $team_name) {

    $team_query = get_posts(array(
        'post_type'      => 'equipes',
        'post_status'    => 'publish',
        'posts_per_page' => 1,
        'title'          => $team_name,
    ));

    if (!empty($team_query)) {
        $team_id = $team_query[0]->ID;
    }
}
                        $team_logo = '';

if ($team_id) {

    // Logo principal
    $logo_principal = get_field('logo_principal', $team_id);

    if (is_array($logo_principal) && !empty($logo_principal['url'])) {
        $team_logo = $logo_principal['url'];
    } elseif (is_string($logo_principal) && !empty($logo_principal)) {
        $team_logo = $logo_principal;
    }

    // Logo miniature si logo principal absent
    if (empty($team_logo)) {

        $logo_miniature = get_field('logo_miniature', $team_id);

        if (is_array($logo_miniature) && !empty($logo_miniature['url'])) {
            $team_logo = $logo_miniature['url'];
        } elseif (is_string($logo_miniature) && !empty($logo_miniature)) {
            $team_logo = $logo_miniature;
        }
    }

    // Image à la une en dernier recours
    if (empty($team_logo)) {
        $team_logo = get_the_post_thumbnail_url($team_id, 'full');
    }
}

// Dernier recours : image fournie directement par get_classement()
if (empty($team_logo) && !empty($clt[0]['image'])) {
    $team_logo = $clt[0]['image'];
}

                        /* =================================================
                         * STATISTIQUES
                         * ================================================= */

                        $points = !empty($clt[0]['points'])
                            ? $clt[0]['points']
                            : 0;

                        $rencontres = !empty($clt[0]['nombre_de_rencontres'])
                            ? $clt[0]['nombre_de_rencontres']
                            : 0;

                        $victoires = !empty($clt[0]['victoires'])
                            ? $clt[0]['victoires']
                            : 0;

                        $nuls = !empty($clt[0]['nuls'])
                            ? $clt[0]['nuls']
                            : 0;

                        $defaites = !empty($clt[0]['defaites'])
                            ? $clt[0]['defaites']
                            : 0;

                        $combats_gagnes = !empty($clt[0]['matchs_v'])
                            ? $clt[0]['matchs_v']
                            : 0;

                        $points_marques = !empty($clt[0]['points_marqués'])
                            ? $clt[0]['points_marqués']
                            : 0;

                             $ippons_marques = !empty($clt[0]['ippons_marqués'])
                            ? $clt[0]['ippons_marqués']
                            : 0;

                             $shidos_marques = !empty($clt[0]['shidos_gagnés'])
                            ? $clt[0]['shidos_gagnés']
                            : 0;


                        /* =================================================
                         * CLASSE TOP 8 / OUTSIDE TOP 8
                         * ================================================= */

                        $rank_class = ($rang <= 8)
                            ? 'top-8'
                            : 'outside-top-8';

                    ?>

                        <div class="jpl-ranking-row <?php echo esc_attr($rank_class); ?>">

                            <!-- RANG -->

                            <span class="rank">
                                <?php echo esc_html($rang); ?>
                            </span>


                            <!-- ÉQUIPE -->

                            <span class="rank-team">

                                <?php if ($team_logo): ?>

                                    <img
                                        src="<?php echo esc_url($team_logo); ?>"
                                        alt="<?php echo esc_attr($team_name); ?>"
                                    >

                                <?php endif; ?>

                                <strong>
                                    <?php echo esc_html($team_name); ?>
                                </strong>

                            </span>


                            <!-- POINTS -->

                            <span class="points">
                                <?php echo esc_html($points); ?>
                            </span>


                            <!-- RENCONTRES -->

                            <span>
                                <?php echo esc_html($rencontres); ?>
                            </span>


                            <!-- VICTOIRES -->

                            <span>
                                <?php echo esc_html($victoires); ?>
                            </span>


                            <!-- NULS -->

                            <span>
                                <?php echo esc_html($nuls); ?>
                            </span>


                            <!-- DÉFAITES -->

                            <span>
                                <?php echo esc_html($defaites); ?>
                            </span>


                            <!-- COMBATS GAGNÉS -->

                            <span class="jpl-ranking-extra">
                                <?php echo esc_html($combats_gagnes); ?>
                            </span>


                            <!-- POINTS MARQUÉS -->

                            <span class="jpl-ranking-extra">
                                <?php echo esc_html($points_marques); ?>
                            </span>

                            <span class="jpl-ranking-extra">
                                <?php echo esc_html($ippons_marques); ?>
                            </span>

                            <span class="jpl-ranking-extra">
                                <?php echo esc_html($shidos_marques); ?>
                            </span>

                        </div>

                    <?php endforeach; ?>

                </div>

            </div>

        <?php endif; ?>

    </section>


    <!-- =========================================================
         JOURNÉES
    ========================================================== -->

    <section class="pd-5 class-jours">

        <?php // display($rencontres_j1, 'J1'); ?>
        <?php // display($rencontres_j2, 'J2'); ?>
        <?php // display($rencontres_j3, 'J3'); ?>
        <?php // display($rencontres_j4, 'J4'); ?>
        <?php // display($rencontres_j5, 'J5'); ?>
        <?php // display($rencontres_j6, 'J6'); ?>

    </section>

</main>


<?php
get_footer();
?>