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


<script>
        $(document).ready(function() {
            $('#saison_value').change(function() {
                $('.season-selector-form').submit();
            });
            $('#equipe_value').change(function() {
                var selectedCategory=$('#categorie_value').val();
                var selectedEquipe = $(this).val(); // Obtenez la valeur sélectionnée
                var search_val=selectedCategory+" "+selectedEquipe;

                console.log('search_val',search_val)
                $('#tableauAll_filter > label > input[type=search]').val(search_val).trigger('input');;
                $('#tableauHommes_filter > label > input[type=search]').val(search_val).trigger('input');;
                $('#tableauFemmes_filter > label > input[type=search]').val(search_val).trigger('input');;
                $('#tableauHommesU23_filter > label > input[type=search]').val(search_val).trigger('input');;
                $('#tableauFemmesU23_filter > label > input[type=search]').val(search_val).trigger('input');;
            });
            $('#categorie_value').change(function() {
                var selectedEquipe=$('#equipe_value').val();
                var selectedCategory = $(this).val(); // Obtenez la valeur sélectionnée
                var search_val=selectedCategory+" "+selectedEquipe;

                console.log('search_val',search_val)
                $('#tableauAll_filter > label > input[type=search]').val(search_val).trigger('input');;
                $('#tableauHommes_filter > label > input[type=search]').val(search_val).trigger('input');;
                $('#tableauFemmes_filter > label > input[type=search]').val(search_val).trigger('input');;
                $('#tableauHommesU23_filter > label > input[type=search]').val(search_val).trigger('input');;
                $('#tableauFemmesU23_filter > label > input[type=search]').val(search_val).trigger('input');;
            });
        });
        
    </script>

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



<script src="https://code.jquery.com/jquery-1.12.0.min.js"></script>
     <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js" defer></script>
     <script type="text/javascript">
    $(document).ready(function() {
        $('#tableauAll').DataTable( {
                language: {
                    processing:     "Traitement en cours...",
                    search:         "",
                    lengthMenu: '<select>'+
                    '<option value="10">10 lignes</option>'+
                    '<option value="25" >25 lignes</option>'+
                    '<option value="50">50 lignes</option>'+
                    '<option value="100">100 lignes</option>'+
                    '</select>',
                    info:           "Affichage des &eacute;lements _START_ &agrave; _END_",
                    infoEmpty:      "Affichage de l'&eacute;lement 0 &agrave; 0 sur 0 lignes",
                    infoFiltered:   "(filtr&eacute; de _MAX_ lignes au total)",
                    infoPostFix:    "",
                    loadingRecords: "Chargement en cours...",
                    zeroRecords:    "Aucun &eacute;l&eacute;ment &agrave; afficher",
                    emptyTable:     "Aucune donnée disponible dans le tableau",
                    paginate: {
                        first:      "Premier",
                        previous:   "Pr&eacute;c&eacute;dent",
                        next:       "Suivant",
                        last:       "Dernier"
                    },
                    aria: {
                        sortAscending:  ": activer pour trier la colonne par ordre croissant",
                        sortDescending: ": activer pour trier la colonne par ordre décroissant"
                    }
                },
                 order: [[3, 'desc'],[5, 'desc'],[6, 'desc'],[7, 'desc']],
                 paging: false,          // Pagination
                searching: true,       // Barre de recherche
                info: false,            // Nombre d'entrées affichées
                lengthChange: false,    // Choix du nombre de lignes
        } );
            $('#tableauHommes').DataTable( {
                language: {
                    processing:     "Traitement en cours...",
                    search:         "",
                    lengthMenu: '<select>'+
                    '<option value="10">10 lignes</option>'+
                    '<option value="25" >25 lignes</option>'+
                    '<option value="50">50 lignes</option>'+
                    '<option value="100">100 lignes</option>'+
                    '</select>',
                    info:           "Affichage des &eacute;lements _START_ &agrave; _END_",
                    infoEmpty:      "Affichage de l'&eacute;lement 0 &agrave; 0 sur 0 lignes",
                    infoFiltered:   "(filtr&eacute; de _MAX_ lignes au total)",
                    infoPostFix:    "",
                    loadingRecords: "Chargement en cours...",
                    zeroRecords:    "Aucun &eacute;l&eacute;ment &agrave; afficher",
                    emptyTable:     "Aucune donnée disponible dans le tableau",
                    paginate: {
                        first:      "Premier",
                        previous:   "Pr&eacute;c&eacute;dent",
                        next:       "Suivant",
                        last:       "Dernier"
                    },
                    aria: {
                        sortAscending:  ": activer pour trier la colonne par ordre croissant",
                        sortDescending: ": activer pour trier la colonne par ordre décroissant"
                    }
                },
                order: [[3, 'desc'],[5, 'desc'],[6, 'desc'],[7, 'desc']],
                paging: false,          // Pagination
                searching: true,       // Barre de recherche
                info: false,            // Nombre d'entrées affichées
                lengthChange: false,    // Choix du nombre de lignes
        } );
        $('#tableauFemmes').DataTable( {
            language: {
                processing:     "Traitement en cours...",
                search:         "",
                lengthMenu: '<select>'+
                '<option value="10">10 lignes</option>'+
                '<option value="25">25 lignes</option>'+
                '<option value="50">50 lignes</option>'+
                '<option value="100">100 lignes</option>'+
                '</select>',
                info:           "Affichage des &eacute;lements _START_ &agrave; _END_",
                infoEmpty:      "Affichage de l'&eacute;lement 0 &agrave; 0 sur 0 lignes",
                infoFiltered:   "(filtr&eacute; de _MAX_ lignes au total)",
                infoPostFix:    "",
                loadingRecords: "Chargement en cours...",
                zeroRecords:    "Aucun &eacute;l&eacute;ment &agrave; afficher",
                emptyTable:     "Aucune donnée disponible dans le tableau",
                paginate: {
                    first:      "Premier",
                    previous:   "Pr&eacute;c&eacute;dent",
                    next:       "Suivant",
                    last:       "Dernier"
                },
                aria: {
                    sortAscending:  ": activer pour trier la colonne par ordre croissant",
                    sortDescending: ": activer pour trier la colonne par ordre décroissant"
                }
            },
            order: [[3, 'desc'],[5, 'desc'],[6, 'desc'],[7, 'desc']],
            paging: false,          // Pagination
                searching: true,       // Barre de recherche
                info: false,            // Nombre d'entrées affichées
                lengthChange: false,    // Choix du nombre de lignes
        } );
        $('#tableauHommesU23').DataTable( {
                language: {
                    processing:     "Traitement en cours...",
                    search:         "",
                    lengthMenu: '<select>'+
                    '<option value="10">10 lignes</option>'+
                    '<option value="25" >25 lignes</option>'+
                    '<option value="50">50 lignes</option>'+
                    '<option value="100">100 lignes</option>'+
                    '</select>',
                    info:           "Affichage des &eacute;lements _START_ &agrave; _END_",
                    infoEmpty:      "Affichage de l'&eacute;lement 0 &agrave; 0 sur 0 lignes",
                    infoFiltered:   "(filtr&eacute; de _MAX_ lignes au total)",
                    infoPostFix:    "",
                    loadingRecords: "Chargement en cours...",
                    zeroRecords:    "Aucun &eacute;l&eacute;ment &agrave; afficher",
                    emptyTable:     "Aucune donnée disponible dans le tableau",
                    paginate: {
                        first:      "Premier",
                        previous:   "Pr&eacute;c&eacute;dent",
                        next:       "Suivant",
                        last:       "Dernier"
                    },
                    aria: {
                        sortAscending:  ": activer pour trier la colonne par ordre croissant",
                        sortDescending: ": activer pour trier la colonne par ordre décroissant"
                    }
                },
                 order: [[3, 'desc'],[5, 'desc'],[6, 'desc'],[7, 'desc']],
                 paging: false,          // Pagination
                searching: true,       // Barre de recherche
                info: false,            // Nombre d'entrées affichées
                lengthChange: false,    // Choix du nombre de lignes
        } );
        $('#tableauFemmesU23').DataTable( {
            language: {
                processing:     "Traitement en cours...",
                search:         "",
                lengthMenu: '<select>'+
                '<option value="10">10 lignes</option>'+
                '<option value="25">25 lignes</option>'+
                '<option value="50">50 lignes</option>'+
                '<option value="100">100 lignes</option>'+
                '</select>',
                info:           "Affichage des &eacute;lements _START_ &agrave; _END_",
                infoEmpty:      "Affichage de l'&eacute;lement 0 &agrave; 0 sur 0 lignes",
                infoFiltered:   "(filtr&eacute; de _MAX_ lignes au total)",
                infoPostFix:    "",
                loadingRecords: "Chargement en cours...",
                zeroRecords:    "Aucun &eacute;l&eacute;ment &agrave; afficher",
                emptyTable:     "Aucune donnée disponible dans le tableau",
                paginate: {
                    first:      "Premier",
                    previous:   "Pr&eacute;c&eacute;dent",
                    next:       "Suivant",
                    last:       "Dernier"
                },
                aria: {
                    sortAscending:  ": activer pour trier la colonne par ordre croissant",
                    sortDescending: ": activer pour trier la colonne par ordre décroissant"
                }
            },
            order: [[3, 'desc'],[5, 'desc'],[6, 'desc'],[7, 'desc']],
            paging: false,          // Pagination
                searching: true,       // Barre de recherche
                info: false,            // Nombre d'entrées affichées
                lengthChange: false,    // Choix du nombre de lignes
        } );
        $('#tableauHommes_wrapper').hide()
        $('#tableauFemmes_wrapper').hide()
        $('#tableauHommesU23_wrapper').hide()
        $('#tableauFemmesU23_wrapper').hide()
        //console.log("genre: ",$('#genre').text())
        
        $('#categorie').change( function() {
            console.log($(this).val())
            //location.href = window.location.pathname.replace('-mf-',$(this).val());
            if($(this).val()=="-h-"){
                console.log("hommes")
                $('#tableauHommes_wrapper').show()
                $('#tableauAll_wrapper').hide()
                $('#tableauFemmes_wrapper').hide()
                $('#tableauHommesU23_wrapper').hide()
                $('#tableauFemmesU23_wrapper').hide()
            }else if($(this).val()=="-all-"){
                console.log("tous")
                $('#tableauHommes_wrapper').hide()
                $('#tableauAll_wrapper').show()
                $('#tableauFemmes_wrapper').hide()
                $('#tableauHommesU23_wrapper').hide()
                $('#tableauFemmesU23_wrapper').hide()
            }
            else if($(this).val()=="-hu23-"){
                console.log("hommes u23")
                $('#tableauHommes_wrapper').hide()
                $('#tableauAll_wrapper').hide()
                $('#tableauFemmes_wrapper').hide()
                $('#tableauHommesU23_wrapper').show()
                $('#tableauFemmesU23_wrapper').hide()
            }
            else if($(this).val()=="-fu23-"){
                console.log("femmes u23")
                $('#tableauHommes_wrapper').hide()
                $('#tableauAll_wrapper').hide()
                $('#tableauFemmes_wrapper').hide()
                $('#tableauHommesU23_wrapper').hide()
                $('#tableauFemmesU23_wrapper').show()
            }
            else if($(this).val()=="-f-"){
                console.log("femmes")
                $('#tableauHommes_wrapper').hide()
                $('#tableauAll_wrapper').hide()
                $('#tableauFemmes_wrapper').show()
                $('#tableauHommesU23_wrapper').hide()
                $('#tableauFemmesU23_wrapper').hide()
            }
        });
        $('.dataTables_filter input[type="search"]').attr('placeholder', 'Trouver un judoka');
        $('.dataTables_length').hide()
        $('.dataTables_filter input[type="search"]').hide();
        /*$('#tableauHommes').DataTable({
        lengthMenu: [
            [10, 25, 50, 100],
            ['10 lignes', '25 lignes', '50 lignes', '100 lignes'],
        ],
    });*/
    });
    </script>

<?php get_footer(); ?>