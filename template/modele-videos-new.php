<?php



/**

 * Template Name: Modèle videos(new)

 */

function get_key_categorie_video($label) {
    // Correspondance label → clé
    $map = [
        'Éditorial'            => 'editorial',
        'Combats'              => 'combat',
        'Ippons de la semaine' => 'ippon'
    ];

    // Trouver la clé correspondante
    $key = isset($map[$label]) ? $map[$label] : sanitize_title($label);

    
    return $key;
}


get_header();
$equipe_value=($_GET["equipe_value"])?$_GET["equipe_value"]:0;
$saison_value=($_GET["saison_value"])?$_GET["saison_value"]:"2026-2027";
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
<main id="primary" class="blog site-main liste-videos vid-club-cat">
    <div class="season-selector-box">
        <form Method="GET" ACTION="" class="season-selector-form">
            <select name="saison_value" id="saison_value" class="season-selector-select">
                <option value="2022-2023" <?php echo ($saison_value=="2022-2023")?"selected":"";?>>2022-2023</option>
                <option value="2023-2024" <?php echo ($saison_value=="2023-2024")?"selected":"";?>>2023-2024</option>
                <option value="2024-2025" <?php echo ($saison_value=="2024-2025")?"selected":"";?>>2024-2025</option>
                <option value="2025-2026" <?php echo ($saison_value=="2025-2026")?"selected":"";?>>2025-2026</option>
                <option value="2026-2027" <?php echo ($saison_value=="2026-2027")?"selected":"";?>>2026-2027</option>


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

                // Déterminer le meta_query de base selon équipe
                $base_meta_query = array('relation' => 'AND');

                if($equipe_value != 0){
                    $base_meta_query[] = array(
                        'key'     => 'equipe1',
                        'compare' => 'LIKE',
                        'value'   => '"' . $equipe_value . '"'
                    );
                }

                $base_meta_query[] = array(
                    'key'     => 'saison',
                    'compare' => 'LIKE',
                    'value'   => $saison_value
                );

                // --- 1) Vidéo "à la une" ---
                $featured_query = new WP_Query(array(
                    'post_type'      => 'video_youtube',
                    'posts_per_page' => 1,
                    'meta_query'     => array_merge($base_meta_query, array(
                        array(
                            'key'     => 'a_la_une',
                            'value'   => '1',  // ACF checkbox true
                            'compare' => '='
                        )
                    )),
                    'orderby' => 'date',
                    'order'   => 'DESC'
                ));

                // --- 2) Groupes de vidéos par catégorie ---
                $categories = array('editorial','combat','ippon'); // tes catégories ACF

                $category_queries = array();

                foreach($categories as $cat){
                    $category_queries[$cat] = new WP_Query(array(
                        'post_type'      => 'video_youtube',
                        'posts_per_page' => 4,
                        'meta_query'     => array_merge($base_meta_query, array(
                            array(
                                'key'     => 'categorie',
                                'value'   => $cat,
                                'compare' => 'LIKE'
                            )
                        )),
                        'orderby' => 'date',
                        'order'   => 'DESC'
                    ));
                }?>


            <section> <!--//ta classe section a la une -->
                <div class="container">
                    <div> <!--//ta classe pour ta grid 1x1 -->
                    <?
                    if($featured_query->have_posts()){
                        while($featured_query->have_posts()){
                            $featured_query->the_post();

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
                            
                        }
                    }
                    wp_reset_postdata();
                    ?>
                    </div>
                </div>
            </section>

          
               
                <?
                // 2) Groupes
                foreach($categories as $cat){
                    $q = $category_queries[$cat];
                    if($q->have_posts()){
                        $first_post = $q->posts[0]; // ne change pas le pointeur interne
        $acf_categorie = get_field('categorie', $first_post->ID);
                        ?>
                        <section class="bg-gt"> <!--//ta classe section  -->
                            <div class="container main-info-eq">
                                <div class="div-flx-nv">
                                    <? echo '<h2 class="nv-title-clsm">'.ucfirst($acf_categorie).'</h2>';?>
                                    <div style="text-align:center;margin-top:0px !important">
                                        <a href="toutes-les-videos/?categorie=<?php echo get_key_categorie_video($acf_categorie);?>&saison_value=<?php echo $saison_value;?>" class="more-actu"><span>Toutes les vidéos</span><i class="fa-solid fa-arrow-right-long"></i></a>
                                    </div>
                                </div>
                                
                               

                                <div class="col-vids"> <!--//ta classe pour tes grid 2x2 -->

                                <?  
                                while($q->have_posts()){
                                    $q->the_post();
                                    
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
                    <?php } 
                    wp_reset_postdata();
                }?>
                
            


            </div>
        </main>

    

    



    <?php



get_footer();

?>

