<?php

namespace Chamber\Widgets;

use Chamber\Helper;

/**
 * @see docs
 */
class RecentPostsByCategory extends \WP_Widget
{

    public $widget_id;  // identifier of this widget for WP

    public $widget_name;  // name of this widget

    public $widget_class;  // name of this widget

    public function __construct()
    {
        $this->widget_class = Helper::prefix('recent_posts_by_category');
        $this->widget_id    = Helper::slugify($this->widget_class);
        $this->widget_name  = Helper::humanize($this->widget_class);

        $params = [
            'classname'   => $this->widget_class,
            'description' => 'Most recent posts by category.'
        ];
        parent::__construct( $this->widget_id, $this->widget_name, $params );
    }

    // --------------------------------------------------------------

    public function widget( $args, $instance )
    {

        if ( ! isset( $args['widget_id'] ) ) {
            $args['widget_id'] = $this->id;
        }

        $title        = apply_filters( 'widget_title', $instance['title'], $instance, $this->id_base );
        $category     = $instance['category'];
        $number       = $instance['number'];
        $show_thumb   = isset( $instance['show_thumb'] ) ? $instance['show_thumb'] : false;
        $show_excerpt = isset( $instance['show_excerpt'] ) ? $instance['show_excerpt'] : false;
        $show_date    = isset( $instance['show_date'] ) ? $instance['show_date'] : false;

        $r = new \WP_Query( apply_filters( 'widget_posts_args', [
            'post_type' => 'post',
            'posts_per_page' => $number,
            'cat' => $category,
            'post_status' => 'publish',
            'ignore_sticky_posts' => true,
        ] ) );

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
                    <h4><a href="<?php the_permalink() ?>"><?php get_the_title() ? the_title() : the_ID(); ?></a></h4>
                    <?php if ( $show_date ) : ?>
                        <time class="widget-post-meta"><?php the_date(); ?></time>
                    <?php endif; ?>
                    <?php if ( $show_excerpt && has_excerpt() ) : ?>
                        <?php the_excerpt(); ?>
                    <?php endif; ?>
                </li>

            <?php endwhile; ?>

            </ul>

        <?php else : ?>

            <div>No posts in this category yet.</div>

        <?php endif; ?>

        <?php wp_reset_postdata(); ?>

        <?php echo $args['after_widget']; ?>

    <?php
    }

    // --------------------------------------------------------------

    public function form( $instance )
    {
        $title        = isset( $instance['title'] ) ? esc_attr( $instance['title'] ) : '';
        $category     = isset( $instance['category'] ) ? $instance['category']: 'post';
        $number       = isset( $instance['number'] ) ? absint( $instance['number'] ) : 5;
        $show_thumb   = isset( $instance['show_thumb'] ) ? (bool) $instance['show_thumb'] : false;
        $show_excerpt = isset( $instance['show_excerpt'] ) ? (bool) $instance['show_excerpt'] : false;
        $show_date    = isset( $instance['show_date'] ) ? (bool) $instance['show_date'] : false;
?>
        <p>
            <label for="<?php echo $this->get_field_id( 'title' ); ?>">Title:</label>
            <input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo $title; ?>" />
        </p>

        <p>
            <label for="widget-<?php $this->widget_id; ?>">Category:</label>        
            
            <?php

            wp_dropdown_categories( array(

                'orderby'    => 'title',
                'hide_empty' => false,
                'name'       => $this->get_field_name( 'category' ),
                'id'         => 'widget_chamber_cat_recent_posts',
                'class'      => 'widefat',
                'selected'   => $category

            ) );

            ?>
        </p>

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

    public function update( $new_instance, $old_instance )
    {
        $instance                 = $old_instance;
        $instance['title']        = strip_tags( $new_instance['title'] );
        $instance['category']     = strip_tags( $new_instance['category'] );
        $instance['number']       = strip_tags( (int) $new_instance['number'] );
        $instance['show_thumb']   = isset( $new_instance['show_thumb'] ) ? (bool) $new_instance['show_thumb'] : false;
        $instance['show_excerpt'] = isset( $new_instance['show_excerpt'] ) ? (bool) $new_instance['show_excerpt'] : false;
        $instance['show_date']    = isset( $new_instance['show_date'] ) ? (bool) $new_instance['show_date'] : false;
        return $instance;
    }

    public function flush()
    {
        wp_cache_delete( $this->widget_id, 'widget' );
    }

}

