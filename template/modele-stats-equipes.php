<?php

/**
 * Template Name: Modèle stats équipes
 */

get_header();
?>
<main id="primary" class="site-main home page-stats-equipes">
    <section>
        <div class="judo_pro_league mt-5p">
        <h1 class="result-h1 mtb-0">Statistiques Judo Pro League 2023</h1>
            <div class="phases-cl2">
                <h2 class="tab-phase tab-act fs-30">
                    <a href="statistiques-equipes-judo-pro-league-2023/">
                        Équipes
                    </a>
                </h2>
                <h2 class="tab-phase fs-30">
                    <a href="statistiques-judokas-judo-pro-league-2023/">
                        Judokas
                    </a>
                </h2>
            </div>
        </div>
		<div class="judo_pro_league ">
			
            <?php 
                $args=array(
                    'post_type'=> 'rencontre',
                    'posts_per_page' => -1,
                    'meta_key' => 'date_de_debut',
                    'orderby' => 'meta_value_num',
                    'order' => 'DESC',
                    
                );
                $rencontres=get_posts($args);
                    require_once (THEMEDIR.'template-parts/content-pro-league2-requests-stats.php');
                    $classement=get_classement($rencontres);
                    //prettyPrint($classement);
                ?>
            <?php  if($classement): 
                //prettyPrint($classement);?>
                <table id="tableauEquipes" data-page-length='25' class="display">
                    <thead>
                        <tr>
                            <th style="width: 320px !important;text-transform: capitalize;">nom</th>
                            <th style="width: 120px !important;text-align: center !important;text-transform: capitalize;"><span class="desktop">combats gagnés</span><span class="mobile">V</span></th>
                            <th style="width: 120px !important;text-align: center !important;text-transform: capitalize;"><span class="desktop">Ippon</span><span class="mobile">Ip</span></th>
                            <th style="width: 120px !important;text-align: center !important;text-transform: capitalize;"><span class="desktop">Waza-ari</span><span class="mobile">Wa</span></th>
                            <th style="width: 120px !important;text-align: center !important;text-transform: capitalize;"><span class="desktop">Pts marqués</span><span class="mobile">Pts</span></th>
                        </tr>
                    </thead> 
                    <tbody>
                    <?php
                       
                        foreach ($classement as $d) {?>
                            <tr>
                                <td  class="align-photo-nom-vertically"><img width="24px" height="24px" src="<?php echo ($d[0]['image'])?$d[0]['image']:''?>" alt=""><?php echo ($d[0]['nom'])?$d[0]['nom']:''?></td>
                                <td class="wp-caption-text"><?php echo ($d[0]['victoires'])?$d[0]['combats_gagnés']:0?></td>
                                <td class="wp-caption-text"><?php echo ($d[0]['ippons_marqués'])?$d[0]['ippons_marqués']:0?></td>
                                <td class="wp-caption-text"><?php echo ($d[0]['wazaris_marqués'])?$d[0]['wazaris_marqués']:0?></td>
                                <td class="wp-caption-text"><?php echo ($d[0]['points_marqués'])?$d[0]['points_marqués']:0?></td>
                            </tr>
                        <?php
                        } ?>
                    </tbody>
                </table>

            <?php  endif;?>
        </div>
    </section>
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
 <?php
 get_footer();