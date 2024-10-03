<?php



/**

 * Template Name: Modèle videos(new)

 */



get_header();
$equipe_value=($_GET["equipe_value"])?$_GET["equipe_value"]:0;
$saison_value=($_GET["saison_value"])?$_GET["saison_value"]:"2024-2025";
$args_teams=array(
    'post_type'=> 'equipes',
    'posts_per_page' => -1,
    'orderby' => 'title',
    'order' => 'ASC',
    );
$equipes=get_posts($args_teams);
$img="/wp-content/uploads/2022/12/image00011.webp";

?>
<script>
        $(document).ready(function() {
            $('#saison_value').change(function() {
                $('.season-selector-form').submit();
            });
            $('#equipe_value').change(function() {
                $('.season-selector-form').submit();
            });
        });
    </script>
<main id="primary" class="blog site-main liste-videos">
    <div class="season-selector-box">
        <form Method="GET" ACTION="" class="season-selector-form">
            <select name="saison_value" id="saison_value" class="season-selector-select">
                <option value="2022-2023" <?php echo ($saison_value=="2022-2023")?"selected":"";?>>2022-2023</option>
                <option value="2023-2024" <?php echo ($saison_value=="2023-2024")?"selected":"";?>>2023-2024</option>
                <option value="2024-2025" <?php echo ($saison_value=="2024-2025")?"selected":"";?>>2024-2025</option>

            </select>
            <select name="equipe_value" id="equipe_value" class="team-selector-select">
            <option value="0">Toutes les équipes</option>

            <?php foreach ($equipes as $equipe) {
                $title=get_the_title($equipe->ID);
                ?>
                
                        <option value="<?php echo $equipe->ID;?>" <?php echo ($equipe_value==$equipe->ID)?"selected":"";?>><?php echo $title;?></option>

                    <?php }?>
                
            </select>
        </form>
    </div>

    
    <section class="nv-liste-judoka pd-5">

        <div class="container">
        <h1 class="result-h1">Vidéos Judo Pro League <?php echo $saison_value;?></h1>
            <?php //recuperer les dernieres series
                if($equipe_value!=0){
                    query_posts(
                        array(
                            'post_type'=> 'video_youtube',
                            'posts_per_page' => -1,
                            'order' => 'DESC',
                            'orderby' => 'date',
                            'meta_query'     => array(		
                                'relation' => 'AND',				
                                array(
                                    'key'        => 'equipe1',
                                    'compare'    => 'LIKE',
                                    'value'   => '"' . $equipe_value . '"'
                                ),
                                array(
                                    'key'        => 'saison',
                                    'compare'    => 'LIKE',
                                    'value'      => $saison_value
                                )
                            )
                        )
                    );
                }else{
                    query_posts(
                        array(
                            'post_type'=> 'video_youtube',
                            'posts_per_page' => -1,
                            'order' => 'DESC',
                            'orderby' => 'date',
                            'meta_query'     => array(		
                                'relation' => 'AND',				
                                array(
                                    'key'        => 'saison',
                                    'compare'    => 'LIKE',
                                    'value'      => $saison_value
                                )
                            )
                        )
                    );
                }

                

            ?>

            <?php if ( have_posts() ) :
              $i=0;
            ?>

                <div class="videos-container" id="videoscontainer">

                    <?php while ( have_posts() ) : the_post();  
                        $image_url=get_the_post_thumbnail_url()?get_the_post_thumbnail_url ():('https://i.ytimg.com/vi/'.get_field('id').'/hqdefault.jpg');
                        $image_url=($i==0)?str_replace("hq","maxres",$image_url):$image_url;

                        ?>

                        <div class="videos-container-element">

                            <div class="video-preview" style="background-image: url(<?php echo $image_url;?>);">

                                <div class="button-play-video button-play-video-grande-taille" >

                                    <?php echo do_shortcode('[video_lightbox_youtube video_id="'.get_field('id').'" width="640" height="480" anchor="'.get_site_url().'/wp-content/uploads/2022/11/play.webp"]') ?>

                                </div>

                                <div class="button-play-video button-play-video-mobile" >

                                    <?php echo do_shortcode('[video_lightbox_youtube video_id="'.get_field('id').'" width="300" height="160" anchor="'.get_site_url().'/wp-content/uploads/2022/11/play.webp"]') ?>

                                </div>

                            </div>                        

                            <h3 class="nv-title-news-3-col"><?php echo get_field('titre');?></h3>

                        </div>

                    <?php 
                    $i+=1;
                endwhile;?> 

                <?php else: ?>

                    <p>Aucun résultat.</p>

                                    

            <?php endif; wp_reset_query();?>

            </div>

        </div>

    </section>

</main>

    

    



    <?php

get_footer();

?>

