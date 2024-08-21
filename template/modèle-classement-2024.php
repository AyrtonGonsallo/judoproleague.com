<?php



/**

 * Template Name: Modèle classement 2024

 */

function display($rencontres_j1,$titre_journee){?>
    <?php if ($rencontres_j1): ?>
            <div class="judo_pro_league">
                <h2 class="crt-title"><?php echo $titre_journee;?></h2>
                <?php $count=count($rencontres_j1);?>
                <div class="cal-res-poule" <?php if($count==1){?> style="grid-template-columns: repeat(1,1fr) !important; max-width: 450px;margin: 0 auto;" <?php }?>>
                    <?php foreach ($rencontres_j1 as $rencontre):
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
                            <div class="cal-res-poule-blc">
                                <div class="header-cal-res-poule">
                                    <span class="cal-res-poule-title"> <?php echo $lieu;?></span>
                                    <span class="cal-res-poule-stat <?php echo $class_status;?>"><?php echo $texte_status;?></span>
                                </div>
                                <div class="horaire-jr" <?php if($texte_status=='terminé'){?>style="grid-template-columns: 100%; !important;"<?php }?>>
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
                                <div class="cal-res-poule-link <?php echo $class_reservation;?>" <?php if(!$lien_live_ou_billet){?> style="grid-template-columns: repeat(1,1fr) !important;" <?php } ?> >
                                    <?php echo $lien_live_ou_billet;?>
                                    <a href="<?php echo $rencontre_permalink;?>" class="nv-link-crt">Détails <i class="fa-solid fa-angles-right"></i></a>
                                </div>
                            </div>
                    <?php endforeach; ?>
                </div>
            </div>
        <?php endif;  
    }?>

<?php 

get_header();
$saison_value=($_GET["saison_value"])?$_GET["saison_value"]:"2023-2024";
$pouleID=488;

$team_permalink = get_the_permalink($post->ID);

$args_j1= array(		'post_type'=> 'rencontre',		'posts_per_page' => -1,'meta_query'     => array(  'relation' => 'and', array('key'        => 'saisons','compare'    => 'LIKE','value'      => $saison_value), array(      'key'        => 'niveau',      'compare'    => '=',      'value'      => 'Phase de poules'    ),
		

		array(

		    'key'        => 'journee',      'compare'    => 'LIKE',      

			'value'      => 'Journée 1'    

		)  ),		'meta_key' => 'date_de_debut',		'orderby' => 'meta_value_num',		'order' => 'DESC',			);

        $args_j2= array(		'post_type'=> 'rencontre',		'posts_per_page' => -1,'meta_query'     => array(  'relation' => 'and',   array(      'key'        => 'niveau',      'compare'    => '=',      'value'      => 'Phase de poules'    ),
        array('key'        => 'saisons','compare'    => 'LIKE','value'      => $saison_value),
		

		array(

		    'key'        => 'journee',      'compare'    => 'LIKE',      

			'value'      => 'Journée 2'    

		)  ),		'meta_key' => 'date_de_debut',		'orderby' => 'meta_value_num',		'order' => 'DESC',			);

        $args_j3= array(		'post_type'=> 'rencontre',		'posts_per_page' => -1,'meta_query'     => array(  'relation' => 'and',   array(      'key'        => 'niveau',      'compare'    => '=',      'value'      => 'Phase de poules'    ),
        array('key'        => 'saisons','compare'    => 'LIKE','value'      => $saison_value),
	

		array(

		    'key'        => 'journee',      'compare'    => 'LIKE',      

			'value'      => 'Journée 3'    

		)  ),		'meta_key' => 'date_de_debut',		'orderby' => 'meta_value_num',		'order' => 'DESC',			);

        $args_j4= array(		'post_type'=> 'rencontre',		'posts_per_page' => -1,'meta_query'     => array(  'relation' => 'and',   array(      'key'        => 'niveau',      'compare'    => '=',      'value'      => 'Phase de poules'    ),
        array('key'        => 'saisons','compare'    => 'LIKE','value'      => $saison_value),
		

		array(

		    'key'        => 'journee',      'compare'    => 'LIKE',      

			'value'      => 'Journée 4'    

		)  ),		'meta_key' => 'date_de_debut',		'orderby' => 'meta_value_num',		'order' => 'DESC',			);

        $args_j5= array(		'post_type'=> 'rencontre',		'posts_per_page' => -1,'meta_query'     => array(  'relation' => 'and',   array(      'key'        => 'niveau',      'compare'    => '=',      'value'      => 'Phase de poules'    ),
        array('key'        => 'saisons','compare'    => 'LIKE','value'      => $saison_value),
		
		array(

		    'key'        => 'journee',      'compare'    => 'LIKE',      

			'value'      => 'Journée 5'    

		)  ),		'meta_key' => 'date_de_debut',		'orderby' => 'meta_value_num',		'order' => 'DESC',			);

        $args_j6= array(		'post_type'=> 'rencontre',		'posts_per_page' => -1,'meta_query'     => array(  'relation' => 'and',   array(      'key'        => 'niveau',      'compare'    => '=',      'value'      => 'Phase de poules'    ),
        array('key'        => 'saisons','compare'    => 'LIKE','value'      => $saison_value),
		
		array(

		    'key'        => 'journee',      'compare'    => 'LIKE',      

			'value'      => 'Journée 6'    

		)  ),		'meta_key' => 'date_de_debut',		'orderby' => 'meta_value_num',		'order' => 'DESC',			);
        $rencontres_j1 = get_posts($args_j1);
        $rencontres_j2 = get_posts($args_j2);
        $rencontres_j3 = get_posts($args_j3);
        $rencontres_j4 = get_posts($args_j4);
        $rencontres_j5 = get_posts($args_j5);
        $rencontres_j6 = get_posts($args_j6);
?>
<script>
        $(document).ready(function() {
            $('#saison_value').change(function() {
                $('.season-selector-form').submit();
            });
        });
    </script>


<main id="primary" class="site-main home classmnt-24">
<div class="season-selector-box">
			<form Method="GET" ACTION="" class="season-selector-form">
				<select name="saison_value" id="saison_value" class="season-selector-select">
					<option value="2021-2022" >2021-2022</option>
					<option value="2022-2023" >2022-2023</option>
					<option value="2023-2024" >2023-2024</option>
                    <option value="2024-2025" selected>2024-2025</option>
				</select>
			</form>
		</div>
    <section class="pd-5">
        <div class="judo_pro_league tab-24">
            <div class="phases-cl">
                <h2 class="tab-phase tab-act fs-30">
                    <a href="/classement-judo-pro-league-2023/">
                        PHASE éliminatoire
                    </a>
                </h2>
                <h2 class="tab-phase  fs-30">
                    <a href="/tableau-principal-judo-pro-league-2023/">
                        Tableau principal
                    </a>
                </h2>
            </div>
        </div>
        <div class="judo_pro_league poules-col">
            <div class="journees">
                <h3 class="nv-journee-cl nv-jr-active">
                    <a href="<?php echo $team_permalink;?>phase-eliminatoire/poule-A">
                        Poule A
                    </a>
                </h3>
                <h3 class="nv-journee-cl">
                    <a href="<?php echo $team_permalink;?>phase-eliminatoire/poule-B">
                        Poule B
                    </a>
                </h3>
                <h3 class="nv-journee-cl">
                    <a href="<?php echo $team_permalink;?>phase-eliminatoire/poule-C">
                        Poule C
                    </a>
                </h3>
                <h3 class="nv-journee-cl">
                    <a href="<?php echo $team_permalink;?>phase-eliminatoire/poule-D">
                        Poule D
                    </a>
                </h3>
            </div>
        </div>
        <?php 
        $args=array(
            'post_type'=> 'rencontre',
            'posts_per_page' => -1,
            'meta_key' => 'date_de_debut',
            'orderby' => 'meta_value_num',
            'order' => 'DESC',
            'meta_query' => array(
                'relation' => 'AND',
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
            ),
        );
        $rencontres=get_posts($args);
            require_once (THEMEDIR.'template-parts/content-pro-league2-requests.php');
            $classement=get_classement($rencontres,$saison_value);
            //prettyPrint($classement);
        ?>
    <?php  if($classement):?>

    <div class="classement-23 judo_pro_league classement-24">

        <h1 class="result-h1">Classement</h1>
        <div class="table-cl">
        <div class="table-23">
        <div class="header-table bb2 table-no-lb table-no-rb table-no-tb "></div>
        <div class="header-table bb2 table-no-lb table-no-rb table-no-tb "></div>
        <div class="table-team" style="display: grid; grid-template-columns: 3fr 1fr;border:none !important;">
        <div class="header-table table-no-lb bb2">RENCONTRES</div>
        <div class="header-table bb2 bleu-score background-score">SCORE</div>
        </div>
        </div>
            <div class="table-23">
            <div class="header-table table-no-lb table-no-rb "></div>
                <div class="header-table table-no-lb table-no-rb"></div>
                <div class="table-results">
                <div class="header-table gras table-no-lb">Pts</div>
                    <div class="header-table table-no-lb table-no-rb">J</div>
                    <div class="header-table table-no-rb table-no-lb">V</div>
                    <div class="header-table table-no-rb table-no-lb">N</div>
                    <div class="header-table table-no-rb table-no-lb">D</div>
                    <div class="header-table table-no-rb table-no-lb">Bonus</div>
                    <div class="header-table table-no-rb desktop bleu-score background-score">Pts marqués</div>
                    <div class="header-table table-no-lb desktop bleu-score background-score">Ippons</div>
                    <div class="header-table table-no-rb mobile bleu-score background-score">Pts M<br/></div>
                    <div class="header-table table-no-lb mobile bleu-score background-score">I++</div>
                </div>

            </div>

            <?php  $rang=1;
            $pos=1;
            $points_prec=0;
            $points_m_prec=0;
            $ippons_m_prec=0;

            foreach($classement as $clt):
                if(($pos>1) && (($clt[0]['points']+$clt[0]['bonus'])<$points_prec) ){
                    $rang++;
                }else if(($pos>1) && (($clt[0]['points']+$clt[0]['bonus'])==$points_prec)){
                    if((($clt[0]['points_marqués'])<$points_m_prec) ){
                        $rang++;
                    }else if((($clt[0]['points_marqués'])==$points_m_prec) ){
                        if((($clt[0]['ippons_marqués'])<$ippons_m_prec) ){
                            $rang++;
                        }
                    }
                }
                //echo "actuel: ".($clt[0]['points']+$clt[0]['bonus'])."prec: ".$points_prec;
            ?>

                <div class="table-23">
                    <div class="table-team table-no-rb table-no-lb">
                    <h3 class="table-tname"><?= $rang;?>.</h3>
                    </div>
                    <div class="table-team table-no-lb table-no-rb">
                        <h3 class="table-tname"> <?= $clt[0]['nom'];?></h3>
                    </div>
                    <div class="table-results">
                        <div class="td-table gras table-no-lb table-no-rb"><?= ($clt[0]['points']+$clt[0]['bonus']);?></div>
                        <div class="td-table table-no-rb table-no-lb"><?= $clt[0]['nombre_de_rencontres'];?></div>
                        <div class="td-table table-no-rb table-no-lb"><?= ($clt[0]['victoires']?$clt[0]['victoires']:0);?></div>
                        <div class="td-table table-no-rb table-no-lb"><?= ($clt[0]['nuls']?$clt[0]['nuls']:0);?></div>
                        <div class="td-table table-no-rb table-no-lb"><?= ($clt[0]['defaites']?$clt[0]['defaites']:0);?></div>
                        <div class="td-table table-no-rb table-no-lb"><?= ($clt[0]['bonus']?$clt[0]['bonus']:0);?></div>
                        <div class="td-table table-no-lb table-no-rb background-score"><?= ($clt[0]['points_marqués']?$clt[0]['points_marqués']:0);?></div>
                        <div class="td-table table-no-rb table-no-lb background-score"><?= ($clt[0]['ippons_marqués']?$clt[0]['ippons_marqués']:0);?></div>
                    </div>

                </div>

            <?php  
            $bonus=($clt[0]['bonus']?$clt[0]['bonus']:0);
            $points=($clt[0]['points']?$clt[0]['points']:0);
            $points_m_prec=($clt[0]['points_marqués']?$clt[0]['points_marqués']:0);
            $ippons_m_prec=($clt[0]['ippons_marqués']?$clt[0]['ippons_marqués']:0);
            $points_prec=$points+$bonus;
            $pos++;
                endforeach; 
            ?>
        </div>
    </div>
    <?php  endif;?>
</section>

    <section class="pd-5 class-jours">
    <?php display($rencontres_j1,'J1')?>
    <?php display($rencontres_j2,'J2')?>
    <?php display($rencontres_j3,'J3')?>
    <?php display($rencontres_j4,'J4')?>
    <?php display($rencontres_j5,'J5')?>
    <?php display($rencontres_j6,'J6')?>
    </section>

<?php
get_footer();