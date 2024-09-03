<?php

/**
 * Template Name: Modèle equipe JPL
 */
get_header();
$saison_value=($_GET["saison_value"])?$_GET["saison_value"]:"2024-2025";
$argsA=array(
			'post_type'=> 'equipes',
			'posts_per_page' => -1,
			'orderby' => 'title',
			'order' => 'ASC',
			'meta_query'     => array(	
				'relation' => 'AND',			
				array(
					'key'        => 'conference',
					'compare'    => '=',
					'value'      => 'Conférence Ouest'
				),
				array(
					'key'        => 'saisons',
					'compare'    => 'LIKE',
					'value'      => $saison_value
				)
			)
			
		);

$argsC=array(
			'post_type'=> 'equipes',
			'posts_per_page' => -1,
			'orderby' => 'title',
			'order' => 'ASC',
			'meta_query'     => array(		
				'relation' => 'AND',				
				array(
					'key'        => 'conference',
					'compare'    => '=',
					'value'      => 'Conférence Est'
				),
				array(
					'key'        => 'saisons',
					'compare'    => 'LIKE',
					'value'      => $saison_value
				)
			)
		);
$equipes_poule_A=get_posts($argsA);
$equipes_poule_C=get_posts($argsC);
$count_A=count($equipes_poule_A);
$count_C=count($equipes_poule_C);
//var_dump($equipes_poule_A);exit();
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
					<option value="2023-2024" <?php echo ($saison_value=="2024-2025")?"selected":"";?>>2024-2025</option>

				</select>
			</form>
		</div>
		<div class="judo_pro_league ">
			<h1 class="result-h1">Les équipes de la Judo Pro League <?php echo $saison_value;?></h1>
			<div class="regions">
				<div>
					<!-- <h2 class="jpl-region">Conférence Ouest</h2> -->
					<div class="jpl-sep"></div>
					<div class="jpl-poules">
						<div class="jpl-team">
							<?php
							for ($x = 0; $x < 4; $x++) {
								$url=get_permalink($equipes_poule_A[$x]->ID);
								$logo=(get_field('logo_circle', $equipes_poule_A[$x]->ID))?get_field('logo_circle', $equipes_poule_A[$x]->ID):get_the_post_thumbnail_url($equipes_poule_A[$x]->ID);
								$title=get_the_title($equipes_poule_A[$x]->ID);
							?>
								<div class="jpl-team">
									<a href="<?php echo $url; ?>" class="jpl-team-name"><?php echo $title; ?></a>
									<a href="<?php echo $url; ?>"><a href="<?php echo $url; ?>"><img src="<?php echo $logo; ?>" class="jpl-img"></a></a>
								</div>
							<?php
							}
							?>
						</div>
						<div class="jpl-team">
							<?php
							for ($x = 4; $x < $count_A; $x++) {
								$url=get_permalink($equipes_poule_A[$x]->ID);
								$logo=(get_field('logo_circle', $equipes_poule_A[$x]->ID))?get_field('logo_circle', $equipes_poule_A[$x]->ID):get_the_post_thumbnail_url($equipes_poule_A[$x]->ID);
								$title=get_the_title($equipes_poule_A[$x]->ID);
								?>
								<div class="jpl-team">
									<a href="<?php echo $url; ?>" class="jpl-team-name"><?php echo $title; ?></a>
									<a href="<?php echo $url; ?>"><img src="<?php echo $logo; ?>" class="jpl-img"></a>
								</div>
							
							<?php
							}
							?>
						</div>
						<div class="jpl-team">
							<?php
							for ($x = 0; $x < 3; $x++) {
								$url=get_permalink($equipes_poule_C[$x]->ID);
								$logo=(get_field('logo_circle', $equipes_poule_C[$x]->ID))?get_field('logo_circle', $equipes_poule_C[$x]->ID):get_the_post_thumbnail_url($equipes_poule_C[$x]->ID);
								$title=get_the_title($equipes_poule_C[$x]->ID);
							?>
								<div class="jpl-team">
									<a href="<?php echo $url; ?>" class="jpl-team-name"><?php echo $title; ?></a>
									<a href="<?php echo $url; ?>"><img src="<?php echo $logo; ?>" class="jpl-img"></a>
								</div>
							<?php
							}
							?>
						</div>
						<div class="jpl-team">
							<?php
							for ($x = 3; $x < $count_C; $x++) {
								$url=get_permalink($equipes_poule_C[$x]->ID);
								$logo=(get_field('logo_circle', $equipes_poule_C[$x]->ID))?get_field('logo_circle', $equipes_poule_C[$x]->ID):get_the_post_thumbnail_url($equipes_poule_C[$x]->ID);
								$title=get_the_title($equipes_poule_C[$x]->ID);
								?>
								<div class="jpl-team">
									<a href="<?php echo $url; ?>" class="jpl-team-name"><?php echo $title; ?></a>
									<a href="<?php echo $url; ?>"><img src="<?php echo $logo; ?>" class="jpl-img"></a>
								</div>
							
							<?php
							}
							?>
						</div>
					</div>
				</div>
				<div>
					<!-- <h2 class="jpl-region">Conférence Est</h2> -->
					<!-- <div class="jpl-sep"></div> -->
					<!-- <div class="jpl-poules">
						
					</div> -->
				</div>
			</div>
        </div>
    </section>
<?php



get_footer();