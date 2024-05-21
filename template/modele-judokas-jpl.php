<?php

/**
 * Template Name: Modèle judokas JPL
 */
get_header();
$saison_value=($_GET["saison_value"])?$_GET["saison_value"]:"2022-2023";
$args_femmes=array(
	'post_type'=> 'judoka',
	'posts_per_page' => -1,
	'meta_key'      => 'categorie_de_poids',
	'orderby' => 'meta_value',
	'order' => 'ASC',
	'meta_query' => array(
		'relation' => 'AND',
		array(
			'key'        => 'saisons',
			'compare'    => 'LIKE',
			'value'      => $saison_value
		),
		array(
			'key' => 'sexe', // recherche sur le champ équipe de type relation
			'value' => 'féminin', // id de l'équipe
			'compare' => 'LIKE'
			)
		
		)
	
	);
	$args_hommes=array(
		'post_type'=> 'judoka',
		'posts_per_page' => -1,
		'meta_key'      => 'categorie_de_poids',
		'orderby' => 'meta_value',
		'order' => 'ASC',
		'meta_query' => array(
			'relation' => 'AND',
			array(
				'key'        => 'saisons',
				'compare'    => 'LIKE',
				'value'      => $saison_value
			),
			array(
				'key' => 'sexe', // recherche sur le champ équipe de type relation
				'value' => 'masculin', // id de l'équipe
				'compare' => 'LIKE'
				)
			
			)
		
		);
	
	
		$judokas_h=get_posts($args_hommes);
		$judokas_f=get_posts($args_femmes);
	
	$judokas=array_merge($judokas_f,$judokas_h);
?>

<main id="primary" class="site-main home">

	<section>
		<div class="season-selector-box">
			<form Method="GET" ACTION="" class="season-selector-form">
				<select name="saison_value" id="saison_value" class="season-selector-select">
					<option value="2021-2022" <?php echo ($saison_value=="2021-2022")?"selected":"";?>>2021-2022</option>
					<option value="2022-2023" <?php echo ($saison_value=="2022-2023")?"selected":"";?>>2022-2023</option>
					<option value="2023-2024" <?php echo ($saison_value=="2023-2024")?"selected":"";?>>2023-2024</option>
				</select>
				<input type="submit" class="season-selector-button" value="choisir une saison">
			</form>
		</div>
		<div class="judo_pro_league ">
			<h1 class="result-h1">Les judokas de la Judo Pro League</h1>
			

			





						<div class="nv-judokas">





							<?php foreach ($judokas as $judoka):




								if(get_field('masquer',$judoka->ID)){
									continue;
								}
							





							$nom=get_field('nom_judoka',$judoka->ID);





							$prenom=get_field('prenom_judoka',$judoka->ID);





							$cat_poids=get_field('categorie_de_poids',$judoka->ID);





							$pays=get_field('pays',$judoka->ID);





							$cat_age=get_field('categorie_dage',$judoka->ID);





							$date_naissance=get_field('date_de_naissance',$judoka->ID);





							$image=get_the_post_thumbnail_url($judoka->ID)?get_the_post_thumbnail_url ($judoka->ID):'/wp-content/uploads/2023/09/profil.jpg';





							?>





						





						<div class="judoka">





							<img src="<?php echo $image;?>">





							<div class="nv-info-judoka">





								<h3 class="judoka-name"><?php echo $prenom.' '.$nom; ?></h3>





								<div class="sep_judoka"></div>





								<div class="nv-cat">





									<span>Catégorie : <?php echo $cat_poids;?>kg</span>





									<a href="<?php echo get_the_permalink($judoka->ID);?> "style="color:<?php echo $couleur1;?> !important">Détails</a>





								</div>





							</div>





						</div>





						<?php endforeach; ?>





						</div>





					</div>




        </div>
    </section>
<?php



get_footer();