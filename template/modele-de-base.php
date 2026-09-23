<?php

/**
 * Template Name: Modèle de base
 */

get_header();

/**
 * =========================================================
 * CONFIGURATION
 * =========================================================
 */

$saison_value = '2026-2027';

/**
 * =========================================================
 * HELPERS
 * =========================================================
 */

function jpl_team_logo($team_id, $class = '') {

    $logo = get_field('logo_miniature', $team_id);

    if (!$logo) {
        $logo = get_field('logo_circle', $team_id);
    }

    if (!$logo) {
        $logo = get_the_post_thumbnail_url($team_id, 'medium');
    }

    if (!$logo) {
        $logo = get_site_url() . '/wp-content/uploads/2022/11/profil.jpg';
    }

    return '<img class="' . esc_attr($class) . '" src="' . esc_url($logo) . '" alt="' . esc_attr(get_the_title($team_id)) . '">';
}


/**
 * Récupération des rencontres de la saison
 */
function jpl_get_home_matches($season = '2026-2027') {

    $args = array(
        'post_type'      => 'rencontre',
        'posts_per_page' => -1,
        'meta_key'       => 'date_de_debut',
        'orderby'        => 'meta_value',
        'order'          => 'ASC',
        'meta_query'     => array(
            array(
                'key'     => 'saisons',
                'value'   => $season,
                'compare' => 'LIKE'
            )
        )
    );

    return get_posts($args);
}


/**
 * Infos communes d'une rencontre
 */
function jpl_match_data($match) {

    $combat = get_field('les_combat', $match->ID);

    if (!empty($combat) && is_array($combat)) {
        $combat = $combat[0];
    } else {
        $combat = array();
    }

    $team1 = get_field('equipe_1', $match->ID);
    $team2 = get_field('equipe_2', $match->ID);

    $team1 = is_array($team1) ? ($team1[0] ?? null) : $team1;
    $team2 = is_array($team2) ? ($team2[0] ?? null) : $team2;

    if (!$team1 || !$team2) {
        return false;
    }

    $status_field = get_field('statut', $match->ID);

    if (is_array($status_field)) {
        $status = $status_field['label'] ?? '';
    } else {
        $status = $status_field;
    }

    $date = get_field(
        'date_de_debut',
        $match->ID,
        false,
        false
    );

    $phase = get_field('phase', $match->ID);
    $phase = is_array($phase) ? ($phase[0] ?? null) : $phase;

    $journee = get_field('journee', $match->ID);

    $team1_name = get_field('abreviation', $team1->ID);
    $team2_name = get_field('abreviation', $team2->ID);

    if (!$team1_name) {
        $team1_name = substr($team1->post_title, 0, 4);
    }

    if (!$team2_name) {
        $team2_name = substr($team2->post_title, 0, 4);
    }

    return array(
        'id'        => $match->ID,
        'team1'     => $team1,
        'team2'     => $team2,
        'team1name' => $team1_name,
        'team2name' => $team2_name,
        'team1logo' => get_field('logo_principal', $team1->ID)
            ?: get_the_post_thumbnail_url($team1->ID),
        'team2logo' => get_field('logo_principal', $team2->ID)
            ?: get_the_post_thumbnail_url($team2->ID),
        'score1' => (int) ($combat['nombre_de_combat_gagne_equipe_1'] ?? 0),
        'score2' => (int) ($combat['nombre_de_combat_gagne_equipe_2'] ?? 0),
        'status'    => strtolower(trim($status)),
        'date'      => $date,
        'phase'     => $phase ? $phase->post_title : '',
        'journee'   => $journee,
        'link'      => get_permalink($match->ID),
        'tickets'   => get_field('lien_de_reservation', $match->ID),
        'live'      => get_field('video_live', $match->ID),
        'winner'    => $combat['equipe_gagnante'] ?? ''
    );
}


/**
 * Séparation des rencontres
 */
$all_matches = jpl_get_home_matches($saison_value);

$live_matches     = array();
$upcoming_matches = array();
$finished_matches = array();

foreach ($all_matches as $match) {

    $data = jpl_match_data($match);

    if (!$data) {
        continue;
    }

    if ($data['status'] === 'en cours') {

        $live_matches[] = $data;

    } elseif ($data['status'] === 'à venir') {

        $upcoming_matches[] = $data;

    } elseif ($data['status'] === 'terminé') {

        $finished_matches[] = $data;
    }
}


/**
 * Prochains matchs
 */
$upcoming_matches = array_slice($upcoming_matches, 0, 4);


/**
 * Derniers résultats
 */
usort(
    $finished_matches,
    function ($a, $b) {
        return strtotime($b['date']) - strtotime($a['date']);
    }
);

$finished_matches = array_slice($finished_matches, 0, 4);


/**
 * =========================================================
 * ACTUALITÉS
 * =========================================================
 */

$news = get_posts(array(
    'post_type'      => 'post',
    'posts_per_page' => 4,
    'orderby'        => 'date',
    'order'          => 'DESC'
));

$featured_news = $news[0] ?? null;
$secondary_news = array_slice($news, 1, 3);


/**
 * =========================================================
 * STATISTIQUES
 * =========================================================
 */

require_once(
    THEMEDIR . 'template-parts/content-judokas-requests-stats-home.php'
);

$classement_equipes = get_classement(
    $all_matches,
    $saison_value,
    7
);

$classement_judokas_data = get_classement_judokas_home(
    $saison_value,
    7
);

$classement_judokas = $classement_judokas_data['total'] ?? array();


/**
 * =========================================================
 * CLASSEMENT
 * =========================================================
 */

$classement_home = get_classement(
    $all_matches,
    $saison_value,
    14
);


/**
 * =========================================================
 * VIDEOS
 * =========================================================
 */

$videos = get_posts(array(
    'post_type'      => 'video_youtube',
    'posts_per_page' => 3,
    'meta_key'       => 'date_dajout',
    'orderby'        => 'meta_value',
    'order'          => 'DESC'
));


/**
 * =========================================================
 * PRESENTATION
 * =========================================================
 */

?>

<main id="primary" class="site-main jpl-home">

    <!-- =====================================================
         HOME TOP
    ====================================================== -->

    <section class="jpl-home-top">

        <div class="jpl-home-container">

            <!-- =================================================
                 MAIN CONTENT
            ================================================== -->
<script src="https://cdn.jsdelivr.net/npm/@splidejs/splide@4.1.4/dist/js/splide.min.js"></script>
<link href="https://cdn.jsdelivr.net/npm/@splidejs/splide@4.1.4/dist/css/splide.min.css" rel="stylesheet">
            <div class="jpl-home-main">

                <div class="jpl-actualite">
                <div class="jpl-section-heading">
                    <h1>NOS ACTUALITÉS</h1>

                    <a href="<?php echo esc_url(
                        home_url('/actualites-judo-pro-league/')
                    ); ?>">
                        VOIR PLUS
                        <img class="" src="/wp-content/uploads/2026/09/arrow-btn.svg"/>
                    </a>

                </div>


                <?php if ($featured_news): ?>

                    <?php
                    $featured_image =
                        get_the_post_thumbnail_url(
                            $featured_news->ID,
                            'large'
                        );
                    ?>

                    <article class="jpl-featured-news">
                        <a
                            href="<?php echo esc_url(
                                get_permalink($featured_news->ID)
                            ); ?>"
                            class="jpl-news-image"
                            style="background-image:url('<?php echo esc_url($featured_image); ?>');"
                        >
                            <div class="jpl-news-overlay"></div>

                            <div class="jpl-news-featured-content">

                                <span class="jpl-news-tag">
                                    Actualités
                                </span>

                                <h2>
                                    <?php echo esc_html(
                                        $featured_news->post_title
                                    ); ?>
                                </h2>
                            </div>
                        </a>
                    </article>
                <?php endif; ?>


                <?php if ($secondary_news): ?>
                    <div class="jpl-news-grid">
                        <?php foreach ($secondary_news as $article): ?>

                            <?php
                            $image = get_the_post_thumbnail_url(
                                $article->ID,
                                'medium_large'
                            );
                            ?>
                            <article class="jpl-news-card">
                                <a
                                    href="<?php echo esc_url(
                                        get_permalink($article->ID)
                                    ); ?>"
                                    class="jpl-news-card-image"
                                    style="background-image:url('<?php echo esc_url($image); ?>');"
                                ></a>
                                <div class="jpl-news-card-body">
                                    <h3>
                                        <a
                                            href="<?php echo esc_url(
                                                get_permalink($article->ID)
                                            ); ?>"
                                        >
                                            <?php echo esc_html(
                                                $article->post_title
                                            ); ?>
                                        </a>
                                    </h3>
                                    <span>
                                        <?php
                                        echo esc_html(
                                            get_the_date(
                                                'j F Y',
                                                $article->ID
                                            )
                                        );
                                        ?>
                                    </span>
                                </div>
                            </article>
                        <?php endforeach; ?>

                    </div>

                <?php endif; ?>
				</div>
    <!-- =====================================================
         STATISTIQUES
    ====================================================== -->
    <section class="jpl-section jpl-statistics">
        <div class="jpl-container">
            <div class="jpl-section-heading">
                <h2>STATISTIQUES</h2>
                <a href="/statistiques-equipes-judo-pro-league/">
                    VOIR PLUS
                    <img class="" src="/wp-content/uploads/2026/09/arrow-btn.svg"/>
                </a>

            </div>
            <div class="jpl-stats-grid">
                <!-- EQUIPES -->
                <div class="jpl-stat-card equipe">
                    <div class="jpl-stat-card-title">
                        <h3>Équipes</h3>
                    </div>
                    <div class="jpl-stat-columns">
                        <div class="bg-column">
                            <h4>Points marqués</h4>

<?php
$teams_points = is_array($classement_equipes)
    ? $classement_equipes
    : array();

usort(
    $teams_points,
    function ($a, $b) {

        $points_b = isset($b[0]['points_marqués'])
            ? (int) $b[0]['points_marqués']
            : 0;

        $points_a = isset($a[0]['points_marqués'])
            ? (int) $a[0]['points_marqués']
            : 0;

        return $points_b - $points_a;
    }
);
?>

                            <?php foreach (array_slice($teams_points, 0, 7) as $row): ?>

                                <?php $team = $row[0]; ?>

                                <div class="jpl-stat-line">

                                    <div class="jpl-stat-name">

                                        <?php if (!empty($team['image'])): ?>

                                            <img
                                                src="<?php echo esc_url(
                                                    $team['image']
                                                ); ?>"
                                                alt=""
                                            >

                                        <?php endif; ?>

                                        <span>
                                            <?php echo esc_html(
                                                $team['abreviation']
                                            ); ?>
                                        </span>

                                    </div>

                                    <strong>
                                        <?php echo esc_html(
                                            $team['points_marqués'] ?? 0
                                        ); ?>
                                    </strong>
                                </div>
                            <?php endforeach; ?>
                        </div>
                        <div class="bg-column">
                            <h4>Ippons</h4>

<?php
$teams_ippons = is_array($classement_equipes)
    ? $classement_equipes
    : array();

usort(
    $teams_ippons,
    function ($a, $b) {

        $ippons_b = isset($b[0]['ippons_marqués'])
            ? (int) $b[0]['ippons_marqués']
            : 0;

        $ippons_a = isset($a[0]['ippons_marqués'])
            ? (int) $a[0]['ippons_marqués']
            : 0;
        return $ippons_b - $ippons_a;
    }
);
?>
                            <?php foreach (array_slice($teams_ippons, 0, 7) as $row): ?>
                                <?php $team = $row[0]; ?>

                                <div class="jpl-stat-line">

                                    <div class="jpl-stat-name">

                                        <?php if (!empty($team['image'])): ?>

                                            <img
                                                src="<?php echo esc_url(
                                                    $team['image']
                                                ); ?>"
                                                alt=""
                                            >
                                        <?php endif; ?>

                                        <span>
                                            <?php echo esc_html(
                                                $team['abreviation']
                                            ); ?>
                                        </span>

                                    </div>

                                    <strong>
                                        <?php echo esc_html(
                                            $team['ippons_marqués'] ?? 0
                                        ); ?>
                                    </strong>

                                </div>

                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>

                <!-- JUDOKAS -->
                <div class="jpl-stat-card judokas">
                    <div class="jpl-stat-card-title">
                        <h3>Judokas</h3>
                    </div>
                    <div class="jpl-stat-columns">
                        <div class="bg-column">
                            <h4>Victoires</h4>
                            <?php foreach ($classement_judokas as $row): ?>
                                <?php $judoka = $row[0]; ?>
                                <div class="jpl-stat-line">
                                   <div class="jpl-stat-name">
                                       <?php if (!empty($judoka['image'])): ?>
                                            <img
                                                src="<?php echo esc_url(
                                                    $judoka['image']
                                                ); ?>"
                                                alt=""
                                            >
                                        <?php endif; ?>
<span>
    <?php echo esc_html(
        $judoka['nom'] ?? ''
    ); ?>
</span>
                                    </div>

                                    <strong>
                                        <?php echo esc_html(
                                            $judoka['matchs_v'] ?? 0
                                        ); ?>
                                    </strong>
                                </div>
                            <?php endforeach; ?>
                        </div>
                        <div class="bg-column">
                            <h4>Ippons</h4>
                            <?php foreach ($classement_judokas as $row): ?>
                                <?php $judoka = $row[0]; ?>
                                <div class="jpl-stat-line">
                                    <div class="jpl-stat-name">
                                        <?php if (!empty($judoka['image'])): ?>
                                            <img
                                                src="<?php echo esc_url(
                                                    $judoka['image']
                                                ); ?>"
                                                alt=""
                                            >

                                        <?php endif; ?>

                                        <span>
                                            <?php echo esc_html(
                                                $judoka['nom']
                                            ); ?>
                                        </span>

                                    </div>

                                    <strong>
                                        <?php echo esc_html(
                                            $judoka['ippons_marqués'] ?? 0
                                        ); ?>
                                    </strong>

                                </div>

                            <?php endforeach; ?>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </section>
<!-- =====================================================
     STATISTIQUES MOBILE
====================================================== -->

<section class="jpl-statistics-mobile">

    <div class="jpl-container" style="margin:0px;width:100%;">
        <!--<div class="jpl-section-heading">
            <h2>STATISTIQUES</h2>
            <a href="/statistiques-equipes-judo-pro-league/">
                VOIR PLUS
                <img
                    src="/wp-content/uploads/2026/09/arrow-btn.svg"
                    alt=""
                >
            </a>
        </div>-->
        <!-- TABS -->
<div class="col-stat-tab jpl-section">
	<h2>STATISTIQUES</h2>
        <div class="jpl-stats-tabs">

            <button
                type="button"
                class="jpl-stats-tab active"
                data-tab="equipes"
            >
                ÉQUIPES
            </button>

            <button
                type="button"
                class="jpl-stats-tab"
                data-tab="judokas"
            >
                JUDOKAS
            </button>

        </div>


        <!-- =========================
             EQUIPES
        ========================== -->

        <div
            class="jpl-mobile-stat-content active"
            id="stats-equipes"
        >

            <div class="jpl-stat-columns">

                <!-- POINTS -->

                <div class="bg-column">

                    <h4>Points marqués</h4>

                    <?php foreach (array_slice($teams_points, 0, 7) as $row): ?>

                        <?php $team = $row[0]; ?>

                        <div class="jpl-stat-line">

                            <div class="jpl-stat-name">

                                <?php if (!empty($team['image'])): ?>

                                    <img
                                        src="<?php echo esc_url($team['image']); ?>"
                                        alt=""
                                    >

                                <?php endif; ?>

                                <span>
                                    <?php echo esc_html(
                                        $team['abreviation'] ?? ''
                                    ); ?>
                                </span>

                            </div>

                            <strong>
                                <?php echo esc_html(
                                    $team['points_marqués'] ?? 0
                                ); ?>
                            </strong>

                        </div>

                    <?php endforeach; ?>

                </div>


                <!-- IPPONS -->

                <div class="bg-column">

                    <h4>Ippons</h4>

                    <?php foreach (array_slice($teams_ippons, 0, 7) as $row): ?>

                        <?php $team = $row[0]; ?>

                        <div class="jpl-stat-line">

                            <div class="jpl-stat-name">

                                <?php if (!empty($team['image'])): ?>

                                    <img
                                        src="<?php echo esc_url($team['image']); ?>"
                                        alt=""
                                    >

                                <?php endif; ?>

                                <span>
                                    <?php echo esc_html(
                                        $team['abreviation'] ?? ''
                                    ); ?>
                                </span>

                            </div>

                            <strong>
                                <?php echo esc_html(
                                    $team['ippons_marqués'] ?? 0
                                ); ?>
                            </strong>

                        </div>

                    <?php endforeach; ?>

                </div>

            </div>

        </div>


        <!-- =========================
             JUDOKAS
        ========================== -->

        <div
            class="jpl-mobile-stat-content"
            id="stats-judokas"
        >

            <div class="jpl-stat-columns">

                <!-- VICTOIRES -->

                <div class="bg-column">

                    <h4>Victoires</h4>

                    <?php foreach (array_slice($classement_judokas, 0, 7) as $row): ?>

                        <?php $judoka = $row[0]; ?>

                        <div class="jpl-stat-line">

                            <div class="jpl-stat-name">

                                <?php if (!empty($judoka['image'])): ?>

                                    <img
                                        src="<?php echo esc_url($judoka['image']); ?>"
                                        alt=""
                                    >

                                <?php endif; ?>

                                <span>
                                    <?php echo esc_html(
                                        $judoka['nom'] ?? ''
                                    ); ?>
                                </span>

                            </div>

                            <strong>
                                <?php echo esc_html(
                                    $judoka['matchs_v'] ?? 0
                                ); ?>
                            </strong>

                        </div>

                    <?php endforeach; ?>

                </div>


                <!-- IPPONS -->

                <div class="bg-column">

                    <h4>Ippons</h4>

                    <?php foreach (array_slice($classement_judokas, 0, 7) as $row): ?>

                        <?php $judoka = $row[0]; ?>

                        <div class="jpl-stat-line">

                            <div class="jpl-stat-name">

                                <?php if (!empty($judoka['image'])): ?>

                                    <img
                                        src="<?php echo esc_url($judoka['image']); ?>"
                                        alt=""
                                    >

                                <?php endif; ?>

                                <span>
                                    <?php echo esc_html(
                                        $judoka['nom'] ?? ''
                                    ); ?>
                                </span>

                            </div>

                            <strong>
                                <?php echo esc_html(
                                    $judoka['ippons_marqués'] ?? 0
                                ); ?>
                            </strong>

                        </div>

                    <?php endforeach; ?>

                </div>

            </div>

        </div>

    </div>

</section>
				<script>
document.addEventListener('DOMContentLoaded', function () {

    const tabs = document.querySelectorAll('.jpl-stats-tab');
    const contents = document.querySelectorAll('.jpl-mobile-stat-content');

    tabs.forEach(function (tab) {

        tab.addEventListener('click', function () {

            const target = tab.dataset.tab;

            tabs.forEach(function (item) {
                item.classList.remove('active');
            });

            contents.forEach(function (content) {
                content.classList.remove('active');
            });

            tab.classList.add('active');

            const targetContent = document.getElementById(
                'stats-' + target
            );

            if (targetContent) {
                targetContent.classList.add('active');
            }

        });

    });

});
</script>
<!-- =====================================================
         VIDEOS
    ====================================================== -->

    <section class="jpl-section jpl-videos">

        <div class="jpl-container">

            <div class="jpl-section-heading">

                <h2>NOS VIDÉOS</h2>

                <a href="/toutes-les-videos/">
                    VOIR PLUS
                    <img class="" src="/wp-content/uploads/2026/09/arrow-btn.svg"/>
                </a>

            </div>


            <div class="jpl-video-grid">

                <?php foreach ($videos as $video): ?>

                    <?php
                    $video_id = get_field('id', $video->ID);

                    $video_image =
                        get_the_post_thumbnail_url(
                            $video->ID,
                            'large'
                        );

                    if (!$video_image && $video_id) {
                        $video_image =
                            'https://i.ytimg.com/vi/' .
                            esc_attr($video_id) .
                            '/maxresdefault.jpg';
                    }

                    $video_title = get_field(
                        'titre',
                        $video->ID
                    );

                     $video_date_dajout = get_field(
                        'date_dajout',
                        $video->ID
                    );

                    

                    if (!$video_title) {
                        $video_title = $video->post_title;
                    }
                    ?>

                    <article class="jpl-video-card">

                        <div
                            class="jpl-video-image"
                            style="background-image:url('<?php echo esc_url($video_image); ?>');"
                        >

                            <?php if ($video_id): ?>

                                <a
                                    href="https://www.youtube.com/watch?v=<?php echo esc_attr($video_id); ?>"
                                    target="_blank"
                                    rel="noopener"
                                    class="jpl-play-button"
                                >
                                    <i class="fa-solid fa-play"></i>
                                </a>

                            <?php endif; ?>

                        </div>

                        <div class="jpl-video-body">

                            <span><?php echo $video_date_dajout;?></span>

                            <h3>
                                <?php echo esc_html(
                                    $video_title
                                ); ?>
                            </h3>

                        </div>

                    </article>

                <?php endforeach; ?>

            </div>

        </div>

    </section>
    <!-- =====================================================
         PRESENTATION
    ====================================================== -->
	<div>
				<?php
    require_once (THEMEDIR.'inc/acf-blocs/bloc-presentation.php');
    while ( have_rows('articles'))
    {
        the_row();
        $style=get_row_layout();
        //site_debug("style=$style");
        $section=false;
        switch($style)
        {
           case 'bloc_presentation':
                require_once (THEMEDIR.'inc/acf-blocs/bloc-presentation.php');
                $section=bloc_presentation();
                break;
    
        }
    }
				?>
		<img class="mob-presenta" src="/wp-content/uploads/2026/09/Group-40420.svg"/>
	</div>
				
				
				
            </div>


            <!-- =================================================
                 SIDEBAR
            ================================================== -->

            <aside class="jpl-home-sidebar">


                <!-- LIVE -->

                <div class="jpl-sidebar-block-live">

                    <!--<div class="jpl-sidebar-title-live">

                        <?php if (!empty($live_matches)): ?>
                            <span class="jpl-live-dot"></span>
                        <?php endif; ?>

                    </div>-->
					
                    <?php if (!empty($live_matches)): ?>

                        <?php foreach ($live_matches as $match): ?>

                            <?php
                            $team1_logo = $match['team1logo'];
                            $team2_logo = $match['team2logo'];
                            ?>

                            <a
                                href="<?php echo esc_url($match['link']); ?>"
                                class="jpl-score-card jpl-score-live jpl-mini-match"
                            >
					<div class="jpl-mini-live-icon">
						<img src="/wp-content/uploads/2026/09/live.svg" />
					</div>
                                <div class="jpl-score-team team1">

                                    <span>
                                        <?php echo esc_html(
                                            $match['team1name']
                                        ); ?>
                                    </span>

                                    <?php if ($team1_logo): ?>
                                        <img
                                            src="<?php echo esc_url($team1_logo); ?>"
                                            alt=""
                                        >
                                    <?php endif; ?>

                                </div>

                                <strong>
                                    <?php echo esc_html($match['score1']); ?>
                                    -
                                    <?php echo esc_html($match['score2']); ?>
                                </strong>

                                <div class="jpl-score-team team2">

                                    <?php if ($team2_logo): ?>
                                        <img
                                            src="<?php echo esc_url($team2_logo); ?>"
                                            alt=""
                                        >
                                    <?php endif; ?>

                                    <span>
                                        <?php echo esc_html(
                                            $match['team2name']
                                        ); ?>
                                    </span>

                                </div>

                            </a>

                        <?php endforeach; ?>

                    <?php else: ?>

                        <div class="jpl-no-live">
                            Aucun match en direct
                        </div>

                    <?php endif; ?>

                </div>


                <!-- UPCOMING -->

                <div class="jpl-sidebar-block rencontres">

                    <div class="jpl-sidebar-title">

                        <h2>RENCONTRES À VENIR</h2>

                        <a href="/calendrier-resultats-2023/final4/">
                            VOIR TOUTES
							<img class="" src="/wp-content/uploads/2026/09/arrow-btn.svg"/>
                        </a>

                    </div>


                    <div class="jpl-mini-matches">

                        <?php foreach ($upcoming_matches as $match): ?>

                            <a
                                href="<?php echo esc_url($match['link']); ?>"
                                class="jpl-mini-match"
                            >

                                <div class="jpl-mini-date">

                                    <strong>
                                        <?php
                                        echo esc_html(
                                            date_i18n(
                                                'd',
                                                strtotime($match['date'])
                                            )
                                        );
                                        ?>
                                    </strong>

                                    <span>
                                        <?php
                                        echo esc_html(
                                            date_i18n(
                                                'M',
                                                strtotime($match['date'])
                                            )
                                        );
                                        ?>
                                    </span>
                                <div class="jpl-mini-time-done">

                                    <?php
                                    echo esc_html(
                                        date_i18n(
                                            'H:i',
                                            strtotime($match['date'])
                                        )
                                    );
                                    ?>

                                </div>
                                </div>


                                <div class="jpl-mini-team team1">

                                    <span>
                                        <?php echo esc_html(
                                            $match['team1name']
                                        ); ?>
                                    </span>

                                    <?php if ($match['team1logo']): ?>
                                        <img
                                            src="<?php echo esc_url(
                                                $match['team1logo']
                                            ); ?>"
                                            alt=""
                                        >
                                    <?php endif; ?>

                                </div>

                                <div class="jpl-mini-result">

                                    <?php echo esc_html(
                                        $match['score1']
                                    ); ?>

                                    <span>-</span>

                                    <?php echo esc_html(
                                        $match['score2']
                                    ); ?>

                                </div>

                                <div class="jpl-mini-team team2">

                                    <?php if ($match['team2logo']): ?>
                                        <img
                                            src="<?php echo esc_url(
                                                $match['team2logo']
                                            ); ?>"
                                            alt=""
                                        >
                                    <?php endif; ?>

                                    <span>
                                        <?php echo esc_html(
                                            $match['team2name']
                                        ); ?>
                                    </span>

                                </div>

                            </a>

                        <?php endforeach; ?>

                    </div>

                </div>


                <!-- RESULTS -->
                <div class="jpl-sidebar-block last-results">
                    <div class="jpl-sidebar-title">
                        <h2>DERNIERS RÉSULTATS</h2>
                        <a href="/calendrier-resultats-2023/final4/">
                            VOIR TOUTES
							<img class="" src="/wp-content/uploads/2026/09/arrow-btn.svg"/>
                        </a>
                    </div>

                    <div class="jpl-mini-matches">
                        <?php foreach ($finished_matches as $match): ?>
                           <a
                                href="<?php echo esc_url($match['link']); ?>"
                                class="jpl-mini-match jpl-result"
                            >
                                <div class="jpl-mini-date">
                                    <strong>
                                        <?php
                                        echo esc_html(
                                            date_i18n(
                                                'd',
                                                strtotime($match['date'])
                                            )
                                        );
                                        ?>
                                    </strong>

                                    <span>
                                        <?php
                                        echo esc_html(
                                            date_i18n(
                                                'M',
                                                strtotime($match['date'])
                                            )
                                        ); ?>
                                    </span>
                                 <div class="jpl-mini-time-done">
                                    <?php
                                    echo esc_html(
                                        date_i18n(
                                            'H:i',
                                            strtotime($match['date'])
                                        )
                                    );
                                    ?>
                                </div>
                                </div>


<div class="jpl-mini-team team1 <?php echo ($match['score1'] < $match['score2']) ? 'lost' : ''; ?>">
                                    <span>
                                        <?php echo esc_html(
                                            $match['team1name']
                                        ); ?>
                                    </span>

                                    <?php if ($match['team1logo']): ?>
                                        <img
                                            src="<?php echo esc_url(
                                                $match['team1logo']
                                            ); ?>"
                                            alt=""
                                        >
                                    <?php endif; ?>

                                </div>


                                <div class="jpl-mini-result">

                                    <?php echo esc_html(
                                        $match['score1']
                                    ); ?>

                                    <span>-</span>

                                    <?php echo esc_html(
                                        $match['score2']
                                    ); ?>

                                </div>


<div class="jpl-mini-team team2 <?php echo ($match['score2'] < $match['score1']) ? 'lost' : ''; ?>">
                                    <?php if ($match['team2logo']): ?>
                                        <img
                                            src="<?php echo esc_url(
                                                $match['team2logo']
                                            ); ?>"
                                            alt=""
                                        >
                                    <?php endif; ?>

                                    <span>
                                        <?php echo esc_html(
                                            $match['team2name']
                                        ); ?>
                                    </span>

                                </div>

                            </a>

                        <?php endforeach; ?>

                    </div>

                </div>


                <!-- PUBLICITE -->

                <div class="jpl-ad">

                    <span>PUBLICITÉ</span>

                </div>


                <!-- CLASSEMENT -->

                <div class="jpl-sidebar-block jpl-ranking">

                    <div class="jpl-sidebar-title">

                        <h2>CLASSEMENT</h2>

                        <a href="/classement-judo-pro-league/">
                            VOIR TOUT
							<img class="" src="/wp-content/uploads/2026/09/arrow-btn.svg"/>
                        </a>

                    </div>


                    <div class="jpl-ranking-header">

                        <span></span>
                        <span style="text-align: left !important;">Équipes</span>
                        <span>Defaites</span>
                        <span>Victoires</span>
                        <span>Points</span>

                    </div>


<?php
$classement_home = is_array($classement_home) ? $classement_home : array();

$rang = 1;

foreach ($classement_home as $row):

    if (
        !is_array($row) ||
        !isset($row[0]) ||
        !is_array($row[0])
    ) {
        continue;
    }

    $team = $row[0];

    $classement_class = ($rang <= 8)
        ? 'top-8'
        : 'outside-top-8';
?>

    <div class="jpl-ranking-row <?php echo esc_attr($classement_class); ?>">

        <span class="rank">
            <?php echo esc_html($rang); ?>
        </span>

        <span class="rank-team">

            <?php if (!empty($team['image'])): ?>

                <img
                    src="<?php echo esc_url($team['image']); ?>"
                    alt=""
                >

            <?php endif; ?>

            <strong>
                <?php echo esc_html($team['abreviation'] ?? ''); ?>
            </strong>

        </span>

        <span>
            <?php echo esc_html(
                (int) ($team['defaites'] ?? 0)
            ); ?>
        </span>

        <span>
            <?php echo esc_html(
                (int) ($team['victoires'] ?? 0)
            ); ?>
        </span>

        <span class="points">
            <?php echo esc_html(
                (int) ($team['points'] ?? 0)
            ); ?>
        </span>

    </div>

<?php
    $rang++;

endforeach;
?>
                </div>
            </aside>
        </div>
    </section>





    <!-- =====================================================
         TEAMS
    ====================================================== -->

    <section class="jpl-team-marquee">

        <div class="jpl-container">

            <div class="jpl-team-track">

                <?php

                $teams = get_posts(array(
                    'numberposts' => -1,
                    'post_type'   => 'equipes',
                    'orderby'     => 'title',
                    'order'       => 'ASC',
                    'meta_query'  => array(
                        array(
                            'key'     => 'saisons',
                            'compare' => 'LIKE',
                            'value'   => $saison_value
                        )
                    )
                ));

                foreach ($teams as $team):

                    $logo = get_field(
                        'logo_circle',
                        $team->ID
                    );

                    if (!$logo) {
                        $logo = get_the_post_thumbnail_url(
                            $team->ID,
                            'medium'
                        );
                    }

                    ?>

                    <a
                        href="<?php echo esc_url(
                            get_permalink($team->ID)
                        ); ?>"
                        class="jpl-team-logo"
                    >

                        <?php if ($logo): ?>

                            <img
                                src="<?php echo esc_url($logo); ?>"
                                alt="<?php echo esc_attr(
                                    $team->post_title
                                ); ?>"
                            >

                        <?php endif; ?>

                    </a>

                <?php endforeach; ?>

            </div>

        </div>

    </section>

</main>

<?php get_footer(); ?>