<?php  
function display_rencontre_quarts($rencontres_quart_2,$quart){
    ?>
<?php if ($rencontres_quart_2): ?><div class="judo_pro_league">    
    <h2 class="crt-title"> Quart <?php echo $quart?></h2>    
    <?php $count=count($rencontres_quart_2);?>
    <div class="cal-res-poule" <?php if($count==1){?> style="grid-template-columns: repeat(1,1fr) !important; max-width: 450px;margin: 0 auto;" <?php }?>>        
    <?php foreach ($rencontres_quart_2 as $rencontre):            
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
                        <div <?php if($texte_status=='terminé'  || empty($date_debut)){?>style="display:none !important;"<?php }?>>
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
</div>
<?php endif;  ?>
    <?php 
}
?>


<?php



$now=date('Y/m/d H:i:s');

$saison_value=($_GET["saison_value"])?$_GET["saison_value"]:"2024-2025";



get_header();





$team_permalink = get_the_permalink($post->ID);





$args_quart_1 = array(		'post_type'=> 'rencontre',		'posts_per_page' => -1,'meta_query'     => array(  'relation' => 'and',   array(      'key'        => 'niveau',      'compare'    => '=',      'value'      => 'Quart de finale'    ),
        array(
            'key'        => 'saisons',
            'compare'    => 'LIKE',
            'value'      => $saison_value
        ),
		array(      
			'key'        => 'phase',      'compare'    => 'LIKE',      
			'value' => '"' . 1667 . '"',  
        ) ),		
        'meta_key' => 'date_de_debut',		'orderby' => 'meta_value_num',		'order' => 'DESC',			);





$args_quart_2 = array(		'post_type'=> 'rencontre',		'posts_per_page' => -1,'meta_query'     => array(  'relation' => 'and',   array(      'key'        => 'niveau',      'compare'    => '=',      'value'      => 'Quart de finale'    ),
        array(
            'key'        => 'saisons',
            'compare'    => 'LIKE',
            'value'      => $saison_value
        ),
		array(      
			'key'        => 'phase',      
            'compare'    => 'LIKE',      
			'value' => '"' . 1668 . '"',  
        ) ),		
        'meta_key' => 'date_de_debut',		'orderby' => 'meta_value_num',		'order' => 'DESC',			
    );





$args_quart_3 = array(		'post_type'=> 'rencontre',		'posts_per_page' => -1,'meta_query'     => array(  'relation' => 'and',   array(      'key'        => 'niveau',      'compare'    => '=',      'value'      => 'Quart de finale'    ),
        array(
            'key'        => 'saisons',
            'compare'    => 'LIKE',
            'value'      => $saison_value
        ),
        array(      
			'key'        => 'phase',      'compare'    => 'LIKE',      
			'value' => '"' . 1669 . '"',  
        ) ),		
        'meta_key' => 'date_de_debut',		'orderby' => 'meta_value_num',		'order' => 'DESC',			
    );





$args_quart_4 = array(		'post_type'=> 'rencontre',		'posts_per_page' => -1,'meta_query'     => array(  'relation' => 'and',   array(      'key'        => 'niveau',      'compare'    => '=',      'value'      => 'Quart de finale'    ),
        array(
            'key'        => 'saisons',
            'compare'    => 'LIKE',
            'value'      => $saison_value
        ),
        array(      
			'key'        => 'phase',      'compare'    => 'LIKE',      
			'value' => '"' . 1670 . '"',  
        ) ),		
        'meta_key' => 'date_de_debut',		'orderby' => 'meta_value_num',		'order' => 'DESC',			
    );











$rencontres_quart_1= get_posts($args_quart_1);





$rencontres_quart_2= get_posts($args_quart_2);





$rencontres_quart_3= get_posts($args_quart_3);





$rencontres_quart_4= get_posts($args_quart_4);





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

				</select>
			</form>
		</div>
        <div class="judo_pro_league">
        <h1 class="result-h1">Calendrier quarts de finale <?php echo $saison_value;?></h1>
            <div class="phases">
                <h2 class="tab-phase fs-30"><a href="<?php echo $team_permalink;?>poules">PHASE éliminatoire</a></h2>
                <h2 class="tab-phase fs-30 tab-act"><a href="<?php echo $team_permalink;?>quarts">quarts de finale</a></h2>
                <h2 class="tab-phase fs-30"><a href="<?php echo $team_permalink;?>final4">FINAL FOUR</a></h2>
            </div>
        </div>
        <div id="tabs" class="tabs-quarts">
            <ul style="display:none">
                <li><a href="#tabs-1" class="nv-journee">Q1</a></li>
                <li><a href="#tabs-2" class="nv-journee">Q2</a></li>
                <li><a href="#tabs-3" class="nv-journee">Q3</a></li>
                <li><a href="#tabs-4" class="nv-journee">Q4</a></li>
            </ul>
            <div id="tabs-1">
                
                <?php display_rencontre_quarts ($rencontres_quart_1,'1');?>
            </div>
            <div id="tabs-2">
                
                <?php display_rencontre_quarts ($rencontres_quart_2,'2');?>
            </div>
            <div id="tabs-3">
                
                <?php display_rencontre_quarts ($rencontres_quart_3,'3');?>
            </div>
            <div id="tabs-4">
                
                <?php display_rencontre_quarts ($rencontres_quart_4,'4');?>
            </div>
        </div>
    </section>
<?php
get_footer();
