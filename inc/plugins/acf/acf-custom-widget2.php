<?php

/**
 * A custom ACF widget.
 */
class gestionnaire_rencontres_Widget extends WP_Widget {

    /**
    * Register widget with WordPress.
    */
    function __construct() {
        parent::__construct(
            'gestionnaire_rencontres_widget', // Base ID
            __('Gestionnaire rencontres Widget', 'text_domain'), // Name
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
$niveaux_a_afficher = get_field('niveaux_a_afficher','widget_'.$args['widget_id']);    
//echo $args['widget_id'];
   //($niveaux_a_afficher);exit(0);
        /**if ( $niveaux_a_afficher ) :
            foreach ($niveaux_a_afficher as $niveau_a_afficher):
                echo $niveau_a_afficher.'<br/>';
            endforeach;
        endif;**/
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
  register_widget( 'gestionnaire_rencontres_Widget' );
});