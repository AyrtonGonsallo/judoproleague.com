<?php

/**
 * A custom ACF widget.
 */
class bandeau_partenaires_Widget extends WP_Widget {

    /**
    * Register widget with WordPress.
    */
    function __construct() {
        parent::__construct(
            'bandeau_partenaires_widget', // Base ID
            __('Bandeau Partenaires Widget', 'text_domain'), // Name
            array( 'description' => __( 'A custom ACF widget', 'text_domain' ), 'classname' => 'acf-custom-widget' ) // Args
        );
    }

    /**
    * Front-end display of widget.
    *
    * @see WP_Widget::widget()
    *
    * @param array $args     Widget arguments.
    * @param array $instance Saved values from database.
    */
    public function widget( $args, $instance ) {
        
//echo $args['widget_id']; 


    //var_dump( get_field('liste_des_partenaires', 'widget_'.$args['widget_id'])[0]["nos_partenaires"]);            
$liste_des_partenaires = get_field('liste_des_partenaires','widget_'.$args['widget_id'])[0]["nos_partenaires"];    
   
        if ( $liste_des_partenaires ) :
            ?>
            <section class="logo-partenaire">
                <h3 class="titre-partners">Partenaires</h3>
                <div class="logos-partners">
                    <?php
                   foreach ( $liste_des_partenaires as $partenaire ) :
                        // Set variables
                        $logo = get_field('logo_partenaire',$partenaire->ID);
                        $site_web = get_field('site_partenaire');
                        //var_dump( $partenaire);            

                        // Output
                        ?>
                                <div class="logo-partner">
                                    <a href="<?= $site_web; ?>" target="_blank"><img src="<?= $logo["url"]; ?>" /></a>
                                </div>
                                
                                        
                    <?php
                    endforeach;
                    
                    ?>                
                </div>
            </section>
                <?php
        endif;
	?>
<?php

                    
            


        
    }

    /**
    * Back-end widget form.
    *
    * @see WP_Widget::form()
    *
    * @param array $instance Previously saved values from database.
    */
    public function form( $instance ) {
        if ( isset($instance['title']) ) {
            $title = $instance['title'];
        }
    ?>
    <p>
      <label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title' ); ?></label>
      <input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">
    </p>
    <?php
    }

    /**
    * Sanitize widget form values as they are saved.
    *
    * @see WP_Widget::update()
    *
    * @param array $new_instance Values just sent to be saved.
    * @param array $old_instance Previously saved values from database.
    *
    * @return array Updated safe values to be saved.
    */
    public function update( $new_instance, $old_instance ) {
        $instance = array();
        $instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';

        return $instance;
    }

} // class ACF_Custom_Widget

// register ACF_Custom_Widget widget
add_action( 'widgets_init', function(){
  register_widget( 'bandeau_partenaires_Widget' );
});