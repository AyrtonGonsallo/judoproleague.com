<?php

get_header();

$now=date('Y/m/d H:i:s');

$team_permalink = get_the_permalink($post->ID);
$saison_value=($_GET["saison_value"])?$_GET["saison_value"]:"2026-2027";
$args_f4 = array(		
    'post_type'=> 'rencontre',		
    'posts_per_page' => -1,
    'meta_query'     => array(  
        'relation' => 'and',   
            array(      
                'key'        => 'niveau',
                'compare'    => '=',
                'value'      => 'Final four (Demi-finale)'    
            ),
            array(
                'key'        => 'saisons',
                'compare'    => 'LIKE',
                'value'      => $saison_value
            )),		
    'meta_key' => 'date_de_debut',		
    'orderby' => 'meta_value_num',		
    'order' => 'DESC',			
);
$rencontres_demies = get_posts($args_f4);

$args_f4f = array(		
    'post_type'=> 'rencontre',		
    'posts_per_page' => -1,
    'meta_query'     => array(  
        'relation' => 'and',   
            array(      
                'key'        => 'niveau',
                    'compare'    => '=',      
                    'value'      => 'Final four (Finale)'   
                    ),
            array(
                'key'        => 'saisons',
                'compare'    => 'LIKE',
                'value'      => $saison_value
            ),
		  ),		
    'meta_key' => 'date_de_debut',		
    'orderby' => 'meta_value_num',		
    'order' => 'DESC',			
);
$rencontre_f = get_posts($args_f4f);

?>
<script>
        $(document).ready(function() {
            $('#saison_value').change(function() {
                $('.season-selector-form').submit();
            });
        });
    </script>
<main id="primary" class="site-main home">

    <section>
        <div class="season-selector-box">
			<form Method="GET" ACTION="" class="season-selector-form">
                <select name="saison_value" id="saison_value" class="season-selector-select">
                    <option value="2021-2022" <?php echo ($saison_value=="2021-2022")?"selected":"";?>>2021-2022</option>
					<option value="2022-2023" <?php echo ($saison_value=="2022-2023")?"selected":"";?>>2022-2023</option>
					<option value="2023-2024" <?php echo ($saison_value=="2023-2024")?"selected":"";?>>2023-2024</option>
					<option value="2024-2025" <?php echo ($saison_value=="2024-2025")?"selected":"";?>>2024-2025</option>
                    <option value="2025-2026" <?php echo ($saison_value=="2025-2026")?"selected":"";?>>2025-2026</option>
                    <option value="2026-2027" <?php echo ($saison_value=="2026-2027")?"selected":"";?>>2026-2027</option>

				</select>
			</form>
		</div>
        <div class="judo_pro_league">
            <h1 class="result-h1">Calendrier final 4 <?php echo $saison_value;?></h1>
            <div class="phases">

                <h2 class="tab-phase fs-30">

                <a href="<?php echo $team_permalink;?>poules">

                    PHASE éliminatoire 

                </a>

                </h2>

                <h2 class="tab-phase fs-30">

                <a href="<?php echo $team_permalink;?>quarts">

                    quarts de finale

                </a>

                </h2>

                <h2 class="tab-phase fs-30 tab-act">

                <a href="<?php echo $team_permalink;?>final4">

                    FINAL FOUR

                </a>

                </h2>

            </div>

        </div>

        

    </section>

    <section class="pd-5">

        
        

                    <div class="judo_pro_league">
                        <h2 class="crt-title"> Demi-Finales</h2>    
                 
                        <?php if ($rencontres_demies): ?>
                            <?php $count=count($rencontres_demies);?>
                            <div class="cal-res-poule" style="grid-template-columns: repeat(2,1fr) !important;margin: 0 auto;"> 
                                <?php foreach ($rencontres_demies as $rencontre):

                                    $combat=get_field('les_combat', $rencontre->ID)[0];

                                    $lieu=get_field('lieu_rencontre', $rencontre->ID);

                                    $equipe1 =get_field('equipe_1', $rencontre->ID)[0];

                                    $equipe2 =get_field('equipe_2', $rencontre->ID)[0];

                                    $rencontre_permalink = get_the_permalink($rencontre->ID);
                                    
                                    $niveau=(get_field('niveau', $rencontre->ID));
                                    $score_equipe1 =$combat['nombre_de_combat_gagne_equipe_1'][0];

                                    $score_equipe2 =$combat['nombre_de_combat_gagne_equipe_2'][0];

                                    $image1_url=(get_field('logo_miniature', $equipe1->ID))?get_field('logo_miniature', $equipe1->ID):get_the_post_thumbnail_url($equipe1->ID);

                                    $image2_url=(get_field('logo_miniature', $equipe2->ID))?get_field('logo_miniature', $equipe2->ID):get_the_post_thumbnail_url($equipe2->ID);

                                    $date_debut=get_field('date_de_debut', $rencontre->ID, false, false);

                                    $date_fin=get_field('date_de_fin', $rencontre->ID, false, false);

                                    $abreviation1=(get_field('abreviation', $equipe1->ID))?get_field('abreviation', $equipe1->ID):$equipe1->post_title;

                                    $abreviation2=(get_field('abreviation', $equipe2->ID))?get_field('abreviation', $equipe2->ID):$equipe2->post_title;

                                    $statut=get_field('statut', $rencontre->ID)['label'];

                            if($statut=='en cours'){

                                $class_status='encours';
                                $equipe_gagnante =  'inconnue';

                                $texte_status='en cours';

                                $class_reservation="link-2";

                                $lien_live_ou_billet='<a href="'.get_field('video_live', $rencontre->ID).'"  target="_blank" class="nv-link-crt brd-right">Live</a>';

                            }else if($statut=='terminé'){

                                $equipe_gagnante =  $combat['equipe_gagnante'];
                                $class_status='terminer';

                                $texte_status='terminé';

                                $class_reservation="";

                                $lien_live_ou_billet="";

                            }

                            else if($statut=="à venir"){

                                $class_status='avenir';
                                $equipe_gagnante =  'inconnue';

                                $texte_status='à venir';

                                $class_reservation="link-2";

                                $lien_live_ou_billet=(get_field("lien_de_reservation", $rencontre->ID))?'<a href="'.get_field("lien_de_reservation", $rencontre->ID).'" target="_blank" class="nv-link-crt brd-right">Billetterie</a>':'';

                            }

                                    ?>
                                    
                                        <div class="cal-res-poule-blc">

                                            <div class="header-cal-res-poule">

                                                <span class="cal-res-poule-title"><?php echo $lieu;?></span>

                                                <span class="cal-res-poule-stat <?php echo $class_status;?>"><?php echo $texte_status;?></span>

                                            </div>                                        <div class="horaire-jr" <?php if($texte_status=='terminé'){?>style="grid-template-columns: 100% !important;"<?php }?>>
                                                <div>
                                                    <div class="cal-res-poule-team <?php if($equipe_gagnante=='équipe 2'){echo "beaten";}?>">
                                                        <img src="<?php echo $image1_url;?>">
                                                        <h3 class="cal-res-poule-eqp"><?php echo $equipe1->post_title;?></h3>
                                                        <span class="cal-res-poule-rs"><?php echo $score_equipe1;?></span>
                                                    </div>
                                                    <div class="cal-res-poule-team <?php if($equipe_gagnante=='équipe 1'){echo "beaten";}?> brd-none">
                                                        <img src="<?php echo $image2_url;?>">
                                                        <h3 class="cal-res-poule-eqp "><?php echo $equipe2->post_title;?></h3>
                                                        <span class="cal-res-poule-rs"><?php echo $score_equipe2;?></span>
                                                    </div>
                                                </div>
                                                <div <?php if($texte_status=='terminé'){?>style="display:none !important;"<?php }?>>
                                                    <span class="cal-res-poule-title"><?php echo substr($date_debut,8,2).'/'.substr($date_debut,5,2);?></span>
                                                    <span class="cal-res-poule-title"><?php echo substr($date_debut,11,2).'h'.substr($date_debut,14,2);?></span>
                                                </div>
                                            </div>

                                            <div class="cal-res-poule-link <?php echo $class_reservation;?>" <?php if($lien_live_ou_billet){?> style="" <?php } ?> >

                                                <?php echo $lien_live_ou_billet;?>

                                                <a href="<?php echo $rencontre_permalink;?>" class="nv-link-crt">Détails <i class="fa-solid fa-angles-right"></i></a>

                                            </div>

                                        </div>

                                <?php endforeach; ?>

                            </div>

                        <?php else:
                            $saison_value2="2025-2026";
                            $args2=array(
                                'post_type'=> 'rencontre',
                                'posts_per_page' => -1,
                                'meta_query'     => 
                                array(  
                                    'relation' => 'and',   
                                    array(      
                                        'key'        => 'niveau',      
                                        'compare'    => '=',      
                                        'value'      => 'Quart de finale'
                                        ),
                                    array(
                                        'key'        => 'saisons',
                                        'compare'    => 'LIKE',
                                        'value'      => $saison_value
                                    ),
                                ),		
                                 'orderby' => 'post_title',
                                'order' => 'ASC',   
                            );
                            $rencontres2=get_posts($args2);
                            $winers = []; 
                            $i=1;
                            foreach ($rencontres2 as $rencontre):
                                $combat=get_field('les_combat', $rencontre->ID)[0]; 
                                $equipe1 =get_field('equipe_1', $rencontre->ID)[0];
                                $equipe2 =get_field('equipe_2', $rencontre->ID)[0];
                            
                                $image1_url=(get_field('logo_miniature', $equipe1->ID))?get_field('logo_miniature', $equipe1->ID):get_the_post_thumbnail_url($equipe1->ID);
                                $image2_url=(get_field('logo_miniature', $equipe2->ID))?get_field('logo_miniature', $equipe2->ID):get_the_post_thumbnail_url($equipe2->ID);
                            
                                $abreviation1=(get_field('abreviation', $equipe1->ID))?get_field('abreviation', $equipe1->ID):$equipe1->post_title;
                                $abreviation2=(get_field('abreviation', $equipe2->ID))?get_field('abreviation', $equipe2->ID):$equipe2->post_title;
                                $equipe_gagnante =  $combat['equipe_gagnante'];
                                if($equipe_gagnante=='équipe 1'){
                                    $winers[] = [            
                                        'nom'   => $equipe1->post_title,
                                        'image' => $image1_url,           
                                    ];
                                }
                                else if($equipe_gagnante=='équipe 2'){
                                    $winers[] = [            
                                        'nom'   => $equipe2->post_title,
                                        'image' => $image2_url,          
                                    ]; 
                                }
                                else{
                                    $winers[] = [            
                                        'nom'   => "Vainqueur QF $i",
                                        'image' => "https://judoproleague.com/wp-content/uploads/2024/08/unknown.png",          
                                    ];
                                }
                                $i+=1;
                            endforeach;
                            
                            ?>
                            <div class="cal-res-poule" style="grid-template-columns: repeat(2,1fr) !important;margin: 0 auto;"> 
                                <?php 
                                    $demiFinales = [
                                        [$winers[0], $winers[3]], // QF1 vs QF4
                                        [$winers[1], $winers[2]]  // QF2 vs QF3
                                    ];

                                    foreach ($demiFinales as $match) {
                                        $teamA = $match[0];
                                        $teamB = $match[1];
                                ?> 

                                    <div class="cal-res-poule-blc">

                                            <div class="header-cal-res-poule">

                                                <span class="cal-res-poule-title"></span>

                                                <span class="cal-res-poule-stat avenir">à venir</span>

                                            </div>                                        
                                            <div class="horaire-jr" >
                                                <div>
                                                    <div class="cal-res-poule-team ">
                                                        <img src="<?= esc_url($teamA['image']); ?>">
                                                        <h3 class="cal-res-poule-eqp"><?php echo esc_html($teamA['nom']); ?></h3>
                                                        <span class="cal-res-poule-rs"></span>
                                                    </div>
                                                    <div class="cal-res-poule-team  brd-none">
                                                        <img src="<?= esc_url($teamB['image']); ?>">
                                                        <h3 class="cal-res-poule-eqp "><?php echo esc_html($teamB['nom']); ?></h3>
                                                        <span class="cal-res-poule-rs"></span>
                                                    </div>
                                                </div>
                                            </div>

                                           

                                        </div>
                                <?php } ?>
                                </div>
                        <?php endif;  ?>

                        

                    </div>
        
        <div id="tabs" class="tabs-quarts">   
            
            <?php if ($rencontre_f): ?>

                    <div class="judo_pro_league">

                        
                    <h2 class="crt-title"> Finale</h2>    
                        
        
                    <div class="cal-res-poule" style=" max-width: 450px;margin: 0 auto;">       
                        <?php foreach ($rencontre_f as $rencontre):

                            $combat=get_field('les_combat', $rencontre->ID)[0];

                            $lieu=get_field('lieu_rencontre', $rencontre->ID);

                            $equipe1 =get_field('equipe_1', $rencontre->ID)[0];

                            $equipe2 =get_field('equipe_2', $rencontre->ID)[0];

                            $rencontre_permalink = get_the_permalink($rencontre->ID);
                            
                            $niveau=(get_field('niveau', $rencontre->ID));
                            $score_equipe1 =$combat['nombre_de_combat_gagne_equipe_1'][0];

                            $score_equipe2 =$combat['nombre_de_combat_gagne_equipe_2'][0];

                            $image1_url=(get_field('logo_miniature', $equipe1->ID))?get_field('logo_miniature', $equipe1->ID):get_the_post_thumbnail_url($equipe1->ID);

                            $image2_url=(get_field('logo_miniature', $equipe2->ID))?get_field('logo_miniature', $equipe2->ID):get_the_post_thumbnail_url($equipe2->ID);

                            $date_debut=get_field('date_de_debut', $rencontre->ID, false, false);

                            $date_fin=get_field('date_de_fin', $rencontre->ID, false, false);

                            $abreviation1=(get_field('abreviation', $equipe1->ID))?get_field('abreviation', $equipe1->ID):$equipe1->post_title;

                            $abreviation2=(get_field('abreviation', $equipe2->ID))?get_field('abreviation', $equipe2->ID):$equipe2->post_title;

                            $statut=get_field('statut', $rencontre->ID)['label'];

                    if($statut=='en cours'){

                        $class_status='encours';
                        $equipe_gagnante =  'inconnue';

                        $texte_status='en cours';

                        $class_reservation="link-2";

                        $lien_live_ou_billet='<a href="'.get_field('video_live', $rencontre->ID).'"  target="_blank" class="nv-link-crt brd-right">Live</a>';

                    }else if($statut=='terminé'){

                        $equipe_gagnante =  $combat['equipe_gagnante'];
                        $class_status='terminer';

                        $texte_status='terminé';

                        $class_reservation="";

                        $lien_live_ou_billet="";

                    }

                    else if($statut=="à venir"){

                        $class_status='avenir';
                        $equipe_gagnante =  'inconnue';

                        $texte_status='à venir';

                        $class_reservation="link-2";

                        $lien_live_ou_billet=(get_field("lien_de_reservation", $rencontre->ID))?'<a href="'.get_field("lien_de_reservation", $rencontre->ID).'" target="_blank" class="nv-link-crt brd-right">Billetterie</a>':'';

                    }

                            ?>
                            
                                <div class="cal-res-poule-blc">

                                    <div class="header-cal-res-poule">

                                        <span class="cal-res-poule-title"><?php echo $lieu;?></span>

                                        <span class="cal-res-poule-stat <?php echo $class_status;?>"><?php echo $texte_status;?></span>

                                    </div>                                        <div class="horaire-jr" <?php if($texte_status=='terminé'){?>style="grid-template-columns: 100% !important;"<?php }?>>
                                        <div>
                                            <div class="cal-res-poule-team <?php if($equipe_gagnante=='équipe 2'){echo "beaten";}?>">
                                                <img src="<?php echo $image1_url;?>">
                                                <h3 class="cal-res-poule-eqp"><?php echo $equipe1->post_title;?></h3>
                                                <span class="cal-res-poule-rs"><?php echo $score_equipe1;?></span>
                                            </div>
                                            <div class="cal-res-poule-team <?php if($equipe_gagnante=='équipe 1'){echo "beaten";}?> brd-none">
                                                <img src="<?php echo $image2_url;?>">
                                                <h3 class="cal-res-poule-eqp "><?php echo $equipe2->post_title;?></h3>
                                                <span class="cal-res-poule-rs"><?php echo $score_equipe2;?></span>
                                            </div>
                                        </div>
                                        <div <?php if($texte_status=='terminé'){?>style="display:none !important;"<?php }?>>
                                                <span class="cal-res-poule-title"><?php echo substr($date_debut,8,2).'/'.substr($date_debut,5,2);?></span>
                                                <span class="cal-res-poule-title"><?php echo substr($date_debut,11,2).'h'.substr($date_debut,14,2);?></span>
                                            </div>
                                    </div>

                                    <div class="cal-res-poule-link <?php echo $class_reservation;?>" <?php if($lien_live_ou_billet){?>  <?php } ?> >

                                        <?php echo $lien_live_ou_billet;?>

                                        <a href="<?php echo $rencontre_permalink;?>" class="nv-link-crt">Détails <i class="fa-solid fa-angles-right"></i></a>

                                    </div>

                                </div>

                        <?php endforeach; ?>

                    </div>

                    

                </div>

            <?php else:
                $saison_value2="2025-2026";
                $args2=array(
                    'post_type'=> 'rencontre',
                    'posts_per_page' => -1,
                    'meta_query'     => 
                    array(  
                        'relation' => 'and',   
                        array(      
                            'key'        => 'niveau',      
                            'compare'    => 'LIKE',      
                            'value'      => 'Demi'
                            ),
                        array(
                            'key'        => 'saisons',
                            'compare'    => 'LIKE',
                            'value'      => $saison_value
                        ),
                    ),		
                        'orderby' => 'post_title',
                    'order' => 'ASC',   
                );
                $rencontres2=get_posts($args2);
                $winers = []; 
                $i=1;
                foreach ($rencontres2 as $rencontre):
                    $combat=get_field('les_combat', $rencontre->ID)[0]; 
                    $equipe1 =get_field('equipe_1', $rencontre->ID)[0];
                    $equipe2 =get_field('equipe_2', $rencontre->ID)[0];
                
                    $image1_url=(get_field('logo_miniature', $equipe1->ID))?get_field('logo_miniature', $equipe1->ID):get_the_post_thumbnail_url($equipe1->ID);
                    $image2_url=(get_field('logo_miniature', $equipe2->ID))?get_field('logo_miniature', $equipe2->ID):get_the_post_thumbnail_url($equipe2->ID);
                
                    $abreviation1=(get_field('abreviation', $equipe1->ID))?get_field('abreviation', $equipe1->ID):$equipe1->post_title;
                    $abreviation2=(get_field('abreviation', $equipe2->ID))?get_field('abreviation', $equipe2->ID):$equipe2->post_title;
                    $equipe_gagnante =  $combat['equipe_gagnante'];
                    if($equipe_gagnante=='équipe 1'){
                        $winers[] = [            
                            'nom'   => $equipe1->post_title,
                            'image' => $image1_url,           
                        ];
                    }
                    else if($equipe_gagnante=='équipe 2'){
                        $winers[] = [            
                            'nom'   => $equipe2->post_title,
                            'image' => $image2_url,          
                        ]; 
                    }
                    else{
                        $winers[] = [            
                            'nom'   => "Vainqueur DF $i",
                            'image' => "https://judoproleague.com/wp-content/uploads/2024/08/unknown.png",          
                        ];
                    }
                    $i+=1;
                endforeach;
                
                ?>
                    <div class="cal-res-poule" style="grid-template-columns: repeat(1,1fr) !important; max-width: 450px;margin: 0 auto;">       
                    <?php 
                        $demiFinales = [
                            [$winers[0], $winers[1]], // QF1 vs QF4
                        ];

                        foreach ($demiFinales as $match) {
                            $teamA = $match[0];
                            $teamB = $match[1];
                    ?> 

                        <div class="cal-res-poule-blc">

                                <div class="header-cal-res-poule">

                                    <span class="cal-res-poule-title">Dojo de Paris (75)</span>

                                    <span class="cal-res-poule-stat avenir">à venir</span>

                                </div>                                        
                                <div class="horaire-jr" >
                                    <div>
                                        <div class="cal-res-poule-team ">
                                            <img src="<?= esc_url($teamA['image']); ?>">
                                            <h3 class="cal-res-poule-eqp"><?php echo esc_html($teamA['nom']); ?></h3>
                                            <span class="cal-res-poule-rs"></span>
                                        </div>
                                        <div class="cal-res-poule-team  brd-none">
                                            <img src="<?= esc_url($teamB['image']); ?>">
                                            <h3 class="cal-res-poule-eqp "><?php echo esc_html($teamB['nom']); ?></h3>
                                            <span class="cal-res-poule-rs"></span>
                                        </div>
                                    </div>
                                </div>

                                

                            </div>
                    <?php } ?>
                    </div>
            <?php endif;  ?>
            
            
        </div>

    </section>
<?php

get_footer();

