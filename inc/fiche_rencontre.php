<?php

/**
 * affiche le tableau des résultats d'une rencontre
 * @param int $post_id
 * @return array string $html string $statut
*/
function fiche_rencontre($result,$post_id=null)
{
	$equipe1 = get_field('equipe_1',$post_id)[0];
	$equipe2 = get_field('equipe_2',$post_id)[0];
	ob_start();
	$statut=get_field('statut',$post_id)['label'];
	if($statut=='en cours'){
		$status='en cours';
		$icone_status='icon-rencontre-encours-1.png';
	}else if($statut=='terminé'){
		$status='terminé';
		$icone_status='icon-rencontre-termine-1.png';
	}
	else if($statut=="à venir"){
		$status='à venir';
		$icone_status='icon-rencontre-a-venir.png';
	}
	?>

	<section class="nv-bg-rencontre" style="background-image:url(/wp-content/uploads/2023/09/bg-rencontre.png)" data-generator="shortcode:fiche_rencontre()" data-post-id="<?php echo $post_id;?>">

		<?php
		if( have_rows('les_combat',$post_id) ){
			while ( have_rows('les_combat',$post_id) ) :

				the_row();

				$logo1=(get_field('logo_circle', $equipe1->ID))?get_field('logo_circle', $equipe1->ID):get_the_post_thumbnail_url($equipe1->ID);
				$logo2=(get_field('logo_circle', $equipe2->ID))?get_field('logo_circle', $equipe2->ID):get_the_post_thumbnail_url($equipe2->ID);
				$ncge1 = get_sub_field('nombre_de_combat_gagne_equipe_1' );
				$pts_e1 = get_sub_field('points_equipe_1' );
				$pts_e2 = get_sub_field('points_equipe_2' );
				$equipe_gagnante = get_sub_field('equipe_gagnante');
				$ncge2 = get_sub_field('nombre_de_combat_gagne_equipe_2' );
				
				?>

				<div class="judo_pro_league desktop">
					<div class="nv-bloc-rencontre">
						<div class="nv-rencontre-equipe">

							<div class="nv-equip-1">
							<a class="nv-renc-equip-link <?php if($equipe_gagnante=='équipe 2'){echo "beaten";}?>" href="<?php echo get_the_permalink($equipe1->ID  );?>">
								<img src="<?php echo $logo1; ?>" class="logo-eqi">
								<span class="nv-equip-name"><?php echo get_the_title($equipe1->ID ); ?></span>
							</a>
							</div>
							<div style="display:grid;grid-template-columns:1fr">
								<div class="">
									<div class="nv-result-rctr">
										<span class="nv-number"><?php echo $ncge1; ?></span><span class="nv-number">-</span><span class="nv-number"><?php echo $ncge2; ?></span>
									</div>
								</div>
								<div class="">
									<div class="nv-result-rctr">
										<span class="nv-number2"><?php echo $pts_e1; ?></span><span class="nv-number2">-</span><span class="nv-number2"><?php echo $pts_e2; ?></span>
									</div>
								</div>
							</div>
							<div class="nv-equip-1">
							<a class="nv-renc-equip-link <?php if($equipe_gagnante=='équipe 1'){echo "beaten";}?>" href="<?php echo get_the_permalink($equipe2->ID  );?>">
								<span class="nv-equip-name"><?php echo get_the_title($equipe2->ID ); ?></span>
								<img src="<?php echo $logo2; ?>" class="logo-eqi">
							</a>
							</div>
						</div>
							<div>
								<div class="rencontre_direct">
									<img src="/wp-content/uploads/2023/07/<?php echo $icone_status;?>">
									<span>
										<?php echo $statut;?>
									</span>
								</div>
								<!--
								<div class="jr-rct-1">
									<span class="jr-nv-1">
										<?php //echo (get_field( "journee"))?(get_field( "journee")):'';?>
										<?php //echo (get_field( "journee"))?',':'';?>
										<?php //echo get_the_title(get_field( "phase")[0]->ID);?></span>
									<span class="rct-nv-1"><?php //echo get_field( "lieu_rencontre");?></span>
								</div>
								-->
							</div>

						<div class="nv-result-eqju">
							<div class="container-iw">
								<div> </div>

								<div class="title-iw">
									<div class="iw-1">
										<div class="div-span"><span>I</span><span>W</span></div>
										<div> </div>
									</div>
									<div></div>

									<div class="iw-2">
										<div></div>
										<div class="div-span"><span>I</span><span>W</span></div>
									</div>
								</div>
								<div></div>
							</div>

							<?php

							if( have_rows('combats',$post_id) ){

								while ( have_rows('combats',$post_id) ) : the_row();

									$categorie_de_poids = get_sub_field('categorie_de_poids' );
									//$duree_combat       = get_sub_field('duree_combat' );
									$statut=get_sub_field('statut')['label'];
									
									$judoka_equipe_1         = get_sub_field('judoka_equipe_1' );
									$valeur_ippon_judoka_1   = get_sub_field('valeur_ippon_judoka_1' );
									$valeur_wazari__judoka_1 = get_sub_field('valeur_wazari__judoka_1');

									$valeurs_shidos_judoka_1 = (get_sub_field('valeurs_shidos_judoka_1'))?get_sub_field('valeurs_shidos_judoka_1')['value']:0;
									$valeurs_shidos_judoka_1_label = (get_sub_field('valeurs_shidos_judoka_1'))?get_sub_field('valeurs_shidos_judoka_1')['label']:'';
									$points_judoka_1 = (get_sub_field('points_judoka_1'))?get_sub_field('points_judoka_1'):0;
									$judoka_equipe_2         = get_sub_field('judoka_equipe_2' );
									$points_judoka_2 = (get_sub_field('points_judoka_2'))?get_sub_field('points_judoka_2'):0;
									$valeur_ippon_judoka_2   = get_sub_field('valeur_ippon_judoka_2');
									$valeur_wazari__judoka_2 = get_sub_field('valeur_wazari__judoka_2' );
									$valeurs_shidos_judoka_2 = (get_sub_field('valeurs_shidos_judoka_2'))?get_sub_field('valeurs_shidos_judoka_2')['value']:0;
									$valeurs_shidos_judoka_2_label = (get_sub_field('valeurs_shidos_judoka_2'))?get_sub_field('valeurs_shidos_judoka_2')['label']:'';

									$judoka_gagnant = get_sub_field('judoka_gagnant');
									
									if($statut=='en cours'){
										$style_duree='background-color: #dd01fb;';
										$duree_combat= get_sub_field('temps_restant' );
									}else if($statut=='terminé'){
										$style_duree='background-color: #aecd3f;';
										$duree_combat= $points_judoka_1.' - '.$points_judoka_2;
									}
									else if($statut=="à venir"){
										$style_duree='background-color: #000a98;';
										$duree_combat= get_sub_field('duree_combat' );
									}
									//var_dump($judoka_equipe_1[0]);exit(-1);
									?>
									<div class="result-jdk">
										<div class="lft-result-jdk">
										<a href="<?php echo get_the_permalink($judoka_equipe_1[0]->ID );?>">
										<h3 class="<?php if ($judoka_gagnant!=null && $judoka_gagnant==1){echo 'gagnant';}?>"><?php echo '<b class="capitalize">'.get_field('prenom_judoka',$judoka_equipe_1[0]->ID ).'</b> <b class="uppercase">'.get_field('nom_judoka',$judoka_equipe_1[0]->ID ).'</b>'; if(get_field('id_ffjda',$judoka_equipe_1[0]->ID )=="")echo ' *'?>	</h3>
										</a>
											<div class="lft-result-jdk-1">
												<div class="resut-new">
													<span><?php echo $valeur_ippon_judoka_1; ?></span>
													<span><?php echo $valeur_wazari__judoka_1; ?></span>
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
												</div>
											</div>
											<a href="<?php echo get_the_permalink($judoka_equipe_2[0]->ID );?>">
											<h3 class="<?php if ($judoka_gagnant!=null && $judoka_gagnant==2){echo 'gagnant';}?>"><?php echo '<b class="capitalize">'.get_field('prenom_judoka',$judoka_equipe_2[0]->ID ).'</b> <b class="uppercase">'.get_field('nom_judoka',$judoka_equipe_2[0]->ID ).'</b>'; if(get_field('id_ffjda',$judoka_equipe_2[0]->ID )=="")echo ' *'?></h3>
											</a>
										</div>
									</div>
								<?php endwhile;
								//reset_rows();
							}
							?>
						</div>
					</div>
				</div>
				<!--desktop-->
		<?php


	$statut_rencontre=get_field('statut',$post_id)['label'];
	if($statut_rencontre=='en cours'){
		$status='en cours';
		$icone_status='icon-rencontre-encours-1.png';
	}else if($statut_rencontre=='terminé'){
		$status='terminé';
		$icone_status='icon-rencontre-termine-1.png';
	}
	else if($statut_rencontre=="à venir"){
		$status='à venir';
		$icone_status='icon-rencontre-a-venir.png';
	}
	?>
				<div class="judo_pro_league mobile">
					<div class="nv-bloc-rencontre">
						<div class="nv-rencontre-equipe">
							<div class="nv-equip-1">
							<a class="nv-renc-equip-link <?php if($equipe_gagnante=='équipe 2'){echo "beaten";}?>" href="<?php echo get_the_permalink($equipe1->ID  );?>">
								<img src="<?php echo $logo1; ?>" class="logo-eqi">
								<span class="nv-equip-name"><?php echo get_the_title($equipe1->ID ); ?></span>
							</a>
							</div>

							<div style="display:grid;grid-template-columns:1fr">
								<div class="">
									<div class="nv-result-rctr">
										<span class="nv-number"><?php echo $ncge1; ?></span><span class="nv-number">-</span><span class="nv-number"><?php echo $ncge2; ?></span>
									</div>
								</div>
								<div class="">
									<div class="nv-result-rctr">
										<span class="nv-number2"><?php echo $pts_e1; ?></span><span class="nv-number2">-</span><span class="nv-number2"><?php echo $pts_e2; ?></span>
									</div>
								</div>
							</div>

							<div class="nv-equip-1">
							<a class="nv-renc-equip-link <?php if($equipe_gagnante=='équipe 1'){echo "beaten";}?>" href="<?php echo get_the_permalink($equipe2->ID  );?>">
								<span class="nv-equip-name"><?php echo get_the_title($equipe2->ID ); ?></span>
								<img src="<?php echo $logo2; ?>" class="logo-eqi">
							</a>
							</div>
						</div>
						<div>
							<div class="rencontre_direct">
								<img src="/wp-content/uploads/2023/07/<?php echo $icone_status;?>">
								<span>
									<?php echo $statut_rencontre;?>
								</span>
							</div>
						</div>
						<div class="nv-result-eqju">
							<div class="nv-container-iw">
								<div class="nv-title-iw">
									<div></div>
									<div class="nv-iw-1">
										<div> </div>
										<div class="nv-div-span"><span>I</span><span>W</span></div>
									</div>
								</div>
								<div> </div>
							</div>
							<?php

								if( have_rows('combats',$post_id) ){

									while ( have_rows('combats',$post_id) ) : the_row();

										$categorie_de_poids = get_sub_field('categorie_de_poids' );
										//$duree_combat       = get_sub_field('duree_combat' );
										$statut=get_sub_field('statut')['label'];
										
										$judoka_equipe_1         = get_sub_field('judoka_equipe_1' );
										$valeur_ippon_judoka_1   = get_sub_field('valeur_ippon_judoka_1' );
										$valeur_wazari__judoka_1 = get_sub_field('valeur_wazari__judoka_1');

										$valeurs_shidos_judoka_1 = (get_sub_field('valeurs_shidos_judoka_1'))?get_sub_field('valeurs_shidos_judoka_1')['value']:0;
										$valeurs_shidos_judoka_1_label = (get_sub_field('valeurs_shidos_judoka_1'))?get_sub_field('valeurs_shidos_judoka_1')['label']:'';
										$points_judoka_1 = (get_sub_field('points_judoka_1'))?get_sub_field('points_judoka_1'):0;
										$judoka_equipe_2         = get_sub_field('judoka_equipe_2' );
										$valeur_ippon_judoka_2   = get_sub_field('valeur_ippon_judoka_2');
										$points_judoka_2 = (get_sub_field('points_judoka_2'))?get_sub_field('points_judoka_2'):0;
										$valeur_wazari__judoka_2 = get_sub_field('valeur_wazari__judoka_2' );
										$valeurs_shidos_judoka_2 = (get_sub_field('valeurs_shidos_judoka_2'))?get_sub_field('valeurs_shidos_judoka_2')['value']:0;
										$valeurs_shidos_judoka_2_label = (get_sub_field('valeurs_shidos_judoka_2'))?get_sub_field('valeurs_shidos_judoka_2')['label']:'';

										$judoka_gagnant = get_sub_field('judoka_gagnant');
										
										if($statut=='en cours'){
											$style_duree='background-color: #dd01fb;';
											$duree_combat= get_sub_field('temps_restant' );
										}else if($statut=='terminé'){
											$style_duree='background-color: #aecd3f;';
											$duree_combat= $points_judoka_1.' - '.$points_judoka_2;
										}
										else if($statut=="à venir"){
											$style_duree='background-color: #000a98;';
											$duree_combat= get_sub_field('duree_combat' );
										}
							?>
								<div class="result-jdk-mobile">
									<div class="nv-rslt-mobile">
										<div class="nv-rgt-result-jdk">
										<a href="<?php echo get_the_permalink($judoka_equipe_1[0]->ID );?>">
											<h3 class="<?php if ($judoka_gagnant!=null && $judoka_gagnant==1){echo 'gagnant';}?>"><?php echo '<b class="capitalize">'.get_field('prenom_judoka',$judoka_equipe_1[0]->ID ).'</b> <b class="uppercase">'.get_field('nom_judoka',$judoka_equipe_1[0]->ID ).'</b>'; if(get_field('id_ffjda',$judoka_equipe_1[0]->ID )=="")echo ' *'?>	</h3>
											</a>
											<div class="rgt-result-jdk-1">
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
															echo '<div class="penalite ">';
															echo'<span>
														<div class="carton-rouge"></div>
														
														</span>';
														echo '</div>';
														}
														else{
															echo '<span><div class="motif-looser">'.$valeurs_shidos_judoka_1_label.'</div></span>';
														}
													?>
												<div class="resut-new">
													<span><?php echo $valeur_ippon_judoka_1; ?></span>
													<span><?php echo $valeur_wazari__judoka_1; ?></span>
												</div>
											</div>
										</div>			
										<div class="nv-rgt-result-jdk">
										<a href="<?php echo get_the_permalink($judoka_equipe_2[0]->ID );?>">
										<h3 class="<?php if ($judoka_gagnant!=null && $judoka_gagnant==2){echo 'gagnant';}?>"><?php echo '<b class="capitalize">'.get_field('prenom_judoka',$judoka_equipe_2[0]->ID ).'</b> <b class="uppercase">'.get_field('nom_judoka',$judoka_equipe_2[0]->ID ).'</b>'; if(get_field('id_ffjda',$judoka_equipe_2[0]->ID )=="")echo ' *'?></h3>
										</a>
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
														echo '<div class="penalite ">';
														echo'<span>
														<div class="carton-rouge"></div>
														
														</span>';
														echo '</div>';
													}
													else{
														echo '<span><div class="motif-looser">'.$valeurs_shidos_judoka_2_label.'</div></span>';
													}
												?>
												<div class="resut-new">
													<span><?php echo $valeur_ippon_judoka_2; ?></span>
													<span><?php echo $valeur_wazari__judoka_2; ?></span>
												</div>
											</div>
										</div>
									</div>
									<div class="flex-col">
										<span class="nv-cat-jdk"><?php echo $categorie_de_poids.'kg'; ?></span>
										<span class="nv-duree-jdk" style="<?php echo $style_duree ?>"><?php echo $duree_combat;?></span>
									</div>
									
								</div>
							<?php
								endwhile;
							} ?>
						</div>
					</div>
				</div>


				<?php
			endwhile;
		} ?>

		
	</section>
	<?php
	$html = ob_get_contents();
  ob_end_clean();
  //$statut=get_field('statut',$post_id)['label'];

  $result['statut']=get_field('statut',$post_id);
  $result['html']=$html;
  return $result;
}

add_filter( 'rencontre_generate_content', 'fiche_rencontre',10,2);
add_filter( 'rencontre_cache_interval', 'fiche_rencontre_update_interval',10 );
/**
 *  appele lors du rechargement de la fiche rencontre
 * @param array $result=[
      'error'        => 'ok',
      'new_interval' => 0, // interval
      'data'         => array(
      	'html' => string html fiche recontre,
      	'statut' => string 'a venir'
      	)
    ];
**/
function fiche_rencontre_update_interval($result)
{
	if(empty($result))
	{
		// no cache file
		$result['new_interval']=30;
		return $result;
	}
	if(empty($result['user_data']['statut'])) {
		$result['error']='missing statut (fiche_rencontre_update_interval) ud='.print_r($result['user_data'],true);
		return $result;
	}
	$statut_value=$result['user_data']['statut']['value'];
	//$statut_value=$result['user_data']['statut'];

	// determine la nouvel intervalle de mise à jour selon le statut de la rencontre
	switch($statut_value) {
		case 'en_cours':
		$new_interval=20;
		break;

		case "a_venir":
		$new_interval=30;
		break;

		default:
		case 'termine':
		$new_interval=0;
		break;
	}

	$result['new_interval']=$new_interval;
	return $result;
}

add_filter('rencontre_cache_dir','rencontre_set_cache_dir',10,2);
function rencontre_set_cache_dir($subdir,$post_id)
{
	// dossier de stockage du cache
	$year=date('Y'); // annee par defaut
	// stocke le cache par annee de date de debut rencontre
	$date_debut_rencontre_fr=get_field('date_de_debut',$post_id);
	if(!empty($date_debut_rencontre_fr) ) {
		list($date,$time)=explode(' ' , $date_debut_rencontre_fr);
		list($day,$month,$year)=explode('/' , $date);
	}
	return $year;
}

add_filter('rencontre_duree','fiche_rencontre_remove_hours');
function fiche_rencontre_remove_hours($duree)
{
	$duree=substr($duree,3); // dureen sans les heures : 00:00:00 -> 00:00
	return $duree;
}
add_filter('rencontre_temps_restant','fiche_rencontre_temps_restant');
function fiche_rencontre_temps_restant($duree)
{
	$duree=substr($duree,3); // duree sans les heures : 00:00:00 -> 00:00

	$duree=substr($duree,0,5); // retire les milisecondes 04:58.0850000 -> 04:58
	return $duree;
}

add_filter('rencontre_add_inline_js','fiche_rencontre_inline_js',10,3);
/**
 * filtre modifiant le javascript
 * @param array $args=[
 *     'selector'        => '.nv-bg-rencontre', // selection de l'element html a mettre a jour
 *     'post_id'         => null,               // post_id rencontre
 *     'interval'        => 10,                 // delai en secondes de rechargement du tableau
 *     'cb_after_update' => '',                 // fonction appelée après chaque fetch
 *   ];
 * @param array $data=[
 * 	'html'	 => string encoded
 *	'statut'	 => array [label,value]
 *	]
 * @return string
**/
function fiche_rencontre_inline_js($js,$args,$data)
{

	if(!empty($data['statut']['value']) && $data['statut']['value']=='termine')
	{
		// rencontre terminée : pas de js pour recharger le tableau des resultats
		return '';
	}

	$out_js='
	<script data-generator="fiche_rencontre/fiche_rencontre_inline_js">
     function update_rencontre_sticky(source_selector)
     {
     	const source=document.querySelector(source_selector)
     	const target=document.querySelector("#stickyrct")

     	// maj des scores
     	const src_scores=source.querySelector(".nv-result-rctr")
     	const dest_scores=target.querySelector(".nv-result-rctr")
     	dest_scores.innerHTML =  src_scores.innerHTML;

     }
    </script>
	'.$js;
	return $out_js;
}
add_filter('rencontre_js_config','fiche_rencontre_js_config');
/**
 * filtre modifiant la configuration javascript
 * appelée par ffjudo_rencontre_cache:filter_inline_js()
 * @param array $args=[
      'selector'        => '.nv-bg-rencontre', // selection de l'element html a mettre a jour
      'post_id'         => null,               // post_id rencontre
      'interval'        => 10,                 // delai en secondes de rechargement du tableau
      'cb_after_update' => '',                 // fonction appelée après chaque fetch
    ];
 * @return array
**/
function fiche_rencontre_js_config($args){
	// fonction js a appeler après la mise à jour du tableau html
	$args['cb_after_update']='update_rencontre_sticky';
	return $args;
}