<?php  



function display_rencontre_journee_poule($rencontres_j2_pouleB,$poule){
    ?>
<?php if ($rencontres_j2_pouleB): ?><div class="judo_pro_league">    
    <h2 class="crt-title">Poule <?php echo $poule?></h2>    
    <a href="/classement-judo-pro-league-2023/phase-eliminatoire/poule-<?php echo $poule?>/" class="more-classement">Classement Poule <?php echo $poule?> <i class="fa-solid fa-arrow-right-long"></i> </a>

    <?php $count=count($rencontres_j2_pouleB);?>
    <div class="cal-res-poule" <?php if($count==1){?> style="grid-template-columns: repeat(1,1fr) !important; max-width: 450px;margin: 0 auto;" <?php }?>>        
    <?php foreach ($rencontres_j2_pouleB as $rencontre):            
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
        $lien_live_ou_billet='<a href="'.get_field('video_live', $rencontre->ID).'"  target="_blank" class="nv-link-crt brd-right">Live</a>';    }
    else if($statut=='terminé'){        
        $equipe_gagnante =  ($combat)?$combat['equipe_gagnante']:'inconnue';
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
                    </div>
                    <div class="horaire-jr" <?php if($texte_status=='terminé'){?>style="grid-template-columns: 100% !important;"<?php }?>>
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
                    <div class="cal-res-poule-link <?php echo $class_reservation;?>">
                        <?php echo $lien_live_ou_billet;?>
                        <a href="<?php echo $rencontre_permalink;?>" class="nv-link-crt">Détails <i class="fa-solid fa-angles-right"></i></a>
                    </div>
                </div>
        <?php endforeach; ?>
    </div>
    <div>
    </div>
</div>
<?php endif;  ?>
    <?php 
}
?>

<?php

$now=date('Y/m/d H:i:s');
get_header();
$saison_value=($_GET["saison_value"])?$_GET["saison_value"]:"2023-2024";
$page_permalink = get_the_permalink($post->ID);

function get_rencontres($poule_id,$journee,$saison_value){
    $args = array(		
        'post_type'=> 'rencontre',		
        'posts_per_page' => -1,
        'meta_query'     => array(  
            'relation' => 'and',   
            array(      
                'key'        => 'niveau',      
                'compare'    => '=',      
                'value'      => 'Phase de poules'
                ),
           
            array(
                'key'        => 'saisons',
                'compare'    => 'LIKE',
                'value'      => $saison_value
            ),
            array(
                'key'        => 'journee',      
                'compare'    => 'LIKE',      
                'value'      => 'Journée '.$journee, 
            )  
        ),		
        'meta_key' => 'date_de_debut',		
        'orderby' => 'meta_value_num',		
        'order' => 'DESC',			
    );
    return get_posts($args);
}

$rencontres_j1_pouleA =get_rencontres(488,'1',$saison_value);

$rencontres_j2_pouleA =get_rencontres(488,'2',$saison_value);

$rencontres_j3_pouleA =get_rencontres(488,'3',$saison_value);

$rencontres_j4_pouleA =get_rencontres(488,'4',$saison_value);

$rencontres_j5_pouleA =get_rencontres(488,'5',$saison_value);

$rencontres_j6_pouleA =get_rencontres(488,'6',$saison_value);

// ---------  fin - journée



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
					<option value="2021-2022" >2021-2022</option>
					<option value="2022-2023" >2022-2023</option>
					<option value="2023-2024" >2023-2024</option>
                    <option value="2023-2024" selected>2024-2025</option>
				</select>
			</form>
		</div>


        <div class="judo_pro_league">



            <div class="phases">



                <h2 class="tab-phase tab-act">



                <a href="<?php echo $page_permalink;?>poules" class="fs-30">



                    PHASE éliminatoire 



                </a>



                </h2>



                <h2 class="tab-phase">



                <a href="<?php echo $page_permalink;?>quarts" class="fs-30">



                    quarts de finale



                </a>



                </h2>



                <h2 class="tab-phase">



                <a href="<?php echo $page_permalink;?>final4" class="fs-30">



                    FINAL FOUR



                </a>



                </h2>



            </div>



        </div>



        <div id="tabs" class="tabs-poules">



            <ul>



                <li><a href="#tabs-1" class="nv-journee">J1</a></li>



                <li><a href="#tabs-2" class="nv-journee">J2</a></li>



                <li><a href="#tabs-3" class="nv-journee">J3</a></li>



                <li><a href="#tabs-4" class="nv-journee">J4</a></li>



                <li><a href="#tabs-5" class="nv-journee">J5</a></li>



                <li><a href="#tabs-6" class="nv-journee">J6</a></li>



            </ul>



            <div id="tabs-1">
                <?php display_rencontre_journee_poule($rencontres_j1_pouleA,'A');?>
            </div>
            <div id="tabs-2">
                <?php display_rencontre_journee_poule($rencontres_j2_pouleA,'A');?>
            </div>
            <div id="tabs-3">
                <?php display_rencontre_journee_poule($rencontres_j3_pouleA,'A');?>
            </div>
            <div id="tabs-4">
                <?php display_rencontre_journee_poule($rencontres_j4_pouleA,'A');?>
            </div>
            <div id="tabs-5">
                <?php display_rencontre_journee_poule($rencontres_j5_pouleA,'A');?>
            </div>
            <div id="tabs-6">
                <?php display_rencontre_journee_poule($rencontres_j6_pouleA,'A');?>
               
            </div>
        </div>



</div>



    </section>






<?php



get_footer();



