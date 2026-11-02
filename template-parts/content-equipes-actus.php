<?php
/**
 * Template part : Actualités équipe
 *
 * @package pro-league
 */

$site          = get_field('site_web');
$description   = get_field('presentation');
$directeur     = get_field('directeur');

$couleur1 = get_field('couleur1');
$couleur1 = $couleur1 ? $couleur1 : '#040b89';

$couleur2 = get_field('couleur2');
$couleur2 = $couleur2 ? $couleur2 : '#e00078';

$image = get_field('logo_principal')
    ? get_field('logo_principal')
    : get_the_post_thumbnail_url($post->ID, 'thumbnail');

$entraineur    = get_field('entraineur');
$date_creation = get_field('date_de_creation');
$reseaux       = get_field('reseaux_sociaux');
$palmares      = get_field('palmares');
$galerie_photos = get_field('galerie_photos');
$gender        = get_field('genre');

$current_fp = get_query_var('fpage');

$team_permalink = get_the_permalink($post->ID);

$logo_circle = get_field('logo_circle')
    ? get_field('logo_circle')
    : get_the_post_thumbnail_url($post->ID);

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


    <!-- =========================================================
         HEADER ÉQUIPE
    ========================================================== -->
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
                        class="jpl-team-menu-link <?php echo $key === 'actus' ? 'is-active' : ''; ?>"
                        <?php if ($key === 'actus'): ?>
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
    <!-- =========================================================
         CONTENU
    ========================================================== -->
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
                    <span>/</span>
                    <a href="<?php echo esc_url($team_permalink . 'infos/'); ?>">
                        <?php echo esc_html(get_the_title()); ?>
                    </a>
                    <span>/</span>
                    <strong>Actualités</strong>
                </div>	
            </div>
        <!-- =====================================================
             HERO DE SECTION
        ====================================================== -->
        <section class="jpl-team-section-header">
                <div>

                    <span class="jpl-page-eyebrow">
                        <?php echo esc_html( $team_name ); ?>
                    </span>

                    <h1 class="jpl-page-title">
                        Actualités
                    </h1>

                    <p class="jpl-page-description">
                        Découvrez les actualités de l'équipe.
<!--                         <?php echo esc_html( $saison_value ); ?>. -->
                    </p>

                </div>
        </section>
        <!-- =====================================================
             ACTUALITÉS
        ====================================================== -->
        <?php

        $args = array(
            'post_type'      => 'post',
            'posts_per_page' => -1,
            'orderby'        => 'post_date',
            'order'          => 'DESC',
            'meta_query'     => array(
                'relation' => 'AND',
                array(
                    'key'     => 'equipes',
                    'value'   => '"' . get_the_ID() . '"',
                    'compare' => 'LIKE'
                )
            ),
        );

        $news = get_posts($args);

        ?>


        <?php if ($news) : ?>

            <section class="jpl-news-grid">

                <?php foreach ($news as $my_post) : ?>

                    <?php

                    $video = get_field(
                        'videos_a_la_une',
                        $my_post->ID
                    );

                    $img = get_the_post_thumbnail_url(
                        $my_post->ID,
                        'full'
                    );

                    $url_externe = get_field(
                        'activer_lien_poule',
                        $my_post->ID
                    );

                    if ($url_externe === 'Activer') {

                        $url = get_field(
                            'lien_classement',
                            $my_post->ID
                        );

                    } else {

                        $url = get_permalink(
                            $my_post->ID
                        );

                    }

                    if (!$url) {
                        $url = get_permalink($my_post->ID);
                    }

                    ?>


                    <article class="jpl-news-card">

                        <a
                            href="<?php echo esc_url($url); ?>"
                            class="jpl-news-card-link"
                        >


                            <!-- IMAGE -->

                            <div class="jpl-news-image">

                                <?php if ($img) : ?>

                                    <img
                                        src="<?php echo esc_url($img); ?>"
                                        alt="<?php echo esc_attr(
                                            $my_post->post_title
                                        ); ?>"
                                        loading="lazy"
                                    >

                                <?php else : ?>

                                    <div class="jpl-news-placeholder">
                                        <i class="fa-solid fa-newspaper"></i>
                                    </div>

                                <?php endif; ?>


                                <?php if ($video) : ?>

                                    <span class="jpl-news-video-icon">

                                        <i class="fa-solid fa-play"></i>

                                    </span>

                                <?php endif; ?>

                            </div>


                            <!-- CONTENU -->

                            <div class="jpl-news-content">

                                <span
                                    class="jpl-news-date"
                                    style="
                                        color: <?php echo esc_attr($couleur1); ?>;
                                    "
                                >
                                    <?php
                                    echo esc_html(
                                        get_the_date(
                                            'j F Y',
                                            $my_post->ID
                                        )
                                    );
                                    ?>
                                </span>


                                <h3>

                                    <?php
                                    echo esc_html(
                                        $my_post->post_title
                                    );
                                    ?>

                                </h3>


<!--                                 <span class="jpl-news-more">

                                    Lire l'article

                                    <i class="fa-solid fa-arrow-right"></i>

                                </span>
 -->
                            </div>

                        </a>

                    </article>


                <?php endforeach; ?>

            </section>


        <?php else : ?>


            <section class="jpl-team-empty">

                <div class="jpl-team-empty-icon">

                    <i class="fa-solid fa-newspaper"></i>

                </div>

                <h2>
                    Aucune actualité
                </h2>
                <p>
                    Aucune actualité n'est actuellement disponible pour cette équipe.
                </p>
            </section>
        <?php endif; ?>

    </div>
</article>