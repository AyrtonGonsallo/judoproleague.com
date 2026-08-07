<?php







/**







 * Template part for displaying posts







 *







 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/







 *







 * @package pro-league







 */

function remplacer_judoka($texte) {
		// Vérifie si le mot "judoka" est présent dans le texte et le remplace
		if (preg_match('/^nom judoka\b/', $texte)) {
			return 'judoka non présenté';
		}
		
		// Utilisation de regex pour vérifier si "renom judokas" est présent
		else if (preg_match('/\bprenom judoka\b/', $texte)) {
			return '';
		}else{
			return $texte;
		}
		
	}

function migrate_combats_from_rencontres() {
    // Récupérer toutes les rencontres
	/*
    $rencontres = get_posts([
        'post_type'      => 'rencontre',
        'posts_per_page' => -1,
        'post_status'    => 'publish'
    ]);
	*/
	$rencontres = get_posts([
        'post_type'      => 'rencontre',
            'posts_per_page' => -1,
            'meta_key'       => 'date_de_debut',
            'orderby'        => 'meta_value',
            'order'          => 'ASC',
            'meta_query'     => [
                'relation' => 'AND',
                [
                    'key'     => 'statut', // remplace par ton champ ACF exact
                    'value'   => 'terminé',
                    'compare' => 'LIKE'
                ],
                [
                    'key'     => 'saisons',
                    'value'   => '2026-2027',
                    'compare' => 'LIKE'
                ]
            ]
    ]);

    foreach ($rencontres as $rencontre) {
        $saison = get_field('saisons', $rencontre->ID); // champ saison sur rencontre
        $matchs_liste = get_field('les_combat', $rencontre->ID);

        if (!$matchs_liste || !is_array($matchs_liste)) {
            continue;
        }

        foreach ($matchs_liste as $bloc) {
            if (!isset($bloc['combats'])) {
                continue;
            }

            foreach ($bloc['combats'] as $match) {
                $judoka1 = !empty($match['judoka_equipe_1'][0]) ? $match['judoka_equipe_1'][0]->ID : null;
                $judoka2 = !empty($match['judoka_equipe_2'][0]) ? $match['judoka_equipe_2'][0]->ID : null;

                if (!$judoka1 || !$judoka2) {
                    continue; // combat incomplet
                }

                // Vérifier si un combat existe déjà pour rencontre + judoka1 + judoka2
                $existing = get_posts([
                    'post_type'      => 'combat',
                    'posts_per_page' => 1,
                    'meta_query'     => [
                        'relation' => 'AND',
                        ['key' => 'rencontre_id', 'value' => $rencontre->ID],
                        ['key' => 'judoka_equipe_1', 'value' => $judoka1],
                        ['key' => 'judoka_equipe_2', 'value' => $judoka2],
                    ]
                ]);

                if ($existing) {
                    continue; // déjà migré
                }

                // Crée un nouveau post combat
                $combat_id = wp_insert_post([
                    'post_type'   => 'combat',
                    'post_status' => 'publish',
                    'post_title'  => get_the_title($rencontre->ID) . ' : '.get_the_title($judoka1).' vs '. get_the_title($judoka2),
                ]);

                if (is_wp_error($combat_id)) {
                    continue;
                }

                // Champs de base
                update_field('judoka_equipe_1', $match['judoka_equipe_1'], $combat_id);
                update_field('judoka_equipe_2', $match['judoka_equipe_2'], $combat_id);
                update_field('judoka_gagnant', $match['judoka_gagnant'], $combat_id);

				update_field('valeur_wazari__judoka_1', $match['valeur_wazari__judoka_1'], $combat_id);
                update_field('valeurs_shidos_judoka_1', $match['valeurs_shidos_judoka_1'], $combat_id);
                update_field('valeur_ippons_comptes_judoka_1', $match['valeur_ippons_comptés_judoka_1'], $combat_id);
                update_field('valeur_ippon_judoka_1', $match['valeur_ippon_judoka_1'], $combat_id);
                update_field('points_judoka_1', $match['points_judoka_1'], $combat_id);
                update_field('kinza_1', $match['kinza_1'], $combat_id);
				update_field('yuko_1', $match['yuko_1'], $combat_id);

				update_field('valeur_wazari__judoka_2', $match['valeur_wazari__judoka_2'], $combat_id);
                update_field('valeurs_shidos_judoka_2', $match['valeurs_shidos_judoka_2'], $combat_id);
                update_field('valeur_ippons_comptes_judoka_2', $match['valeur_ippons_comptés_judoka_2'], $combat_id);
                update_field('valeur_ippon_judoka_2', $match['valeur_ippon_judoka_2'], $combat_id);
                update_field('points_judoka_2', $match['points_judoka_2'], $combat_id);
                update_field('kinza_2', $match['kinza_2'], $combat_id);
				update_field('yuko_2', $match['yuko_2'], $combat_id);

                update_field('categorie_de_poids', $match['categorie_de_poids'], $combat_id);

                // Ajout des infos relationnelles
                update_field('saisons', $saison, $combat_id);        // saison copiée depuis rencontre
                update_field('rencontre_id', $rencontre->ID, $combat_id); // stocker l’ID de la rencontre
            }
        }
    }
}

// ⚠️ à exécuter une seule fois pour migrer
/*
if($post->ID==7001){
	migrate_combats_from_rencontres();
}
*/















function get_combats_by_judoka_and_saison($judoka_id, $saison_value) {
    if (empty($judoka_id) || empty($saison_value)) {
        return [];
    }

    $args = [
        'post_type'      => 'combat',
        'posts_per_page' => -1,
        'post_status'    => 'publish',
        'meta_query'     => [
            'relation' => 'AND',
            [
                'key'     => 'saisons',
                'value'   => $saison_value,
                'compare' => '=',
            ],
            [
                'relation' => 'OR',
                [
                    'key'     => 'judoka_equipe_1',
                    'value'   => '"' . $judoka_id . '"',
                    'compare' => 'LIKE',
                ],
                [
                    'key'     => 'judoka_equipe_2',
                    'value'   => '"' . $judoka_id . '"',
                    'compare' => 'LIKE',
                ],
            ],
        ],
    ];

    return get_posts($args);
}


 $saison_value=isset($_GET["saison_value"])?$_GET["saison_value"]:"";
 $saisons = array();
// equipe de la saison en cours
 $found_equipe=null;
  //equipe de la derniere saison trouvee
 $default_equipe=null;
//$equipe=get_field('equipe_judoka',$post->ID)[0];
$equipe=null;
$equipes_par_saisons =get_field('equipes_par_saisons',$post->ID);
//var_dump($equipes_par_saisons);
if ($equipes_par_saisons) {
	$highest="";
	foreach ($equipes_par_saisons as $equipe1) {
		// prendre la derniere saison
		if (isset($equipe1['equipe_judoka']) && isset($equipe1['saisons'])) {
			// Obtenir la saison actuelle
			$current_saison = $equipe1['saisons'];
			// Vérifier si c'est la première itération ou si la saison actuelle est supérieure à la plus élevée trouvée jusqu'à présent
			if ($highest == "" || strcmp($current_saison, $highest) > 0) {
				$highest = $current_saison; // Mettre à jour la saison la plus élevée
			}
		}
	}
	//mettre a jour la derniere saison
	if($saison_value=="" && $saison_value!=$highest){
		$saison_value=$highest;
	}
	//prendre la derniere equipe
	foreach ($equipes_par_saisons as $equipe1) {
		// Vérifier si les clés 'equipe_judoka' et 'saisons' existent
		if (isset($equipe1['equipe_judoka']) && isset($equipe1['saisons'])) {
			// Obtenir la saison actuelle
			$current_saison = $equipe1['saisons'];
	
			// Si la saison actuelle n'est pas déjà dans le tableau $saisons, l'ajouter
			if (!in_array($current_saison, $saisons)) {
				$saisons[] = $current_saison;
			}
	
			// Trouver l'équipe judoka en fonction de la saison
			if ($current_saison == $saison_value) {
				$found_equipe = $equipe1['equipe_judoka'][0];
			} else {
				$default_equipe = $equipe1['equipe_judoka'][0];
			}
		}
	}
}
usort($saisons, function ($a, $b) {
    return  strcmp($a, $b);
});
$equipe=($found_equipe)?$found_equipe:$default_equipe;
//var_dump($equipe);
//echo $highest;

$site = get_field('site_web',$equipe->ID);

$team_permalink = get_the_permalink($equipe->ID);


$reseaux= get_field('reseaux_sociaux',$equipe->ID);




$couleur1 = get_field('couleur1',$equipe->ID); 







$image=get_field('logo_principal',$equipe->ID)?get_field('logo_principal',$equipe->ID):get_the_post_thumbnail_url($equipe->ID,"thumbnail");







$style_couleur1=($couleur1)?'style="background: '.$couleur1.';"':'style="background: #e5332a;"';















$couleur2 = get_field('couleur2',$equipe->ID); 















$style_couleur2=($couleur2)?'style="background: '.$couleur2.';"':'style="background: #990021;"';






$args = array(
	'post_type' => 'attachment', // Spécifiez le type de post comme étant des pièces jointes
	'post_status' => 'inherit',   // Les images sont généralement en statut "inherit"
	'posts_per_page' => -1,       // Récupérer toutes les images
	'meta_query' => array(
		'relation' => 'AND', // Utiliser une relation AND pour que la saison soit vraie
		array(
			'key' => 'related_saison', // Métadonnée pour la saison
			'value' => $saison_value,         // La saison que vous recherchez
			'compare' => '=',           // Comparaison
		),
		array(
			'relation' => 'OR', // Relation OR pour vérifier les judokas
			array(
				'key' => 'related_judoka_1', // Métadonnée pour le premier judoka
				'value' => $post->ID,       // ID du judoka
				'compare' => 'LIKE',            // Comparaison pour vérifier l'ID
			),
			array(
				'key' => 'related_judoka_2', // Métadonnée pour le deuxième judoka
				'value' => $post->ID,       // ID du judoka
				'compare' => 'LIKE',            // Comparaison pour vérifier l'ID
			),
		),
	),
);

// Exécutez la requête
$images_par_judokas_et_saisons = get_posts($args);



function get_correct_categorie($saison_value,$cat){
	if($saison_value=="2024-2025"){
		switch ($cat) {
			case '-65':
				return '-66';
				break;
			case '-75':
				return '-73';
				break;
			case '-85':
				return '-81';
				break;
			case '-95':
				return '-90';
				break;
			case '+95':
				return '+90';
				break;
			default:
				# code...
				break;
		}
	}
	return $cat;
}




?>






<script>
        $(document).ready(function() {
            $('#saison_value').change(function() {
                $('.season-selector-form').submit();
            });
        });
    </script>








<article id="post-<?php the_ID(); ?>" <?php post_class(); ?> >

<div class="page-jdk" style="max-width: 100%;width: 100%;">

<section class="nv-header-nav" >

    <div class="container"  >

        <div class="nv-nav">

            <div class="nv-logo-team-1" style="background-image:url(<?php echo (get_field('logo_circle',$equipe->ID))?get_field('logo_circle',$equipe->ID):get_the_post_thumbnail_url($equipe->ID)?>)"></div>

			<div class="menu-eq">
				<a href="<?php echo $team_permalink;?>infos" class="team-link" <?php echo $style_couleur2;?>>Infos générales</a>

				<a href="<?php echo $team_permalink;?>actus" class="team-link" <?php echo $style_couleur2;?>>Actualités</a>

				<a href="<?php echo $team_permalink;?>photos" class="team-link" <?php echo $style_couleur2;?>>Photos</a>

				<a href="<?php echo $team_permalink;?>videos" class="team-link" <?php echo $style_couleur2;?>>Vidéos</a>

				<a href="<?php echo $team_permalink;?>calendrier_resultats" class="team-link" <?php echo $style_couleur2;?>>Calendrier / Résultats</a>

				<a href="<?php echo $team_permalink;?>judokas" class="team-link nvtl-active " <?php echo $style_couleur1;?>>Judokas</a>
            
			</div>
        </div>
        <span><a href="/equipes-judo-pro-league/">Equipes</a> > <a href="<?php echo $team_permalink;?>infos"><?php echo get_the_title($equipe->ID);?></a> > <?php echo get_the_title();?> </span>

    </div>

</section>

<?php


	$judoka = get_post($post->ID);


	$nom=get_field('nom_judoka');

	$prenom=get_field('prenom_judoka');

	$cat_poids=get_field('categorie_de_poids');

	$pays=get_field('pays');


	$cat_age=get_field('categorie_dage');

	$club_actuel=get_field('club_actuel');

	$sexe==get_field('sexe');


	$image=get_the_post_thumbnail_url($post->ID)?get_the_post_thumbnail_url ($post->ID):'/wp-content/uploads/2023/09/profil.jpg';


	$date_naissance=get_field('date_de_naissance');

?>

</div>
<section class="sec-jdk-detail" style="padding: 0% 2% 2%; background: #EEEEEF;    width: 100%;">
    <div class="container">
<div class="season-selector-box">
    <form Method="GET" ACTION="" class="season-selector-form">
        <select name="saison_value" id="saison_value" class="season-selector-select">
            <?php foreach ($saisons as $saison) : ?>
                <option value="<?php echo esc_attr($saison); ?>" <?php echo selected($saison_value, $saison, false); ?>>
                    <?php echo esc_html($saison); ?>
                </option>
            <?php endforeach; ?>
        </select>
    </form>
</div>

		<div class="div-jdk-detail">
			<div>
				
						<img src="<?php echo $image;?>" class="img-fiche-jdk">
			</div>
			<div class="jdk-div-ttl">
				<h2 class="title-grade"><?php echo $prenom.' '.$nom; ?></h2>
				<div class="nv-info-judoka-1">

						<div class="personal-info">

							<div class="disp-grid">

								<span class="titile-1">Catégorie de poids : </span>

								<span class="info-1"><?php echo get_correct_categorie($saison_value,$cat_poids).' kg';?></span>

							</div>

							

								<?php if($club_actuel){?>
									<div class="disp-grid">
										<span class="titile-1">Club actuel</span>

										<span class="info-1"><?php echo $club_actuel;?></span>
									</div>
								<?php }?>

							

							

								<?php if($sexe){?>
									<div class="disp-grid">
										<span class="titile-1">Sexe</span>

										<span class="info-1"><?php echo $sexe;?></span>
									</div>
								<?php }?>

							

						</div>

						<div class="personal-info">
							<?php if($pays){
								?>
							<div class="disp-grid">

								<span class="titile-1">Pays : </span>

								<span class="info-1"><?php if($pays){ echo $pays;}else {echo 'France';}?></span>

							</div>
							<?php 
							}
							?>
							<?php if($date_naissance){?>
							<div class="disp-grid">							

								<span class="titile-1">Date de naissance : </span>

								<span class="info-1"><?php echo $date_naissance;?></span>

							</div>
							<?php }?>
						</div>

					</div>
			</div>
			<div>
			
				

				<?php 
					require_once (THEMEDIR.'template-parts/content-judokas-requests-total.php');
					$classement_total=get_classement( $saison_value);
					if($classement_total['total'][$judoka->post_title]){
						$datas=$classement_total['total'][$judoka->post_title][0];
						//prettyPrint($datas);exit(-1);?>
					<div class="stat-infos">
						<div class="results-cmba">
							<div class="combat-judo">
								<div class="header-tabl">
									<h2 class="title-stat" <?php echo $style_couleur1;?>>COMBATS JUDO PRO LEAGUE  <?php echo $saison_value." (".(get_field("abreviation",$found_equipe->ID)?get_field("abreviation",$found_equipe->ID):"NON PARTICIPATION").")";?> </h2>
								</div>
								<div class="resultat-combat">
									<div class="col-1">
										<div class="disp-grid-stat">
											<span class="number-stat"><?php if($datas['matchs_joués']){echo $datas['matchs_joués'];}else{echo '0';}?></span>
											<span class="titile-stat">disputé(s)</span>
										</div>
									</div>
									<div class="col-1">
										<div class="disp-grid-stat">
											<span class="number-stat"><?php if($datas['matchs_v']){echo $datas['matchs_v'];}else{echo '0';}?></span>
											<span class="titile-stat">gagné(s)</span>
										</div>
									</div>
									<div class="col-1">
										<div class="disp-grid-stat">
											<span class="number-stat"><?php  if($datas['matchs_nuls']){echo $datas['matchs_nuls'];}else{echo '0';}?></span>
											<span class="titile-stat">nul(s)</span>
										</div>
									</div>
									<div class="col-1">
										<div class="disp-grid-stat">
											<span class="number-stat"><?php  if($datas['matchs_d']){echo $datas['matchs_d'];}else{echo '0';}?></span>
											<span class="titile-stat">perdu(s)</span>
										</div>
									</div>
									<div>
										
							<div class="col-1 statistic">
								<div class="disp-grid-stat">
									<span class="percent-stat"><?php echo round((($datas['matchs_v']*100)/$datas['matchs_joués']));?>%</span>
									<span class="titile-percent">de combat(s)<br> gagné(s)</span>
									<img src="/wp-content/uploads/2023/07/logo-jpl-1.png" class="logo-jpl">
								</div>
							</div>
						</div>
									
								</div>
							</div>
							<div class="ippon-wazari">
								<div class="ippon">
									<div class="header-tabl">
										<h2 class="title-stat" <?php echo $style_couleur1;?>>IPPON</h2>
									</div>
									<div class="resultat-ippon">
										<div class="col-1">
											<div class="disp-grid-stat">
												<span class="number-stat"><?php if($datas['ippons_marqués']){echo $datas['ippons_marqués'];}else{echo '0';}?></span>
												<span class="titile-stat">marqué(s)</span>
											</div>
										</div>
										<div class="col-1">
											<div class="disp-grid-stat">
												<span class="number-stat"><?php if($datas['ippons_concédés']){ echo $datas['ippons_concédés'];}else{echo '0';}?></span>
												<span class="titile-stat">reçu(s)</span>
											</div>
										</div>
									</div>
								</div>
								<div class="ippon">
									<div class="header-tabl">
										<h2 class="title-stat" <?php echo $style_couleur1;?>>WAZARI</h2>
									</div>
									<div class="resultat-ippon">
										<div class="col-1">
											<div class="disp-grid-stat">
												<span class="number-stat"><?php  if($datas['wazaris_marqués']){echo $datas['wazaris_marqués'];}else{echo '0';}?></span>
												<span class="titile-stat">marqué(s)</span>
											</div>
										</div>
										<div class="col-1">
											<div class="disp-grid-stat">
												<span class="number-stat"><?php  if($datas['wazaris_concédés']){echo $datas['wazaris_concédés'];}else{echo '0';}?></span>
												<span class="titile-stat">reçu(s)</span>
											</div>
										</div>
									</div>
								</div>						
								<div class="ippon">
									<div class="header-tabl">
										<h2 class="title-stat" <?php echo $style_couleur1;?>>PÉNALITÉS</h2>
									</div>
									<div class="resultat-ippon">
										<div class="col-1">
											<div class="disp-grid-stat">
												<span class="number-stat"><?php  if($datas['hansokumake_encaissés']){echo $datas['hansokumake_encaissés'];}else{echo '0';}?></span>
												<span class="titile-stat">hansokumake reçu(s)</span>
											</div>
										</div>
										<div class="col-1">
											<div class="disp-grid-stat">
												<span class="number-stat"><?php  if($datas['shidos_encaissés']){echo $datas['shidos_encaissés'];}else{echo '0';}?></span>
												<span class="titile-stat">shidos reçu(s)</span>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
						
					</div>
				<?php  }else{?>
						<div class="stat-infos">
						<div class="results-cmba">
							<div class="combat-judo">
								<div class="header-tabl">
									<h2 class="title-stat" <?php echo $style_couleur1;?>>COMBATS JUDO PRO LEAGUE  <?php echo $saison_value." (".(get_field("abreviation",$found_equipe->ID)?get_field("abreviation",$found_equipe->ID):"NON PARTICIPATION").")";?> </h2>
								</div>
								<div class="resultat-combat">
									<div class="col-1">
										<div class="disp-grid-stat">
											<span class="number-stat">0</span>
											<span class="titile-stat">disputé(s)</span>
										</div>
									</div>
									<div class="col-1">
										<div class="disp-grid-stat">
											<span class="number-stat">0</span>
											<span class="titile-stat">gagné(s)</span>
										</div>
									</div>
									<div class="col-1">
										<div class="disp-grid-stat">
											<span class="number-stat">0</span>
											<span class="titile-stat">nul(s)</span>
										</div>
									</div>
									<div class="col-1">
										<div class="disp-grid-stat">
											<span class="number-stat">0</span>
											<span class="titile-stat">perdu(s)</span>
										</div>
									</div>
									<div class="col-1 statistic">
										<div class="disp-grid-stat">
											<span class="percent-stat">0%</span>
											<span class="titile-percent">de combat(s)<br> gagné(s)</span>
											<img src="/wp-content/uploads/2023/07/logo-jpl-1.png" class="logo-jpl">
										</div>
									</div>
								</div>
							</div>
							<div class="ippon-wazari">
								<div class="ippon">
									<div class="header-tabl">
										<h2 class="title-stat" <?php echo $style_couleur1;?>>IPPON</h2>
									</div>
									<div class="resultat-ippon">
										<div class="col-1">
											<div class="disp-grid-stat">
												<span class="number-stat">0</span>
												<span class="titile-stat">marqué(s)</span>
											</div>
										</div>
										<div class="col-1">
											<div class="disp-grid-stat">
												<span class="number-stat">0</span>
												<span class="titile-stat">reçu(s)</span>
											</div>
										</div>
									</div>
								</div>
								<div class="ippon">
									<div class="header-tabl">
										<h2 class="title-stat" <?php echo $style_couleur1;?>>WAZARI</h2>
									</div>
									<div class="resultat-ippon">
										<div class="col-1">
											<div class="disp-grid-stat">
												<span class="number-stat">0</span>
												<span class="titile-stat">marqué(s)</span>
											</div>
										</div>
										<div class="col-1">
											<div class="disp-grid-stat">
												<span class="number-stat">0</span>
												<span class="titile-stat">reçu(s)</span>
											</div>
										</div>
									</div>
								</div>						
								<div class="ippon">
									<div class="header-tabl">
										<h2 class="title-stat" <?php echo $style_couleur1;?>>PÉNALITÉS</h2>
									</div>
									<div class="resultat-ippon">
										<div class="col-1">
											<div class="disp-grid-stat">
												<span class="number-stat">0</span>
												<span class="titile-stat">hansokumake reçu(s)</span>
											</div>
										</div>
										<div class="col-1">
											<div class="disp-grid-stat">
												<span class="number-stat">0</span>
												<span class="titile-stat">shidos reçu(s)</span>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				<?php  }?>


			</div>
		</div>
	</div>
</section>







<section class="det-combts" >
    <div class="container cont-det-cmbat">

        <?php

        $combats     = get_combats_by_judoka_and_saison($post->ID, $saison_value);

        if ($combats) {
            echo "<h2>Détails des combats</h2>"; ?>
            <div class="nv-result-eqju">
                <div class="container-iw">
                    <div> </div>

                    <div class="title-iw">
                        <div class="iw-1">
                            <div class="div-span"><span>I</span><span>W</span><span>Y</span></div>
                            <div> </div>
                        </div>
                        <div></div>

                        <div class="iw-2">
                            <div></div>
                            <div class="div-span"><span>I</span><span>W</span><span>Y</span></div>
                        </div>
                    </div>
                    <div></div>
                </div>

                <?php

                    foreach ($combats as $combat) {

                        $categorie_de_poids = get_field('categorie_de_poids', $combat->ID);
                        //get_field('judoka_equipe_1', $combat->ID);
                        $statut="terminé";
                        
                        $judoka_equipe_1         = get_field('judoka_equipe_1', $combat->ID);
                        $valeur_ippon_judoka_1   = get_field('valeur_ippon_judoka_1', $combat->ID);
                        $valeur_wazari__judoka_1 = get_field('valeur_wazari__judoka_1', $combat->ID);
                        $valeur_ippon_judoka_1   = get_field('valeur_ippon_judoka_1', $combat->ID);
                        $yuko_1   = get_sub_field('yuko_1', $combat->ID)?get_sub_field('yuko_1', $combat->ID):0;
                        $yuko_2   = get_sub_field('yuko_2', $combat->ID)?get_sub_field('yuko_2', $combat->ID):0;
                        $valeurs_shidos_judoka_1 = (get_field('valeurs_shidos_judoka_1', $combat->ID))?get_field('valeurs_shidos_judoka_1', $combat->ID)['value']:0;
                        $valeurs_shidos_judoka_1_label = (get_field('valeurs_shidos_judoka_1', $combat->ID))?get_field('valeurs_shidos_judoka_1', $combat->ID)['label']:'';
                        $points_judoka_1 = (get_field('points_judoka_1', $combat->ID))?get_field('points_judoka_1', $combat->ID):0;
                        $judoka_equipe_2         = get_field('judoka_equipe_2' , $combat->ID);
                        $points_judoka_2 = (get_field('points_judoka_2', $combat->ID))?get_field('points_judoka_2', $combat->ID):0;
                        $valeur_ippon_judoka_2   = get_field('valeur_ippon_judoka_2', $combat->ID);
                        $valeur_wazari__judoka_2 = get_field('valeur_wazari__judoka_2' , $combat->ID);
                        $valeurs_shidos_judoka_2 = (get_field('valeurs_shidos_judoka_2', $combat->ID))?get_field('valeurs_shidos_judoka_2', $combat->ID)['value']:0;
                        $valeurs_shidos_judoka_2_label = (get_field('valeurs_shidos_judoka_2', $combat->ID))?get_field('valeurs_shidos_judoka_2', $combat->ID)['label']:'';
                        $judoka_gagnant = get_field('judoka_gagnant', $combat->ID);
                        $style_duree='background-color: #aecd3f;';
                        $duree_combat= $points_judoka_1.' - '.$points_judoka_2;
                        
                        ?>
                        <div class="result-jdk">
                            <div class="lft-result-jdk">
                            <a href="<?php echo get_the_permalink($judoka_equipe_1[0]->ID );?>">
                            <h3 class="<?php if ($judoka_gagnant!=null && $judoka_gagnant==1){echo 'gagnant';}?>"><?php echo '<b class="capitalize">'.remplacer_judoka(get_field('prenom_judoka',$judoka_equipe_1[0]->ID )).'</b> <b class="uppercase">'.remplacer_judoka(get_field('nom_judoka',$judoka_equipe_1[0]->ID )).'</b>'; if(get_field('id_ffjda',$judoka_equipe_1[0]->ID )=="")echo ' *'?>    </h3>
                            </a>
                                <div class="lft-result-jdk-1">
                                    <div class="resut-new">
                                        <span><?php echo $valeur_ippon_judoka_1; ?></span>
                                        <span><?php echo $valeur_wazari__judoka_1; ?></span>
                                        <span><?php echo $yuko_1; ?></span>
                                    </div>

                                    <?php
                                        if(is_numeric($valeurs_shidos_judoka_1)){
                                            echo '<div class="penalite">';
                                            if($valeurs_shidos_judoka_1==3){
                                                for($i=0; $i<2; $i++){
                                                    echo '<span><div class="carton-jaune"></div></span>';
                                                }
                                                echo'<span><div class="carton-rouge"></div></span>';
                                            }else{
                                                for($i=0; $i<$valeurs_shidos_judoka_1; $i++){
                                                    if($valeurs_shidos_judoka_1==1 || $valeurs_shidos_judoka_1==2){
                                                        echo '<span><div class="carton-jaune"></div></span>';
                                                    }
                                                
                                                }
                                            }
                                            echo '</div>';
                                        }else if($valeurs_shidos_judoka_1=='H'||$valeurs_shidos_judoka_1=='X'){
                                            echo'<span>
                                        <div class="carton-rouge"></div>
                                        
                                        </span>';
                                        }
                                        else{
                                            echo '<span><div class="motif-looser">'.$valeurs_shidos_judoka_1_label.'</div></span>';
                                        }
                                    ?>
                                </div>
                            </div>

                            <div class="flex-col">
                                <span class="nv-cat-jdk"><?php echo $categorie_de_poids.'kg'; ?></span>
                                <span class="nv-duree-jdk" style="<?php echo $style_duree ?>"><?php echo $duree_combat;?></span>
                            </div>
                            <div class="rgt-result-jdk">
                                <div class="rgt-result-jdk-1">
                                <?php
                                    if(is_numeric($valeurs_shidos_judoka_2)){
                                        echo '<div class="penalite ">';
                                        if($valeurs_shidos_judoka_2==3){
                                            for($i=0; $i<2; $i++){
                                                echo '<span><div class="carton-jaune"></div></span>';
                                            }
                                            echo'<span><div class="carton-rouge"></div></span>';
                                        }else{
                                            for($i=0; $i<$valeurs_shidos_judoka_2; $i++){
                                                if($valeurs_shidos_judoka_2==1 || $valeurs_shidos_judoka_2==2){
                                                    echo '<span><div class="carton-jaune"></div></span>';
                                                }
                                            
                                            }
                                        }
                                        echo '</div>';
                                    }
                                    else if($valeurs_shidos_judoka_2=='H'||$valeurs_shidos_judoka_2=='X'){
                                        echo'<span>
                                        <div class="carton-rouge"></div>
                                        
                                        </span>';
                                        //echo '';
                                    }
                                    else{
                                        echo '<span><div class="motif-looser">'.$valeurs_shidos_judoka_2_label.'</div></span>';
                                    }
                                ?>

                                    <div class="resut-new">
                                        <span><?php echo $valeur_ippon_judoka_2; ?></span>
                                        <span><?php echo $valeur_wazari__judoka_2; ?></span>
                                        <span><?php echo $yuko_2; ?></span>
                                    </div>
                                </div>
                                <a href="<?php echo get_the_permalink($judoka_equipe_2[0]->ID );?>">
                                <h3 class="<?php if ($judoka_gagnant!=null && $judoka_gagnant==2){echo 'gagnant';}?>"><?php echo '<b class="capitalize">'.remplacer_judoka(get_field('prenom_judoka',$judoka_equipe_2[0]->ID )).'</b> <b class="uppercase">'.remplacer_judoka(get_field('nom_judoka',$judoka_equipe_2[0]->ID )).'</b>'; if(get_field('id_ffjda',$judoka_equipe_2[0]->ID )=="")echo ' *'?></h3>
                                </a>
                            </div>
                        </div>
                        <div class="lien-rencontre">
                            <?php
                                $rencontre_id = get_field('rencontre_id', $combat->ID);
                                $equipe1 = get_field('equipe_1',$rencontre_id)[0];
                                $equipe2 = get_field('equipe_2',$rencontre_id)[0];
                                $titre_equipe1=get_the_title($equipe1->ID);
                                $titre_equipe2=get_the_title($equipe2->ID);
                                if( have_rows('les_combat',$rencontre_id) ){
                                    while ( have_rows('les_combat',$rencontre_id) ) :
                                        the_row();
                                        $ncge1 = get_sub_field('nombre_de_combat_gagne_equipe_1' );
                                        $ncge2 = get_sub_field('nombre_de_combat_gagne_equipe_2' );
                                    endwhile;
                                }
                                echo $titre_equipe1.' - '.$titre_equipe2.' : '.$ncge1.' - '.$ncge2;
                            ?>

                            
                        </div>
                    <?php
                    }
                
                ?>
            </div>
        <? } else {
            echo '<p class="aucun-cmbt">Aucun combat trouvé pour cette saison.</p>';
        }

        ?>

        
    </div>
</section>




<section class="nv-gal-equ">
	<?php if ($images_par_judokas_et_saisons) {?>
		<div class="galerie-images-resultat">

			<div class="liste-images-galerie judo_pro_league page-eq-gal" >

				<?php foreach($images_par_judokas_et_saisons as $image){
					$attachment_id = $image->ID; // ID de la pièce jointe
					$image_src = wp_get_attachment_image_src($attachment_id, 'medium_large'); // Récupérer l'URL de la taille 'medium_large'
					$image_url = $image_src ? $image_src[0] : ''; // L'URL de l'image si elle existe
					$titre = get_the_title($attachment_id);
				?>

					<div class="liste-images-element" style="background-image: url(<?php echo $image_url; ?>);">

						<img class="diaporama" src="<?php echo esc_url($image_url); ?>" alt="<?php echo esc_attr($titre); ?>" />

					</div>

				<?php } ?>

			</div>

		</div>
	<?} else {
    	echo '';
	} ?>
</section>	





	
</article>
