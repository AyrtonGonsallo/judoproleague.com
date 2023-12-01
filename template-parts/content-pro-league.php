<?php
/**
 * Template part for displaying posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package pro-league
 */
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
					<?php if(!$desactiver_le_classement){?>
						<!---------------------------------AFFICHAGE DU CLASSEMENT------------------------------------------------->
						<h2 class="titre-galerie">Classement</h2>
						<div class="classement">
							<div class="title-poule">
							</div>
							<div class="resultat">
								<div class="mc">MG</div>
								<div class="mc">CG</div>
								<div class="mc">I</div>
							</div>
						</div>			
					
						<div class="liste-equipe">
							<?php
							if( have_rows('equipe_participante') ){
								while ( have_rows('equipe_participante') ) : the_row();
									$equipe = get_sub_field('equipe' );						
									$resultat = get_sub_field('resultat' );
									foreach($equipe as $requipe):
									?>
									<div class="r-equipe">
										<div class="r-team">
											<h3><?= get_the_title($requipe->ID);?></h3>
										</div>
										<div class="resultat">
											<?php 
											foreach($resultat as $rsl):
												if(is_numeric($rsl)){
													echo '<div class="mc">'.$rsl.'</div>';
												
												}
												elseif($rsl=='Qualifié'){
													echo '<div class="r-final">Qualifié</div>';
												}
												else{
													echo '<div class="r-final-none">Qualifié</div>';
												}
											endforeach;
											?>
										</div>
									</div>
								<?php
									endforeach;
								endwhile;
							}
							?>
						</div>
						<div class="ps"><span>MG : Matchs Gagnés - CG : Combats Gagnés - I : Ippons</span></div>
					<?php }?>
					
					<!---------------------------------AFFICHAGE DES COMBAT------------------------------------------------->
					<h2 class="titre-galerie">Les rencontres de la soirée</h2>
					<div class="accordion" id="accordionExample">
						<?php
						if( have_rows('les_combat') ){
							$collaps=0;
							while ( have_rows('les_combat') ) : the_row();
								$equipe1 = get_sub_field('equipe_1');
								$ncge1 = get_sub_field('nombre_de_combat_gagne_equipe_1' );
								$equipe2 = get_sub_field('equipe_2');
								$equipe_gagnante = get_sub_field('equipe_gagnante');
								$ncge2 = get_sub_field('nombre_de_combat_gagne_equipe_2' );
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
							$collaps=$collaps+1;
							endwhile;
						}
						?>
					</div>
					<div class="ps"><span>I : Ippon - W : Waza-ari</span></div>
					<!-- galerie d'images-->
					<?php $images = get_field('images');
					if($images): ?>
						<div class="galerie-images-resultat">
							
							<?php $credit_images = get_field('credit_images');
							if($credit_images){
								echo '<h2 class="titre-galerie" style="padding-bottom:0px;margin-bottom:0px">Photos</h2><div class="txt-desc text-center"><p>Crédit photos :  '.$credit_images.'<p></div>';
							}else{
								echo '<h2 class="titre-galerie" >Photos</h2>';
							}
							?>
							<div class="liste-images-galerie" >
								<?php  //var_dump($images);exit(-1);
								foreach($images as $image){?>
								<div class="liste-images-element" style="background-image: url(<?php echo '\''.esc_url($image['sizes']['medium_large']).'\'';?>);">
									<img class="diaporama" src="<?php echo esc_url($image['sizes']['medium_large']); ?>" alt="<?php echo esc_attr($image['alt']); ?>" />
								</div>
								<?php } ?>
							</div>
						</div>
					<?php endif;?>
					<!-- fin galerie d'images-->
				</div>
	</div><!-- .entry-content -->
</article>