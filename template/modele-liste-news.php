<?php
/**
 * Template Name: Actualités Judo Pro League
 */
get_header();
/* =========================================================
 * CONFIGURATION
 * ========================================================= */

$posts_per_page_initial = 4;
$posts_per_click        = 4;

/* =========================================================
 * RÉCUPÉRER LE PREMIER ET LE DERNIER ARTICLE
 * ========================================================= */

$first_post_query = new WP_Query(array(
    'post_type'           => 'post',
    'post_status'         => 'publish',
    'posts_per_page'      => 1,
    'orderby'             => 'date',
    'order'               => 'ASC',
    'ignore_sticky_posts' => true,
    'no_found_rows'       => false,
));

$last_post_query = new WP_Query(array(
    'post_type'           => 'post',
    'post_status'         => 'publish',
    'posts_per_page'      => 1,
    'orderby'             => 'date',
    'order'               => 'DESC',
    'ignore_sticky_posts' => true,
    'no_found_rows'       => false,
));

$first_post_date = '';
$last_post_date  = '';

if ($first_post_query->have_posts()) {
    $first_post_query->the_post();
    $first_post_date = get_the_date('Y-m-d H:i:s');
}

wp_reset_postdata();

if ($last_post_query->have_posts()) {
    $last_post_query->the_post();
    $last_post_date = get_the_date('Y-m-d H:i:s');
}

wp_reset_postdata();


/* =========================================================
 * SAISONS À AFFICHER
 *
 * 2026/2027
 * 2025/2026
 * 2024/2025
 * ========================================================= */

$seasons = array(
    array(
        'start_year' => 2026,
        'end_year'   => 2027,
        'label'      => '2026/2027',
        'start_date' => '2026-01-01 00:00:00',
        'end_date'   => '2027-12-31 23:59:59',
    ),

    array(
        'start_year' => 2025,
        'end_year'   => 2026,
        'label'      => '2025/2026',
        'start_date' => '2025-01-01 00:00:00',
        'end_date'   => '2026-12-31 23:59:59',
    ),

    array(
        'start_year' => 2024,
        'end_year'   => 2025,
        'label'      => '2024/2025',
        'start_date' => '2024-01-01 00:00:00',
        'end_date'   => '2025-12-31 23:59:59',
    ),
);


/* =========================================================
 * IMAGE ARTICLE
 * ========================================================= */

function jpl_news_image($post_id) {

    if (has_post_thumbnail($post_id)) {
        return get_the_post_thumbnail_url(
            $post_id,
            'large'
        );
    }

    return get_template_directory_uri()
        . '/assets/images/default-news.jpg';
}


/* =========================================================
 * CATÉGORIES
 * ========================================================= */

function jpl_news_categories($post_id) {

    $categories = get_the_category($post_id);

    if (empty($categories)) {
        return '';
    }

    $output = array();

    foreach ($categories as $category) {
        $output[] = esc_html($category->name);
    }

    return implode(' · ', $output);
}


/* =========================================================
 * TAGS
 * ========================================================= */

function jpl_news_tags($post_id) {

    $tags = get_the_tags($post_id);

    if (empty($tags)) {
        return '';
    }

    $output = array();

    foreach ($tags as $tag) {
        $output[] = esc_html($tag->name);
    }

    return implode(' · ', $output);
}

?>


<main class="jpl-news-page" style="background: #F5F7FB;">

    <div class="jpl-news-container">

<section class="jpl-stats-hero">
        <div class="jpl-stats-hero-content">
            <span class="jpl-stats-eyebrow">
                JUDO PRO LEAGUE
            </span>
            <h1 class="">ACTUALITÉS de la Judo Pro League</h1>
        </div>

    </section>

        <?php if (!empty($seasons)) : ?>

            <?php foreach ($seasons as $season_index => $season) : ?>

                <?php

                /*
                 * La saison 2026/2027 est ouverte par défaut.
                 */
                $is_current_season = ($season['label'] === '2026/2027');


                /*
                 * Pour 2026/2027 :
                 *
                 * - 4 articles visibles au départ
                 * - 1 grand article
                 * - 3 articles en dessous
                 * - 3 articles supplémentaires par clic
                 *
                 * Pour les autres saisons :
                 *
                 * - 4 visibles
                 * - 4 supplémentaires par clic
                 */

                $initial_count = $posts_per_page_initial;

                if ($is_current_season) {
                    $load_more_count = 3;
                } else {
                    $load_more_count = $posts_per_click;
                }


                /*
                 * RÉCUPÉRER TOUS LES ARTICLES DE LA SAISON
                 */

                $season_query = new WP_Query(array(

                    'post_type'           => 'post',

                    'post_status'         => 'publish',

                    'posts_per_page'      => -1,

                    'orderby'             => 'date',

                    'order'               => 'DESC',

                    'ignore_sticky_posts' => true,

                    'no_found_rows'       => false,

                    'date_query'          => array(
                        array(
                            'after'     => $season['start_date'],
                            'before'    => $season['end_date'],
                            'inclusive' => true,
                        ),
                    ),

                ));

                $season_count = (int) $season_query->found_posts;

                ?>


                <section
                    class="jpl-news-season <?php echo $is_current_season ? 'is-open' : ''; ?>"
                    data-season="<?php echo esc_attr($season['label']); ?>"
                >


                    <!-- =========================================
                         HEADER SAISON
                    ========================================== -->

                    <div class="jpl-season-header">

                        <h2 class="jpl-season-title">

                            <?php echo esc_html($season['label']); ?>

                            <span
                                style="
                                    font-size:14px;
                                    font-weight:500;
                                    color:#777;
                                    margin-left:8px;
                                "
                            >
                                (<?php echo $season_count; ?> articles)
                            </span>

                        </h2>


                        <?php if (!$is_current_season) : ?>

                            <button
                                type="button"
                                class="jpl-season-toggle"
                                aria-expanded="false"
                                aria-label="Afficher la saison <?php echo esc_attr($season['label']); ?>"
                            >
                                   <img
        src="/wp-content/uploads/2026/09/Vector.svg"
        alt=""
        class="jpl-season-arrow"
    >
                            </button>

                        <?php endif; ?>

                    </div>


                    <!-- =========================================
                         CONTENU SAISON
                    ========================================== -->

                    <div
                        class="jpl-season-content"
                        <?php echo !$is_current_season ? 'style="display:none;"' : ''; ?>
                    >
                        <?php if ($season_query->have_posts()) : ?>
                            <div
                                class="jpl-news-grid <?php echo $is_current_season ? 'jpl-news-grid-2026' : 'jpl-news-grid-standard'; ?>"
                                data-news-grid
                                data-season="<?php echo esc_attr($season['label']); ?>"
                            >
                                <?php

                                $article_index = 0;

                                while ($season_query->have_posts()) :

                                    $season_query->the_post();

                                    $post_id = get_the_ID();


                                    /*
                                     * Cacher les articles après les 4 premiers.
                                     */

                                    $is_hidden =
                                        $article_index >= $initial_count;


                                    /*
                                     * Le premier article de 2026/2027
                                     * est le grand article pleine largeur.
                                     */

                                    $is_featured =
                                        $is_current_season &&
                                        $article_index === 0;

                                    ?>


                                    <article
                                        class="
                                            jpl-news-card
                                            <?php echo $is_hidden ? 'is-hidden' : ''; ?>
                                            <?php echo $is_featured ? 'jpl-news-featured' : ''; ?>
                                        "
                                        data-news-card
                                    >


                                        <!-- =================================
                                             IMAGE
                                        ================================== -->

                                        <a
                                            href="<?php the_permalink(); ?>"
                                            class="jpl-news-card-image"
                                        >

                                            <img
                                                src="<?php echo esc_url(
                                                    jpl_news_image($post_id)
                                                ); ?>"
                                                alt="<?php echo esc_attr(
                                                    get_the_title()
                                                ); ?>"
                                                loading="lazy"
                                            >

                                        </a>


                                        <!-- =================================
                                             CONTENU
                                        ================================== -->

                                        <div class="jpl-news-card-content">


                                            <!-- CATÉGORIES + DATE -->

                                            <?php

                                            $categories =
                                                jpl_news_categories($post_id);

                                            if ($categories) :

                                            ?>

                                                <div class="jpl-news-meta">

                                                    <span class="jpl-news-cat">

                                                        <?php
                                                        echo $categories;
                                                        ?>

                                                    </span>


                                                    <span class="jpl-news-date">

                                                        <?php

                                                        echo esc_html(
                                                            get_the_date(
                                                                'd/m/Y',
                                                                $post_id
                                                            )
                                                        );

                                                        ?>

                                                    </span>

                                                </div>

                                            <?php endif; ?>


                                            <!-- TITRE -->

                                            <h3 class="jpl-news-card-title">

                                                <a
                                                    href="<?php the_permalink(); ?>"
                                                >

                                                    <?php the_title(); ?>

                                                </a>

                                            </h3>


                                        </div>

                                    </article>


                                    <?php

                                    $article_index++;

                                endwhile;

                                ?>

                            </div>


                            <!-- =================================
                                 AFFICHER PLUS
                            ================================== -->

                            <?php if ($season_count > $initial_count) : ?>

                                <div class="jpl-news-load-more-wrapper">

                                    <button
                                        type="button"
                                        class="jpl-news-load-more"
                                        data-load-more
                                        data-load-count="<?php echo esc_attr($load_more_count); ?>"
                                    >
                                        AFFICHER PLUS
                                    </button>

                                </div>

                            <?php endif; ?>


                        <?php else : ?>

                            <div class="jpl-news-empty">

                                Aucun article pour cette saison.

                            </div>

                        <?php endif; ?>


                    </div>

                </section>


                <?php wp_reset_postdata(); ?>

            <?php endforeach; ?>

        <?php else : ?>

            <p class="jpl-news-empty">
                Aucun article trouvé.
            </p>

        <?php endif; ?>


    </div>

</main>


<script>

document.addEventListener('DOMContentLoaded', function () {


    /* =====================================================
       TOGGLE DES SAISONS
    ===================================================== */

    document
        .querySelectorAll('.jpl-news-season')
        .forEach(function (season) {

            const toggle =
                season.querySelector('.jpl-season-toggle');

            const content =
                season.querySelector('.jpl-season-content');


            if (!toggle || !content) {
                return;
            }


            toggle.addEventListener('click', function () {

                const isOpen =
                    season.classList.contains('is-open');


                if (isOpen) {

                    season.classList.remove('is-open');

                    toggle.setAttribute(
                        'aria-expanded',
                        'false'
                    );

                    content.style.display = 'none';

                } else {

                    season.classList.add('is-open');

                    toggle.setAttribute(
                        'aria-expanded',
                        'true'
                    );

                    content.style.display = 'block';

                }

            });

        });



    /* =====================================================
       AFFICHER PLUS
    ===================================================== */

    document
        .querySelectorAll('[data-load-more]')
        .forEach(function (button) {


            button.addEventListener('click', function () {


                const content =
                    button.closest('.jpl-season-content');


                if (!content) {
                    return;
                }


                /*
                 * Récupérer uniquement les articles cachés
                 */

                const cards =
                    Array.from(
                        content.querySelectorAll(
                            '[data-news-card].is-hidden'
                        )
                    );


                /*
                 * Nombre d'articles à afficher.
                 *
                 * 2026/2027 = 3
                 * autres saisons = 4
                 */

                const loadCount =
                    parseInt(
                        button.getAttribute('data-load-count'),
                        10
                    ) || 4;


                /*
                 * Afficher le nombre demandé
                 */

                const cardsToShow =
                    cards.slice(0, loadCount);


                cardsToShow.forEach(function (card) {

                    card.classList.remove('is-hidden');

                });


                /*
                 * Vérifier s'il reste des articles cachés
                 */

                const remaining =
                    content.querySelectorAll(
                        '[data-news-card].is-hidden'
                    );


                /*
                 * Supprimer le bouton lorsqu'il
                 * n'y a plus d'articles
                 */

                if (remaining.length === 0) {

                    button.remove();

                }

            });

        });

});

</script>


<?php get_footer(); ?>
