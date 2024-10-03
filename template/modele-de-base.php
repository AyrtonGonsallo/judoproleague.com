<?php

/**
 * Template Name: Modèle de base
 */

get_header();

?>
    
 <?php

require_once (THEMEDIR.'inc/acf-blocs/bloc-video-en-live.php');

recuperer_video_live();

?>
   
<main id="primary" class="site-main home">

    <?php
   
    //require_once (THEMEDIR.'inc/acf-blocs/bloc-event.php');
   // $section=bloc_event();
    require_once (THEMEDIR.'inc/acf-blocs/bloc-rencontres.php'); 
    require_once (THEMEDIR.'inc/acf-blocs/bloc-playlist-videos.php');
    require_once (THEMEDIR.'inc/acf-blocs/bloc-classement.php');
    require_once (THEMEDIR.'inc/acf-blocs/bloc-sondage.php');
    require_once (THEMEDIR.'inc/acf-blocs/bloc-stat.php');
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
   
get_footer();