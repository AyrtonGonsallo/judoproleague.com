<?php
/**
 * Template part for displaying posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package pro-league
/
 */
$site = get_field('site_web');

$description = get_field('presentation'); 

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

$args=array('post_type'=> 'video_youtube','posts_per_page' => -1,'order' => 'ASC','orderby' => 'title',	'meta_query' => array(

'relation' => 'AND',


array(

'key' => 'equipe1', // recherche sur le champ équipe de type relation

'value' => '"' . get_the_ID() . '"', // id de l'équipe

'compare' => 'LIKE'

)

),

);
$videos=get_posts($args);

$img="/wp-content/uploads/2022/12/image00011.webp";

$gender=  get_field('genre');

$current_fp = get_query_var('fpage');

$team_permalink = get_the_permalink($post->ID);
/* =========================================================
 * DONNÉES ÉQUIPE
 * ========================================================= */

$team_id = get_the_ID();

$site          = get_field( 'site_web', $team_id );
$description   = get_field( 'presentation', $team_id );
$directeur     = get_field( 'directeur', $team_id );
$entraineur    = get_field( 'entraineur', $team_id );
$date_creation = get_field( 'date_de_creation', $team_id );
$reseaux       = get_field( 'reseaux_sociaux', $team_id );
$palmares      = get_field( 'palmares', $team_id );
$galerie_photos = get_field( 'galerie_photos', $team_id );
$partenaires   = get_field( 'partenaires', $team_id );
$gender        = get_field( 'genre', $team_id );

$current_fp = get_query_var( 'fpage' );

$title = get_field( 'titre_de_la_page', $team_id );

$couleur1 = get_field( 'couleur1', $team_id );
$couleur2 = get_field( 'couleur2', $team_id );

$couleur1 = $couleur1 ? $couleur1 : '#040b89';
$couleur2 = $couleur2 ? $couleur2 : '#e00078';

$logo_principal = get_field( 'logo_principal', $team_id );
$logo_circle    = get_field( 'logo_circle', $team_id );

$logo_principal_url = $logo_principal
    ? $logo_principal
    : get_the_post_thumbnail_url( $team_id, 'full' );

$logo_circle_url = $logo_circle
    ? $logo_circle
    : $logo_principal_url;

$team_permalink = trailingslashit( get_permalink( $team_id ) );
$team_name      = get_the_title( $team_id );

$photo_du_staff = get_field( 'photo_du_staff', $team_id );

/* =========================================================
 * MENU ÉQUIPE
 * ========================================================= */

$menu_items = array(
    'infos' => array(
        'label' => 'Infos générales',
        'url'   => $team_permalink,
    ),
    'actus' => array(
        'label' => 'Actualités',
        'url'   => $team_permalink . 'actus/',
    ),
    'photos' => array(
        'label' => 'Photos',
        'url'   => $team_permalink . 'photos/',
    ),
    'videos' => array(
        'label' => 'Vidéos',
        'url'   => $team_permalink . 'videos/',
    ),
    'calendrier_resultats' => array(
        'label' => 'Calendrier / Résultats',
        'url'   => $team_permalink . 'calendrier_resultats/',
    ),
    'judokas' => array(
        'label' => 'Judokas',
        'url'   => $team_permalink . 'judokas/',
    ),
);
?>
<article
    id="post-<?php the_ID(); ?>"
    <?php post_class('jpl-team-page'); ?>
    style="
        --team-color-1: <?php echo esc_attr($couleur1); ?>;
        --team-color-2: <?php echo esc_attr($couleur2); ?>;
        --team-gradient: linear-gradient(
            90deg,
            <?php echo esc_attr($couleur1); ?> 0%,
            <?php echo esc_attr($couleur2); ?> 100%
        );
    "
>
    <!-- =====================================================
         HEADER ÉQUIPE
    ====================================================== -->

    <section
        class="jpl-team-header"
        style="
            --team-color-1: <?php echo esc_attr( $couleur1 ); ?>;
            --team-color-2: <?php echo esc_attr( $couleur2 ); ?>;
        "
    >

        <div class="jpl-team-container">

            <div class="jpl-team-identity">

                <!-- LOGO -->
                <div class="jpl-team-main-logo">

                    <?php if ( $logo_principal_url ) : ?>

                        <a
                            href="<?php echo esc_url( $team_permalink ); ?>"
                            class="jpl-team-logo-link"
                        >
                            <img
                                src="<?php echo esc_url( $logo_principal_url ); ?>"
                                alt="<?php echo esc_attr( $team_name ); ?>"
                            >
                        </a>

                    <?php endif; ?>

                </div>

                <!-- MENU ÉQUIPE -->
                <nav
                    class="jpl-team-menu"
                    aria-label="Navigation <?php echo esc_attr( $team_name ); ?>"
                >

                    <?php foreach ( $menu_items as $key => $item ) : ?>

                        <a
                            href="<?php echo esc_url( $item['url'] ); ?>"
                            class="jpl-team-menu-link <?php echo ( 'videos' === $key ) ? 'is-active' : ''; ?>"
                            style="
                                --menu-color: <?php echo esc_attr( 'videos' === $key ? $couleur1 : $couleur2 ); ?>;
                                --menu-color-hover: <?php echo esc_attr( 'videos' === $key ? $couleur2 : $couleur1 ); ?>;
                            "
                        >
                            <?php echo esc_html( $item['label'] ); ?>
                        </a>

                    <?php endforeach; ?>

                </nav>

            </div>

        </div>

    </section>


			<div  class="blog site-main liste-videos judo_pro_league page-eq-vid" style="max-width:1401px;">
				<div class="jpl-team-topbar">
                <a
                    href="<?php echo esc_url(home_url('/equipes-judo-pro-league/')); ?>"
                    class="jpl-team-back"
                >
                    <i class="fa-solid fa-arrow-left"></i>
                    <span>Retour aux équipes</span>
                </a>
				                <div class="jpl-team-breadcrumb">
                    <a href="<?php echo esc_url(home_url('/equipes-judo-pro-league/')); ?>">
                        Équipes
                    </a>
                    <span>/</span>
                    <a href="<?php echo esc_url($team_permalink . 'infos/'); ?>">
                        <?php echo esc_html(get_the_title()); ?>
                    </a>
                    <span>/</span>
                    <strong>Vidéos</strong>
                </div>	
            </div>
        <!-- =====================================================
             HERO DE SECTION
        ====================================================== -->
        <section class="jpl-team-section-header">
                            <div>

                    <span class="jpl-page-eyebrow">
                        <?php echo esc_html( $team_name ); ?>
                    </span>

                    <h1 class="jpl-page-title">
                        Vidéos
                    </h1>

                    <p class="jpl-page-description">
                        Découvrez les vidéos de l'équipe.
<!--                         <?php echo esc_html( $saison_value ); ?>. -->
                    </p>

                </div>
        </section>
                <div class="liste-images-galerie" style="">

                    <?php foreach ($videos as $video_object):

                        $id=get_field('id', $video_object->ID);

                        $video_url='https://youtu.be/'.$id;
                        $date_dajout=get_the_date('j F Y', $video_object->ID );


                        $titre=get_field('titre', $video_object->ID);


                        $image_url=get_the_post_thumbnail_url($video_object->ID)?get_the_post_thumbnail_url ($video_object->ID):('https://i.ytimg.com/vi/'.get_field('id',$video_object->ID).'/hqdefault.jpg');


                    ?>


                        <div class="jpl-video-card">


                        <div class="jpl-video-image" style="background-image: url(<?php echo $image_url; ?>);">

 <div class="jpl-video-play">
<?php 
    echo '<div class="button-play-video button-play-video-grande-taille">'.do_shortcode('[video_popup url="'.$video_url.'" img="'.get_site_url().'/wp-content/uploads/2022/11/play.webp"]').'</div>';

   // echo '<div class="button-play-video button-play-video-grande-taille">'.do_shortcode('[video_lightbox_youtube video_id="'.$id.'" width="640" height="480" anchor="'.get_site_url().'/wp-content/uploads/2022/11/play.webp"]').'</div>';



    //echo '<div class="button-play-video button-play-video-mobile">'.do_shortcode('[video_lightbox_youtube video_id="'.$id.'" width="300" height="160" anchor="'.get_site_url().'/wp-content/uploads/2022/11/play.webp"]').'</div>';



?>

</div>

</div>


                            <div class="jpl-video-content">
                                <a href="#" class=""><h3 class=""><?= $video_object->post_title?></h3></a>
                                    <span style="color:<?php echo $couleur1;?>"><?php $date=get_the_date('j F Y', $my_post->ID ); echo $date; ?></span>


                                </div>


                        </div>


                    <?php endforeach; ?>
                    </div>

	</div><!-- .entry-content -->

</article>


<style>
    .team-link:hover {
        background: <?php echo esc_attr($couleur1); ?> !important;
    }
</style>