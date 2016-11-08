<?php

namespace Chamber\Plugin\Widgets;

use Chamber\Plugin\Helper;

/**
* @see docs
*/
class ChamberMasterRss extends \WP_Widget {

    public function __construct()
    {
        $this->widget_class = Helper::prefix('chamber_master_rss');
        $this->widget_id    = Helper::slugify($this->widget_class);
        $this->widget_name  = 'Chamber Master Upcoming Events RSS';
        $this->rss_feed_url = 'https://member.flintandgenesee.org/Feed/rss/UpcomingEvents.rss';
        $this->description_length = 120;
        $this->display_items = 3;

        $params = [
            'classname'   => $this->widget_class,
            'description' => 'Displays three upcoming events from the Chamber Master RSS upcoming events theme'
        ];
        parent::__construct( $this->widget_id, $this->widget_name, $params );
    }

    // --------------------------------------------------------------

    public function widget( $args, $instance )
    {
        if ( ! isset( $args['widget_id'] ) ) {
            $args['widget_id'] = $this->id;
        }
        $rssFeed = fetch_feed($this->rss_feed_url);
        $rssArr = $rssFeed->get_items(0, $this->display_items);

        ?>

        <?php echo $args['before_widget']; ?>

        <h3 class="widget-title">Upcoming Events</h3>

        <ul>

        <?php foreach ( $rssArr as $rssItem ) {

            // perform split to get date and title
            list($date, $title) = explode(' - ', $rssItem->get_title());
?>
            <li class="event">
                <time class="event-time">
                    <span class="event-date">
                        <span class="event-day"><?= date_format(date_create($date), 'd'); ?></span>
                        <span class="event-month"><?= date_format(date_create($date), 'M'); ?></span>
                        <span class="event-year"><?= date_format(date_create($date), 'Y'); ?></span>
                    </span>
                </time>

                <div class="event-desc">
                    <h4 class="event-desc-header"><?= $title; ?></h4>

                    <div class="event-desc-detail">
                        <?= substr(strip_tags($rssItem->get_description()), 0, $this->description_length); ?>
                    </div>
                    <a href="<?= $rssItem->get_permalink(); ?>" class="small hollow rsvp button">RSVP &amp; Details</a>
                </div>

            </li>

            <?php } ?>

        </ul>

        <?php echo $args['after_widget']; ?>

        <?php wp_reset_postdata(); ?>

        <?php

    }

}
