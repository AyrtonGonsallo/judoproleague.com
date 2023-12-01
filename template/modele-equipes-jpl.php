<?php

/**
 * Template Name: Modèle equipe JPL
 */
get_header();

$argsA=array(
			'post_type'=> 'equipes',
			'posts_per_page' => -1,
			'orderby' => 'title',
			'order' => 'ASC',
			'meta_query'     => array(				
				array(
					'key'        => 'conference',
					'compare'    => '=',
					'value'      => 'Conférence Ouest'
				)
			)
			
		);

$argsC=array(
			'post_type'=> 'equipes',
			'posts_per_page' => -1,
			'orderby' => 'title',
			'order' => 'ASC',
			'meta_query'     => array(				
				array(
					'key'        => 'conference',
					'compare'    => '=',
					'value'      => 'Conférence Est'
				)
			)
		);
$equipes_poule_A=get_posts($argsA);
$equipes_poule_C=get_posts($argsC);
$count_A=count($equipes_poule_A);
$count_C=count($equipes_poule_C);
//var_dump($equipes_poule_A);exit();
?>

<main id="primary" class="site-main home">

	<section>
		<div class="judo_pro_league ">
			<h1 class="result-h1">Les équipes de la Judo Pro League</h1>
			<div class="regions">
				<div>
					<h2 class="jpl-region">Conférence Ouest</h2>
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
					</div>
				</div>
				<div>
					<h2 class="jpl-region">Conférence Est</h2>
					<div class="jpl-sep"></div>
					<div class="jpl-poules">
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
			</div>
        </div>
    </section>
<?php



get_footer();