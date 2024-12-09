<?php
        $equipe_id=$_GET["equipeID"];
        $photos=get_field('photos');
        $credit_images = get_field('credit_images');
		$titre = get_field('titre');
        $equipes = get_field('equipes');
        $current_equipe=null;
        foreach($equipes as $equipe){
            if($equipe->ID==$equipe_id){
                $current_equipe=$equipe;
            }
        }
        if($current_equipe==null){
            $current_equipe =$equipes[0];
        }
		$date=get_the_date('j F Y', $my_post->ID );
		$couleur1 = get_field('couleur1',$current_equipe->ID);
		$site = get_field('site_web',$current_equipe->ID);
		$style_couleur1=($couleur1)?'style="background: '.$couleur1.';"':'style="background: #e5332a;"';
		$image=get_field('logo_principal')?get_field('logo_principal'):get_the_post_thumbnail_url($current_equipe->ID,"thumbnail");
		$couleur2 = get_field('couleur2',$current_equipe->ID); 
		$style_couleur2=($couleur2)?'style="background: '.$couleur2.';"':'style="background: #990021;"';
		$team_permalink = get_the_permalink($current_equipe->ID);
        $reseaux= get_field('reseaux_sociaux',$current_equipe->ID);
?>


<?php if($equipe){ ?>
<header class="nv.team-header">
<section class="nv-header-team" <?php echo $style_couleur1;?>>
    <div class="container">

        <div class="nv-logo-team-1" style="background-image:url(<?php echo (get_field('logo_principal',$current_equipe->ID))?get_field('logo_principal',$current_equipe->ID):get_the_post_thumbnail_url($current_equipe->ID)?>)">
        </div>
            <h2 class="blanc mrg-0 fs-30"><?php echo get_the_title($current_equipe->ID);?></h2> 
        <?php if($site){?><a class="site-team-blanc" href="<?php echo $site;?>"><?php echo str_replace("/","",str_replace("https://","",$site));?></a><?php }?> 
    </div>
</section>
<section class="nv-header-nav" <?php echo $style_couleur2;?>>

    <div class="container">

        <div class="nv-nav">

            <a href="<?php echo $team_permalink;?>infos" class="team-link">Infos générales</a>

            <a href="<?php echo $team_permalink;?>actus" class="team-link">Actualités</a>

            <a href="<?php echo $team_permalink;?>photos" class="team-link  nvtl-active ">Photos</a>

            <a href="<?php echo $team_permalink;?>videos" class="team-link">Vidéos</a>

            <a href="<?php echo $team_permalink;?>calendrier_resultats" class="team-link">Calendrier / Résultats</a>

            <a href="<?php echo $team_permalink;?>judokas" class="team-link">Judokas</a>

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
<?php }?>


<h1 class="result-h1"><?php echo $titre;?></h1>



					<div class="galerie-images-resultat">

					<div class="liste-images-galerie judo_pro_league page-eq-gal" >

								<?php foreach($photos as $image){?>

								<div class="liste-images-element" style="background-image: url(<?php echo '\''.esc_url($image['sizes']['medium_large']).'\'';?>);">

									<img class="diaporama" src="<?php echo esc_url($image['sizes']['large']); ?>" alt="<?php echo esc_attr($image['alt']); ?>" />

								</div>

								<?php } ?>

						</div>

					</div>

        <?php  if($credit_images){

            echo '<div class="txt-credit text-center"> <p>Crédit photos :  '.$credit_images.'<p></div>';

        }?>



