<?php

function afficher_bandeau_live() {
    $actif   = get_sub_field('actif',14);
    $counter_background   = get_sub_field('counter_background');
    $intitule   = get_sub_field('intitule');
    $horaires   = get_sub_field('horaires');
    $lien  = get_sub_field('lien');
    ?>
    <?php if($actif):?>
        <section class="section-event-live">
            <div class="events-live">
                <div class="event-live-title">
                    <b class="title-bandeau"> <?php echo ' LIVE    : '.$intitule; if($horaires): echo ' ( '.$horaires.' ) '; endif;?></b>
                </div>
                <?php if($lien):?>
                    <div class="button-bandeau-live">
                        <a href="<?php echo $lien;?>"  title="suivre en live" target="_blank">
                            <span class="bouton-bandeau">suivre le direct </span>
                        </a>
                        <img src="<?php echo get_site_url();?>/wp-content/uploads/2022/11/live.webp" class="picto-live"  >
                    </div>
                <?php endif;?>
            </div>
        </section>
    <?php endif;?>
    
<?php
}

function recuperer_bandeau_live() {
    
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
            $section=afficher_bandeau_live();
            break;
        }
    }

    
}