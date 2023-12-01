<?php

/**
 * Template Name: Modèle de base
 */

get_header();

?>


   
<main id="primary" class="site-main home">
   
    <?php
    while ( have_rows('articles'))
    {
        the_row();
        $style=get_row_layout();
        //site_debug("style=$style");
        $section=false;
        switch($style)
        {

            case 'article_a_la_une':
            require_once (THEMEDIR.'inc/acf-blocs/bloc-une.php');
            $section=bloc_une();
            break;
    
            case 'articles':
            require_once (THEMEDIR.'inc/acf-blocs/bloc-articles.php');
            $section=bloc_articles();
            break;

            case 'evenement':
            require_once (THEMEDIR.'inc/acf-blocs/bloc-event.php');
            $section=bloc_event();
            break;

            case 'bloc_des_articles':
            require_once (THEMEDIR.'inc/acf-blocs/bloc-articles-nv.php');
            $section=bloc_articles_nv();
            break;

            case 'reservations':
            require_once (THEMEDIR.'inc/acf-blocs/bloc-reservation-billets.php');
            $section=bloc_reservation();
            break;

           case 'bloc_presentation':
			require_once (THEMEDIR.'inc/acf-blocs/bloc-playlist-videos.php');
            require_once (THEMEDIR.'inc/acf-blocs/bloc-presentation.php');
            $section=bloc_presentation();
			
            break;
    
            case 'liste_des_equipes':
            require_once (THEMEDIR.'inc/acf-blocs/bloc-equipe.php');
            $section=bloc_equipe();
            break;
        }
    }
    
   
get_footer();