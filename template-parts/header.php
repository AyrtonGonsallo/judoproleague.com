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

$equipes = get_posts(
    array(
        'numberposts'   => -1,
        'post_type'     => 'equipes',
        'orderby' => 'title',
        'order' => 'ASC',
        'meta_query'     => 
            array(	
                'relation' => 'AND',			
                array(
                    'key'        => 'conference',
                    'compare'    => '=',
                    'value'      => 'Conférence Ouest'
                ),
                array(
                    'key'        => 'saisons',
                    'compare'    => 'LIKE',
                    'value'      => "2024-2025"
                )
            )
    )
);

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

		if(( $post->post_title=="Calendrier résultat Judo Pro League 2023")){

		?>

		<link rel="stylesheet" href="//code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">

  <link rel="stylesheet" href="/resources/demos/style.css">

  <script src="https://code.jquery.com/jquery-3.6.0.js"></script>

  <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>

  <script>

  $( function() {

    $( "#tabs" ).tabs();

  } );

	  $( function() {

    $( "#tabs-rencontres" ).tabs();

  } );

	   $( function() {

    $( "#tabs-quarts" ).tabs();

  } );

	  

  </script>

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

			<button aria-label="Open navigation" class="navbar-toggler">

				<img src="<?php echo get_site_url();?>/wp-content/uploads/2022/11/menu-burger.webp">

			</button>

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

                   

                </div>

			</div>

			<div class="nv-header-right">

				<div class="nv-header-rs">
    <button id="searchBtn" class="search-btn">
        <i class="fa fa-search"></i>
    </button>

    <!-- Popup de recherche -->
    <div id="searchPopup" class="search-popup">
        <div class="search-popup-content">
            <span id="closeSearchPopup" class="close">&times;</span>
            <h2>Rechercher</h2>
            <input type="text" id="searchInput" placeholder="Rechercher...">
            <button id="searchSubmit">Chercher</button>
        </div>
    </div>
					<a href="https://www.youtube.com/channel/UC1f3LEmw3KiLiLmejqt2I2g" target="_blank"><i class="fa-brands fa-youtube" ></i></a>

                    <a href="https://twitter.com/francejudo_" target="_blank"><i class="fa-brands fa-twitter" ></i></a>

                    <a href="https://t.me/joinchat/PUBZaK_-HQk0YjZk" target="_blank"><i class="fa-brands fa-telegram" ></i></a>

				</div>

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

    
    <script>
    jQuery(document).ready(function($) {
        // Obtenez les éléments
        var searchBtn = document.getElementById("searchBtn");
        var searchPopup = document.getElementById("searchPopup");
        var closeSearchPopup = document.getElementById("closeSearchPopup");

        // Ouvrir la popup lorsque le bouton de recherche est cliqué
        searchBtn.onclick = function() {
            searchPopup.style.display = "block";
        }

        // Fermer la popup lorsque le "X" est cliqué
        closeSearchPopup.onclick = function() {
            searchPopup.style.display = "none";
        }

        // Fermer la popup lorsque l'utilisateur clique en dehors de la popup
        window.onclick = function(event) {
            if (event.target == searchPopup) {
                searchPopup.style.display = "none";
            }
        }
    });
    </script>

    
    
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
                            <div class="nv-header-rencontre"><span><?php echo get_field('phase', $rencontre->ID)[0]->post_title.' '.get_field('journee', $rencontre->ID); ?></span><span class="nv-staut"> <?php echo $status ;?> <img src="/wp-content/uploads/2023/07/<?php echo $icone_status;?>" class="nv-img-statut"></span></div>
                            <div class="nv-team"><span class="nv-name"><?php echo $abreviation1;?></span><img src="<?php echo $image1_url; ?>" class="nv-img"><span class="nv-score"><?php echo (($status!='à venir')?$score_equipe1:(substr($date_debut,8,2).'.'.substr($date_debut,5,2)));?></span></div>
                            <div class="nv-team"><span class="nv-name"><?php echo $abreviation2;?></span><img src="<?php echo $image2_url; ?>" class="nv-img"><span class="nv-score"><?php echo (($status!='à venir')?$score_equipe2:(substr($date_debut,11,2).'h'.substr($date_debut,14,2)));?></span></div>
                        </div>
                        <div class="flip-card-back">
                            <a href="<?php echo $lien;?>" class="nv-all-info">Toutes les infos</a>
                            <?php if($lien2){
                                echo '<div class="brd-sep"></div>';
                                echo '<a href="'.$lien2.'" target="_blank" class="nv-all-info">Billetterie</a>';
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
                <?php if(get_sub_field('actif',14)){?>
                    <a href="<?php echo $lien;?>" target="_blank" class="nv-btn"><img src="/wp-content/uploads/2023/07/youtube.png">Suivre le direct</a>
                <?php }?>
                <a href="/calendrier-resultats-2023/" class="nv-btn"><img src="/wp-content/uploads/2023/07/plus.png">Toutes les rencontres</a>
            </div>
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

			 }?>
			

</header>

<?php 

$post_type=get_post_type();

if($post_type=='post'){

	echo '<h1 class="result-h1 fs-65">Actualités de la Judo Pro League</h1>';

}

?>
