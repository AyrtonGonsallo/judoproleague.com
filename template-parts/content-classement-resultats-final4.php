<?php

get_header();

$now=date('Y/m/d H:i:s');

$team_permalink = get_the_permalink($post->ID);
$page_permalink = get_the_permalink($post->ID);
$saison_value=($_GET["saison_value"])?$_GET["saison_value"]:"2026-2027";
$saison_param = isset($_GET['saison_value'])
    ? '?saison_value=' . urlencode($_GET['saison_value'])
    : '';
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














    

<main id="primary" class="site-main home result-24 jpl-calendrier" style="padding: 3% 2% 5%;background: #F5F7FB;">

    <section class="">
        
		<div class="jpl-stats-hero">	
            <span class="jpl-stats-eyebrow" style="text-align:center;">JUDO PRO LEAGUE </span>
            <h1 style="text-align:center;">Calendrier quarts de finale <?php echo $saison_value;?></h1>
		</div>
		<div class="jpl-calend-card">
            <div class="jpl-teams-header">
                <div class="jpl-stats-tabs">
                    
                    <a href="<?php echo $page_permalink;?>poules/<?php echo $saison_param; ?>" class="jpl-stats-tab">
                        <span>Phase éliminatoire </span>
                    </a>
                                
                    <a <?php if ($saison_value != "2026-2027") {
                        echo 'href="' . $page_permalink . 'quarts/'.$saison_param.'"';
                    } ?> class="jpl-stats-tab">
                        <span>Quarts de finale</span>
                    </a>

                    <a <?php if ($saison_value != "2026-2027") {
                        echo 'href="' . $page_permalink . 'final4/'.$saison_param.'"';
                    } ?> class="jpl-stats-tab active">
                        <span>Final four</span>
                    </a>
                    
                </div>
                    
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
            </div>

            
            <section class="pd-5">

        
        

                    <div class="judo_pro_league">
                         
                 
                        <?php if ($rencontres_demies): ?>
                            <h2 class="crt-title"> Demi-Finales</h2>   
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

                                    $image1_url=(get_field('logo_principal', $equipe1->ID))?get_field('logo_principal', $equipe1->ID):get_the_post_thumbnail_url($equipe1->ID);

                                    $image2_url=(get_field('logo_principal', $equipe2->ID))?get_field('logo_principal', $equipe2->ID):get_the_post_thumbnail_url($equipe2->ID);

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
                                    
                                        <div class="cal-res-poule-blc" <?php echo ($statut == 'en cours') ? 'match-live' : ''; ?>">

                                            <div class="header-cal-res-poule">

                                                <span class="cal-res-poule-title"><?php echo $lieu;?></span>
                                                <div class="cal-res-poule-link <?php echo $class_reservation;?>">
                                                    <?php echo $lien_live_ou_billet;?>
                                                    <a href="<?php echo $rencontre_permalink;?>" class="nv-link-crt">
                                                        <!-- <img src="/wp-content/uploads/2026/09/Vector-3.svg"/> -->
                                                        <i class="fas fa-arrow-right"></i>
                                                    </a>
                                                </div>
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

                                            

                                        </div>

                                <?php endforeach; ?>

                            </div>

                        
                        <?php endif;  ?>

                        

                    </div>
        
        <div id="tabs" class="tabs-quarts">   
            
            <?php if ($rencontre_f): ?>

                    <div class="judo_pro_league">

                        
                    <h2 class="crt-title"> Finale</h2>    
                        
        
                    <div class="cal-res-poule" style=" margin: 0 auto;">       
                        <?php foreach ($rencontre_f as $rencontre):

                            $combat=get_field('les_combat', $rencontre->ID)[0];

                            $lieu=get_field('lieu_rencontre', $rencontre->ID);

                            $equipe1 =get_field('equipe_1', $rencontre->ID)[0];

                            $equipe2 =get_field('equipe_2', $rencontre->ID)[0];

                            $rencontre_permalink = get_the_permalink($rencontre->ID);
                            
                            $niveau=(get_field('niveau', $rencontre->ID));
                            $score_equipe1 =$combat['nombre_de_combat_gagne_equipe_1'][0];

                            $score_equipe2 =$combat['nombre_de_combat_gagne_equipe_2'][0];

                            $image1_url=(get_field('logo_principal', $equipe1->ID))?get_field('logo_principal', $equipe1->ID):get_the_post_thumbnail_url($equipe1->ID);

                            $image2_url=(get_field('logo_principal', $equipe2->ID))?get_field('logo_principal', $equipe2->ID):get_the_post_thumbnail_url($equipe2->ID);

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
                            
                                <div class="cal-res-poule-blc <?php echo ($statut == 'en cours') ? 'match-live' : ''; ?>">

                                    <div class="header-cal-res-poule">

                                        <span class="cal-res-poule-title"><?php echo $lieu;?></span>

                                        <div class="cal-res-poule-link <?php echo $class_reservation;?>">
                                            <?php echo $lien_live_ou_billet;?>
                                            <a href="<?php echo $rencontre_permalink;?>" class="nv-link-crt">
                                                <!-- <img src="/wp-content/uploads/2026/09/Vector-3.svg"/> -->
                                                <i class="fas fa-arrow-right"></i>
                                            </a>
                                        </div>
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

                                   

                                </div>

                        <?php endforeach; ?>

                    </div>

                    

                </div>

            
            <?php endif;  ?>
            
            
        </div>

    </section>

        </div>

    </section>



<style>
.jpl-calend-card{	
	width: min(1026px, calc(100% - 40px));
    margin-left: auto;
    margin-right: auto;
    overflow: hidden;
    border-radius: 22px;
    border: 2px solid var(--jpl-purple-principal);
    box-shadow: 0 15px 45px rgba(15, 25, 80, .065);
    background: #fff;
    padding: 1%;
    margin-top: 3%;}
</style>

</main>
<?php

get_footer();

