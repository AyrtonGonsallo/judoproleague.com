<?php







/**







 * Template part for displaying posts







 *







 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/







 *







 * @package pro-league







 */





 $saison_value=($_GET["saison_value"])?$_GET["saison_value"]:"2024-2025";
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
	foreach ($equipes_par_saisons as $equipe1) {
		// Obtenir et afficher le titre de l'équipe
		if (isset($equipe1['equipe_judoka']) && isset($equipe1['saisons']) ) {
			//var_dump($equipe1['saisons'][0]);
			if (!in_array($equipe1['saisons'], $saisons)) {
                $saisons[] = $equipe1['saisons'];
            }
			if( $equipe1['saisons']== $saison_value){
				$found_equipe = $equipe1['equipe_judoka'][0];
			}else{
				$default_equipe=$equipe1['equipe_judoka'][0];
			}
				
			
		}
		

	}
}
$equipe=($found_equipe)?$found_equipe:$default_equipe;
//var_dump($equipe);


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

<div class="page-jdk">













	<header class="nv.team-header">







	<section class="nv-header-team" <?php echo $style_couleur1;?>>
    <div class="container">

        <div class="nv-logo-team-1" style="background-image:url(<?php echo (get_field('logo_principal',$equipe->ID))?get_field('logo_principal',$equipe->ID):get_the_post_thumbnail_url($equipe->ID)?>)">
        </div>
            <h2 class="blanc mrg-0 fs-30"><?php echo get_the_title($equipe->ID);?></h2> 
        <?php if($site){?><a class="site-team-blanc" href="<?php echo $site;?>"><?php echo str_replace("/","",str_replace("https://","",$site));?></a><?php }?> 
    </div>
</section>
<section class="nv-header-nav" <?php echo $style_couleur2;?>>

    <div class="container">

        <div class="nv-nav">

            <a href="<?php echo $team_permalink;?>infos" class="team-link">Infos générales</a>

            <a href="<?php echo $team_permalink;?>actus" class="team-link">Actualités</a>

            <a href="<?php echo $team_permalink;?>photos" class="team-link">Photos</a>

            <a href="<?php echo $team_permalink;?>videos" class="team-link">Vidéos</a>

            <a href="<?php echo $team_permalink;?>calendrier_resultats" class="team-link">Calendrier / Résultats</a>

            <a href="<?php echo $team_permalink;?>judokas" class="team-link  nvtl-active ">Judokas</a>

            <div class="nv-eqip-rs">

                <?php  if($reseaux){

                    foreach($reseaux as $rs){

                        $rs_link=$rs['lien_page'];

                        if($rs["type"]=="Facebook"){

                            echo '<a href="'.$rs_link.'" target="_blank"><i class="fa-brands fa-square-facebook"></i></a>';

                        }

                        elseif($rs["type"]=="Instagram"){

                            echo '<a href="'.$rs_link.'" target="_blank"><i class="fa-brands fa-instagram"></i></a>';

                        }

                        elseif($rs["type"]=="Tiktok"){

                            echo '<a href="'.$rs_link.'" target="_blank"><i class="fa-brands fa-tiktok"></i></a>';						}

                        elseif($rs["type"]=="YouTube"){

                            echo '<a href="'.$rs_link.'" target="_blank"><i class="fa-brands fa-youtube"></i></a>';

                        }

                        elseif($rs["type"]=="Twitter"){

                            echo '<a href="'.$rs_link.'" target="_blank"><i class="fa-brands fa-twitter"></i></a>';

                        }

                    }

                }?>

            </div>

        </div>

    </div>

</section>







		<?php







	?>







       







	</header>







		















	<section class="nv-details-judoka">


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




		<div class="container">







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







			<div class="detail-judoka">







				<div>







					<div>







						<img src="<?php echo $image;?>" class="img-fiche-jdk">







					</div>







				</div>







				<div>







					<div class="name-judoka">







						<h2 class="title-grade"><?php echo $prenom.' '.$nom; ?></h2>







					</div>







					<div class="nv-info-judoka-1">

						<div class="personal-info">

							<div class="disp-grid">

								<span class="titile-1">Catégorie de poids</span>

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

								<span class="titile-1">Pays</span>

								<span class="info-1"><?php if($pays){ echo $pays;}else {echo 'France';}?></span>

							</div>
							<?php 
							}
							?>
							<?php if($date_naissance){?>
							<div class="disp-grid">							

								<span class="titile-1">Date de naissance</span>

								<span class="info-1"><?php echo $date_naissance;?></span>

							</div>
							<?php }?>
						</div>

					</div>

				</div>

			</div>







		</div>







	</section>















	<section class="nv-title-stat">







		<div class="container">







			<!--h2 class="title-stat">Statistiques Judo Pro League 2023</h2-->







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
							<h2 class="title-stat" <?php echo $style_couleur1;?>>COMBATS JUDO PRO LEAGUE  <?php echo $saison_value." (".(get_field("abreviation",$found_equipe->ID)?get_field("abreviation",$found_equipe->ID):"SANS ÉQUIPE").")";?> </h2>
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
		<?php  }else{?>
				<div class="stat-infos">
				<div class="results-cmba">
					<div class="combat-judo">
						<div class="header-tabl">
							<h2 class="title-stat" <?php echo $style_couleur1;?>>COMBATS JUDO PRO LEAGUE  <?php echo $saison_value." (".(get_field("abreviation",$found_equipe->ID)?get_field("abreviation",$found_equipe->ID):"SANS ÉQUIPE").")";?> </h2>
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
				<div>
					<div class="col-1 statistic">
						<div class="disp-grid-stat">
							<span class="percent-stat">0%</span>
							<span class="titile-percent">de combat(s)<br> gagné(s)</span>
							<img src="/wp-content/uploads/2023/07/logo-jpl-1.png" class="logo-jpl">
						</div>
					</div>
				</div>
			</div>
		<?php  }?>






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







	</div>
</article>