<?php

namespace Chamber\Plugin\Widgets;

use Chamber\Plugin\Helper;

/**
 * @see docs
 */
class RecentPostsByPostType extends \WP_Widget {

    public function addThumbnailSize($name, $width, $height)
    {
        return add_image_size( $name, $width, $height, $crop = false );
    }

    public function __construct()
    {
        $this->widget       = new WidgetBuilder;
        $this->widget_class = Helper::prefix('recent_posts_by_post_type');
        $this->widget_id    = Helper::slugify($this->widget_class);
        $this->widget_name  = Helper::humanize($this->widget_class);

        $widget_card_size   = $this->addThumbnailSize( 'widget_card', 480, 360 );

        $params = [
            'classname'   => $this->widget_class,
            'description' => 'Most recent posts of your custom post types.'
        ];
        parent::__construct( $this->widget_id, $this->widget_name, $params );
    }

    // --------------------------------------------------------------

    public function widget( $args, $instance ) 
    {
        if ( ! isset( $args['widget_id'] ) ) {
            $args['widget_id'] = $this->id;
        }

        $title              = apply_filters( 'widget_title', $instance['title'], $instance, $this->id_base );
        $posttype           = $instance['posttype'];
        $number             = $instance['number'];
        $show_thumb         = isset( $instance['show_thumb'] ) ? $instance['show_thumb'] : false;
        $show_excerpt       = isset( $instance['show_excerpt'] ) ? $instance['show_excerpt'] : false;
        $show_date          = isset( $instance['show_date'] ) ? $instance['show_date'] : false;
        $thumb_size_card    = isset( $instance['thumb_size_card'] ) ? $instance['thumb_size_card'] : false;

        $post_types = get_post_types( [ 'public' => true ], 'objects' );

        if ( array_key_exists( $posttype, (array) $post_types ) ) {
            $r = new \WP_Query( apply_filters( 'widget_posts_args', [
                'post_type' => $posttype,
                'posts_per_page' => $number,
                'no_found_rows' => true,
                'post_status' => 'publish',
                'ignore_sticky_posts' => true,
            ] ) );

            if ( $r->have_posts() ) :
                echo $args['before_widget'];
                if ( $title ) :
                    echo $args['before_title'] . $title . $args['after_title'];
                endif;
                ?>
                <ul>
                <?php while ( $r->have_posts() ) : $r->the_post(); ?>
                    <li>
                        <?php if ( $show_thumb && has_post_thumbnail() ) : ?>
                            <?php if ( $thumb_size_card ) : ?>
                                <?= $this->widget->thumbnail( 'widget_card', 'widget-card-image' ); ?>
                            <?php else : ?>
                                <?= $this->widget->thumbnail(); ?>
                            <?php endif; ?>
                        <?php endif; ?>

                        <?php if ( $show_date ) : ?>
                            <?= $this->widget->dateTime(); ?>
                        <?php endif; ?>

                        <?= $this->widget->postTitle(); ?>

                        <?php if ( $show_excerpt ) : ?>
                            <?= $this->widget->excerpt(); ?>
                        <?php endif; ?>
                    </li>
                <?php endwhile; ?>
                </ul>
                <?php
                echo $args['after_widget'];
                wp_reset_postdata();
            endif;
        }
    }

    // --------------------------------------------------------------

    public function form( $instance ) 
    {
        $title              = isset( $instance['title'] ) ? esc_attr( $instance['title'] ) : '';
        $posttype           = isset( $instance['posttype'] ) ? $instance['posttype']: 'post';
        $number             = isset( $instance['number'] ) ? absint( $instance['number'] ) : 5;
        $show_thumb         = isset( $instance['show_thumb'] ) ? (bool) $instance['show_thumb'] : false;
        $show_excerpt       = isset( $instance['show_excerpt'] ) ? (bool) $instance['show_excerpt'] : false;
        $show_date          = isset( $instance['show_date'] ) ? (bool) $instance['show_date'] : false;
        $thumb_size_card    = isset( $instance['thumb_size_card'] ) ? (bool) $instance['thumb_size_card'] : false;
?>
        <p><label for="<?= $this->get_field_id( 'title' ); ?>">Title:</label>
        <input class="widefat" id="<?= $this->get_field_id( 'title' ); ?>" name="<?= $this->get_field_name( 'title' ); ?>" type="text" value="<?= $title; ?>" /></p>
        
        <?php

        ?>

        <?php
            $post_types = get_post_types( array( 'public' => true ), 'objects' );

            printf(
                '<p><label for="%1$s">%2$s</label>' .
                '<select class="widefat" id="%1$s" name="%3$s">',
                $this->get_field_id( 'posttype' ),
                'Post Type:',
                $this->get_field_name( 'posttype' )
            );

            foreach ( $post_types as $post_type => $value ) {
                if ( 'attachment' === $post_type ) {
                    continue;
                }

                printf(
                    '<option value="%s"%s>%s</option>',
                    esc_attr( $post_type ),
                    selected( $post_type, $posttype, false ),
                    __( $value->label, 'chamber-cpt-widget' )
                );

            }
            echo '</select></p>';
        ?>

        <p>
            <label for="<?= $this->get_field_id( 'number' ); ?>">Number of posts to show:</label>
            <input id="<?= $this->get_field_id( 'number' ); ?>" name="<?= $this->get_field_name( 'number' ); ?>" type="text" value="<?= $number; ?>" size="3" />
        </p>

        <p>
            <input class="checkbox" type="checkbox" id="<?= $this->get_field_id( 'show_thumb' ); ?>" name="<?= $this->get_field_name( 'show_thumb' ); ?>" <?php checked( $show_thumb ); ?> />
            <label for="<?= $this->get_field_id( 'show_thumb' ); ?>">Display post thumbnail?</label>
        </p>

        <p>
            <label>
                <input class="checkbox" type="checkbox" id="<?= $this->get_field_id( 'thumb_size_card' ); ?>" name="<?= $this->get_field_name( 'thumb_size_card' ); ?>" <?php checked( $thumb_size_card ); ?> />
                Make image full-width? (480 × 320)
            </label>
        </p>

        <p>
            <input class="checkbox" type="checkbox" id="<?= $this->get_field_id( 'show_excerpt' ); ?>" name="<?= $this->get_field_name( 'show_excerpt' ); ?>" <?php checked( $show_excerpt ); ?> />
            <label for="<?= $this->get_field_id( 'show_excerpt' ); ?>">Display post excerpt?</label>
        </p>

        <p>
            <input class="checkbox" type="checkbox" id="<?= $this->get_field_id( 'show_date' ); ?>" name="<?= $this->get_field_name( 'show_date' ); ?>" <?php checked( $show_date ); ?> />
            <label for="<?= $this->get_field_id( 'show_date' ); ?>">Display post date?</label>
        </p>
<?php
    }

    // --------------------------------------------------------------

    public function update( $new_instance, $old_instance ) 
    {
        $instance                       = $old_instance;
        $instance['title']              = strip_tags( $new_instance['title'] );
        $instance['posttype']           = strip_tags( $new_instance['posttype'] );
        $instance['number']             = (int) $new_instance['number'];
        $instance['show_thumb']         = isset( $new_instance['show_thumb'] ) ? (bool) $new_instance['show_thumb'] : false;
        $instance['show_excerpt']       = isset( $new_instance['show_excerpt'] ) ? (bool) $new_instance['show_excerpt'] : false;
        $instance['show_date']          = isset( $new_instance['show_date'] ) ? (bool) $new_instance['show_date'] : false;
        $instance['thumb_size_card']    = isset( $new_instance['thumb_size_card'] ) ? (bool) $new_instance['thumb_size_card'] : false;
        return $instance;
    }

    public function flush() 
    {
        wp_cache_delete( $this->widget_id, 'widget' );
    }

}

