<?php

function display_rencontre_journee_poule($rencontres_j2_pouleB, $poule) {
?>

<?php if ($rencontres_j2_pouleB): ?>

    <div class="judo_pro_league">

        <div class="crt-title-row">

            <h2 class="crt-title">
                Poule <?php echo esc_html($poule); ?>
            </h2>

            <a
                href="/classement-judo-pro-league-2023/phase-eliminatoire/poule-<?php echo esc_attr($poule); ?>/"
                class="more-classement"
            >
                Classement Poule <?php echo esc_html($poule); ?>
                <i class="fa-solid fa-arrow-right-long"></i>
            </a>

        </div>


        <?php $count = count($rencontres_j2_pouleB); ?>

        <div
            class="cal-res-poule"
            <?php if ($count == 1): ?>
                style="grid-template-columns:repeat(1,1fr)!important;max-width:450px;margin:0 auto;"
            <?php endif; ?>
        >

        <?php foreach ($rencontres_j2_pouleB as $rencontre):

            $combat = get_field('les_combat', $rencontre->ID)[0];

            $lieu = get_field('lieu_rencontre', $rencontre->ID);

            $equipe1 = get_field('equipe_1', $rencontre->ID)[0];
            $equipe2 = get_field('equipe_2', $rencontre->ID)[0];

            $rencontre_permalink = get_the_permalink($rencontre->ID);

            $score_equipe1 = !empty($combat['nombre_de_combat_gagne_equipe_1'][0])
                ? $combat['nombre_de_combat_gagne_equipe_1'][0]
                : '';

            $score_equipe2 = !empty($combat['nombre_de_combat_gagne_equipe_2'][0])
                ? $combat['nombre_de_combat_gagne_equipe_2'][0]
                : '';

            $image1_url = get_field('logo_principal', $equipe1->ID)
                ? get_field('logo_miniature', $equipe1->ID)
                : get_the_post_thumbnail_url($equipe1->ID);

            $image2_url = get_field('logo_principal', $equipe2->ID)
                ? get_field('logo_miniature', $equipe2->ID)
                : get_the_post_thumbnail_url($equipe2->ID);

            $date_debut = get_field(
                'date_de_debut',
                $rencontre->ID,
                false,
                false
            );

            $statut_field = get_field('statut', $rencontre->ID);

            $statut = !empty($statut_field['label'])
                ? $statut_field['label']
                : 'à venir';


            /*
             * =====================================================
             * STATUT
             * =====================================================
             */

            $equipe_gagnante = 'inconnue';

            if ($statut == 'en cours') {

                $class_status = 'encours';

                $equipe_gagnante = 'inconnue';

            } elseif ($statut == 'terminé') {

                $class_status = 'terminer';

                $equipe_gagnante = ($combat && !empty($combat['equipe_gagnante']))
                    ? $combat['equipe_gagnante']
                    : 'inconnue';

            } else {

                $class_status = 'avenir';

                $equipe_gagnante = 'inconnue';

            }


            /*
             * =====================================================
             * ACTIONS
             * =====================================================
             */

            $reservation = get_field(
                'lien_de_reservation',
                $rencontre->ID
            );

            $video_live = get_field(
                'video_live',
                $rencontre->ID
            );

        ?>

            <article class="cal-res-poule-blc">

                <!-- =========================================
                     HEADER
                ========================================== -->

<div class="header-cal-res-poule">

    <span class="cal-res-poule-title">
        <i class="fa-solid fa-location-dot"></i>
        <?php echo esc_html($lieu); ?>
    </span>

    <div class="cal-res-actions">

        <?php if ($statut == 'à venir' && $reservation): ?>

            <a
                href="<?php echo esc_url($reservation); ?>"
                target="_blank"
                rel="noopener"
                class="cal-res-poule-link cal-res-action-ticket"
                title="Billetterie"
                aria-label="Billetterie"
            >
                <i class="fa-solid fa-ticket"></i>
            </a>

        <?php endif; ?>


        <?php if ($statut == 'en cours' && $video_live): ?>

            <a
                href="<?php echo esc_url($video_live); ?>"
                target="_blank"
                rel="noopener"
                class="cal-res-poule-link cal-res-action-live"
                title="Live"
                aria-label="Live"
            >
                <i class="fa-solid fa-play"></i>
            </a>

        <?php endif; ?>


        <a
            href="<?php echo esc_url($rencontre_permalink); ?>"
            class="cal-res-poule-link cal-res-action-details"
            title="Détails"
            aria-label="Détails"
        >
            <i class="fa-solid fa-circle-info"></i>
        </a>

    </div>

</div>


                <!-- =========================================
                     MATCH
                ========================================== -->

                <div class="horaire-jr">

                    <div>

                        <!-- ÉQUIPE 1 -->

                        <div class="cal-res-poule-team <?php
                            if ($equipe_gagnante == 'équipe 2') {
                                echo 'beaten';
                            }
                        ?>">

                            <?php if ($image1_url): ?>

                                <img
                                    src="<?php echo esc_url($image1_url); ?>"
                                    alt="<?php echo esc_attr($equipe1->post_title); ?>"
                                >

                            <?php endif; ?>

                            <h3 class="cal-res-poule-eqp">
                                <?php echo esc_html($equipe1->post_title); ?>
                            </h3>

                            <span class="cal-res-poule-rs">
                                <?php echo esc_html($score_equipe1); ?>
                            </span>

                        </div>


                        <!-- ÉQUIPE 2 -->

                        <div class="cal-res-poule-team <?php
                            if ($equipe_gagnante == 'équipe 1') {
                                echo 'beaten';
                            }
                        ?> brd-none">

                            <?php if ($image2_url): ?>

                                <img
                                    src="<?php echo esc_url($image2_url); ?>"
                                    alt="<?php echo esc_attr($equipe2->post_title); ?>"
                                >

                            <?php endif; ?>

                            <h3 class="cal-res-poule-eqp">
                                <?php echo esc_html($equipe2->post_title); ?>
                            </h3>

                            <span class="cal-res-poule-rs">
                                <?php echo esc_html($score_equipe2); ?>
                            </span>

                        </div>

                    </div>


                    <!-- DATE / HEURE -->

                    <?php if ($statut != 'terminé' && !empty($date_debut)): ?>

                        <div class="cal-res-match-date">

                            <span class="cal-res-poule-title">

                                <?php
                                echo esc_html(
                                    substr($date_debut, 8, 2)
                                    . '/'
                                    . substr($date_debut, 5, 2)
                                );
                                ?>

                            </span>

                            <span class="cal-res-poule-title">

                                <?php
                                echo esc_html(
                                    substr($date_debut, 11, 2)
                                    . 'h'
                                    . substr($date_debut, 14, 2)
                                );
                                ?>

                            </span>

                        </div>

                    <?php endif; ?>

                </div>

            </article>

        <?php endforeach; ?>

        </div>

    </div>

<?php endif; ?>

<?php
}
?>