<?php

/**
 * Template Name: Modèle module de pari (login)
 */

// À placer dans ton template de page, ou via un plugin / code snippet
if ( ! is_user_logged_in() || ! current_user_can('joueur_jpl') ) {
    wp_redirect( site_url('/judopronoschallenge/') );
    exit;
}


get_header();

?>

<main id="primary" class="site-main ">
    <section class="listes-equipes page-calendrier">
        <?php echo do_shortcode("[jpl_login_or_register]");?>
    
 
    </section>

    <?php
get_footer();
?>