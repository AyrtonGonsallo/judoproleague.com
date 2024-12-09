<?php

















/**

















 * Template part for displaying posts

















 *

















 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/

















 *

















 * @package pro-league

















 */

















$site = get_field('site_web');











$saison_value=($_GET["saison_value"])?$_GET["saison_value"]:"2024-2025";






$description = get_field('presentation'); 








$saisons = get_field('saisons'); 








$directeur = get_field('directeur'); 

















$couleur1 = get_field('couleur1'); 

















$style_couleur1=($couleur1)?'style="background: '.$couleur1.';"':'style="background: #e5332a;"';











$image=get_field('logo_principal')?get_field('logo_principal'):get_the_post_thumbnail_url($post->ID,"thumbnail");





$couleur2 = get_field('couleur2'); 

















$style_couleur2=($couleur2)?'style="background: '.$couleur2.';"':'style="background: #990021;"';

















$entraineur = get_field('entraineur'); 

















$date_creation = get_field('date_de_creation'); 

















$reseaux= get_field('reseaux_sociaux');

















$palmares = get_field('palmares');

















$galerie_photos = get_field('galerie_photos');

















$gender=  get_field('genre');





$current_fp = get_query_var('fpage');





$team_permalink = get_the_permalink($post->ID);





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

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>











<header class="nv.team-header">




<section class="nv-header-team" <?php echo $style_couleur1;?>>
    <div class="container">

        <div class="nv-logo-team-1" style="background-image:url(<?php echo (get_field('logo_principal'))?get_field('logo_principal'):get_the_post_thumbnail_url($post->ID)?>)">
        </div>
            <h2 class="blanc mrg-0 fs-30"><?php echo get_the_title();?></h2> 
        <?php if($site){?><a class="site-team-blanc" target="_blank"  href="<?php echo $site;?>"><?php echo str_replace("/","",str_replace("https://","",$site));?></a><?php }?> 
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





       





	</header>





		<div id="">





			





  











	<div id="tabs-6">





		<?php 
//recuperation judokas


<<<<<<< HEAD



	$args_femmes=array(
    'post_type'=> 'judoka',
    'posts_per_page' => -1,
    'meta_key'      => 'categorie_de_poids',
    'orderby' => 'meta_value',
    'order' => 'ASC',
    'meta_query'     => array(
    'relation' => 'AND',
    array(
        'relation' => 'AND',
        array(
            'key'     => 'equipes_par_saisons_0_equipe_judoka', // Interroger le sous-champ 'equipe_judoka' du répéteur 'equipes_par_saisons'
            'value'   => '"' . get_the_ID() . '"', // ID de l'équipe
            'compare' => 'LIKE'
        ),
        array(
            'relation' => 'OR', // Le OR pour les équipes et saisons
            array(
                'key'     => 'equipes_par_saisons_1_saisons', // Requête sur le sous-champ 'saisons' du répéteur 'equipes_par_saisons'
                'value'   => $saison_value, // Valeur de la saison
                'compare' => 'LIKE'
            ),
            array(
                'key'     => 'equipes_par_saisons_0_saisons', // Requête sur le sous-champ 'saisons' du répéteur 'equipes_par_saisons'
                'value'   => $saison_value, // Valeur de la saison
                'compare' => 'LIKE'
            ),
            array(
                'key'     => 'equipes_par_saisons_2_saisons', // Requête sur le sous-champ 'saisons' du répéteur 'equipes_par_saisons'
                'value'   => $saison_value, // Valeur de la saison
                'compare' => 'LIKE'
            )
        )
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
    'meta_query'     => array(
        'relation' => 'AND',
        array(
            'relation' => 'AND',
            array(
                'key'     => 'equipes_par_saisons_0_equipe_judoka', // Interroger le sous-champ 'equipe_judoka' du répéteur 'equipes_par_saisons'
                'value'   => '"' . get_the_ID() . '"', // ID de l'équipe
                'compare' => 'LIKE'
            ),
            array(
                'relation' => 'OR', // Le OR pour les équipes et saisons
                array(
                    'key'     => 'equipes_par_saisons_1_saisons', // Requête sur le sous-champ 'saisons' du répéteur 'equipes_par_saisons'
                    'value'   => $saison_value, // Valeur de la saison
                    'compare' => 'LIKE'
                ),
                array(
                    'key'     => 'equipes_par_saisons_0_saisons', // Requête sur le sous-champ 'saisons' du répéteur 'equipes_par_saisons'
                    'value'   => $saison_value, // Valeur de la saison
                    'compare' => 'LIKE'
                ),
                array(
                    'key'     => 'equipes_par_saisons_2_saisons', // Requête sur le sous-champ 'saisons' du répéteur 'equipes_par_saisons'
                    'value'   => $saison_value, // Valeur de la saison
                    'compare' => 'LIKE'
                )
            )
        ),
        array(
            'key' => 'sexe', // recherche sur le champ équipe de type relation
            'value' => 'masculin', // id de l'équipe
            'compare' => 'LIKE'
            )
        
        )
    
    );
   
=======
// Fonction pour générer les arguments de requête pour les judokas
function get_judoka_args($sexe, $saison_value, $index) {
    return array(
        'post_type'      => 'judoka',
        'posts_per_page' => -1,
        'meta_query'     => array(
            'relation' => 'AND',
            // Recherche par sexe
            array(
                'key'     => 'sexe',
                'value'   => $sexe,
                'compare' => '='
            ),
            // Recherche sur les équipes et saisons
            array(
                'relation' => 'AND', // Combinaison pour l'index donné
                array(
                    'key'     => 'equipes_par_saisons_' . $index . '_equipe_judoka',
                    'value'   => '"' . get_the_ID() . '"',
                    'compare' => 'LIKE'
                ),
                array(
                    'key'     => 'equipes_par_saisons_' . $index . '_saisons',
                    'value'   => $saison_value,
                    'compare' => 'LIKE'
                ),
            ),
        ),
        'orderby'        => 'meta_value', // Tri par valeur du champ meta
        'meta_key'      => 'categorie_de_poids', // Champ meta sur lequel on base le tri
        'order'          => 'ASC', // Ou 'DESC' selon l'ordre désiré
    );
}
>>>>>>> bb9a269b60d1b01722195fd603b0b6e6ebbf2367

// Fonction pour récupérer tous les judokas par sexe et saison
function get_judokas_by_sex_and_season($sexe, $saison_value) {
    $judokas = [];

<<<<<<< HEAD
    $judokas_h=get_posts($args_hommes);
    $judokas_f=get_posts($args_femmes);

$judokas=array_merge($judokas_f,$judokas_h);
=======
    // Boucle pour les indices 0, 1 et 2
    for ($i = 0; $i <= 2; $i++) {
        $args = get_judoka_args($sexe, $saison_value, $i);
        $judokas = array_merge($judokas, get_posts($args));
    }

    return $judokas;
}
>>>>>>> bb9a269b60d1b01722195fd603b0b6e6ebbf2367

// Récupérer les judokas féminins et masculins
$judokas_f = get_judokas_by_sex_and_season('féminin', $saison_value);
$judokas_h = get_judokas_by_sex_and_season('masculin', $saison_value);

// Fusionner tous les judokas
$judokas = array_merge($judokas_f, $judokas_h);

// Définir l'ordre spécifique des catégories de poids sans le suffixe "kg"
$ordre_poids = array('-52', '-57', '-63', '-65','-66', '-70', '-73','-75', '-81','-85', '-90','-95', '+70', '+90','+95');

// Créer un tableau d'index pour l'ordre
$index_poids = array_flip($ordre_poids);

// Fusionner les judokas féminins et masculins
$judokas = array_merge($judokas_f, $judokas_h);

// Définir l'ordre spécifique des catégories de poids sans le suffixe "kg"
$ordre_poids = array('-52', '-57', '-63', '-65','-66', '-70', '-73','-75', '-81','-85', '-90','-95', '+70', '+90','+95');

// Créer un tableau d'index pour l'ordre
$index_poids = array_flip($ordre_poids);

// Trier le tableau par sexe et par categorie_de_poids
usort($judokas, function($a, $b) use ($index_poids) {
    $sexe_a = get_post_meta($a->ID, 'sexe', true); // Obtenir le sexe pour $a
    $sexe_b = get_post_meta($b->ID, 'sexe', true); // Obtenir le sexe pour $b

    // Comparer les sexes
    if ($sexe_a !== $sexe_b) {
        return $sexe_a <=> $sexe_b; // Trier par sexe (par exemple, 'féminin' avant 'masculin')
    }

    // Si les sexes sont identiques, trier par categorie_de_poids
    $poids_a = str_replace('kg', '', get_post_meta($a->ID, 'categorie_de_poids', true)); // Retirer "kg" pour $a
    $poids_b = str_replace('kg', '', get_post_meta($b->ID, 'categorie_de_poids', true)); // Retirer "kg" pour $b

    // Utiliser l'index pour trier par ordre spécifique
    return ($index_poids[$poids_a] ?? PHP_INT_MAX) <=> ($index_poids[$poids_b] ?? PHP_INT_MAX);
});

// Maintenant, $judokas est trié par sexe puis par categorie_de_poids dans l'ordre spécifié




	?>





		<section class="nv-title-grade">
        <div class="season-selector-box">
			<form Method="GET" ACTION="" class="season-selector-form">
                <select name="saison_value" id="saison_value" class="season-selector-select">
                    <?php foreach ($saisons as $saison) {?>
                        <option value="<?php echo $saison;?>" <?php echo ($saison_value==$saison)?"selected":"";?>><?php echo $saison;?></option>

                    <?php }?>
					
				</select>
			</form>
		</div>





		<div class="container">





			<div class="nv-title">





				<h2 class="title-grade"><?php the_title(); ?> - JUDOKAS</h2>





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




                <a  href="<?php echo get_the_permalink($judoka->ID);?> " >
                    <img src="<?php echo $image;?>">
                    </a>




                    <div class="nv-info-judoka">





                        <h3 class="judoka-name"><?php echo $prenom.' '.$nom; ?></h3>





                        <div class="sep_judoka"></div>





                        <div class="nv-cat">





<<<<<<< HEAD
                        <span>Catégorie : <?php echo get_correct_categorie($saison_value,$cat_poids);?>kg</span>
=======
                            <span>Catégorie : <?php echo get_correct_categorie($saison_value,$cat_poids);?>kg</span>
>>>>>>> bb9a269b60d1b01722195fd603b0b6e6ebbf2367





<<<<<<< HEAD

=======
>>>>>>> bb9a269b60d1b01722195fd603b0b6e6ebbf2367
                            <a href="<?php echo get_the_permalink($judoka->ID);?> "  class="btn-eq-clr" style="background: <?php echo $couleur1;?>; color: #fff !important;border-radius: 8px !important;
    padding: 3px 20px;">Détails <i class="fa-solid fa-angles-right"></i></a>





                        </div>





                    </div>





                </div>





				<?php endforeach; ?>





				</div>





			</div>





		</div>





	</section>





    





  </div>





	

















  </div>























		














	

















</article>