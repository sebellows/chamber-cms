<?php

namespace Chamber\Widgets;

/**
 * @see docs
 */
class RecentPostsByPostType extends \WP_Widget {

    public function __construct() {
        $params = [
            'classname'   => 'chamber_recent_posts_by_post_type',
            'description' => 'Most recent custom Posts.'
        ];
        parent::__construct( __NAMESPACE__.'\\RecentPostsByPostType', 'Chamber Recent Posts By Post Type', $params );
    }

    // --------------------------------------------------------------

    public function widget( $args, $instance ) {
        if ( ! isset( $args['widget_id'] ) ) {
            $args['widget_id'] = $this->id;
        }

        $title        = apply_filters( 'widget_title', $instance['title'], $instance, $this->id_base );
        $posttype     = $instance['posttype'];
        $number       = $instance['number'];
        $show_thumb   = isset( $instance['show_thumb'] ) ? $instance['show_thumb'] : false;
        $show_excerpt = isset( $instance['show_excerpt'] ) ? $instance['show_excerpt'] : false;
        $show_date    = isset( $instance['show_date'] ) ? $instance['show_date'] : false;

        $post_types = get_post_types( array( 'public' => true ), 'objects' );

        if ( array_key_exists( $posttype, (array) $post_types ) ) {
            $r = new WP_Query( apply_filters( 'widget_posts_args', array(
                'post_type' => $posttype,
                'posts_per_page' => $number,
                'no_found_rows' => true,
                'post_status' => 'publish',
                'ignore_sticky_posts' => true,
            ) ) );

            if ( $r->have_posts() ) : ?>
                <?php echo $args['before_widget']; ?>
                <?php if ( $title ) {
                    echo $args['before_title'] . $title . $args['after_title'];
                } ?>
                <ul>
                <?php while ( $r->have_posts() ) : $r->the_post(); ?>
                    <li>
                        <?php if ( $show_thumb && has_post_thumbnail() ) : ?>
                            <a class="widget-post-thumbnail" href="<?php the_permalink() ?>">
                                <?php the_post_thumbnail( 'thumbnail', [ 'class' => 'alignleft' ]); ?>
                            </a>
                        <?php endif; ?>

                        <h4>
                            <a href="<?php the_permalink() ?>"><?php get_the_title() ? the_title() : the_ID(); ?></a>
                        </h4>

                        <?php if ( $show_date && get_post_type() == 'event' ) :
                            $event_date       = get_field('event_date');
                            $event_start_time = get_field('event_start_time');
                            $event_end_time   = get_field('event_end_time');
                        ?>
                        <time class="widget-post-meta">
                            <span class="event-date">
                                <span m-Icon="calendar small" aria-hidden>
                                    <svg role="presentation"><use xlink:href="#icon-calendar" viewbox="0 0 24 24"></use></svg>
                                </span> <?php echo $event_date; ?>
                            </span> <!--
                         --><span class="event-time">
                                <span m-Icon="clock small" aria-hidden>
                                    <svg role="presentation"><use xlink:href="#icon-clock" viewbox="0 0 24 24"></use></svg>
                                </span> <?php echo $event_start_time; ?>–<?php echo $event_end_time; ?>
                            </span>
                        </time>
                        <?php endif; ?>

                        <?php if ( $show_excerpt && has_excerpt() ) : ?>
                            <?php the_excerpt(); ?>
                        <?php endif; ?>

                    </li>
                <?php endwhile; ?>
                </ul>
                <?php echo $args['after_widget']; ?>
                <?php
                wp_reset_postdata();
            endif;
        }
    }

    // --------------------------------------------------------------

    public function form( $instance ) {
        $title        = isset( $instance['title'] ) ? esc_attr( $instance['title'] ) : '';
        $posttype     = isset( $instance['posttype'] ) ? $instance['posttype']: 'post';
        $number       = isset( $instance['number'] ) ? absint( $instance['number'] ) : 5;
        $show_thumb   = isset( $instance['show_thumb'] ) ? (bool) $instance['show_thumb'] : false;
        $show_excerpt = isset( $instance['show_excerpt'] ) ? (bool) $instance['show_excerpt'] : false;
        $show_date    = isset( $instance['show_date'] ) ? (bool) $instance['show_date'] : false;
?>
        <p><label for="<?php echo $this->get_field_id( 'title' ); ?>">Title:</label>
        <input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo $title; ?>" /></p>
        
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
            <label for="<?php echo $this->get_field_id( 'number' ); ?>">Number of posts to show:</label>
            <input id="<?php echo $this->get_field_id( 'number' ); ?>" name="<?php echo $this->get_field_name( 'number' ); ?>" type="text" value="<?php echo $number; ?>" size="3" />
        </p>

        <p>
            <input class="checkbox" type="checkbox" id="<?php echo $this->get_field_id( 'show_thumb' ); ?>" name="<?php echo $this->get_field_name( 'show_thumb' ); ?>" <?php checked( $show_thumb ); ?> />
            <label for="<?php echo $this->get_field_id( 'show_thumb' ); ?>">Display post thumbnail?</label>
        </p>

        <p>
            <input class="checkbox" type="checkbox" id="<?php echo $this->get_field_id( 'show_excerpt' ); ?>" name="<?php echo $this->get_field_name( 'show_excerpt' ); ?>" <?php checked( $show_excerpt ); ?> />
            <label for="<?php echo $this->get_field_id( 'show_excerpt' ); ?>">Display post excerpt?</label>
        </p>

        <p>
            <input class="checkbox" type="checkbox" id="<?php echo $this->get_field_id( 'show_date' ); ?>" name="<?php echo $this->get_field_name( 'show_date' ); ?>" <?php checked( $show_date ); ?> />
            <label for="<?php echo $this->get_field_id( 'show_date' ); ?>">Display post date?</label>
        </p>
<?php
    }

    // --------------------------------------------------------------

    public function update( $new_instance, $old_instance ) {
        $instance                 = $old_instance;
        $instance['title']        = strip_tags( $new_instance['title'] );
        $instance['posttype']     = strip_tags( $new_instance['posttype'] );
        $instance['number']       = (int) $new_instance['number'];
        $instance['show_thumb']   = isset( $new_instance['show_thumb'] ) ? (bool) $new_instance['show_thumb'] : false;
        $instance['show_excerpt'] = isset( $new_instance['show_excerpt'] ) ? (bool) $new_instance['show_excerpt'] : false;
        $instance['show_date']    = isset( $new_instance['show_date'] ) ? (bool) $new_instance['show_date'] : false;
        return $instance;
    }
}

