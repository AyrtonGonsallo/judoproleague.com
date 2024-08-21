<?php

/**

 * The header for our theme

 *

 * This is the template that displays all of the <head> section and everything up until <div id="content">

 *

 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials

 *

 * @package inox

 */
$equipes = get_posts(array(
    'numberposts' => -1,
    'post_type'   => 'equipes',
    'orderby'     => 'title',
    'order'       => 'ASC',
    'meta_query'  => array(
        array(
            'key'     => 'saisons',
            'compare' => 'LIKE',
            'value'   => '2023-2024'
        )
    )
));
?>

<!doctype html>

<html <?php language_attributes(); ?>>

<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">

	<meta name="viewport" content="width=device-width, initial-scale=1">

	<meta name="facebook-domain-verification" content="nvxm1hchghoa4cfkqi1z59utzn0oxn" />

	<link rel="profile" href="https://gmpg.org/xfn/11">

	<link rel="preconnect" href="https://fonts.googleapis.com">

	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

<script src="https://code.jquery.com/jquery-3.6.1.min.js" integrity="sha256-o88AwQnZB+VDvE9tvIXrMQaPlFFSUTR+nldQm1LuPXQ=" crossorigin="anonymous"></script>

	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" integrity="sha512-xh6O/CkQoPOWDdYTDqeRdPCVd1SpvCA9XXcUnZS2FmJNp1coAFzvtCN9BmamE+4aHK8yyUHUSCcJHgXloTyT2A==" crossorigin="anonymous" referrerpolicy="no-referrer" />

	

	

	<?php wp_head(); ?>

	<?php

		if(($post_type=="judo_pro_league") or ($post->ID==795)){

		?>

		<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">

		<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.min.js" integrity="sha384-IDwe1+LCz02ROU9k972gdyvl+AESN10+x7tBKgc9I5HFtuNz0wWnPclzo6p9vxnk" crossorigin="anonymous"></script>

	<?php

	}

	?>
	<?php
		if(($post->ID==1620)){
	?>
		<link rel="stylesheet" href="/wp-content/themes/judo-pro-league-theme/css/flexslider.css">
		<script src="/wp-content/themes/judo-pro-league-theme/js/jquery.flexslider-min.js"></script>
	<?php } ?>
	<?php

		if(( $post->post_title=="Calendrier résultat Judo Pro League 2023" || $post->post_title=="Calendrier résultat Judo Pro League 2024")){
           

		?>

		<link rel="stylesheet" href="//code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">



  <script src="https://code.jquery.com/jquery-3.6.0.js"></script>

  <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>

  <script>

	  $( function() {
        if( $('.tabs-poules').length ){
            $( "#tabs" ).tabs( { active: 0 } );
            console.log("poules")
        }else if($('.tabs-quarts').length){
            //$( "#tabs" ).tabs( { active: 0 });
            console.log("quarts")
        }else{
            $( "#tabs" ).tabs();
            console.log("autre")
        }
  } );

	   
  </script>

	<?php

	}

	?>
<?php

if(( $post->post_title=="Statistiques équipes judo pro league 2023" || $post->post_title=="Statistiques judokas judo pro league 2023")){
?>
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.css" />
<?php
}
?>
	<?php

		if(($post_type=="judoka")){?>

	<meta name="robots" content="noindex">

	<?php }?>



<script>

!function(f,b,e,v,n,t,s)

{if(f.fbq)return;n=f.fbq=function(){n.callMethod?

n.callMethod.apply(n,arguments):n.queue.push(arguments)};

if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';

n.queue=[];t=b.createElement(e);t.async=!0;

t.src=v;s=b.getElementsByTagName(e)[0];

s.parentNode.insertBefore(t,s)}(window, document,'script',

'https://connect.facebook.net/en_US/fbevents.js');

fbq('init', '1277521052827557');

fbq('track', 'PageView');

</script>

<noscript><img height="1" width="1" style="display:none"

src="https://www.facebook.com/tr?id=1277521052827557&ev=PageView&noscript=1"

/></noscript>

<script>

  var _paq = window._paq = window._paq || [];

  /* tracker methods like "setCustomDimension" should be called before "trackPageView" */

  _paq.push(['trackPageView']);

  _paq.push(['enableLinkTracking']);

  (function() {

    var u="https://ffjudo.matomo.cloud/";

    _paq.push(['setTrackerUrl', u+'matomo.php']);

    _paq.push(['setSiteId', '6']);

    var d=document, g=d.createElement('script'), s=d.getElementsByTagName('script')[0];

    g.async=true; g.src='//cdn.matomo.cloud/ffjudo.matomo.cloud/matomo.js'; s.parentNode.insertBefore(g,s);

  })();

</script>

<!-- End Matomo Code -->

</head>



<body <?php body_class(); ?> >

<?php wp_body_open(); ?>



	<header id="header" class="site-header">

		<div id="page" class="site">

			<a class="skip-link screen-reader-text" href="#primary"><?php esc_html_e( 'Skip to content', 'inox' ); ?></a>

			<div class="brd-header">

				<div class="nv-logo-cpyr container">

					<?php foreach ($equipes as $equipe):

						$logo=(get_field('logo_circle', $equipe->ID))?get_field('logo_circle', $equipe->ID):get_the_post_thumbnail_url($equipe->ID);

						$url=get_permalink($equipe->ID);

						?>



					<a href="<?= $url;?>"><img src="<?php echo $logo;?>"></a>

					 <?php endforeach; ?>

				</div>

			</div>

	<nav class="sps inverse sps--abv" id="navbar">

		<div class="container">

			<?php the_custom_logo(); ?>
    
   <div class="mob-icon">
    <!-- Search Icon -->
          <div class="search-icon">
              <i class="fa fa-search"></i>
          </div>

			<button aria-label="Open navigation" class="navbar-toggler">

				<img src="<?php echo get_site_url();?>/wp-content/uploads/2022/11/menu-burger.webp">

			</button>
    </div>
			<div id="navbar-menu" class="">

				<div id="navbar-mobile-header">

					<button aria-label="Open navigation" class="navbar-toggler">

						<img src='/wp-content/uploads/2022/11/1000-DOJOS-1000dojos-close.webp' class="logo-media">

					</button>

				</div>



				<?php

				wp_nav_menu(

					array(

						'theme_location' => 'menu-1',

						'menu_id'        => 'primary-menu',

						'conatiner' => false,

						'menu_class' => 'navbar-nav',



					)

				); ?>

				<div class="mobile-menu-rs">

                    <a href=""><i class="fa-brands fa-youtube"></i></a>

                    <a href=""><i class="fa-brands fa-twitter"></i></a>

                  
                    <a href=""><i class="fa-brands fa-linkedin-in"></i></a>
    

                    <div class="nv-header-lang">
                        <?php

                        wp_nav_menu(

                        array(

                            'theme_location' => 'langues',

                            'menu_id'        => 'langues-menu',

                            'conatiner' => false,

                            'menu_class' => 'navbar-nav',

                        )

                        ); ?>
                    </div>

			</div>

			<div class="nv-header-right">
    <div class="nv-header-lang">

        <?php

    wp_nav_menu(

        array(

            'theme_location' => 'langues',

            'menu_id'        => 'langues-menu',

            'conatiner' => false,

            'menu_class' => 'navbar-nav',



        )

    ); ?>

    </div>
				<div class="nv-header-rs">
    
    <!-- Search Icon -->
          <div class="search-icon">
              <i class="fa fa-search"></i>
          </div>

    <!-- Search Popup -->
    <div id="search-popup" class="search-popup">
        <div class="search-popup-content">
            <span class="close">&times;</span>
           
            <form id="search-form" role="search" method="get" action="<?php echo home_url('/'); ?>">
               
                    <input type="text" name="s" class="search-field"  value="<?php the_search_query(); ?>">
                    <button type="submit" class="search-submit">Chercher <i class="fa-solid fa-arrow-right-long"></i></button>
                
            </form>
        </div>
    </div>
    
    <script>
    jQuery(document).ready(function($) {
        // Function to show the popup
        function showPopup() {
            $('#search-popup').fadeIn();
        }

        // Function to hide the popup
        function hidePopup() {
            $('#search-popup').fadeOut();
        }

        // Event listener for search icon click
        $(document).on('click', '.search-icon', function() {
            showPopup();
        });

        // Event listener for close button click
        $(document).on('click', '.close', function() {
            hidePopup();
        });

        // Close the popup when clicking outside the content area
        $(document).on('click', function(event) {
            if ($(event.target).closest('.search-popup-content, .search-icon').length === 0) {
                hidePopup();
            }
        });

        // Prevent event propagation for clicks inside the popup content
        $(document).on('click', '.search-popup-content', function(event) {
            event.stopPropagation();
        });

        
    });


    </script>
    <?php
    function enqueue_custom_scripts() {
        wp_enqueue_script('jquery');
        wp_enqueue_script('custom-scripts', get_template_directory_uri() . '/js/scripts.js', array('jquery'), null, true);
    }

    add_action('wp_enqueue_scripts', 'enqueue_custom_scripts');

    ?>
    
    <!-- <a href="https://www.youtube.com/@francejudo_/playlists" target="_blank"><i class="fa-brands fa-youtube" ></i></a>
                    <a href="https://www.facebook.com/judoproleague" target="_blank"><i class="fa-brands fa-facebook-f"></i></a>
                    <a href="https://twitter.com/proleaguejudo" target="_blank"><i class="fa-brands fa-twitter" ></i></a>
                    <a href="https://www.instagram.com/proleaguejudo/" target="_blank"><i class="fa-brands fa-instagram" ></i></a>-->

				</div>



				</div>

			</div>

		</div>

	</nav>

	<?php

		//require_once (THEMEDIR.'inc/acf-blocs/bloc-en-live.php');

		//recuperer_bandeau_live();

		?>		

		<?php

 		if(!($post_type=="equipes") && !($post_type=="judoka") && !($post_type=="galerie") && !($post->ID==1620)){?>

		
<script src="https://cdn.jsdelivr.net/npm/@splidejs/splide@4.1.4/dist/js/splide.min.js"></script>
<link href="https://cdn.jsdelivr.net/npm/@splidejs/splide@4.1.4/dist/css/splide.min.css" rel="stylesheet">
<?php date_default_timezone_set('Africa/Porto-Novo'); ?>
<?php $niveaux_a_afficher=get_field('niveaux_a_afficher','widget_gestionnaire_rencontres_widget-2'); ?>
<?php 
$rencontres=array();
if( have_rows('rencontres_a_afficher','widget_gestionnaire_rencontres_widget-2') ){
    while ( have_rows('rencontres_a_afficher','widget_gestionnaire_rencontres_widget-2') ) : the_row();
    $rencontre = get_sub_field('rencontre');
    $rencontres=array_merge($rencontres,$rencontre);
    endwhile;
}
?>

<?php 
   // $rencontres=get_posts($args);
    $now=date('Y/m/d H:i:s');
?>




<section class="splide rencontres-section nv-decalage-bandeau nv-sllide"  aria-label="Slide Container Example">
    <div class="section-header" style="">
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
                    $matchs_liste=get_field('les_combat',$rencontre->ID);
                    $niveau=(get_field('niveau', $rencontre->ID));
                    $equipe_gagnante = $matchs_liste[0]['equipe_gagnante'];
                    
                    if($statut=='en cours'){
                        $status='en cours';
                        $lien=get_the_permalink($rencontre->ID);
                        $lien_live=get_field('video_live', $rencontre->ID);
                        $lien_billets=null;
                        $icone_status='icon-rencontre-encours-1.png';
                    }else if($statut=='terminé'){
                        $status='terminé';
                        $lien=get_the_permalink($rencontre->ID);
                        $lien_billets=null;
                        $lien_live=null;
                        $icone_status='icon-rencontre-termine-1.png';
                        /*if((strtotime($now)-strtotime($date_fin))>=86400){
                            continue;
                        }*/
                    }
                    else if($statut=="à venir"){
                        $status='à venir';
                        $icone_status='icon-rencontre-a-venir.png';
                        $lien=get_the_permalink($rencontre->ID);
                        $lien_live=null;
                        $lien_billets=get_field('lien_de_reservation', $rencontre->ID);
                    }
                    //var_dump($equipe1);exit(-1);
                ?>
                <li class="rencontre-element flip-card splide__slide" style="margin:20px !important;">
                    <div class="flip-card-inner splide__slide__container">
                        <div class="flip-card-front">
                            <div class="nv-header-rencontre"><span><?php echo get_field('phase', $rencontre->ID)[0]->post_title.' '.get_field('journee', $rencontre->ID); ?></span><span class="nv-staut"> <?php echo $status ;?> <img src="/wp-content/uploads/2023/07/<?php echo $icone_status;?>" class="nv-img-statut"></span></div>
                            <div class="nv-team <?php if($equipe_gagnante=='équipe 2'){echo "beaten";}?>" ><span class="nv-name"><?php echo $abreviation1;?></span><img src="<?php echo $image1_url; ?>" class="nv-img"><span class="nv-score"><?php echo (($status!='à venir')?$score_equipe1:(substr($date_debut,8,2).'/'.substr($date_debut,5,2)));?></span></div>
                            <div class="nv-team <?php if($equipe_gagnante=='équipe 1'){echo "beaten";}?>"><span class="nv-name"><?php echo $abreviation2;?></span><img src="<?php echo $image2_url; ?>" class="nv-img"><span class="nv-score"><?php if($status!='à venir'){echo $score_equipe2;}else{echo substr($date_debut,11,2).'h'.substr($date_debut,14,2);}?></span></div>
                        </div>
                        <div class="flip-card-back">
                            <a href="<?php echo $lien;?>" class="nv-all-info">Toutes les infos</a>
                            <?php if($lien_billets){
                                echo '<div class="brd-sep"></div>';
                                echo '<a href="'.$lien_billets.'" target="_blank" class="nv-all-info">Billetterie</a>';
                            }?>
                            <?php if($lien_live){
                                echo '<div class="brd-sep"></div>';
                                echo '<a href="'.$lien_live.'" target="_blank" class="nv-all-info">Suivre le live</a>';
                            }?>
                        </div>
                    </div>
                </li>
                <?php 
                        endforeach ?>
                
                <li class="rencontre flip-card splide__slide" style="margin:20px !important;">
                    <div class="flip-card-inner splide__slide__container">
                        <div class="flip-card-front">
                            <div class="nv-header-rencontre"><span>Finale</span><span class="nv-staut">  à venir  <img src="/wp-content/uploads/2023/07/icon-rencontre-a-venir.png" class="nv-img-statut"></span></div>
                            <div class="nv-team" ><span class="nv-name">SGS</span><img src="https://judoproleague.com/wp-content/uploads/2023/07/logo-sgs-judo_rouge-mini.png" class="nv-img"><span class="nv-score">06/01</span></div>
                            
                            <div class="nv-team nv-team-final4"><span class="nv-name-final4">Vainqueur DF 2</span><span class="nv-score">18h30 </span></div>
                        </div>
                        <div class="flip-card-back">
                        <a href="<?php echo $lien;?>" class="nv-all-info">Toutes les infos</a>
                            <?php if($lien_billets){
                                echo '<div class="brd-sep"></div>';
                                echo '<a href="'.$lien_billets.'" target="_blank" class="nv-all-info">Billetterie</a>';
                            }?>
                            <?php if($lien_live){
                                echo '<div class="brd-sep"></div>';
                                echo '<a href="'.$lien_live.'" target="_blank" class="nv-all-info">Suivre le live</a>';
                            }?>
                        </div>
                    </div>
                </li>
                
            </ul>
        </div>
        <div>       
            <div class="nv-btns" >
                <?php 
                while ( have_rows('articles',14))
                {
                    the_row();
                    $style=get_row_layout();
                    //site_debug("style=$style");
                    $section=false;
                    switch($style)
                    {
                        case 'evenement_en_live':
                            $actif   = get_sub_field('actif',14);
                            $lien  = get_sub_field('lien',14);
                        break;
                    }
                    
                }
                
                if($actif){?>
                    <a href="<?php echo $lien;?>" target="_blank" class="nv-btn"><img src="/wp-content/uploads/2023/07/youtube.png">Suivre le direct</a>
                <?php }?>
                <a href="/calendrier-resultats-2023/final4/" class="nv-btn"><img src="/wp-content/uploads/2023/07/plus.png">Toutes les rencontres</a>
            </div>
        </div>
    </div>
</section>

<script>

const splide = new Splide( '.splide' , {
                type: 'slide',
                perPage: 6,
                rewind: false,
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

			 }?>
			

</header>
<div id="recherche-box">
	 <?php echo do_shortcode( '[search_form]' ); ?>
<!-- 	 <?php echo do_shortcode( '[ays_survey id="2"]' ); ?> -->
</div>

<?php 

$post_type=get_post_type();

if($post_type=='post' && !$_GET['s']){

	echo '<h1 class="result-h1 fs-65">Actualités de la Judo Pro League</h1>';

}

?>
