<?php


/**


 * Template part for displaying posts


 *


 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/


 *


 * @package pro-league


 */


$current_fp = get_query_var('fpage');

 if (!$current_fp) {
        get_template_part( 'template-parts/content-equipes-infos', get_post_type() );
    } else if ($current_fp == 'infos') {
        get_template_part( 'template-parts/content-equipes-infos', get_post_type() );
    } else if ($current_fp == 'photos') {
        get_template_part( 'template-parts/content-equipes-photos', get_post_type() );
    } else if ($current_fp == 'videos') {
        get_template_part( 'template-parts/content-equipes-videos', get_post_type() );
    }
else if ($current_fp == 'actus') {
        get_template_part( 'template-parts/content-equipes-actus', get_post_type() );
    }
else if ($current_fp == 'calendrier_resultats') {
        get_template_part( 'template-parts/content-equipes-calendrier-resultats', get_post_type() );
    }
else if ($current_fp == 'judokas') {
        get_template_part( 'template-parts/content-equipes-judokas', get_post_type() );
    }; 

?>




