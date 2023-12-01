<?php
/**

 * Template Name: Modèle tableau principal

 */
get_header();
$args_quarts = array(		
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
	),		
    'meta_key' => 'date_de_debut',		
    'orderby' => 'meta_value_num',		
    'order' => 'DESC',			
);

$rencontres_quarts= get_posts($args_quarts);
?>
<?php
function display($rencontres){?>
    <?php if ($rencontres): ?>     
        <?php foreach ($rencontres as $rencontre):
            $combat=get_field('les_combat', $rencontre->ID)[0];
            $lieu=get_field('lieu_rencontre', $rencontre->ID);
            $equipe1 =get_field('equipe_1', $rencontre->ID)[0];
            $equipe2 =get_field('equipe_2', $rencontre->ID)[0];
            $rencontre_permalink = get_the_permalink($rencontre->ID);
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
            <div class="tp-4y-grid-content">
                <div class="cal-res-poule-blc">
                    <div class="header-cal-res-poule">
                        <span class="cal-res-poule-title"> <?php echo $lieu;?></span>
                        <span class="cal-res-poule-stat-tp <?php echo $class_status;?>"><?php echo $texte_status;?></span>
                    </div>
                    <div class="horaire-jr-tp" <?php if($texte_status=='terminé'){?>style="grid-template-columns: 100%; !important;"<?php }?>>
                        <div>
                            <div class="cal-res-poule-team <?php if($equipe_gagnante=='équipe 2'){echo "beaten";}?>">
                                <img src="<?php echo $image1_url;?>">
                                <h3 class="cal-res-poule-eqp-tp"><?php echo $equipe1->post_title;?></h3>
                                <span class="cal-res-poule-rs"><?php echo $score_equipe1;?></span>
                            </div>
                            <div class="cal-res-poule-team <?php if($equipe_gagnante=='équipe 1'){echo "beaten";}?> brd-none">
                                <img src="<?php echo $image2_url;?>">
                                <h3 class="cal-res-poule-eqp-tp "><?php echo $equipe2->post_title;?></h3>
                                <span class="cal-res-poule-rs"><?php echo $score_equipe2;?></span>
                            </div>
                        </div>
                        <div <?php if($texte_status=='terminé'){?>style="display:none !important;"<?php }?>>
                            <span class="cal-res-poule-title"><?php echo substr($date_debut,8,2).'/'.substr($date_debut,5,2);?></span>
                            <span class="cal-res-poule-title"><?php echo substr($date_debut,11,2).'h'.substr($date_debut,14,2);?></span>
                        </div>
                    </div>
                    <div class="cal-res-poule-link <?php echo $class_reservation;?>" <?php if(!$lien_live_ou_billet){?> style="grid-template-columns: repeat(1,1fr) !important;" <?php } ?> >
                        <?php echo $lien_live_ou_billet;?>
                        <a href="<?php echo $rencontre_permalink;?>" class="nv-link-crt">Détails</a>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    <?php endif;  
}?>



<main id="primary" class="site-main home">
    <section class="pd-5">
        <div class="judo_pro_league  mt-5p">
            <div class="phases-cl">
                <h2 class="tab-phase fs-30">
                    <a href="classement-judo-pro-league-2023/">
                        PHASE éliminatoire
                    </a>
                </h2>
                <h2 class="tab-phase tab-act fs-30">
                    <a href="tableau-principal-judo-pro-league-2023/">
                        tableau principal
                    </a>
                </h2>
            </div>
        </div>
        <div class="judo_pro_league">
            <div class="phases-finales">
                <h3 class="nv-tableau-final-subtitle tab-phase tab-act2 px-40">
                    
                        QUARTS DE FINALE
                    
                </h3>
                <h3 class="nv-tableau-final-subtitle tab-phase tab-act2 px-40">
                    
                        DEMI-FINALES
                    
                </h3>
                <h3 class="nv-tableau-final-subtitle tab-phase tab-act2 px-40">
                    
                        FINALE
                    
                </h3>
                
            </div>
        </div>
        <div class="judo_pro_league mtop-5">
            <div class="tp-3x-grid">
                <div class="tp-3x-grid-content">
                    <div class="tp-4y-grid">
                        
                        <?php display($rencontres_quarts);?>
                        
                        
                    </div>
                </div>
                <div class="tp-3x-grid-content">
                    <div class="tp-2y-grid">
                        <div class="tp-2y-grid-content">
                            <div class="cal-res-poule-blc">
                                <div class="header-cal-res-poule">
                                    <span class="cal-res-poule-title"> </span>
                                    <span class="cal-res-poule-stat-tp avenir">à venir</span>
                                </div>
                                <div class="horaire-jr-tp">
                                    <div>
                                        
                                        <div class="cal-res-poule-team ">
                                            <img src="/wp-content/uploads/2023/07/logo-sgs-judo_rouge-mini.png">
                                            <h3 class="cal-res-poule-eqp-tp">Sainte-Geneviève Sports Judo</h3>
                                        </div>
                                        <div class="cal-res-poule-team  brd-none">
                                            <h3 class="cal-res-poule-eqp-tp ">Vainqueur quart de finale 3</h3>
                                            <span class="cal-res-poule-rs"></span>
                                        </div>
                                    </div>
                                    <div>
                                        <span class="cal-res-poule-title">06/01</span>
                                        <span class="cal-res-poule-title">19:30</span>
                                    </div>
                                </div>
                                <div class="cal-res-poule-link link-2" style="grid-template-columns: repeat(1,1fr) !important;">
                                                            <a href="/rencontre/2023/quart-1/" class="nv-link-crt">Détails</a>
                                </div>
                            </div>
                        </div>
                        <div class="tp-2y-grid-content">
                        <div class="cal-res-poule-blc">
                                <div class="header-cal-res-poule">
                                    <span class="cal-res-poule-title"> </span>
                                    <span class="cal-res-poule-stat-tp avenir">à venir</span>
                                </div>
                                <div class="horaire-jr-tp">
                                    <div>
                                        <div class="cal-res-poule-team ">
                                            <img src="/wp-content/uploads/2023/07/logo-AM-ASNIERES-JUDO-92-mini.png">
                                            <h3 class="cal-res-poule-eqp-tp">AM Asnières Judo 92</h3>
                                        </div>
                                        <div class="cal-res-poule-team  brd-none">
                                            <h3 class="cal-res-poule-eqp-tp ">Vainqueur quart de finale 4</h3>
                                            <span class="cal-res-poule-rs"></span>
                                        </div>
                                    </div>
                                    <div>
                                        <span class="cal-res-poule-title">06/01</span>
                                        <span class="cal-res-poule-title">19:30</span>
                                    </div>
                                </div>
                                <div class="cal-res-poule-link link-2" style="grid-template-columns: repeat(1,1fr) !important;">
                                                            <a href="/rencontre/2023/quart-1/" class="nv-link-crt">Détails</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="tp-3x-grid-content">
                    <div class="tp-y-grid">
                        <div class="tp-y-grid-content">
                        <div class="cal-res-poule-blc">
                                <div class="header-cal-res-poule">
                                    <span class="cal-res-poule-title"> </span>
                                    <span class="cal-res-poule-stat-tp avenir">à venir</span>
                                </div>
                                <div class="horaire-jr-tp">
                                    <div>
                                        <div class="cal-res-poule-team ">
                                            <h3 class="cal-res-poule-eqp-tp">Vainqueur demi-finale 1</h3>
                                            <span class="cal-res-poule-rs"></span>
                                        </div>
                                        <div class="cal-res-poule-team  brd-none">
                                            <h3 class="cal-res-poule-eqp-tp ">Vainqueur demi-finale 2</h3>
                                            <span class="cal-res-poule-rs"></span>
                                        </div>
                                    </div>
                                    <div>
                                        <span class="cal-res-poule-title">06/01</span>
                                        <span class="cal-res-poule-title">20h00</span>
                                    </div>
                                </div>
                                <div class="cal-res-poule-link link-2" style="grid-template-columns: repeat(1,1fr) !important;">
                                                            <a href="/rencontre/2023/quart-1/" class="nv-link-crt">Détails</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
<?php
 get_footer();