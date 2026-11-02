<?php
function bloc_presentation() {
    $title        = get_sub_field('titre_bloc');
    $presentation = get_sub_field('description_presentation');
    $lien         = get_sub_field('lien_page_datterrissage'); // Peut être un tableau ou une URL

    // Gestion propre de l'URL du lien (si c'est un tableau de type "Lien" dans ACF)
    $url_lien = is_array($lien) && isset($lien['url']) ? $lien['url'] : $lien;
    if (empty($url_lien)) {
        $url_lien = '/apropos/'; // Valeur par défaut si vide
    }
    ?>

    <section class="section-presentation jpl-section" style="background-image: url(/wp-content/uploads/2026/09/image-presentation1-desktop.webp); background-size: cover; background-repeat: no-repeat; background-position: 86%;">
		<div>
<!-- 			<img src="/wp-content/uploads/2026/09/image-presentation.webp" /> -->
		</div>
        <div class="presentation">
            <?php if ($title): ?>
                <h2 class="h2-presentation"><?php echo esc_html($title); ?></h2>
            <?php endif; ?>

            <?php if ($presentation): ?>
                <div class="presentation-content">
                    <?php echo wp_kses_post($presentation); ?>
                </div>
            <?php endif; ?>

            <div class="flx-btn jpl-section-heading">
                <a href="<?php echo esc_url($url_lien); ?>">
                    EN SAVOIR PLUS
                    <img src="/wp-content/uploads/2026/09/arrow-btn.svg" alt="Flèche"/>
                </a>
            </div>
        </div>
    </section>

    <?php
}