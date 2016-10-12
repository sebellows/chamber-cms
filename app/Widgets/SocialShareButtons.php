<?php

namespace Chamber\Plugin\Widgets;

use Chamber\Plugin\Helper;

/**
 * @see docs
 */
class SocialShareButtons extends \WP_Widget
{

    /**
     * Identifier of this widget for WP
     * 
     * @var mixed
     */
    public $widget_id;

    /**
     * Name of this widget.
     * 
     * @var str
     */
    public $widget_name;

    /**
     * Class name of this widget.
     * 
     * @var str
     */
    public $widget_class;

    /**
     * Default settings and values for social sharing buttons.
     * 
     * @var array
     */
    protected $defaults = [];

    /**
     * Associative array of properties and values for the items
     * to add to the Social Share Button menu.
     * 
     * @var array
     */
    protected $profiles = [];

    public $post_id;

    public $post_title;

    public $post_url;

    // protected $queried_object;


    public function __construct()
    {

        $this->widget_class = Helper::prefix('social_share_buttons');
        $this->widget_id    = Helper::slugify($this->widget_class);
        $this->widget_name  = Helper::humanize($this->widget_class);

        $params = [
            'classname'   => $this->widget_class,
            'description' => 'Share posts via social media outlets and by email.'
        ];

        $this->post_url = $this->getPostURL();

        parent::__construct( $this->widget_id, $this->widget_name, $params );

    }

    // --------------------------------------------------------------

    public function widget( $args, $instance )
    {
        if ( ! isset( $args['widget_id'] ) ) {
            $args['widget_id'] = $this->id;
        }

        $title     = apply_filters( 'widget_title', $instance['title'], $instance, $this->id_base );
        $email     = isset( $instance['email'] ) ? $instance['email'] : false;
        $facebook  = isset( $instance['facebook'] ) ? $instance['facebook'] : false;
        $google    = isset( $instance['google+'] ) ? $instance['google+'] : false;
        $linkedin  = isset( $instance['linkedin'] ) ? $instance['linkedin'] : false;
        $pinterest = isset( $instance['pinterest'] ) ? $instance['pinterest'] : false;
        $twitter   = isset( $instance['twitter'] ) ? $instance['twitter'] : false;

        extract( $args );

        $post_title = rawurlencode(html_entity_decode(get_the_title(), ENT_COMPAT, 'UTF-8'));

        echo $args['before_widget'];

        if ( $title ) {
            echo $args['before_title'] . $title . $args['after_title'];
        }

        ?>

        <menu class="share-menu">

        <?php if ( $email ) : ?>
            <a class="button" m-Button="share email" href="<?php echo 'mailto:?Subject=' . $post_title . '&amp;body=' . $this->post_url; ?>">
                <span class="icon" m-Icon="email small has-circle" aria-presentation><svg viewBox="0 0 24 24" stroke="#fefefe"><use xlink:href="#icon-email"></use></svg></span> Email
            </a>
        <?php endif; ?>

        <?php if ( $facebook ) : ?>
            <a class="button" m-Button="share facebook" href="<?php echo 'https://facebook.com/sharer/sharer.php?u=' . $this->post_url; ?>" target="_blank">
                <span class="icon" m-Icon="facebook small has-circle" aria-presentation><svg viewBox="0 0 24 24" stroke="#fefefe"><use xlink:href="#icon-facebook"></use></svg></span> Facebook
            </a>
        <?php endif; ?>

        <?php if ( $google ) : ?>
            <a class="button" m-Button="share google+" href="<?php echo 'https://plus.google.com/share?url=' . $this->post_url; ?>" target="_blank">
                <span class="icon" m-Icon="google+ small has-circle" aria-presentation><svg viewBox="0 0 24 24" stroke="#fefefe"><use xlink:href="#icon-google+"></use></svg></span> Google +
            </a>
        <?php endif; ?>

        <?php if ( $linkedin ) : ?>
            <a class="button" m-Button="share linkedin" href="<?php echo 'https://www.linkedin.com/shareArticle?mini=true&amp;url=' . $this->post_url . '&amp;title=' . $post_title . '&amp;summary=' . $post_title . '&amp;source=' . $this->post_url; ?>" target="_blank">
                <span class="icon" m-Icon="linkedin small has-circle" aria-presentation><svg viewBox="0 0 24 24" stroke="#fefefe"><use xlink:href="#icon-linkedin"></use></svg></span> Linkedin
            </a>
        <?php endif; ?>

        <?php if ( $pinterest ) : ?>
            <a class="button" m-Button="share pinterest" href="<?php echo 'https://pinterest.com/pin/create/button/?url=' . $this->post_url . '&amp;media=' . $this->post_url . '&amp;summary=' . $post_title; ?>" target="_blank">
                <span class="icon" m-Icon="pinterest small has-circle" aria-presentation><svg viewBox="0 0 24 24" stroke="#fefefe"><use xlink:href="#icon-pinterest"></use></svg></span> Pinterest
            </a>
        <?php endif; ?>

        <?php if ( $twitter ) : ?>
            <a class="button" m-Button="share twitter" href="<?php echo 'https://twitter.com/intent/tweet/?text=' . $post_title . '&amp;url=' . $this->post_url; ?>" target="_blank">
                <span class="icon" m-Icon="twitter small has-circle" aria-presentation><svg viewBox="0 0 24 24" stroke="#fefefe"><use xlink:href="#icon-twitter"></use></svg></span> Twitter
            </a>
        <?php endif; ?>

        </menu>

        <?php 
        echo $after_widget;
    }

    // --------------------------------------------------------------

    public function form( $instance )
    {
        $title     = isset( $instance['title'] ) ? esc_attr( $instance['title'] ) : '';
        $email     = isset( $instance['email'] ) ? (bool) $instance['email'] : false;
        $facebook  = isset( $instance['facebook'] ) ? (bool) $instance['facebook'] : false;
        $google    = isset( $instance['google+'] ) ? (bool) $instance['google+'] : false;
        $linkedin  = isset( $instance['linkedin'] ) ? (bool) $instance['linkedin'] : false;
        $pinterest = isset( $instance['pinterest'] ) ? (bool) $instance['pinterest'] : false;
        $twitter   = isset( $instance['twitter'] ) ? (bool) $instance['twitter'] : false;

        ?>

        <p>
            <label for="<?php echo $this->get_field_id( 'title' ); ?>">Title:</label>
            <input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo $title; ?>" />
        </p>

        <p>
            <label>
                <input id="<?php echo $this->get_field_id( 'email' ); ?>" class="checkbox" type="checkbox" name="<?php echo $this->get_field_name( 'email' ); ?>" <?php checked( $email ); ?> />
                Email
            </label>
        </p>

        <p>
            <label>
                <input id="<?php echo $this->get_field_id( 'facebook' ); ?>" class="checkbox" type="checkbox" name="<?php echo $this->get_field_name( 'facebook' ); ?>" <?php checked( $facebook ); ?> />
                Facebook
            </label>
        </p>

        <p>
            <label>
                <input id="<?php echo $this->get_field_id( 'google+' ); ?>" class="checkbox" type="checkbox" name="<?php echo $this->get_field_name( 'google+' ); ?>" <?php checked( $google ); ?> />
                Google +
            </label>
        </p>

        <p>
            <label>
                <input id="<?php echo $this->get_field_id( 'linkedin' ); ?>" class="checkbox" type="checkbox" name="<?php echo $this->get_field_name( 'linkedin' ); ?>" <?php checked( $linkedin ); ?> />
                LinkedIn
            </label>
        </p>

        <p>
            <label>
                <input id="<?php echo $this->get_field_id( 'pinterest' ); ?>" class="checkbox" type="checkbox" name="<?php echo $this->get_field_name( 'pinterest' ); ?>" <?php checked( $pinterest ); ?> />
                Pinterest
            </label>
        </p>

        <p>
            <label>
                <input id="<?php echo $this->get_field_id( 'twitter' ); ?>" class="checkbox" type="checkbox" name="<?php echo $this->get_field_name( 'twitter' ); ?>" <?php checked( $twitter ); ?> />
                Twitter
            </label>
        </p>

        <?php
    }

    // --------------------------------------------------------------

    function update( $new_instance, $old_instance ) {
        $instance              = $old_instance;
        $instance['title']     = strip_tags( $new_instance['title'] );
        $instance['email']     = isset( $new_instance['email'] ) ? (bool) $new_instance['email'] : false;
        $instance['facebook']  = isset( $new_instance['facebook'] ) ? (bool) $new_instance['facebook'] : false;
        $instance['google+']   = isset( $new_instance['google+'] ) ? (bool) $new_instance['google+'] : false;
        $instance['linkedin']  = isset( $new_instance['linkedin'] ) ? (bool) $new_instance['linkedin'] : false;
        $instance['pinterest'] = isset( $new_instance['pinterest'] ) ? (bool) $new_instance['pinterest'] : false;
        $instance['twitter']   = isset( $new_instance['twitter'] ) ? (bool) $new_instance['twitter'] : false;

        return $instance;
    }


    /**
     * Get the current post title.
     */
    public function getPostTitle( $post_id ) {

        return get_the_title($post_id);
    }

    /**
     * Get short url.
     */
    public function getShortUrl( $post_id ) {

        $short_url = '';
        
        if (function_exists('wp_get_shortlink')) {
            $short_url = wp_get_shortlink( get_the_ID() );
        }

        return $short_url;
    }

    /**
     * Get the URL of the current page.
     *
     * @link http://stackoverflow.com/questions/2820723/how-to-get-base-url-with-php#answer-2820771
     * 
     * @return str
     */
    protected function getPostURL()
    {
        return sprintf(
            "%s://%s%s",
            isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off' ? 'https' : 'http',
            $_SERVER['SERVER_NAME'],
            $_SERVER['REQUEST_URI']
        );
    }
}