<?php 
/**
 * Template Name: Modèle calendrier résultat 2024
 */

$current_fp = get_query_var('fpage');
 if (!$current_fp) {
        get_template_part( 'template-parts/content-classement-resultats-quarts');
    } else if ($current_fp == 'poules') {
        get_template_part( 'template-parts/content-classement-resultats-poules-2024' );
    } else if ($current_fp == 'quarts') {
        get_template_part( 'template-parts/content-classement-resultats-quarts' );
    } else if ($current_fp == 'final4') {
        get_template_part( 'template-parts/content-classement-resultats-final4' );
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