<?php
/**

 * Template Name: Modèle tableau principal 2024

 */
get_header();
$saison_value=($_GET["saison_value"])?$_GET["saison_value"]:"2025-2026";
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

$rencontres_quarts= get_posts($args_quarts);

$args_demies = array(		
    'post_type'=> 'rencontre',		
    'posts_per_page' => -1,
    'meta_query'     => 
    array(  
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
        ),
	),		
    'meta_key' => 'date_de_debut',		
    'orderby' => 'meta_value_num',		
    'order' => 'DESC',			
);

$rencontres_demies= get_posts($args_demies);

$args_f = array(		
    'post_type'=> 'rencontre',		
    'posts_per_page' => -1,
    'meta_query'     => 
    array(  
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

$rencontre_f= get_posts($args_f);
?>
<?php
function display($rencontres,$fake=false){?>
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
            $niveau=(get_field('niveau', $rencontre->ID));
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
                        <div <?php if($texte_status=='terminé' || empty($date_debut)){?>style="display:none !important;"<?php }?>>
                            <span class="cal-res-poule-title"><?php echo substr($date_debut,8,2).'/'.substr($date_debut,5,2);?></span>
                            <span class="cal-res-poule-title"><?php  echo substr($date_debut,11,2).'h'.substr($date_debut,14,2);?></span>
                        </div>
                    </div>
                    <div class="cal-res-poule-link <?php echo $class_reservation;?>" <?php if(!$lien_live_ou_billet){?> style="grid-template-columns: repeat(1,1fr) !important;" <?php } ?> >
                        <?php echo $lien_live_ou_billet;?>
                        <a href="<?php echo $rencontre_permalink;?>" class="nv-link-crt">Détails <i class="fa-solid fa-angles-right"></i></a>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    <?php endif; 
    if (!$rencontres && $fake ): 
        $saison_value2="2025-2026";
        $args2=array(
            'post_type'=> 'rencontre',
            'posts_per_page' => -1,
            'meta_query'     => 
            array(  
                array(
                    'key'        => 'saisons',
                    'compare'    => 'LIKE',
                    'value'      => $saison_value2
                )
            ),		
            'meta_key' => 'date_de_debut',
            'orderby' => 'meta_value_num',
            'order' => 'DESC',  
        );
        $rencontres2=get_posts($args2);
        require_once (THEMEDIR.'template-parts/content-judokas-requests-stats-home.php');
        $classement_equipes2=get_classement($rencontres2,$saison_value2,50);
        $top8_raw = array_slice($classement_equipes2, 0, 8);

        $top8 = []; // tableau propre et réutilisable

        foreach ($top8_raw as $index => $d) {
            $top8[] = [            // 1 à 8
                'nom'   => $d[0]['nom'],
                'image' => $d[0]['image'],
                'data'  => $d[0],                   // optionnel : tout garder
            ];
        }
        $quarts = [
            [$top8[0], $top8[7]], // 1er vs 8e
            [$top8[3], $top8[4]], // 4e vs 5e
            [$top8[1], $top8[6]], // 2e vs 7e
            [$top8[2], $top8[5]], // 3e vs 6e
            
        ];

    ?> 
    
        <?php for ($i = 0; $i < 4; $i++): 
            $teamA = $quarts[$i][0];
            $teamB = $quarts[$i][1];
        ?>
            <div class="tp-4y-grid-content">
                <div class="cal-res-poule-blc">
                    <div class="header-cal-res-poule">
                        <span class="cal-res-poule-title"></span>
                        <span class="cal-res-poule-stat avenir">à venir</span>
                    </div>

                    <div class="horaire-jr">
                        <div>
                            <div class="cal-res-poule-team">
                                <img src="<?= esc_url($teamA['image']); ?>">
                                <h3 class="cal-res-poule-eqp"><?= esc_html($teamA['nom']); ?></h3>
                                <span class="cal-res-poule-rs"></span>
                            </div>

                            <div class="cal-res-poule-team brd-none">
                                <img src="<?= esc_url($teamB['image']); ?>">
                                <h3 class="cal-res-poule-eqp"><?= esc_html($teamB['nom']); ?></h3>
                                <span class="cal-res-poule-rs"></span>
                            </div>
                        </div>

                        <div>
                            <span class="cal-res-poule-title"></span>
                            <span class="cal-res-poule-title"></span>
                        </div>
                    </div>

                    <div class="cal-res-poule-link link-2">
                        <a href="#" class="nv-link-crt brd-right">Billetterie</a>
                        <a href="#" class="nv-link-crt">Détails <i class="fa-solid fa-angles-right"></i></a>
                    </div>
                </div>
            </div>
        <?php endfor; ?>

     
    <?php endif; 
}?>


<script>
        $(document).ready(function() {
            $('#saison_value').change(function() {
                $('.season-selector-form').submit();
            });
        });
    </script>

<main id="primary" class="site-main home">
    <section class="pd-5">
    <div class="season-selector-box">
			<form Method="GET" ACTION="" class="season-selector-form">
				<select name="saison_value" id="saison_value" class="season-selector-select">
					<option value="2022-2023" <?php echo ($saison_value=="2022-2023")?"selected":"";?>>2022-2023</option>
					<option value="2023-2024" <?php echo ($saison_value=="2023-2024")?"selected":"";?>>2023-2024</option>
                    <option value="2024-2025" <?php echo ($saison_value=="2024-2025")?"selected":"";?>>2024-2025</option>
                    <option value="2025-2026" <?php echo ($saison_value=="2025-2026")?"selected":"";?>>2025-2026</option>
				</select>
			</form>
		</div>


        <div class="judo_pro_league  mt-5p">
            <div class="phases-cl">
                <h2 class="tab-phase fs-30">
                    <a href="classement-judo-pro-league/">
                        PHASE éliminatoire
                    </a>
                </h2>
                <h2 class="tab-phase tab-act fs-30">
                    <a href="tableau-principal-judo-pro-league/">
                        tableau principal
                    </a>
                </h2>
            </div>
        </div>

        <div class="judo_pro_league mtop-5 tab-princ-23">
            <h1 class="result-h1">tableau principal Judo Pro League <?php echo $saison_value;?></h1>
            <?php if($saison_value=="2025-2026"){
                setlocale(LC_TIME, 'fr_FR.UTF-8');
            ?>
            <p class="page-result-desc" style="text-align:center">Les affiches correspondent au classement du <?php echo strftime('%d %B %Y');?>. Elles ne seront considérées comme définitives qu'après la dernière rencontre de la 4ème journée. </p>
            <?php }?>
            <div class="tp-3x-grid">

                <div class="tp-3x-grid-content">
                    <h3 class="nv-tableau-final-subtitle tab-phase tab-act2 px-40 title-mobile">QUARTS DE FINALE</h3>

                    <div class="tp-4y-grid">
                        
                        <?php display($rencontres_quarts,true);?>

                        
                        
                    </div>
                </div>
                <div class="tp-3x-grid-content">
                    <h3 class="nv-tableau-final-subtitle tab-phase tab-act2 px-40 title-mobile">DEMI-FINALES</h3>

                    <div class="tp-2y-grid">
                        <?php display($rencontres_demies);?>
                        
                        
                    </div>
                </div>
                <div class="tp-3x-grid-content">
                    <h3 class="nv-tableau-final-subtitle tab-phase tab-act2 px-40 title-mobile">FINALE </h3>

                    <div class="tp-y-grid">
                        <?php display($rencontre_f);?>
                        
                        
                    </div>
                </div>
                
            </div>
        </div>







    </section>
<?php
 get_footer();