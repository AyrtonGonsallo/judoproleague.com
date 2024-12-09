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
    $args_femmes_2=array(
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
                'key'     => 'equipes_par_saisons_1_equipe_judoka', // Interroger le sous-champ 'equipe_judoka' du répéteur 'equipes_par_saisons'
                'value'   => '"' . get_the_ID() . '"', // ID de l'équipe
                'compare' => 'LIKE'
            ),
            array(
                'key'     => 'equipes_par_saisons_1_saisons', // Interroger le sous-champ 'saisons' du répéteur 'equipes_par_saisons'
                'value'   => $saison_value, // Valeur de la saison
                'compare' => 'LIKE'
            )
        ),
        array(
            'key' => 'sexe', // recherche sur le champ équipe de type relation
            'value' => 'féminin', // id de l'équipe
            'compare' => 'LIKE'
            )
        
        )
    
    );
    $args_hommes_2=array(
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
                    'key'     => 'equipes_par_saisons_1_equipe_judoka', // Interroger le sous-champ 'equipe_judoka' du répéteur 'equipes_par_saisons'
                    'value'   => '"' . get_the_ID() . '"', // ID de l'équipe
                    'compare' => 'LIKE'
                ),
                array(
                    'key'     => 'equipes_par_saisons_1_saisons', // Interroger le sous-champ 'saisons' du répéteur 'equipes_par_saisons'
                    'value'   => $saison_value, // Valeur de la saison
                    'compare' => 'LIKE'
                )
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
    $judokas_h_2=get_posts($args_hommes_2);
    $judokas_f_2=get_posts($args_femmes_2);

$judokas=array_merge($judokas_f,$judokas_f_2,$judokas_h,$judokas_h_2);





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





                            <span>Catégorie : <?php echo $cat_poids;?>kg</span>





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

















