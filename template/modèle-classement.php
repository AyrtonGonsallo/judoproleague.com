<?php



/**

 * Template Name: Modèle classement

 */

$current_fp = get_query_var('fpage');
 if (!$current_fp) {
        get_template_part( 'template-parts/content-classement-poule-A');
    } else if ($current_fp == 'poule-A') {
        get_template_part( 'template-parts/content-classement-poule-A' );
    } else if ($current_fp == 'poule-B') {
        get_template_part( 'template-parts/content-classement-poule-B' );
    } else if ($current_fp == 'poule-C') {
        get_template_part( 'template-parts/content-classement-poule-C' );
    } else if ($current_fp == 'poule-D') {
        get_template_part( 'template-parts/content-classement-poule-D' );
    }

/*

phases      |     ID

poule A         488
Poule B         426
poule C         555
poule D         600
quart 1         1667
quart 2         1668
quart 3         1669
quart 4         1670
final 4         1307

 */
?>