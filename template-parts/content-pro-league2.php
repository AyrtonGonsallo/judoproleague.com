<?php
/**
 * Template part for displaying posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package pro-league
 */
?>
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
				'key' => 'phase', // recherche sur le champ équipe de type relation
				'value' => '"' . get_the_ID() . '"', // id de l'équipe
				'compare' => 'LIKE'
			)
		),
	);
	$rencontres=get_posts($args);
	
?>
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

	<header class="result-header">
		<?php
        $mypost = get_post($post->ID);
		$args = array(
            'post_type' => 'judo_pro_league',
            'post_status' => 'publish',
            'posts_per_page' => '16'
        );
        $poule_loop = new WP_Query( $args );
		$poule=get_the_title($post->ID);
		$lieu = get_field('lieu');	
		echo '<div class="info-team">';
            if ( is_singular() ) :
							
                echo '<h1 class="result-h1">Résultats de la judo pro league 2022</h1>';
				echo '<div id="menu-poules-description"><div>1er tour</div><div>Quarts de finale</div><div>Finale à 4</div></div>';
				wp_nav_menu( 
					array( 
						'theme_location' => 'my-custom-menu'
					) 
				);
				
				echo '<span class="lieu">'.$poule.'</span>';
				echo '<h2 class="titre-lieu">'.$lieu.'</h2>';
            else :
                the_title( '<h2 class="team-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' );
				wp_nav_menu( 
					array( 
						'theme_location' => 'my-custom-menu'
					) 
				);
            endif;
        echo '</div>';
        ?> 
       
	</header>
    <?php
        $args = array(
            'post_type' => 'judo_pro_league',
            'post_status' => 'publish',
            'posts_per_page' => '16'
        );
        $poule_loop = new WP_Query( $args );
		?>
		<div class="result-content">
			<?php		
				$video = get_field( "video_live");
				$texte_descriptif = get_field( "texte_descriptif");
				$desactiver_le_classement = get_field( "desactiver_le_classement");
			 ?>
				<div class="tab-pane fade show active " id="<?= str_replace(" ","-",$poule);?>" role="tabpanel" aria-labelledby="<?= str_replace(" ","-",$poule);?>-tab" tabindex="0">
					<!---------------------------------AFFICHAGE DU live------------------------------------------------->
					<?php
					if($video!=null){
						$iframe=substr($video, strrpos($video, '=' )+1);
						echo '<div class="live-video">
							<div class="live">
							<iframe src="https://www.youtube.com/embed/'.$iframe.'" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
							</div>
							</div>';
					}
					if($texte_descriptif!=null){
						echo '<div class="txt-desc"><p>'.$texte_descriptif.'</p></div>';
					}
					
					?>
					<?php 
					require_once (THEMEDIR.'template-parts/content-pro-league2-requests.php');
            		$classement=get_classement($rencontres);
					//prettyPrint($classement);?>
					
					<?php  if(!$desactiver_le_classement){?>
						<!---------------------------------AFFICHAGE DU CLASSEMENT------------------------------------------------->
						<h2 class="titre-galerie">Classement</h2>
						<div class="classement">
							<div class="title-poule">
							</div>
							<div class="resultat">
								<div class="mc">J</div>
								<div class="mc">Pts</div>
								<div class="mc">V</div>
								
								<div class="mc">N</div>
								<div class="mc">D</div>
								<div class="mc">Bonus </div>
								<div class="mc">Ipp+</div>
								<div class="mc">Ipp-</div>
								<div class="mc">Wa+ </div>
								<div class="mc">Wa-</div>
								<div class="mc"></div>
							</div>
						</div>			
					
						<div class="liste-equipe">
							<?php 
							if( $classement ){
								foreach($classement as $clt):
									?>
									<div class="r-equipe">
										<div class="r-team">
											<h3><?= $clt[0]['nom'];?></h3>
										</div>
										<div class="resultat">
											<?php 
											
												echo '<div class="mc">'.$clt[0]['nombre_de_rencontres'].'</div>';
												echo '<div class="mc">'.($clt[0]['points']+$clt[0]['bonus']).'</div>';
												echo '<div class="mc">'.($clt[0]['victoires']?$clt[0]['victoires']:0).'</div>';
										echo '<div class="mc">'.($clt[0]['nuls']?$clt[0]['nuls']:0).'</div>';
										echo '<div class="mc">'.($clt[0]['defaites']?$clt[0]['defaites']:0).'</div>';
												echo '<div class="mc">'.($clt[0]['bonus']?$clt[0]['bonus']:0).'</div>';
												echo '<div class="mc">'.($clt[0]['ippons_marqués']?$clt[0]['ippons_marqués']:0).'</div>';
												echo '<div class="mc">'.($clt[0]['ippons_concédés']?$clt[0]['ippons_concédés']:0).'</div>';
												echo '<div class="mc">'.($clt[0]['wazaris_marqués']?$clt[0]['wazaris_marqués']:0).'</div>';
												echo '<div class="mc">'.($clt[0]['wazaris_concédés']?$clt[0]['wazaris_concédés']:0).'</div>';
												if($clt[0]['qualifié']==1){
													echo '<div class="r-final">Qualifié</div>';
												}
												else{
													echo '<div class="r-final-none">Qualifié</div>';
												}
											
											?>
										</div>
									</div>
								<?php
									endforeach;
								
							}
							?>
						</div>
						<div class="ps"><span>J : Nbre de rencontres - Pts : Points  - Ipp+ : Ippon marqués - Ipp- : Ippon concédés - Wa+ : Wazaris marqués - Wa- : Wazaris concédés</span></div>
					<?php }?>
					
					<!---------------------------------AFFICHAGE DES COMBAT------------------------------------------------->
					<h2 class="titre-galerie">Les rencontres de la soirée</h2>
					<div class="accordion" id="accordionExample">

						<?php $collaps=0;
						foreach($rencontres as $rencontre):
							
							//var_dump(get_post_meta($rencontre->ID,'les_combat',true));exit(-1);
							if( have_rows('les_combat',$rencontre->ID) ){
								
								
								while ( have_rows('les_combat',$rencontre->ID) )  :  the_row();
									$equipe1 = get_sub_field('equipe_1');
									$ncge1 = get_sub_field('nombre_de_combat_gagne_equipe_1' );
									$equipe2 = get_sub_field('equipe_2');
									$equipe_gagnante = get_sub_field('equipe_gagnante');
									$ncge2 = get_sub_field('nombre_de_combat_gagne_equipe_2' );
									//var_dump($equipe1);exit(-1);
							?>
								<div class="accordion-item">
									<h2 class="accordion-header" id="headingOne">
									<div class="accordion-button equipe-combat" type="button" data-bs-toggle="collapse" data-bs-target="#collapse<?= $collaps?>" aria-expanded="true" aria-controls="collapse<?= $collaps?>">
										<div class="team-combat">
											<?php 
											foreach($equipe1 as $tm1){
												$class=" ";
												if($equipe_gagnante=="équipe 1"){
													$class="gagnant";
												}
												echo '<div class="team-1 '.$class.'">'.get_the_title($tm1->ID ).'</div>';
											}
											?>										
											<div  class="ranking"><span><?= $ncge1; ?></span> - <span><?= $ncge2; ?></span></div>
											<?php 
											foreach($equipe2 as $tm2){
												$class=" ";
												if($equipe_gagnante=="équipe 2"){
													$class="gagnant";
												}
												echo '<div class="team-2 '.$class.'">'.get_the_title($tm2->ID ).'</div>';
											}
											?>
											
										</div>
									</div>
									</h2>
									<div id="collapse<?= $collaps?>" class="accordion-collapse collapse " aria-labelledby="headingOne" data-bs-parent="#accordionExample">
										<div class="accordion-body">
											<?php
											$iw=0;
											if( have_rows('combats') ){
												while ( have_rows('combats') ) : the_row();
												$categorie_de_poids = get_sub_field('categorie_de_poids' );
												$judoka_equipe_1 = get_sub_field('judoka_equipe_1' ); 
												$valeur_ippon_judoka_1 = get_sub_field('valeur_ippon_judoka_1' );
												$valeur_wazari__judoka_1 = get_sub_field('valeur_wazari__judoka_1');
												$valeurs_shidos_judoka_1 = get_sub_field('valeurs_shidos_judoka_1' );

												$judoka_equipe_2 = get_sub_field('judoka_equipe_2' ); 
												$valeur_ippon_judoka_2 = get_sub_field('valeur_ippon_judoka_2');
												$valeur_wazari__judoka_2 = get_sub_field('valeur_wazari__judoka_2' );
												$valeurs_shidos_judoka_2 = get_sub_field('valeurs_shidos_judoka_2');

												$judoka_gagnant = get_sub_field('judoka_gagnant');
												if($iw==0){
												?>	
												<div class="container-iw">
													<div></div>
													<div class="title-iw">
														<div class="iw-1">
															<div class="div-span"><span>I</span><span>W</span></div>
															<div></div>
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
												}
												?>		
												<div class="jdk-combat">
													<?php foreach($judoka_equipe_1 as $je1){?>
														<p class="judoka-1 <?php if ($judoka_gagnant!=null && $judoka_gagnant=='Judoka équipe 1'){echo 'gagnant';}?>"><?= get_the_title($je1->ID )?></p>
													<?php	} ?>
													<div class="ranking-judoka">
														
														<div class="rank-jdk-1">
															<div class="resut-new">
																<div class="resut-details">
																	<p><?= $valeur_ippon_judoka_1 ?></p>
																</div>
																<div class="resut-details">
																	<p><?= $valeur_wazari__judoka_1 ?></p>
																</div>
															</div>
															<div class="penalite">
																<?php
																for($i=0; $i<$valeurs_shidos_judoka_1; $i++){
																	if($valeurs_shidos_judoka_1==1 || $valeurs_shidos_judoka_1==2){
																		echo '<div class="carton-jaune"></div>';
																	}
																	elseif($valeurs_shidos_judoka_1==3){
																		echo'<div class="carton-rouge"></div>';
																	}
																}
																?>
															</div>
														</div>
														<div class="mrg-fight"><p class="time-fight"><?= $categorie_de_poids.'kg'; ?></p></div>
														<div class="rank-jdk-2 right">
															<div class="penalite ">
															<?php
																for($i=0; $i<$valeurs_shidos_judoka_2; $i++){
																	if($valeurs_shidos_judoka_2==1 || $valeurs_shidos_judoka_2==2){
																		echo '<div class="carton-jaune"></div>';
																	}
																	elseif($valeurs_shidos_judoka_2==3){
																		echo'<div class="carton-rouge"></div>';
																	}
																}
																?>
															</div>
															<div class="resut-new">
																<div class="resut-details">
																	<p><?= $valeur_ippon_judoka_2 ?></p>
																</div>
																<div class="resut-details">
																	<p><?= $valeur_wazari__judoka_2 ?></p>
																</div>
															</div>
														</div>
													</div>
													<?php foreach($judoka_equipe_2 as $je2){?>
														<p class="judoka-2 <?php if ($judoka_gagnant!=null && $judoka_gagnant=='Judoka équipe 2'){echo 'gagnant';}?>"><?=get_the_title($je2->ID )?></p>
														<?php } ?>
												</div>
											<?php
											$iw=$iw+1;
											endwhile;
											}
											?>
										</div>
									</div>
								</div>
							<?php

							
							endwhile;
							}$collaps=$collaps+1;
						endforeach;
						?>
					</div>
					<div class="ps"><span>I : Ippon - W : Waza-ari</span></div>
					<!-- galerie d'images-->
					<?php 
					$images=array();
					foreach ($rencontres as $rencontre){
						$args=array(
						'post_type'=> 'galerie',
						'posts_per_page' => -1,
						'orderby' => 'post_date', 
						'order' => 'DESC',
						'meta_query' => array(
							'relation' => 'AND',
							array(
								'key' => 'rencontre', // recherche sur le champ équipe de type relation
								'value' => '"' . $rencontre->ID . '"', // id de l'équipe
								'compare' => 'LIKE'
							)
						),
					);
					$images_galeries=get_posts($args);
					array_push($images,$images_galeries);
					}
					
					//var_dump($images);exit(-1);
					if($images):
					?>
						
							
							<?php 
							
								echo '<h2 class="titre-galerie" >Photos</h2>';
							
							?>
							
								<?php  //var_dump($images);exit(-1);
								foreach ($images as $image_galerie):
								$photos=get_field('photos',$image_galerie[0]->ID);
							$credit_images = get_field('credit_images',$image_galerie[0]->ID);
					$titre = get_field('titre',$image_galerie[0]->ID);
							if($credit_images){
								echo '<div class="txt-desc text-center"><p>'.$titre.' - Crédit photos :  '.$credit_images.'<p></div>';
							}
								?>
					<div class="galerie-images-resultat">
					<div class="liste-images-galerie" >
								
								<?php foreach($photos as $image){?>
								
								<div class="liste-images-element" style="background-image: url(<?php echo '\''.esc_url($image['sizes']['medium_large']).'\'';?>);">
									<img class="diaporama" src="<?php echo esc_url($image['sizes']['medium_large']); ?>" alt="<?php echo esc_attr($image['alt']); ?>" />
								</div>
								<?php } ?>
						</div>
					</div>
	<?php endforeach;?>
							
						</div>
					<?php 
					
					endif;?>
					<!-- fin galerie d'images-->
				
	</div><!-- .entry-content -->
</article>