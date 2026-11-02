<?php
/**
 * Template Name: Modèle stats équipes
 */
get_header();
/* =========================================================
 * SAISON
 * ========================================================= */
$saison_value = isset($_GET['saison_value'])
    ? sanitize_text_field(wp_unslash($_GET['saison_value']))
    : '2026-2027';
// $logo_principal = get_field( 'logo_principal', $team_id );
// $logo_principal_url = $logo_principal
//     ? $logo_principal
//     : get_the_post_thumbnail_url( $team_id, 'full' );
?>
<main id="primary" class="site-main jpl-stats-page page-stats-equipes">
    <!-- =====================================================
         HEADER
    ====================================================== -->
    <section class="jpl-stats-hero jpl-teams-header">
        <div class="jpl-stats-hero-content">
            <span class="jpl-stats-eyebrow">
                JUDO PRO LEAGUE
            </span>
            <h1>
                Statistiques équipes <strong><?php echo esc_html($saison_value); ?></strong>
            </h1>
        </div>

    </section>
    <!-- =====================================================
         DONNÉES
    ====================================================== -->
    <?php
    $args = array(
        'post_type'      => 'rencontre',
        'posts_per_page' => -1,

        'meta_query'     => array(
            array(
                'key'     => 'saisons',
                'compare' => 'LIKE',
                'value'   => $saison_value,
            ),
        ),

        'meta_key'       => 'date_de_debut',
        'orderby'        => 'meta_value_num',
        'order'          => 'DESC',
    );
    $rencontres = get_posts($args);
    require_once(
        THEMEDIR . 'template-parts/content-pro-league2-requests-stats.php'
    );
    $classement = get_classement(
        $rencontres,
        $saison_value
    );
    ?>
    <!-- =====================================================
         TABLEAU
    ====================================================== -->
    <section class="jpl-stats-card">

        <div class="jpl-stats-card-header">
    <!-- =====================================================
         TABS
    ====================================================== -->
    <div class="jpl-stats-tabs">
        <a
            href="<?php echo esc_url(
                home_url('/statistiques-equipes-judo-pro-league/')
            ); ?>"
            class="jpl-stats-tab active"
        >
            <span>Équipes</span>
        </a>

        <a
            href="<?php echo esc_url(
                home_url('/statistiques-judokas-judo-pro-league/')
            ); ?>"
            class="jpl-stats-tab"
        >
            <span>Judokas</span>
        </a>

    </div>
			
			<div>
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


        <?php if ($classement) : ?>

            <div class="jpl-table-scroll">

                <table
                    id="tableauEquipes"
                    class="jpl-stats-table"
                >

                    <thead>

                        <tr>

                            <th class="jpl-team-column">
                                ÉQUIPE
                            </th>

                            <th>
                                <span class="desktop">
                                    COMBATS GAGNÉS
                                </span>

                                <span class="mobile">
                                    V
                                </span>
                            </th>

                            <th>
                                <span class="desktop">
                                    IPPON
                                </span>

                                <span class="mobile">
                                    IP
                                </span>
                            </th>

                            <th>
                                <span class="desktop">
                                    WAZA-ARI
                                </span>

                                <span class="mobile">
                                    WA
                                </span>
                            </th>

                            <th>
                                <span class="desktop">
                                    PTS MARQUÉS
                                </span>

                                <span class="mobile">
                                    PTS
                                </span>
                            </th>

                        </tr>

                    </thead>


                    <tbody>

                        <?php

                        $position = 1;

                        foreach ($classement as $d) :

$nom = $d[0]['nom'];

$id = !empty($d[0]['id'])
    ? absint($d[0]['id'])
    : 0;

// Récupérer l'abréviation depuis les données du classement
$abreviation = !empty($d[0]['abreviation'])
    ? $d[0]['abreviation']
    : '';

// Si elle n'est pas présente, la récupérer depuis les champs ACF
if (empty($abreviation) && $id) {
    $abreviation = get_field('abreviation', $id);
}

// Logo principal
$logo_principal = $id
    ? get_field('logo_principal', $id)
    : '';

if (is_array($logo_principal)) {
    $logo_url = $logo_principal['url'] ?? '';
} elseif (is_numeric($logo_principal)) {
    $logo_url = wp_get_attachment_image_url(
        (int) $logo_principal,
        'full'
    );
} else {
    $logo_url = is_string($logo_principal)
        ? $logo_principal
        : '';
}
                            $combats = !empty($d[0]['combats_gagnés'])
                                ? $d[0]['combats_gagnés']
                                : 0;

                            $ippons = !empty($d[0]['ippons_marqués'])
                                ? $d[0]['ippons_marqués']
                                : 0;

                            $wazaris = !empty($d[0]['wazaris_marqués'])
                                ? $d[0]['wazaris_marqués']
                                : 0;

                            $points = !empty($d[0]['points_marqués'])
                                ? $d[0]['points_marqués']
                                : 0;

                            $team_url = $id
                                ? get_permalink($id)
                                : '#';

                        ?>

                            <tr class="jpl-stat-row">
                                <!-- ÉQUIPE -->
                                <td class="jpl-team-cell">

                                    <div class="jpl-rank">
                                        <?php echo esc_html($position); ?>
                                    </div>
                                    <a
                                        href="<?php echo esc_url($team_url); ?>"
                                        class="jpl-team-link"
                                    >
                                        <div class="jpl-team-logo">
                                            <?php if ($logo_principal) : ?>
                                                <img
                                                    src="<?php echo esc_url($logo_principal); ?>"
                                                    alt="<?php echo esc_attr($nom); ?>"
                                                >
                                            <?php else : ?>
                                                <span>
                                                    <?php
                                                    echo esc_html(
                                                        mb_substr($nom, 0, 1)
                                                    );
                                                    ?>
                                                </span>
                                            <?php endif; ?>
                                        </div>
                                        <span class="jpl-team-name desktop-label">
                                            <?php echo esc_html($nom); ?>
	                                        </span>
										<span class="mobile-label">
                                            <?php echo esc_html($abreviation ?: $nom); ?>
										</span>
                                    </a>
                                </td>
                                <!-- V -->
                                <td>
                                    <span class="jpl-number">
                                        <?php echo esc_html($combats); ?>
                                    </span>
                                </td>
                                <!-- IPPON -->
                                <td>
                                    <span class="jpl-number">
                                        <?php echo esc_html($ippons); ?>
                                    </span>
                                </td>
                                <!-- WAZA-ARI -->
                                <td>
                                    <span class="jpl-number">
                                        <?php echo esc_html($wazaris); ?>
                                    </span>
                                </td>
                                <!-- POINTS -->
                                <td>
                                    <span class="jpl-points">
                                        <?php echo esc_html($points); ?>
                                    </span>
                                </td>
                            </tr>
                        <?php
                            $position++;
                        endforeach;
                        ?>
                    </tbody>
                </table>
            </div>
        <?php else : ?>
            <div class="jpl-no-stats">
                <span class="jpl-no-stats-icon">
                    —
                </span>
                <h3>
                    Aucune statistique disponible
                </h3>
                <p>
                    Aucune donnée n'est disponible pour cette saison.
                </p>
            </div>
        <?php endif; ?>
    </section>
</main>



<script src="https://code.jquery.com/jquery-1.12.0.min.js"></script>
     <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js" defer></script>
     <script type="text/javascript">
    $(document).ready(function() {
        
            $('#tableauEquipes').DataTable( {
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
                "paging": false,
                info: false,
                order: [[1, 'desc'],[2, 'desc'],[3, 'desc'],[4, 'desc']]
        } );
        
        $('.dataTables_filter input[type="search"]').hide();
        /*$('#tableauEquipes').DataTable({
        lengthMenu: [
            [10, 25, 50, 100],
            ['10 lignes', '25 lignes', '50 lignes', '100 lignes'],
        ],
    });*/
    });
    </script>
<style>
	.flex-stat{    display: grid;
    grid-auto-flow: column;
    align-items: center;}

</style>

<?php get_footer(); ?>