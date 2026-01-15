<?php

















/**

















 * Template part for displaying posts

















 *

















 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/

















 *

















 * @package pro-league

















 */

















$site = get_field('site_web');











$saison_value=($_GET["saison_value"])?$_GET["saison_value"]:"2025-2026";






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



function get_champs_groupes_par_semaine() {
    $args = [
        'post_type'      => 'champ_semaine',
        'posts_per_page' => -1,
        'meta_key'       => 'date_semaine',
        'orderby'        => 'meta_value',
        'order'          => 'DESC',
        'meta_type'      => 'DATE',
    ];

    $posts = get_posts($args);

    $groupes = [];

    foreach ($posts as $post) {
        $date_raw = get_field('date_semaine', $post->ID);

        if (!$date_raw) {
            continue;
        }

        // Convertir en DateTime (ton champ est en d/m/Y)
        $date_obj = DateTime::createFromFormat('d/m/Y', $date_raw, wp_timezone());

        if (!$date_obj) {
            continue;
        }

        // Calculer début et fin de la semaine
        $start = clone $date_obj;
        $start->modify('monday this week');

        $end = clone $start;
        $end->modify('sunday this week');

        $cle = $start->format('Y-m-d');

        if (!isset($groupes[$cle])) {
            $groupes[$cle] = [
                'date_debut_semaine' => $start->format('d/m/Y'),
                'date_fin_semaine'   => $end->format('d/m/Y'),
                'donnees'            => [],
            ];
        }

        // Ajouter données avec les champs ACF pour le tri
        $groupes[$cle]['donnees'][] = [
            'id'            => $post->ID,
            'title'         => get_the_title($post),
            'date'          => $date_raw,
            'total_points'  => (int) get_field('total_points', $post->ID),
            'paris_gagnes'  => (int) get_field('paris_gagnes', $post->ID),
            'score_exact'   => (int) get_field('score_exact', $post->ID),
        ];
    }

     // 🔎 Trier chaque semaine selon la logique
    foreach ($groupes as &$semaine) {
        usort($semaine['donnees'], function($a, $b) {
            if ($a['total_points'] === $b['total_points']) {
                if ($a['paris_gagnes'] === $b['paris_gagnes']) {
                    return $b['score_exact'] <=> $a['score_exact'];
                }
                return $b['paris_gagnes'] <=> $a['paris_gagnes'];
            }
            return $b['total_points'] <=> $a['total_points'];
        });
    }
    unset($semaine); // bonne pratique

    return $groupes;
}

/*
$semaines = get_champs_groupes_par_semaine();
echo "nom,prenom,pseudo,email,rang,debut semaine, fin semaine<br>";
foreach ($semaines as $semaine) : 
    $rang=1;
    foreach ($semaine['donnees'] as $donnee) : 
        if($rang>=4){
            continue;
        }
        $points = get_field('points', $donnee['id']);
        $bonus_utilises = get_field('bonus_utilises', $donnee['id']);
        $user_id = get_field('user_id', $donnee['id']);
        $nom = get_field('nom', $donnee['id']);
        $prenom = get_field('prenom', $donnee['id']);
        $user = get_user_by('id', $user_id);
        $email = $user->user_email;
        $pseudo = get_field('pseudo', 'user_'.$user_id) ?: $user->display_name;
        $paris_gagnes = get_field('paris_gagnes', $donnee['id']);
        $score_exacts = get_field('score_exacts', $donnee['id']);
        $serie_en_cours = get_field('serie_en_cours', $donnee['id']);
        $bonus_utilises = get_field('bonus_utilises', $donnee['id']);
 
echo "$nom,$prenom,$pseudo,$email,$rang,{$semaine['date_debut_semaine']},{$semaine['date_fin_semaine']}";
echo "<br>";

        $rang+=1;
    endforeach;
endforeach;                              
*/
?>








<script>
        $(document).ready(function() {
            $('#saison_value').change(function() {
                $('.season-selector-form').submit();
            });
        });
    </script>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?> class="main-info-eq">











<header class="nv.team-header">





<section class="nv-header-nav" >

    <div class="container">

        <div class="nv-nav">
            <div class="nv-logo-team-1" style="background-image:url(<?php echo (get_field('logo_circle'))?get_field('logo_circle'):get_the_post_thumbnail_url($post->ID)?>)"></div>

            <div class="menu-eq">
                <a href="<?php echo $team_permalink;?>infos" class="team-link " <?php echo $style_couleur2;?>>Infos générales</a>

                <a href="<?php echo $team_permalink;?>actus" class="team-link" <?php echo $style_couleur2;?>>Actualités</a>

                <a href="<?php echo $team_permalink;?>photos" class="team-link" <?php echo $style_couleur2;?>>Photos</a>

                <a href="<?php echo $team_permalink;?>videos" class="team-link" <?php echo $style_couleur2;?>>Vidéos</a>

                <a href="<?php echo $team_permalink;?>calendrier_resultats" class="team-link" <?php echo $style_couleur2;?>>Calendrier / Résultats</a>

                <a href="<?php echo $team_permalink;?>judokas" class="team-link nvtl-active " <?php echo $style_couleur1;?>>Judokas</a>
            </div>

        </div>
        <span><a href="/equipes-judo-pro-league/">Equipes</a> > <a href="<?php echo $team_permalink;?>infos"><?php echo get_the_title();?></a> > Judokas</span>

    </div>

</section>





       





	</header>





		<div id="">





			





  











	<div id="tabs-6">





		<?php 



$judokas = $wpdb->get_results($wpdb->prepare(
    "SELECT * 
     FROM prol_judokas_saisons 
     WHERE saison = %s and equipe_id = %s
     ORDER BY sexe asc,categorie_de_poids asc",
    $saison_value,get_the_id()
));









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





		<div class="container section-page-jdks">





			<div class="nv-title">





				<h2 class="title-grade"><?php the_title(); ?> - JUDOKAS</h2>





				<div class="nv-judokas">





					<?php foreach ($judokas as $j):

                     $judoka = get_post($j->judoka_id);




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
                    <div class="nv-img-judoka" style="background-image:url(<?php echo esc_url($image); ?>)">
                            </div>
                    </a>




                    <div class="nv-info-judoka">





                        <h3 class="judoka-name"><?php echo $prenom.' '.$nom; ?></h3>





                        <div class="sep_judoka"></div>





                        <div class="nv-cat">





                        <span>Catégorie : <?php echo get_correct_categorie($saison_value,$cat_poids);?>kg</span>






                            <a href="<?php echo get_the_permalink($judoka->ID);?> "  class="btn-eq-clr" style="background: <?php echo $couleur1;?>; color: #fff !important;border-radius: 50px !important;
    padding: 3px 20px;">Voir +</a>





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
<style>
    .team-link:hover {
        background: <?php echo esc_attr($couleur1); ?> !important;
    }
</style>