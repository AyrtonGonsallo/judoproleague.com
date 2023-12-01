<?php


/**




 * Template Name: Modèle rencontres



 */




get_header();


$equipes = get_posts(array(





    'numberposts'   => -1,





    'post_type'     => 'equipes',





	'orderby' => 'title',





	'order' => 'ASC'





));





?>


<script src="https://cdn.jsdelivr.net/npm/@splidejs/splide@4.1.4/dist/js/splide.min.js"></script>
<link href="https://cdn.jsdelivr.net/npm/@splidejs/splide@4.1.4/dist/css/splide.min.css" rel="stylesheet">
<?php date_default_timezone_set('Africa/Porto-Novo'); ?>
<?php 

	$args=array(
		'post_type'=> 'rencontre',
		'posts_per_page' => 20,
        'order' => 'ASC',
        'orderby'   => 'meta_value',
        'meta_key' => 'date_de_debut',
        'meta_query' => array(
        array(
            'key'       => 'date_de_debut',
            'compare'   => '>=',
            'value'     => date('Y/m/d H:i:s'),
            'type'      => 'NUMERIC' //casting to int
        )
    ) );
    $rencontres=get_posts($args);
    $now=date('Y/m/d H:i:s');
?>




<section class="splide rencontres-section nv-decalage-bandeau nv-sllide"  aria-label="Slide Container Example">
	
  <div class="splide__track" style="">
    <ul class="splide__list">
    <?php 
		foreach ($rencontres as $rencontre):
            $combat=get_field('les_combat', $rencontre->ID)[0];
            $equipe1 =get_field('equipe_1', $rencontre->ID)[0];
            $equipe2 =get_field('equipe_2', $rencontre->ID)[0];
            $score_equipe1 =$combat['nombre_de_combat_gagne_equipe_1'][0];
            $image1_url=(get_field('logo_miniature', $equipe1->ID))?get_field('logo_miniature', $equipe1->ID):get_the_post_thumbnail_url($equipe1->ID);
            $image2_url=(get_field('logo_miniature', $equipe2->ID))?get_field('logo_miniature', $equipe2->ID):get_the_post_thumbnail_url($equipe2->ID);
            $score_equipe2 =$combat['nombre_de_combat_gagne_equipe_2'][0];
            $date_debut=get_field('date_de_debut', $rencontre->ID, false, false);
            $date_fin=get_field('date_de_fin', $rencontre->ID, false, false);
            $statut=get_field('statut', $rencontre->ID)['label'];
            $abreviation1=(get_field('abreviation', $equipe1->ID))?get_field('abreviation', $equipe1->ID):substr($equipe1->post_title,0,4);
            $abreviation2=(get_field('abreviation', $equipe2->ID))?get_field('abreviation', $equipe2->ID):substr($equipe2->post_title,0,4);
            if($statut=='en cours'){
                $status='en cours';
                $lien=get_the_permalink($rencontre->ID);
                $lien2=null;
                $icone_status='icon-rencontre-encours-1.png';
            }else if($statut=='terminé'){
                $status='terminé';
                $lien=get_the_permalink($rencontre->ID);
                $lien2=null;
                $icone_status='icon-rencontre-termine-1.png';
                if((strtotime($now)-strtotime($date_fin))>=86400){
                    continue;
                }
			}
            else if($statut=="à venir"){
                $status='à venir';
                $icone_status='icon-rencontre-a-venir.png';
                $lien=get_the_permalink($rencontre->ID);
                $lien2=get_field('lien_de_reservation', $rencontre->ID);
            }
			//var_dump($equipe1);exit(-1);
        ?>
        <li class="rencontre flip-card splide__slide" style="margin:20px !important;">
            <div class="flip-card-inner splide__slide__container">
                <div class="flip-card-front">
                    <div class="nv-header-rencontre"><span><?php echo get_field('phase', $rencontre->ID)[0]->post_title; ?></span><span class="nv-staut"> <?php echo $status ;?> <img src="/wp-content/uploads/2023/07/<?php echo $icone_status;?>" class="nv-img-statut"></span></div>
                    <div class="nv-team"><span class="nv-name"><?php echo $abreviation1;?></span><img src="<?php echo $image1_url; ?>" class="nv-img"><span class="nv-score"><?php (($status!='à venir')?$score_equipe1:(substr($date_debut,8,2).'.'.substr($date_debut,5,2)));?></span></div>
                    <div class="nv-team"><span class="nv-name"><?php echo $abreviation2;?></span><img src="<?php echo $image2_url; ?>" class="nv-img"><span class="nv-score"><?php (($status!='à venir')?$score_equipe2:(substr($date_debut,11,2).'h'.substr($date_debut,14,2)));?></span></div>
                </div>
                <div class="flip-card-back">
                    <a href="<?php echo $lien;?>" class="nv-all-info">Toutes les infos</a>
                    <?php if($lien2){
                        echo '<a href="'.$lien2.'" target="_blank" class="nv-all-info">Billeterie</a>';
                    }?>
                </div>
            </div>
        </li>
        <?php 
              endforeach ?>
      
    </ul>
  </div>
	<div>       
                <div class="nv-btns" >
                    <a href="<?php echo $lien;?>" target="_blank" class="nv-btn"><img src="/wp-content/uploads/2023/07/youtube.png">Suivre le direct</a>
                    <a href="/judo_pro_league/poule-a/" class="nv-btn"><img src="/wp-content/uploads/2023/07/plus.png">Toutes les rencontres</a>
                </div>
    </div>
</section>

<script>

const splide = new Splide( '.splide' , {
                type: 'loop',
                perPage: 6,
                rewind: true,
                pagination:true,
                breakpoints: {
                    1200:{
                        perPage:4,
                    },
                    992:{
                        perPage:3,
                    },
                    640: {
                        perPage: 2,
                    }
                },
            });


splide.mount();

</script>



    <?php





get_footer();





?>