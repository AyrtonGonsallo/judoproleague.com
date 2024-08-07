<?php

/**
 * Template Name: Modèle stats Judokas
 */
 get_header();
 $saison_value=($_GET["saison_value"])?$_GET["saison_value"]:"2023-2024";

 ?>
 
<script>
        $(document).ready(function() {
            $('#saison_value').change(function() {
                $('.season-selector-form').submit();
            });
        });
    </script>
 <main id="primary" class="site-main home page-stats-judokas">

 <div class="season-selector-box">
			<form Method="GET" ACTION="" class="season-selector-form">
				<select name="saison_value" id="saison_value" class="season-selector-select">
					<option value="2021-2022" <?php echo ($saison_value=="2021-2022")?"selected":"";?>>2021-2022</option>
					<option value="2022-2023" <?php echo ($saison_value=="2022-2023")?"selected":"";?>>2022-2023</option>
					<option value="2023-2024" <?php echo ($saison_value=="2023-2024")?"selected":"";?>>2023-2024</option>
				</select>
			</form>
		</div>
     <section>
     <div class="judo_pro_league  mt-5p">
        <h1 class="result-h1 mtb-0">Statistiques Judo Pro League 2023</h1>

            <div class="phases-cl2">
                <h2 class="tab-phase fs-30">
                    <a href="statistiques-equipes-judo-pro-league-2023/">
                        Équipes
                    </a>
                </h2>
                <h2 class="tab-phase tab-act  fs-30">
                    <a href="statistiques-judokas-judo-pro-league-2023/">
                        Judokas
                    </a>
                </h2>
            </div>
        </div>
         <div class="judo_pro_league ">
            <?php 
                require_once (THEMEDIR.'template-parts/content-judokas-requests-stats.php');
                $classement_total=get_classement( $saison_value);
            ?>  
            <?php
                if($classement_total['total']){
                    $datas=$classement_total['total'];
				    //prettyPrint($datas);exit(-1);
            ?>
                <select id="categorie" style="height:34px">  
                    <option value="-all-">Tous les judokas</option>
                    <option value="-h-">Masculins</option>
                    <option value="-f-">Féminines</option>
                    <option value="-hu23-">Masculins U23</option>
                    <option value="-fu23-">Féminines U23</option>
                </select>
                <table id="tableauAll" data-page-length='25' class="display">
                    <thead>
                        <tr>
                        <!--<th style="text-transform: capitalize;">Rang</th>-->
                            <th style="text-transform: capitalize;">nom</th>
                            <th class="text-end" style="text-transform: capitalize;">Age</th>
                            
                            <th class="text-end" style="text-transform: capitalize;">V</th>
                            <th class="text-end" style="text-transform: capitalize;">N</th>
                            <th class="text-end" style="text-transform: capitalize;">D</th>
                            <th class="text-end" style="text-transform: capitalize;"><span class="desktop">Ippon</span><span class="mobile">Ip</span></th>
                            
                            <th class="text-end" style="text-transform: capitalize;"><span class="desktop">Waza-ari</span><span class="mobile">Wa</span></th>
                            
                           
                            <th class="text-end" style="text-transform: capitalize;">Pts</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php
                       foreach ($datas as $d) {?>
                            <tr class="tr-stat">
                                <!--<td><?php //echo $i;?></td>-->
                                <td class="align-photo-nom-vertically "><img class="desktop" width="24px" height="24px" style="border-radius:40px" src="<?php echo ($d[0]['image'])?$d[0]['image']:''?>" alt=""><a href="<?php echo get_the_permalink($d[0]['judoka_id']);?>"><?php echo ($d[0]['nom'])?$d[0]['nom']:''?></a></td>
                                <td class="wp-caption-text"><?php echo ($d[0]['age'])?$d[0]['age']:0?></td>

                                
                                <td class="wp-caption-text"><?php echo ($d[0]['matchs_v'])?$d[0]['matchs_v']:0?></td>
                                <td class="wp-caption-text"><?php echo ($d[0]['matchs_nuls'])?$d[0]['matchs_nuls']:0?></td>
                                <td class="wp-caption-text"><?php echo ($d[0]['matchs_d'])?$d[0]['matchs_d']:0?></td>
                                <td class="wp-caption-text"><?php echo ($d[0]['ippons_marqués'])?$d[0]['ippons_marqués']:0?></td>
                                <td class="wp-caption-text"><?php echo ($d[0]['wazaris_marqués'])?$d[0]['wazaris_marqués']:0?></td>
                                <td class="wp-caption-text"><?php echo ($d[0]['points_judoka'])?$d[0]['points_judoka']:0?></td>
                            </tr>
                        <?php
                        } ?>
                    </tbody>
                </table>
                <table id="tableauHommes" data-page-length='25' class="display">
                    <thead>
                        <tr>
                        <!--<th style="text-transform: capitalize;">Rang</th>-->
                            <th style="text-transform: capitalize;">nom</th>
                            <th class="text-end" style="text-transform: capitalize;">Age</th>
                            
                            <th class="text-end" style="text-transform: capitalize;">V</th>
                            <th class="text-end" style="text-transform: capitalize;">N</th>
                            <th class="text-end" style="text-transform: capitalize;">D</th>
                            <th class="text-end" style="text-transform: capitalize;"><span class="desktop">Ippon</span><span class="mobile">Ip</span></th>
                            
                            <th class="text-end" style="text-transform: capitalize;"><span class="desktop">Waza-ari</span><span class="mobile">Wa</span></th>
                           
                            <th class="text-end" style="text-transform: capitalize;">Pts</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php
                       foreach ($datas as $d) {
                            if($d[0]['sexe']=='masculin'){?>
                                <tr>
                                    <!--<td><?php //echo $i;?></td>-->
                                    <td class="align-photo-nom-vertically"><img class="desktop" width="24px" height="24px" style="border-radius:40px" src="<?php echo ($d[0]['image'])?$d[0]['image']:''?>" alt=""><a href="<?php echo get_the_permalink($d[0]['judoka_id']);?>"><?php echo ($d[0]['nom'])?$d[0]['nom']:''?></a></td>
                                    <td class="wp-caption-text"><?php echo ($d[0]['age'])?$d[0]['age']:0?></td>

                                    
                                    <td class="wp-caption-text"><?php echo ($d[0]['matchs_v'])?$d[0]['matchs_v']:0?></td>
                                    <td class="wp-caption-text"><?php echo ($d[0]['matchs_nuls'])?$d[0]['matchs_nuls']:0?></td>
                                    <td class="wp-caption-text"><?php echo ($d[0]['matchs_d'])?$d[0]['matchs_d']:0?></td>
                                    <td class="wp-caption-text"><?php echo ($d[0]['ippons_marqués'])?$d[0]['ippons_marqués']:0?></td>
                                    <td class="wp-caption-text"><?php echo ($d[0]['wazaris_marqués'])?$d[0]['wazaris_marqués']:0?></td>
                                    <td class="wp-caption-text"><?php echo ($d[0]['points_judoka'])?$d[0]['points_judoka']:0?></td>
                                </tr>
                        <?php
                            }
                        } ?>
                    </tbody>
                </table>
            
                
                <table id="tableauFemmes" data-page-length='25' class="display">
                    <thead>
                        <tr>
                        <!--<th style="text-transform: capitalize;">Rang</th>-->
                            <th style="text-transform: capitalize;">nom</th>
                            <th class="text-end" style="text-transform: capitalize;">Age</th>
                            
                            <th class="text-end" style="text-transform: capitalize;">V</th>
                            <th class="text-end" style="text-transform: capitalize;">N</th>
                            <th class="text-end" style="text-transform: capitalize;">D</th>
                            <th class="text-end" style="text-transform: capitalize;"><span class="desktop">Ippon</span><span class="mobile">Ip</span></th>
                            
                            <th class="text-end" style="text-transform: capitalize;"><span class="desktop">Waza-ari</span><span class="mobile">Wa</span></th>
                         
                            <th class="text-end" style="text-transform: capitalize;">Pts</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php
                       foreach ($datas as $d) {
                            if($d[0]['sexe']=='féminin'){?>
                                <tr>
                                    <!--<td><?php //echo $i;?></td>-->
                                    <td class="align-photo-nom-vertically"><img class="desktop" width="24px" height="24px" style="border-radius:40px" src="<?php echo ($d[0]['image'])?$d[0]['image']:''?>" alt=""><a href="<?php echo get_the_permalink($d[0]['judoka_id']);?>"><?php echo ($d[0]['nom'])?$d[0]['nom']:''?></a></td>
                                    <td class="wp-caption-text"><?php echo ($d[0]['age'])?$d[0]['age']:0?></td>
                                    
                                    <td class="wp-caption-text"><?php echo ($d[0]['matchs_v'])?$d[0]['matchs_v']:0?></td>
                                    <td class="wp-caption-text"><?php echo ($d[0]['matchs_nuls'])?$d[0]['matchs_nuls']:0?></td>
                                    <td class="wp-caption-text"><?php echo ($d[0]['matchs_d'])?$d[0]['matchs_d']:0?></td>
                                    <td class="wp-caption-text"><?php echo ($d[0]['ippons_marqués'])?$d[0]['ippons_marqués']:0?></td>
                                    <td class="wp-caption-text"><?php echo ($d[0]['wazaris_marqués'])?$d[0]['wazaris_marqués']:0?></td>
                                    <td class="wp-caption-text"><?php echo ($d[0]['points_judoka'])?$d[0]['points_judoka']:0?></td>
                                </tr>
                        <?php
                            }
                        } ?>
                    </tbody>
                </table>

                <table id="tableauHommesU23" data-page-length='25' class="display">
                    <thead>
                        <tr>
                        <!--<th style="text-transform: capitalize;">Rang</th>-->
                            <th style="text-transform: capitalize;">nom</th>
                            <th class="text-end" style="text-transform: capitalize;">Age</th>
                            
                            <th class="text-end" style="text-transform: capitalize;">V</th>
                            <th class="text-end" style="text-transform: capitalize;">N</th>
                            <th class="text-end" style="text-transform: capitalize;">D</th>
                            <th class="text-end" style="text-transform: capitalize;"><span class="desktop">Ippon</span><span class="mobile">Ip</span></th>
                            
                            <th class="text-end" style="text-transform: capitalize;"><span class="desktop">Waza-ari</span><span class="mobile">Wa</span></th>
                         
                            <th class="text-end" style="text-transform: capitalize;">Pts</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php
                       foreach ($datas as $d) {
                            if($d[0]['sexe']=='masculin' && $d[0]['age']<=23){?>
                                <tr>
                                    <!--<td><?php //echo $i;?></td>-->
                                    <td class="align-photo-nom-vertically"><img class="desktop" width="24px" height="24px" style="border-radius:40px" src="<?php echo ($d[0]['image'])?$d[0]['image']:''?>" alt=""><a href="<?php echo get_the_permalink($d[0]['judoka_id']);?>"><?php echo ($d[0]['nom'])?$d[0]['nom']:''?></a></td>
                                    <td class="wp-caption-text"><?php echo ($d[0]['age'])?$d[0]['age']:0?></td>
                                    
                                    <td class="wp-caption-text"><?php echo ($d[0]['matchs_v'])?$d[0]['matchs_v']:0?></td>
                                    <td class="wp-caption-text"><?php echo ($d[0]['matchs_nuls'])?$d[0]['matchs_nuls']:0?></td>
                                    <td class="wp-caption-text"><?php echo ($d[0]['matchs_d'])?$d[0]['matchs_d']:0?></td>
                                    <td class="wp-caption-text"><?php echo ($d[0]['ippons_marqués'])?$d[0]['ippons_marqués']:0?></td>
                                    <td class="wp-caption-text"><?php echo ($d[0]['wazaris_marqués'])?$d[0]['wazaris_marqués']:0?></td>
                                    <td class="wp-caption-text"><?php echo ($d[0]['points_judoka'])?$d[0]['points_judoka']:0?></td>
                                </tr>
                        <?php
                            }
                        } ?>
                    </tbody>
                </table>

                <table id="tableauFemmesU23" data-page-length='25' class="display">
                    <thead>
                        <tr>
                        <!--<th style="text-transform: capitalize;">Rang</th>-->
                            <th style="text-transform: capitalize;">nom</th>
                            <th class="text-end" style="text-transform: capitalize;">Age</th>
                            
                            <th class="text-end" style="text-transform: capitalize;">V</th>
                            <th class="text-end" style="text-transform: capitalize;">N</th>
                            <th class="text-end" style="text-transform: capitalize;">D</th>
                            <th class="text-end" style="text-transform: capitalize;"><span class="desktop">Ippon</span><span class="mobile">Ip</span></th>
                            
                            <th class="text-end" style="text-transform: capitalize;"><span class="desktop">Waza-ari</span><span class="mobile">Wa</span></th>
                         
                            <th class="text-end" style="text-transform: capitalize;">Pts</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php
                       foreach ($datas as $d) {
                            if($d[0]['sexe']=='féminin' && $d[0]['age']<=23){?>
                                <tr>
                                    <!--<td><?php //echo $i;?></td>-->
                                    <td class="align-photo-nom-vertically"><img class="desktop" width="24px" height="24px" style="border-radius:40px" src="<?php echo ($d[0]['image'])?$d[0]['image']:''?>" alt=""><a href="<?php echo get_the_permalink($d[0]['judoka_id']);?>"><?php echo ($d[0]['nom'])?$d[0]['nom']:''?></a></td>
                                    <td class="wp-caption-text"><?php echo ($d[0]['age'])?$d[0]['age']:0?></td>
                                    
                                    <td class="wp-caption-text"><?php echo ($d[0]['matchs_v'])?$d[0]['matchs_v']:0?></td>
                                    <td class="wp-caption-text"><?php echo ($d[0]['matchs_nuls'])?$d[0]['matchs_nuls']:0?></td>
                                    <td class="wp-caption-text"><?php echo ($d[0]['matchs_d'])?$d[0]['matchs_d']:0?></td>
                                    <td class="wp-caption-text"><?php echo ($d[0]['ippons_marqués'])?$d[0]['ippons_marqués']:0?></td>
                                    <td class="wp-caption-text"><?php echo ($d[0]['wazaris_marqués'])?$d[0]['wazaris_marqués']:0?></td>
                                    <td class="wp-caption-text"><?php echo ($d[0]['points_judoka'])?$d[0]['points_judoka']:0?></td>
                                </tr>
                        <?php
                            }
                        } ?>
                    </tbody>
                </table>
            <?php  }?>
         </div>
     </section>
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
                 order: [[2, 'desc'],[5, 'desc'],[6, 'desc'],[7, 'desc']]
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
                 order: [[2, 'desc'],[5, 'desc'],[6, 'desc'],[7, 'desc']]
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
            order: [[2, 'desc'],[5, 'desc'],[6, 'desc'],[7, 'desc']]
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
                 order: [[2, 'desc'],[5, 'desc'],[6, 'desc'],[7, 'desc']]
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
            order: [[2, 'desc'],[5, 'desc'],[6, 'desc'],[7, 'desc']]
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
 <?php
 get_footer();