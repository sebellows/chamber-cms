<?php

namespace Chamber\Widgets;

use Chamber\Helper;

/**
 * @see docs
 */
class Card extends \WP_Widget {

    public function __construct()
    {
        $this->widget_class = Helper::prefix('card_widget');
        $this->widget_id    = Helper::slugify($this->widget_class);
        $this->widget_name  = Helper::humanize($this->widget_class);

        $params = [
            'classname'   => $this->widget_class,
            'description' => 'A card-like display for calls-to-action.'
        ];
        parent::__construct( $this->widget_id, $this->widget_name, $params );

        add_action('admin_enqueue_scripts', [$this, 'upload_scripts']);
    }

    /**
     * Upload the Javascripts for the media uploader.
     *
     * -NOTE-: These are default Wordpress scripts, not custom. 
     *         This is just to make sure they are enqueued correctly.
     */
    public function upload_scripts()
    {
        // for the media upload
        wp_enqueue_script('media-upload');
        wp_enqueue_script('thickbox');
        wp_enqueue_script('image_widget', Helper::assetUrl('/js/jquery.cardWidget.js'), array('jquery'));
        wp_enqueue_style('thickbox');

        // for the date picker
        if ( isset( $add_datepicker) && is_active_widget(false, __NAMESPACE__.'\\cardWidget' ) ) {
            if ( ! wp_script_is( 'jquery-ui-datepicker', 'enqueued' ) ) {
                return;
            } else {
                wp_enqueue_script('jquery-ui-datepicker');
            }
            wp_enqueue_style('jquery-style', 'http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.2/themes/smoothness/jquery-ui.css');
        }
    }

    /**
     * Outputs the HTML for the widget.
     *
     * @param array  An array of standard parameters for widgets.
     * @param array  An array of settings for this widget instance.
     * 
     * @return void  Echo the output.
     **/
    public function widget( $args, $instance )
    {

        if ( ! isset( $args['widget_id'] ) ) {
            $args['widget_id'] = $this->id;
        }

        $title          = apply_filters( 'widget_title', $instance['title'], $instance, $this->id_base );
        $image          = isset( $instance['image'] )          ? $instance['image']          : false;
        $desc           = isset( $instance['desc'] )           ? $instance['desc']           : false;
        $link           = isset( $instance['link'] )           ? $instance['link']           : false;
        $add_datepicker = isset( $instance['add_datepicker'] ) ? $instance['add_datepicker'] : false;
        $datepicker     = isset( $instance['datepicker'] )     ? $instance['datepicker']     : false;

        ?>

        <?php echo $args['before_widget']; ?>

        <div class="chamber-card"<?php if ($image) { echo ' style="background-image:url(' . $image . ');"'; } ?> >
            <div class="chamber-card-skrim"></div>
            <div class="chamber-card-content">
                <?php if ( $title ) : ?>
                    <?php echo $args['before_title'] . $title . $args['after_title']; ?>
                <?php endif; ?>
                <?php if ( $datepicker ) : ?>
                    <time class="chamber-card-meta"><?php echo $datepicker; ?></time>
                <?php endif; ?>
                <?php if ( $desc ) : ?>
                    <p><?php echo $desc; ?></p>
                <?php endif; ?>
            </div>
            <?php if ( $desc ) : ?>
                <a class="chamber-card-link" href="<?php echo $link; ?>"></a>
            <?php endif; ?>
        </div>

        <?php echo $args['after_widget']; ?>

    <?php
    }

    // --------------------------------------------------------------

    public function form( $instance )
    {
        $title          = isset( $instance['title'] )          ? esc_attr( $instance['title'] )                 : '';
        $desc           = isset( $instance['desc'] )           ? esc_attr( $instance['desc'] )                  : '';
        $link           = isset( $instance['link'] )           ? esc_attr( $instance['link'] )                  : '/';
        $image          = isset( $instance['image'] )          ? esc_attr( $instance['image'] )                 : '';
        $add_datepicker = isset( $instance['add_datepicker'] ) ? 'checked'         : false;
        $datepicker     = isset( $instance['datepicker'] )     ? esc_attr( $instance['datepicker'] )            : false;
    ?>

        <p>
            <label for="<?php echo $this->get_field_name( 'title' ); ?>"><?php _e( 'Title:' ); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr($title); ?>" />
        </p>

        <p>
            <label for="<?php echo $this->get_field_name( 'desc' ); ?>"><?php _e( 'Description:' ); ?></label>
            <textarea class="widefat" id="<?php echo $this->get_field_id('desc'); ?>" name="<?php echo $this->get_field_name('desc'); ?>" type="text" rows="8" cols="50" spellcheck="true"><?php echo $instance['desc']; ?></textarea>
        </p>

        <p>
            <label for="<?php echo $this->get_field_name( 'image' ); ?>"><?php _e( 'Image:' ); ?></label>
            <input name="<?php echo $this->get_field_name( 'image' ); ?>" id="<?php echo $this->get_field_id( 'image' ); ?>" class="widefat" type="text" size="36"  value="<?php echo esc_url( $image ); ?>" />
            <input id="upload_image_button" class="button" m-Button="upload primary" type="button" value="Upload Image" />
        </p>

        <p>
            <label for="<?php echo $this->get_field_id( 'link' ); ?>"><?php _e( 'Link:' ); ?></label>
            <input class="url" type="url" id="<?php echo $this->get_field_id( 'link' ); ?>" name="<?php echo $this->get_field_name( 'link' ); ?>" />
        </p>

        <p>
            <label for="<?php echo $this->get_field_id( 'datepicker' ); ?>"><?php _e( 'Date:' ); ?></label>
            <input type="date" id="chamber_datepicker" name="<?php echo $this->get_field_name( 'datepicker' ); ?>" value="" class="<?php plugin_name().'-datepicker'; ?>" />
        </p>

<?php
    }

    // --------------------------------------------------------------

    public function update( $new_instance, $old_instance )
    {
        $instance                   = $old_instance;
        $instance['title']          = strip_tags( $new_instance['title'] );
        $instance['desc']           = strip_tags( $new_instance['desc'] );
        $instance['image']          = isset( $new_instance['image'] ) ? $new_instance['image'] : false;
        $instance['link']           = strip_tags( $new_instance['link'] );
        $instance['add_datepicker'] = isset( $new_instance['add_datepicker'] ) ? (bool) $new_instance['add_datepicker'] : false;
        return $instance;
    }

    public function flush()
    {
        wp_cache_delete( $this->widget_id, 'widget' );
    }

}

