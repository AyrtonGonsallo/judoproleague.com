<?php



/**

 * Template Name: Modèle videos par categories

 */

function get_key_categorie_video($label) {
    // Correspondance label → clé
    $map = [
        'editorial'            => 'Éditorial',
        'combat'              => 'Combats',
        'ippon' => 'Ippons de la semaine'
    ];

    // Trouver la clé correspondante
    $key = isset($map[$label]) ? $map[$label] : sanitize_title($label);

    
    return $key;
}

get_header();
$categorie=($_GET["categorie"])?$_GET["categorie"]:"";
$equipe_value=($_GET["equipe_value"])?$_GET["equipe_value"]:0;
$saison_value=($_GET["saison_value"])?$_GET["saison_value"]:"2025-2026";
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
<main id="primary" class="blog site-main liste-videos vid-club-cat page-template-modele-videos-new">
    <div class="season-selector-box">
        <form Method="GET" ACTION="" class="season-selector-form">
            <select name="saison_value" id="saison_value" class="season-selector-select">
                <option value="2022-2023" <?php echo ($saison_value=="2022-2023")?"selected":"";?>>2022-2023</option>
                <option value="2023-2024" <?php echo ($saison_value=="2023-2024")?"selected":"";?>>2023-2024</option>
                <option value="2024-2025" <?php echo ($saison_value=="2024-2025")?"selected":"";?>>2024-2025</option>
                <option value="2025-2026" <?php echo ($saison_value=="2025-2026")?"selected":"";?>>2025-2026</option>


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
        <div>
    </section>
            <?php
                // Prépare la meta_query commune
                $meta_query = [
                    'relation' => 'AND',
                    [
                        'key'     => 'saison',
                        'value'   => $saison_value,
                        'compare' => 'LIKE'
                    ],
                    [
                        'key'     => 'categorie',
                        'value'   => $categorie,
                        'compare' => 'LIKE'
                    ]
                ];

                // Si on a une équipe spécifique, on l'ajoute à la meta_query
                if ($equipe_value != 0) {
                    $meta_query[] = [
                        'key'     => 'equipe1',
                        'value'   => '"' . $equipe_value . '"',
                        'compare' => 'LIKE'
                    ];
                }

                // Crée une requête WP_Query propre
                $args = [
                    'post_type'      => 'video_youtube',
                    'posts_per_page' => -1,
                    'order'          => 'DESC',
                    'orderby'        => 'date',
                    'meta_query'     => $meta_query
                ];

                $videos_query = new WP_Query($args);

                ?>


                        
                <section class="bg-gt"> <!--//ta classe section  -->
                    <div class="container">
                        
                        <span><a href="/liste-videos/">Vidéos</a> > <? echo get_key_categorie_video($categorie);?></span>
                        
                        <? echo '<h2>'.get_key_categorie_video($categorie).'</h2>';?>

                        <div class="col-vids"> <!--//ta classe pour tes grid 2x2 -->

                        <?  
                        while($videos_query->have_posts()){
                            $videos_query->the_post();
                            
                            $image_url=get_the_post_thumbnail_url()?get_the_post_thumbnail_url ():('https://i.ytimg.com/vi/'.get_field('id').'/hqdefault.jpg');
                            $image_url=($i==0)?str_replace("hq","maxres",$image_url):$image_url;

                        ?>
                                <div class="videos-container-element">

                                    <div class="video-preview" style="background-image: url(<?php echo $image_url;?>);">

                                        <div class="button-play-video button-play-video-grande-taille" >

                                            <?php echo do_shortcode('[video_popup url="https://youtu.be/'.get_field('id').'" w="640" h="480" img="'.get_site_url().'/wp-content/uploads/2022/11/play.webp"]') ?>

                                        </div>

                                        

                                    </div>                        

                                    <h3 class="nv-title-news-3-col"><?php echo get_field('titre');?></h3>

                                </div>
                            
                        <?php
                        } ?>
                        </div>
                    </div>
                </section>
                    
                
            


            </div>
        </main>

    

    



    <?php



get_footer();

?>

