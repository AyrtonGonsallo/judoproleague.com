<?php
/**
 * Template part pour un article (details)
 *
 * @package pro-league
 */
?>

<div class="jpl-single-news">

    <!-- =====================================================
         NAVIGATION / FIL D'ARIANE
    ====================================================== -->
    <div class="jpl-single-news-navigation">

        <!-- Bouton retour -->
        <button
            type="button"
            class="jpl-news-back"
            onclick="if (document.referrer) { window.history.back(); } else { window.location.href='/actualites/'; }"
        >
            <img class="jpl-news-back-arrow" style="" src="/wp-content/uploads/2026/09/Vector-3.svg"/>
            <span>RETOUR</span>
        </button>

        <!-- Fil d'Ariane -->
        <nav class="jpl-breadcrumb" aria-label="Fil d’Ariane">

            <a href="/actualites/">
                Actualités
            </a>

            <span class="jpl-breadcrumb-separator">/</span>

            <?php
            $categories = get_the_category();

            if (!empty($categories)) :
                $category = $categories[0];
            ?>

                <a href="<?php echo esc_url(get_category_link($category->term_id)); ?>">
                    <?php echo esc_html($category->name); ?>
                </a>

                <span class="jpl-breadcrumb-separator">></span>

            <?php endif; ?>

            <span class="jpl-breadcrumb-current">
                <?php the_title(); ?>
            </span>

        </nav>

    </div>


    <!-- =====================================================
         ARTICLE
    ====================================================== -->

    <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

        <div
            class="thumb-article article-respo"
            style="height:auto !important;"
        >

            <?php if (has_post_thumbnail()) : ?>

                <img
                    src="<?php echo esc_url(get_the_post_thumbnail_url()); ?>"
                    alt="<?php echo esc_attr(get_the_title()); ?>"
                >

            <?php endif; ?>

        </div>


        <div class="content-article">

            <header class="entry-header news-content">

                <?php

                if (is_singular()) :

                    the_title(
                        '<h1 class="entry-title">',
                        '</h1>'
                    );

                else :

                    the_title(
                        '<h3 class="title-news-singular"><a href="' .
                        esc_url(get_permalink()) .
                        '" rel="bookmark">',
                        '</a></h3>'
                    );

                endif;

                ?>


                <?php if ('post' === get_post_type()) : ?>

                    <div class="entry-meta">

                        <?php
                        // pro_league_posted_on();
                        // pro_league_posted_by();
                        ?>

                    </div>

                <?php endif; ?>

            </header>


            <div class="entry-content">

                <?php

                $post_type = get_the_title(
                    get_option('page_for_posts', true)
                );


                if (
                    $post_type == "Actualités"
                    && !is_singular()
                ) :

                    $excerpt = get_the_excerpt();

                    echo wp_trim_words(
                        $excerpt,
                        22,
                        ' [...]'
                    );


                elseif (is_singular()) :

                    the_content(
                        sprintf(
                            wp_kses(
                                __(
                                    'Continue reading<span class="screen-reader-text"> "%s"</span>',
                                    'pro-league'
                                ),
                                array(
                                    'span' => array(
                                        'class' => array(),
                                    ),
                                )
                            ),
                            wp_kses_post(get_the_title())
                        )
                    );

                endif;

                ?>

            </div>

        </div>

    </article>

</div>