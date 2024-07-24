<?php

function afficher_video_live() {

    $actif   = get_sub_field('actif',14);



    $counter_background   = get_sub_field('counter_background');



    $intitule   = get_sub_field('intitule');



    $horaires   = get_sub_field('horaires');



    $lien  = get_sub_field('lien');


?>



    <?php if($actif):?>


        <section class="section-event-live" style="background-image: url(http://www.rimo0631.odns.fr/wp-content/uploads/2024/07/bg-live.jpg);background-size:cover;background-repeat:no-repeat; background-position:center;">
        <div class="live-vid-flx">
        
               <div class="live-vid">
              
                     <span class="live-vid-txt"> LE DIRECT </span>
                     <img src="http://www.rimo0631.odns.fr/wp-content/uploads/2024/07/live-icon.svg"/>
        
               </div>
        
        
            <div class="nv-live-video" style="">


                <?php if($lien):

                    $id = explode('watch?v=', $lien)[1];?>


                    <iframe width="100%" height="400px" src="https://www.youtube.com/embed/<?php  echo $id;?>" frameborder="0" allowfullscreen></iframe>


                <?php endif;?>


            </div>

        </div>
        </section>


    <?php endif;?>





<?php


}


function recuperer_video_live() {



    while ( have_rows('articles',14))


    {


        the_row();

        $style=get_row_layout();


        //site_debug("style=$style");


        $section=false;


        switch($style)


        {


            case 'evenement_en_live':


            require_once (THEMEDIR.'inc/acf-blocs/bloc-en-live.php');


            $section=afficher_video_live();



            break;



        }



    }


}
