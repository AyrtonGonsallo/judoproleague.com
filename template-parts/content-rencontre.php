<?php

get_header();

$video = get_field( "video_live");
$equipe1 = get_field('equipe_1')[0];
$equipe2 = get_field('equipe_2')[0];
$texte_descriptif = get_field( "texte_descriptif");
$lieu_rencontre_titre = " - ".get_field( "lieu_rencontre");
setlocale(LC_ALL, 'fr_FR.UTF8', 'fr_FR','fr','fr','fra','fr_FR@euro');
$date_de_debut_titre = " - ".strftime('%A %d %B %Y',strtotime(get_field( "date_de_debut")));
$desactiver_le_classement = get_field( "desactiver_le_classement");
$nom=get_the_title();
$statut=get_field('statut')['label'];
if($statut=='en cours'){
	$status='en cours';
	$icone_status='icon-rencontre-encours-1.png';
}else if($statut=='terminé'){
	$status='terminé';
	$icone_status='icon-rencontre-termine-1.png';
}
else if($statut=="à venir"){
	$status='à venir';
	$icone_status='icon-rencontre-a-venir.png';
}
$matchs_liste=get_field('les_combat',$rencontre->ID);
//$equipe_gagnante = $matchs_liste[0]['equipe_gagnante'];
?>

<main id="primary" class="site-main home rencntr-main">

	<div class="jpl-sep"></div>
    <section class="sec-rencontre">
		<div class="judo_pro_league ">
		<?php if($texte_descriptif!=null){ ?>
			<div class="nv-txt-desc"><p> <?php echo $texte_descriptif; ?></p></div>
		<?php } ?>
		<?php	
			if( have_rows('les_combat') ){
		?>
			<?php	
				while ( have_rows('les_combat') ) :
				the_row();
				$logo1=(get_field('logo_circle', $equipe1->ID))?get_field('logo_circle', $equipe1->ID):get_the_post_thumbnail_url($equipe1->ID);
				$logo2=(get_field('logo_circle', $equipe2->ID))?get_field('logo_circle', $equipe2->ID):get_the_post_thumbnail_url($equipe2->ID);
				$ncge1 = get_sub_field('nombre_de_combat_gagne_equipe_1' );
				$equipe_gagnante = get_sub_field('equipe_gagnante');
				$ncge2 = get_sub_field('nombre_de_combat_gagne_equipe_2' );
				$pts_e1 = get_sub_field('points_equipe_1' );
				$pts_e2 = get_sub_field('points_equipe_2' );
			?>
				<div class="rtc-disp-g nv-bg-rct">
					<div class="center">
						<span class="jr-nv-1"><?php echo strftime('%A %d %B %Y - %Hh%M',strtotime(get_field( "date_de_debut",false,false)));?></span>
					</div>
					<div class="nv-rencontre-equipe" id="stickyrct">
						<div class="nv-equip-1 flex1">
							<a class="nv-renc-equip-link 2 <?php if($equipe_gagnante=='équipe 2'){echo "beaten";}?>" href="<?php echo get_the_permalink($equipe1->ID  );?>">
								<img src="<?php echo $logo1; ?>" class="logo-eqi">
								<span class="nv-equip-name"><?php echo get_the_title($equipe1->ID ); ?></span>
							</a>
						</div>
						<div style="display:grid;grid-template-columns:1fr">
							<div class="nv-rslt-fix center">
								<div class="nv-result-rctr">
									<span class="nv-number"><?php echo $ncge1; ?></span><span class="nv-number">-</span><span class="nv-number"><?php echo $ncge2; ?></span>
								</div>
							</div>
							<div class="nv-rslt-fix center">
								<div class="nv-result-rctr">
									<span class="nv-number2"><?php echo $pts_e1; ?></span><span class="nv-number2">-</span><span class="nv-number2"><?php echo $pts_e2; ?></span>
								</div>
							</div>
						</div>
						<div class="nv-equip-1 flex2">
							<a class="nv-renc-equip-link <?php if($equipe_gagnante=='équipe 1'){echo "beaten";}?>" href="<?php echo get_the_permalink($equipe2->ID  );?>">
								<span class="nv-equip-name"><?php echo get_the_title($equipe2->ID ); ?></span>
								<img src="<?php echo $logo2; ?>" class="logo-eqi">
							</a>
						</div>
					</div>
					<div><!--
						<div class="rencontre_direct">
							<img src="/wp-content/uploads/2023/07/<?php //echo $icone_status;?>">
							<span>
								<?php //echo $statut;?>
							</span>
						</div>
					-->
						<div class="jr-rct-1">
							<span class="jr-nv-1">
								
								<?php echo get_field( "intitule");?></span>
							<span class="rct-nv-1"><?php echo get_field( "lieu_rencontre");?></span>
						</div>
					</div>
				</div>
			<?php
				endwhile;
			?>
		<?php
			}
		?>

			<?php if($video!=null){ 







			$iframe=substr($video, strrpos($video, '=' )+1);?>







            <div class="live-video">
                <div class="live">
                    <iframe src="https://www.youtube.com/embed/<?php echo $iframe;?>" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
			</div>
            </div>
			<?php } ?>
        </div>
    </section>
    <?php
   if(shortcode_exists('fiche_rencontre')) {
    	echo do_shortcode('[fiche_rencontre callback="fiche_rencontre" ]');
	}
	else {
		$data=fiche_rencontre();
    	echo $data['html'];
	}
    ?>
    <section>
		<?php
			$args=array(
			'post_type'=> 'galerie',
			'posts_per_page' => -1,
			'orderby' => 'post_date', 
			'order' => 'DESC',
			'meta_query' => array(
			'relation' => 'AND',
				array(
				'key' => 'rencontre', // recherche sur le champ rencontre de type relation
				'value' => '"' . get_the_ID() . '"', // id de la rencontre
				'compare' => 'LIKE')
				),
			);
			$galeries=get_posts($args);
		?>



<?php if($galeries):?>



	<section class="nv-liste-judoka pd-5">



            <div class="container">



                <h2 class="nv-title-clsm">GALERIES <?php echo $title;?></h2>



                <div class="galerie-images-resultat m-t-0">
					<div class="liste-images-galerie judo_pro_league page-eq-gal" >



                <?php  //var_dump($images);exit(-1);







                    foreach ($galeries as $image_galerie):



                        $photos=get_field('photos',$image_galerie->ID);



                        $credit_images = get_field('credit_images',$image_galerie->ID);



                        $titre = get_field('titre',$image_galerie->ID);



                        $cover=$photos[0];



                        $link=get_the_permalink($image_galerie->ID);



                ?>







                        



                            







								<?php foreach($photos as $image){?>



								<div class="liste-images-element" style="background-image: url(<?php echo '\''.esc_url($image['sizes']['medium_large']).'\'';?>);">



									<img class="diaporama" src="<?php echo esc_url($image['sizes']['large']); ?>" alt="<?php echo esc_attr($image['alt']); ?>" />



								</div>



								<?php } ?>



						



        



                            



                        



                <?php endforeach;?></div></div>



            </div>



			<?php  if($credit_images){



					echo '<div class="txt-credit text-center"> <p>Crédit photos :  '.$credit_images.'<p></div>';



        }?>	



        </section>



    <?php endif;?>			







		







		







		







        







    </section>







    <?php







    get_footer();
