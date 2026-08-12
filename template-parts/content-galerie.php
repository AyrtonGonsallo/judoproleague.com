<?php
        $equipe_id=$_GET["equipeID"];
        $photos=get_field('photos');
        $credit_images = get_field('credit_images');
		$titre = get_field('titre');
        $equipe = get_field('equipes');
		$date=get_the_date('j F Y', $my_post->ID );
		$couleur1 = get_field('couleur1',$equipe_id);
		$site = get_field('site_web',$equipe_id);
		$style_couleur1=($couleur1)?'style="background: '.$couleur1.';"':'style="background: #e5332a;"';
		$image=get_field('logo_principal')?get_field('logo_principal'):get_the_post_thumbnail_url($equipe_id,"thumbnail");
		$couleur2 = get_field('couleur2',$equipe_id); 
		$style_couleur2=($couleur2)?'style="background: '.$couleur2.';"':'style="background: #990021;"';
		$team_permalink = get_the_permalink($equipe_id);
        $reseaux= get_field('reseaux_sociaux',$equipe_id);
        $rencontre=get_field('rencontre')[0];
        $equipe1 = get_field('equipe_1',$rencontre->ID)[0];
        $equipe2 = get_field('equipe_2',$rencontre->ID)[0];

        // Récupère la saison si la rencontre existe
        $saison = get_field("saisons", $rencontre->ID ?? null);

        // Si pas de rencontre ou saison vide → valeur par défaut
        if (!$rencontre || empty($saison)) {
            $saison = "2025-2026";
        }

        // Construction des titres
        $title  = "Photos de " . get_the_title($equipe1->ID) . " vs " . get_the_title($equipe2->ID) . " " . $saison;
        $title2 = get_the_title($equipe1->ID) . " vs " . get_the_title($equipe2->ID) . " " . $saison;


?>


<?php if($equipe_id){ ?>
<header class="nv.team-header">

<main id="primary" class="site-main  main-info-eq">

<section class="nv-header-nav" >

    <div class="container">

        <div class="nv-nav">
            <div class="nv-logo-team-1" style="background-image:url(<?php echo (get_field('logo_circle',$equipe_id))?get_field('logo_circle',$equipe_id):get_the_post_thumbnail_url($equipe_id)?>)"></div>

            <div class="menu-eq">
                <a href="<?php echo $team_permalink;?>infos" class="team-link  " <?php echo $style_couleur2;?>>Infos générales</a>

                <a href="<?php echo $team_permalink;?>actus" class="team-link" <?php echo $style_couleur2;?>>Actualités</a>

                <a href="<?php echo $team_permalink;?>photos" class="team-link nvtl-active" <?php echo $style_couleur1;?>>Photos</a>

                <a href="<?php echo $team_permalink;?>videos" class="team-link" <?php echo $style_couleur2;?>>Vidéos</a>

                <a href="<?php echo $team_permalink;?>calendrier_resultats" class="team-link" <?php echo $style_couleur2;?>>Calendrier / Résultats</a>

                <a href="<?php echo $team_permalink;?>judokas" class="team-link" <?php echo $style_couleur2;?>>Judokas</a>
            </div>

        </div>
        
        <span><a href="/equipes-judo-pro-league/">Equipes</a> > <a href="<?php echo $team_permalink;?>infos"><?php echo get_the_title($equipe_id);?></a> > <a href="<?php echo $team_permalink;?>photos">Photos</a> > <?php echo $title2;?></span>


    </div>

</section>







</header>
<?php }?>


<h1 class="result"><?php echo $title;?></h1>



					<div class="galerie-images-resultat">

					<div class="liste-images-galerie judo_pro_league page-eq-gal" >

								<?php foreach($photos as $image){?>

								<div class="liste-images-element dld-btn-container" style="background-image: url(<?php echo '\''.esc_url($image['sizes']['medium_large']).'\'';?>);">

									<img class="diaporama" src="<?php echo esc_url($image['sizes']['large']); ?>" alt="<?php echo esc_attr($image['alt']); ?>" />
                                    <div class="dld-tnt-on-lightbox"><a href="<?php echo $image['sizes']['2048x2048'];?>" download class="btn-telhd">Télécharger en HD</a></div>

								</div>

								<?php } ?>

						</div>

					</div>

        <?php  if($credit_images){

            echo '<div class="txt-credit text-center"> <p>Crédit photos :  '.$credit_images.'<p></div>';

        }?>



