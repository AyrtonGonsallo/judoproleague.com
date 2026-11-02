<?php

/**
 * Template Name: Modèle equipe JPL
 */

get_header();

/* =========================================================
 * SAISON
 * ========================================================= */

$saison_value = isset($_GET['saison_value'])
    ? sanitize_text_field($_GET['saison_value'])
    : '2026-2027';


/* =========================================================
 * RÉCUPÉRER LES ÉQUIPES
 * ========================================================= */

$args = array(
    'post_type'      => 'equipes',
    'posts_per_page' => -1,
    'orderby'        => 'title',
    'order'          => 'ASC',
    'meta_query'     => array(
        array(
            'key'     => 'saisons',
            'compare' => 'LIKE',
            'value'   => $saison_value
        )
    )
);

$equipes_t = get_posts($args);

$count_t = count($equipes_t);

?>

<script>
jQuery(document).ready(function($) {

    $('#saison_value').on('change', function() {
        $('.season-selector-form').submit();
    });

});
</script>


<main id="primary" class="site-main jpl-liste-equipe">
    <section class="jpl-teams-page">
        <div class="jpl-teams-container">
            <!-- =====================================================
                 HEADER
                 ===================================================== -->
            <div class="jpl-teams-header">
                <div class="">
                    <span class="jpl-stats-eyebrow">
                        Judo Pro League
                    </span>
                    <h1 class="jpl-teams-title">Les équipes <?php echo esc_html($saison_value); ?></h1>
                    <p class="jpl-teams-description">
                        Retrouvez les équipes engagées dans la Judo Pro League
                        pour la saison <?php echo esc_html($saison_value); ?>.
                    </p>
                </div>
                <!-- =================================================
                     SELECT SAISON
                     ================================================= -->

                <div class="jpl-teams-season">

                    <form
                        method="GET"
                        action=""
                        class="season-selector-form"
                    >

                        <div class="jpl-season-select-wrap">

                            <select
                                name="saison_value"
                                id="saison_value"
                                class="season-selector-select"
                            >

                                <option
                                    value="2021-2022"
                                    <?php selected($saison_value, '2021-2022'); ?>
                                >
                                    2021-2022
                                </option>

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

<!--                             <i class="fa-solid fa-chevron-down"></i> -->

                        </div>

                    </form>

                </div>

            </div>


            <!-- =====================================================
                 NOMBRE D'ÉQUIPES
                 ===================================================== -->
<!--             <div class="jpl-teams-meta">
                <span>
                    <?php echo esc_html($count_t); ?>
                    équipes
                </span>
                <span class="jpl-teams-meta-line"></span>
                <span>
                    Saison <?php echo esc_html($saison_value); ?>
                </span>
            </div> -->
            <!-- =====================================================
                 GRILLE
                 ===================================================== -->

            <?php if ($equipes_t) : ?>

                <div class="jpl-teams-grid">

                    <?php
                    $numero = 1;

                    foreach ($equipes_t as $equipe) :

                        $url = get_permalink($equipe->ID);

                        $logo = get_field(
                            'logo_principal',
                            $equipe->ID
                        );

                        if (!$logo) {
                            $logo = get_the_post_thumbnail_url(
                                $equipe->ID,
                                'medium'
                            );
                        }

                        $title = get_the_title($equipe->ID);
                    ?>

                        <a
                            href="<?php echo esc_url($url); ?>"
                            class="jpl-team-card"
                        >

                            <!-- NUMÉRO -->

<!--                             <div class="jpl-team-number">
                                <?php echo sprintf('%02d', $numero); ?>
                            </div> -->


                            <!-- LOGO -->

                            <div class="jpl-team-logo">

                                <?php if ($logo) : ?>

                                    <img
                                        src="<?php echo esc_url($logo); ?>"
                                        alt="<?php echo esc_attr($title); ?>"
                                    >

                                <?php else : ?>

                                    <span class="jpl-team-no-logo">
                                        JPL
                                    </span>

                                <?php endif; ?>

                            </div>


                            <!-- NOM + FLÈCHE -->

                            <div class="jpl-team-bottom">

                                <h2 class="jpl-team-name">
                                    <?php echo esc_html($title); ?>
                                </h2>

                                <span class="jpl-team-arrow">
                                    <i class="fa-solid fa-arrow-right"></i>
                                </span>

                            </div>

                        </a>

                    <?php
                        $numero++;

                    endforeach;
                    ?>

                </div>

            <?php else : ?>

                <div class="jpl-teams-empty">

                    <i class="fa-solid fa-circle-info"></i>

                    <p>
                        Aucune équipe n'est disponible pour la saison
                        <?php echo esc_html($saison_value); ?>.
                    </p>

                </div>

            <?php endif; ?>


        </div>

    </section>

</main>


<?php get_footer(); ?>