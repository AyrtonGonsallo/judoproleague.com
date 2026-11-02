<?php

/**
 * Template Name: Modèle stats Judokas
 */

get_header();


/* =========================================================
 * PARAMÈTRES
 * ========================================================= */

$saison_value = isset($_GET['saison_value'])
    ? sanitize_text_field(wp_unslash($_GET['saison_value']))
    : '2026-2027';

$equipe_value = isset($_GET['equipe_value'])
    ? sanitize_text_field(wp_unslash($_GET['equipe_value']))
    : '0';

$categorie_value = isset($_GET['categorie_value'])
    ? sanitize_text_field(wp_unslash($_GET['categorie_value']))
    : '0';


/* =========================================================
 * ÉQUIPES
 * ========================================================= */

$args_teams = array(
    'post_type'      => 'equipes',
    'posts_per_page' => -1,
    'orderby'        => 'title',
    'order'          => 'ASC',
);

$equipes = get_posts($args_teams);


/* =========================================================
 * CORRECTION CATÉGORIES
 * ========================================================= */

function get_correct_categorie($saison_value, $cat)
{
    if ($saison_value === '2024-2025') {

        switch ($cat) {

            case '-65':
                return '-66';

            case '-75':
                return '-73';

            case '-85':
                return '-81';

            case '-95':
                return '-90';

            case '+95':
                return '+90';

            default:
                return $cat;
        }
    }

    return $cat;
}

?>


<main
    id="primary"
    class="site-main jpl-stats-page page-stats-judokas"
>


    <!-- =====================================================
         HEADER
    ====================================================== -->

    <section class="jpl-stats-hero jpl-teams-header">

        <div class="jpl-stats-hero-content">

            <span class="jpl-stats-eyebrow">
                JUDO PRO LEAGUE
            </span>

            <h1>
                Statistiques judokas <strong><?php echo esc_html($saison_value); ?></strong>
            </h1>
        </div>

    </section>

    <!-- =====================================================
         DONNÉES
    ====================================================== -->
    <?php

    require_once(
        THEMEDIR . 'template-parts/content-judokas-requests-stats.php'
    );

    $classement_total = get_classement($saison_value);

    ?>


    <?php if (!empty($classement_total['total'])) : ?>

        <?php $datas = $classement_total['total']; ?>


        <!-- =================================================
             FILTRES
        ================================================== -->

        <section class="jpl-stats-card jpl-judokas-card">


            <div class="jpl-stats-card-header">
    <!-- =====================================================
         TABS
    ====================================================== -->
    <div class="jpl-stats-tabs">
        <a
            href="<?php echo esc_url(
                home_url('/statistiques-equipes-judo-pro-league/')
            ); ?>"
            class="jpl-stats-tab"
        >
            <span>Équipes</span>
        </a>
        <a
            href="<?php echo esc_url(
                home_url('/statistiques-judokas-judo-pro-league/')
            ); ?>"
            class="jpl-stats-tab active"
        >
            <span>Judokas</span>
        </a>
    </div>
                <div>

<!--                     <span class="jpl-card-eyebrow">
                        CLASSEMENT STATISTIQUE
                    </span>

                    <h2>
                        Performances des judokas
						<span class="jpl-season-badge">
                    <?php echo esc_html($saison_value); ?>
                </span>
                    </h2> -->
					
					
        <!-- SAISON -->

                <div class="season-selector-select">
            <form
                method="GET"
                action=""
                class="season-selector-form"
            >
                <div class="jpl-select-wrapper">
                    <select
                        name="saison_value"
                        id="saison_value"
                        class="jpl-season-select"
                    >
                        <?php
                        $saisons = array(
                            '2021-2022',
                            '2022-2023',
                            '2023-2024',
                            '2024-2025',
                            '2025-2026',
                            '2026-2027',
                        );
                        foreach ($saisons as $saison) :
                        ?>
                            <option
                                value="<?php echo esc_attr($saison); ?>"
                                <?php selected($saison_value, $saison); ?>
                            >
                                <?php echo esc_html($saison); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                        <svg class="jpl-select-arrow" fill='black' height='16' viewBox='0 0 24 24' width='16' xmlns='http://www.w3.org/2000/svg'><path d='M7 10l5 5 5-5z'/></svg>
                </div>
            </form>
        </div>

                </div>


            </div>


            <div class="jpl-judokas-filters">


                <!-- TYPE -->

                <div class="jpl-filter-group">

                    <label for="categorie">
                        PROFIL
                    </label>

                    <div class="jpl-filter-select">

                        <select id="categorie">

                            <option value="-all-">
                                Tous les judokas
                            </option>

                            <option value="-h-">
                                Masculins
                            </option>

                            <option value="-f-">
                                Féminines
                            </option>

                            <option value="-hu23-">
                                Masculins U23
                            </option>

                            <option value="-fu23-">
                                Féminines U23
                            </option>

                        </select>

                    </div>

                </div>


                <!-- CATÉGORIE -->
                <div class="jpl-filter-group">
                    <label for="categorie_value">
                        CATÉGORIE
                    </label>
                    <div class="jpl-filter-select">

                        <select
                            name="categorie_value"
                            id="categorie_value"
                        >
                            <option value="0"
                                <?php selected($categorie_value, '0'); ?>
                            >
                                Toutes les catégories
                            </option>
                            <option value="-52"
                                <?php selected($categorie_value, '-52'); ?>
                            >
                                -52
                            </option>
                            <option value="-57"
                                <?php selected($categorie_value, '-57'); ?>
                            >
                                -57
                            </option>
                            <option value="-63"
                                <?php selected($categorie_value, '-63'); ?>
                            >
                                -63
                            </option>
                            <option value="-70"
                                <?php selected($categorie_value, '-70'); ?>
                            >
                                -70
                            </option>
                            <option value="+70"
                                <?php selected($categorie_value, '+70'); ?>
                            >
                                +70
                            </option>
                            <option value="-75"
                                <?php selected($categorie_value, '-75'); ?>
                            >
                                -75
                            </option>
                            <option value="-85"
                                <?php selected($categorie_value, '-85'); ?>
                            >
                                -85
                            </option>
                            <option value="-95"
                                <?php selected($categorie_value, '-95'); ?>
                            >
                                -95
                            </option>
                            <option value="+95"
                                <?php selected($categorie_value, '+95'); ?>
                            >
                                +95
                            </option>
                            <option value="-66"
                                <?php selected($categorie_value, '-66'); ?>
                            >
                                -66
                            </option>

                            <option value="-73"
                                <?php selected($categorie_value, '-73'); ?>
                            >
                                -73
                            </option>
                            <option value="-81"
                                <?php selected($categorie_value, '-81'); ?>
                            >
                                -81
                            </option>
                            <option value="-90"
                                <?php selected($categorie_value, '-90'); ?>
                            >
                                -90
                            </option>

                            <option value="+90"
                                <?php selected($categorie_value, '+90'); ?>
                            >
                                +90
                            </option>
                        </select>
                    </div>
                </div>
                <!-- ÉQUIPE -->

                <div class="jpl-filter-group">

                    <label for="equipe_value">
                        ÉQUIPE
                    </label>

                    <div class="jpl-filter-select">

                        <select
                            name="equipe_value"
                            id="equipe_value"
                        >

                            <option value="0">
                                Toutes les équipes
                            </option>

                            <?php foreach ($equipes as $equipe) : ?>

                                <?php
                                $title = get_the_title($equipe->ID);
                                ?>

                                <option
                                    value="<?php echo esc_attr($title); ?>"
                                    <?php selected($equipe_value, $title); ?>
                                >
                                    <?php echo esc_html($title); ?>
                                </option>

                            <?php endforeach; ?>

                        </select>

                    </div>

                </div>

            </div>


            <!-- =================================================
                 TABLEAUX
            ================================================== -->

            <div class="jpl-table-scroll">


                <!-- =============================================
                     TOUS
                ============================================== -->

                <table
                    id="tableauAll"
                    class="jpl-stats-table jpl-judoka-table"
                >

                    <thead>
                        <tr>
                            <th class="jpl-player-column">NOM  </th>
                            <th>AGE
							</th>
                            <th>CAT.</th>
                            <th>V</th>
                            <th>N</th>
                            <th>D</th>
                            <th>
								<span class="desktop-label">IPPON</span>
								<span class="mobile-label" style="text-align:center;">I</span>
								
							</th>
                            <th>
								<span class="desktop-label">WAZA-ARI</span>
								<span class="mobile-label" style="text-align:center;">W</span>
							</th>
                            <th>
								<span class="desktop-label">KINZA</span>
								<span class="mobile-label" style="text-align:center;">K</span>
							</th>
                            <th>PTS</th>
                        </tr>

                    </thead>

                    <tbody>

                        <?php foreach ($datas as $d) : ?>

                            <?php $player = $d[0]; ?>

                            <tr class="jpl-stat-row">

                                <td class="jpl-player-cell">

                                    <a
                                        href="<?php echo esc_url(
                                            get_permalink($player['judoka_id'])
                                        ); ?>"
                                        class="jpl-player-link"
                                    >

                                        <div class="jpl-player-avatar">

                                            <?php if (!empty($player['image'])) : ?>

                                                <img
                                                    src="<?php echo esc_url(
                                                        $player['image']
                                                    ); ?>"
                                                    alt="<?php echo esc_attr(
                                                        $player['nom']
                                                    ); ?>"
                                                >

                                            <?php else : ?>

                                                <span>
                                                    <?php
                                                    echo esc_html(
                                                        mb_substr(
                                                            $player['nom'],
                                                            0,
                                                            1
                                                        )
                                                    );
                                                    ?>
                                                </span>

                                            <?php endif; ?>

                                        </div>

                                        <span>
                                            <?php echo esc_html(
                                                $player['nom']
                                            ); ?>
                                        </span>

                                    </a>

                                </td>

                                <td>
                                    <?php echo !empty($player['age'])
                                        ? esc_html($player['age'])
                                        : 0; ?>
                                </td>

                                <td>
                                    <?php
                                    echo !empty(
                                        $player['categorie_de_poids']
                                    )
                                        ? esc_html(
                                            get_correct_categorie(
                                                $saison_value,
                                                $player['categorie_de_poids']
                                            )
                                        )
                                        : 0;
                                    ?>
                                </td>

                                <td>
                                    <?php echo !empty($player['matchs_v'])
                                        ? esc_html($player['matchs_v'])
                                        : 0; ?>
                                </td>

                                <td>
                                    <?php echo !empty($player['matchs_nuls'])
                                        ? esc_html($player['matchs_nuls'])
                                        : 0; ?>
                                </td>

                                <td>
                                    <?php echo !empty($player['matchs_d'])
                                        ? esc_html($player['matchs_d'])
                                        : 0; ?>
                                </td>

                                <td>
                                    <?php echo !empty($player['ippons_marqués'])
                                        ? esc_html($player['ippons_marqués'])
                                        : 0; ?>
                                </td>

                                <td>
                                    <?php echo !empty($player['wazaris_marqués'])
                                        ? esc_html($player['wazaris_marqués'])
                                        : 0; ?>
                                </td>

                                <td>
                                    <?php echo !empty($player['kinza'])
                                        ? esc_html($player['kinza'])
                                        : 0; ?>
                                </td>

                                <td>
                                    <span class="jpl-points">
                                        <?php echo !empty($player['points_judoka'])
                                            ? esc_html($player['points_judoka'])
                                            : 0; ?>
                                    </span>
                                </td>

                            </tr>

                        <?php endforeach; ?>

                    </tbody>

                </table>


                <!-- =================================================
                     HOMMES
                ================================================== -->

                <table
                    id="tableauHommes"
                    class="jpl-stats-table jpl-judoka-table"
                >

                    <thead>
                        <tr>
                            <th class="jpl-player-column">NOM  </th>
                            <th>AGE
							</th>
                            <th>CAT.</th>
                            <th>V</th>
                            <th>N</th>
                            <th>D</th>
                            <th>
								<span class="desktop-label">IPPON</span>
								<span class="mobile-label" style="text-align:center;">I</span>
								
							</th>
                            <th>
								<span class="desktop-label">WAZA-ARI</span>
								<span class="mobile-label" style="text-align:center;">W</span>
							</th>
                            <th>
								<span class="desktop-label">KINZA</span>
								<span class="mobile-label" style="text-align:center;">K</span>
							</th>
                            <th>PTS</th>
                        </tr>
                    </thead>

                    <tbody>

                        <?php foreach ($datas as $d) : ?>

                            <?php
                            $player = $d[0];

                            if ($player['sexe'] !== 'masculin') {
                                continue;
                            }
                            ?>

                            <tr class="jpl-stat-row">

                                <td class="jpl-player-cell">

                                    <a
                                        href="<?php echo esc_url(
                                            get_permalink($player['judoka_id'])
                                        ); ?>"
                                        class="jpl-player-link"
                                    >

                                        <div class="jpl-player-avatar">

                                            <?php if (!empty($player['image'])) : ?>

                                                <img
                                                    src="<?php echo esc_url(
                                                        $player['image']
                                                    ); ?>"
                                                    alt=""
                                                >

                                            <?php endif; ?>

                                        </div>

                                        <span>
                                            <?php echo esc_html(
                                                $player['nom']
                                            ); ?>
                                        </span>

                                    </a>

                                </td>

                                <td><?php echo !empty($player['age']) ? esc_html($player['age']) : 0; ?></td>

                                <td>
                                    <?php
                                    echo !empty($player['categorie_de_poids'])
                                        ? esc_html(
                                            get_correct_categorie(
                                                $saison_value,
                                                $player['categorie_de_poids']
                                            )
                                        )
                                        : 0;
                                    ?>
                                </td>

                                <td><?php echo !empty($player['matchs_v']) ? esc_html($player['matchs_v']) : 0; ?></td>
                                <td><?php echo !empty($player['matchs_nuls']) ? esc_html($player['matchs_nuls']) : 0; ?></td>
                                <td><?php echo !empty($player['matchs_d']) ? esc_html($player['matchs_d']) : 0; ?></td>
                                <td><?php echo !empty($player['ippons_marqués']) ? esc_html($player['ippons_marqués']) : 0; ?></td>
                                <td><?php echo !empty($player['wazaris_marqués']) ? esc_html($player['wazaris_marqués']) : 0; ?></td>
                                <td><?php echo !empty($player['kinza']) ? esc_html($player['kinza']) : 0; ?></td>

                                <td>
                                    <span class="jpl-points">
                                        <?php echo !empty($player['points_judoka']) ? esc_html($player['points_judoka']) : 0; ?>
                                    </span>
                                </td>

                            </tr>

                        <?php endforeach; ?>

                    </tbody>

                </table>


                <!-- =================================================
                     FEMMES
                ================================================== -->

                <table
                    id="tableauFemmes"
                    class="jpl-stats-table jpl-judoka-table"
                >

                    <thead>
                        <tr>
                            <th class="jpl-player-column">NOM  </th>
                            <th>AGE
							</th>
                            <th>CAT.</th>
                            <th>V</th>
                            <th>N</th>
                            <th>D</th>
                            <th>
								<span class="desktop-label">IPPON</span>
								<span class="mobile-label" style="text-align:center;">I</span>
								
							</th>
                            <th>
								<span class="desktop-label">WAZA-ARI</span>
								<span class="mobile-label" style="text-align:center;">W</span>
							</th>
                            <th>
								<span class="desktop-label">KINZA</span>
								<span class="mobile-label" style="text-align:center;">K</span>
							</th>
                            <th>PTS</th>
                        </tr>
                    </thead>

                    <tbody>

                        <?php foreach ($datas as $d) : ?>

                            <?php
                            $player = $d[0];

                            if ($player['sexe'] !== 'féminin') {
                                continue;
                            }
                            ?>

                            <tr class="jpl-stat-row">

                                <td class="jpl-player-cell">

                                    <a
                                        href="<?php echo esc_url(
                                            get_permalink($player['judoka_id'])
                                        ); ?>"
                                        class="jpl-player-link"
                                    >

                                        <div class="jpl-player-avatar">

                                            <?php if (!empty($player['image'])) : ?>

                                                <img
                                                    src="<?php echo esc_url(
                                                        $player['image']
                                                    ); ?>"
                                                    alt=""
                                                >

                                            <?php endif; ?>

                                        </div>

                                        <span>
                                            <?php echo esc_html($player['nom']); ?>
                                        </span>

                                    </a>

                                </td>

                                <td><?php echo !empty($player['age']) ? esc_html($player['age']) : 0; ?></td>

                                <td>
                                    <?php
                                    echo !empty($player['categorie_de_poids'])
                                        ? esc_html(
                                            get_correct_categorie(
                                                $saison_value,
                                                $player['categorie_de_poids']
                                            )
                                        )
                                        : 0;
                                    ?>
                                </td>

                                <td><?php echo !empty($player['matchs_v']) ? esc_html($player['matchs_v']) : 0; ?></td>
                                <td><?php echo !empty($player['matchs_nuls']) ? esc_html($player['matchs_nuls']) : 0; ?></td>
                                <td><?php echo !empty($player['matchs_d']) ? esc_html($player['matchs_d']) : 0; ?></td>
                                <td><?php echo !empty($player['ippons_marqués']) ? esc_html($player['ippons_marqués']) : 0; ?></td>
                                <td><?php echo !empty($player['wazaris_marqués']) ? esc_html($player['wazaris_marqués']) : 0; ?></td>
                                <td><?php echo !empty($player['kinza']) ? esc_html($player['kinza']) : 0; ?></td>

                                <td>
                                    <span class="jpl-points">
                                        <?php echo !empty($player['points_judoka']) ? esc_html($player['points_judoka']) : 0; ?>
                                    </span>
                                </td>

                            </tr>

                        <?php endforeach; ?>

                    </tbody>

                </table>


                <!-- =================================================
                     HOMMES U23
                ================================================== -->

                <table
                    id="tableauHommesU23"
                    class="jpl-stats-table jpl-judoka-table"
                >

                    <thead>
                        <tr>
                            <th class="jpl-player-column">NOM  </th>
                            <th>AGE
							</th>
                            <th>CAT.</th>
                            <th>V</th>
                            <th>N</th>
                            <th>D</th>
                            <th>
								<span class="desktop-label">IPPON</span>
								<span class="mobile-label" style="text-align:center;">I</span>
								
							</th>
                            <th>
								<span class="desktop-label">WAZA-ARI</span>
								<span class="mobile-label" style="text-align:center;">W</span>
							</th>
                            <th>
								<span class="desktop-label">KINZA</span>
								<span class="mobile-label" style="text-align:center;">K</span>
							</th>
                            <th>PTS</th>
                        </tr>
                    </thead>

                    <tbody>

                        <?php foreach ($datas as $d) : ?>

                            <?php
                            $player = $d[0];

                            if (
                                $player['sexe'] !== 'masculin' ||
                                (int) $player['age'] > 23
                            ) {
                                continue;
                            }
                            ?>

                            <tr class="jpl-stat-row">

                                <td class="jpl-player-cell">

                                    <a
                                        href="<?php echo esc_url(
                                            get_permalink($player['judoka_id'])
                                        ); ?>"
                                        class="jpl-player-link"
                                    >

                                        <div class="jpl-player-avatar">

                                            <?php if (!empty($player['image'])) : ?>

                                                <img
                                                    src="<?php echo esc_url(
                                                        $player['image']
                                                    ); ?>"
                                                    alt=""
                                                >

                                            <?php endif; ?>

                                        </div>

                                        <span>
                                            <?php echo esc_html($player['nom']); ?>
                                        </span>

                                    </a>

                                </td>

                                <td><?php echo !empty($player['age']) ? esc_html($player['age']) : 0; ?></td>

                                <td>
                                    <?php
                                    echo !empty($player['categorie_de_poids'])
                                        ? esc_html(
                                            get_correct_categorie(
                                                $saison_value,
                                                $player['categorie_de_poids']
                                            )
                                        )
                                        : 0;
                                    ?>
                                </td>

                                <td><?php echo !empty($player['matchs_v']) ? esc_html($player['matchs_v']) : 0; ?></td>
                                <td><?php echo !empty($player['matchs_nuls']) ? esc_html($player['matchs_nuls']) : 0; ?></td>
                                <td><?php echo !empty($player['matchs_d']) ? esc_html($player['matchs_d']) : 0; ?></td>
                                <td><?php echo !empty($player['ippons_marqués']) ? esc_html($player['ippons_marqués']) : 0; ?></td>
                                <td><?php echo !empty($player['wazaris_marqués']) ? esc_html($player['wazaris_marqués']) : 0; ?></td>
                                <td><?php echo !empty($player['kinza']) ? esc_html($player['kinza']) : 0; ?></td>

                                <td>
                                    <span class="jpl-points">
                                        <?php echo !empty($player['points_judoka']) ? esc_html($player['points_judoka']) : 0; ?>
                                    </span>
                                </td>

                            </tr>

                        <?php endforeach; ?>

                    </tbody>

                </table>


                <!-- =================================================
                     FEMMES U23
                ================================================== -->

                <table
                    id="tableauFemmesU23"
                    class="jpl-stats-table jpl-judoka-table"
                >

                    <thead>
                        <tr>
                            <th class="jpl-player-column">NOM  </th>
                            <th>AGE</th>
                            <th>CAT.</th>
                            <th>V</th>
                            <th>N</th>
                            <th>D</th>
                            <th>
								<span class="desktop-label">IPPON</span>
								<span class="mobile-label" style="text-align:center;">I</span>
								
							</th>
                            <th>
								<span class="desktop-label">WAZA-ARI</span>
								<span class="mobile-label" style="text-align:center;">W</span>
							</th>
                            <th>
								<span class="desktop-label">KINZA</span>
								<span class="mobile-label" style="text-align:center;">K</span>
							</th>
                            <th>PTS</th>
                          </tr>
                    </thead>

                    <tbody>

                        <?php foreach ($datas as $d) : ?>

                            <?php
                            $player = $d[0];

                            if (
                                $player['sexe'] !== 'féminin' ||
                                (int) $player['age'] > 23
                            ) {
                                continue;
                            }
                            ?>

                            <tr class="jpl-stat-row">

                                <td class="jpl-player-cell">

                                    <a
                                        href="<?php echo esc_url(
                                            get_permalink($player['judoka_id'])
                                        ); ?>"
                                        class="jpl-player-link"
                                    >

                                        <div class="jpl-player-avatar">

                                            <?php if (!empty($player['image'])) : ?>

                                                <img
                                                    src="<?php echo esc_url(
                                                        $player['image']
                                                    ); ?>"
                                                    alt=""
                                                >

                                            <?php endif; ?>

                                        </div>

                                        <span>
                                            <?php echo esc_html($player['nom']); ?>
                                        </span>

                                    </a>

                                </td>

                                <td><?php echo !empty($player['age']) ? esc_html($player['age']) : 0; ?></td>

                                <td>
                                    <?php
                                    echo !empty($player['categorie_de_poids'])
                                        ? esc_html(
                                            get_correct_categorie(
                                                $saison_value,
                                                $player['categorie_de_poids']
                                            )
                                        )
                                        : 0;
                                    ?>
                                </td>

                                <td><?php echo !empty($player['matchs_v']) ? esc_html($player['matchs_v']) : 0; ?></td>
                                <td><?php echo !empty($player['matchs_nuls']) ? esc_html($player['matchs_nuls']) : 0; ?></td>
                                <td><?php echo !empty($player['matchs_d']) ? esc_html($player['matchs_d']) : 0; ?></td>
                                <td><?php echo !empty($player['ippons_marqués']) ? esc_html($player['ippons_marqués']) : 0; ?></td>
                                <td><?php echo !empty($player['wazaris_marqués']) ? esc_html($player['wazaris_marqués']) : 0; ?></td>
                                <td><?php echo !empty($player['kinza']) ? esc_html($player['kinza']) : 0; ?></td>

                                <td>
                                    <span class="jpl-points">
                                        <?php echo !empty($player['points_judoka']) ? esc_html($player['points_judoka']) : 0; ?>
                                    </span>
                                </td>

                            </tr>

                        <?php endforeach; ?>

                    </tbody>

                </table>

            </div>

        </section>

    <?php endif; ?>

</main>


<script>
document.addEventListener('DOMContentLoaded', function () {

    const saison = document.getElementById('saison_value');
    const profil = document.getElementById('categorie');
    const categorie = document.getElementById('categorie_value');
    const equipe = document.getElementById('equipe_value');

    const tableaux = {
        all: document.getElementById('tableauAll'),
        hommes: document.getElementById('tableauHommes'),
        femmes: document.getElementById('tableauFemmes'),
        hommesU23: document.getElementById('tableauHommesU23'),
        femmesU23: document.getElementById('tableauFemmesU23')
    };


    /* =========================================================
     * SAISON
     * ========================================================= */

    if (saison) {

        saison.addEventListener('change', function () {

            this.form.submit();

        });

    }


    /* =========================================================
     * FILTRAGE
     * ========================================================= */

    function filtrerJudokas() {

        const profilValue = profil ? profil.value : '-all-';
        const categorieValue = categorie ? categorie.value : '0';
        const equipeValue = equipe ? equipe.value : '0';


        /* -----------------------------------------------------
         * DÉTERMINER LE TABLEAU À AFFICHER
         * ----------------------------------------------------- */

        Object.values(tableaux).forEach(function (table) {

            if (table) {
                table.style.display = 'none';
            }

        });


        let tableauActif = tableaux.all;


        switch (profilValue) {

            case '-h-':

                tableauActif = tableaux.hommes;

                break;


            case '-f-':

                tableauActif = tableaux.femmes;

                break;


            case '-hu23-':

                tableauActif = tableaux.hommesU23;

                break;


            case '-fu23-':

                tableauActif = tableaux.femmesU23;

                break;


            case '-all-':

            default:

                tableauActif = tableaux.all;

                break;

        }


        if (!tableauActif) {
            return;
        }


        tableauActif.style.display = 'table';


        /* -----------------------------------------------------
         * FILTRER LES LIGNES
         * ----------------------------------------------------- */

        const rows = tableauActif.querySelectorAll(
            'tbody tr.jpl-stat-row'
        );

		

        rows.forEach(function (row) {

            let afficher = true;


            /* ================================================
             * CATÉGORIE DE POIDS
             *
             * 3e colonne :
             * NOM | AGE | CAT.
             * ================================================ */

            if (categorieValue !== '0') {

                const celluleCategorie = row.cells[2];

                if (!celluleCategorie) {

                    afficher = false;

                } else {

                    const valeurLigne = celluleCategorie.textContent
                        .trim()
                        .replace(/\s+/g, '');

                    const valeurFiltre = categorieValue
                        .trim()
                        .replace(/\s+/g, '');

                    if (valeurLigne !== valeurFiltre) {
                        afficher = false;
                    }

                }

            }


            /* ================================================
             * ÉQUIPE
             * ================================================ */

            if (
                afficher &&
                equipeValue !== '0'
            ) {

                const equipeLigne = row.getAttribute('data-equipe');

                if (!equipeLigne) {

                    afficher = false;

                } else if (
                    equipeLigne.trim().toLowerCase() !==
                    equipeValue.trim().toLowerCase()
                ) {

                    afficher = false;

                }

            }


            row.style.display = afficher ? '' : 'none';

        });


        /* -----------------------------------------------------
         * MESSAGE AUCUN RÉSULTAT
         * ----------------------------------------------------- */

        let message = tableauActif.parentElement.querySelector(
            '.jpl-no-filter-result'
        );


        const lignesVisibles = tableauActif.querySelectorAll(
            'tbody tr.jpl-stat-row:not([style*="display: none"])'
        );


        if (lignesVisibles.length === 0) {

            if (!message) {

                message = document.createElement('div');

                message.className = 'jpl-no-filter-result';

                message.textContent =
                    'Aucun judoka ne correspond aux filtres sélectionnés.';

                tableauActif.parentElement.appendChild(message);

            }

            message.style.display = 'block';

        } else {

            if (message) {
                message.style.display = 'none';
            }

        }

    }


    /* =========================================================
     * ÉVÉNEMENTS
     * ========================================================= */

    if (profil) {

        profil.addEventListener(
            'change',
            filtrerJudokas
        );

    }


    if (categorie) {

        categorie.addEventListener(
            'change',
            filtrerJudokas
        );

    }


    if (equipe) {

        equipe.addEventListener(
            'change',
            filtrerJudokas
        );

    }


    /* =========================================================
     * INITIALISATION
     * ========================================================= */

    filtrerJudokas();

});
</script>


<?php get_footer(); ?>