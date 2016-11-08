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
        $this->description_length = 50;
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

        $output = '<section id="events" class="widget widget-event-listing">' .
        '<h3 class="widget-title">Upcoming Events</h3>' .
        '<ul>';


        foreach ( $rssArr as $rssItem ) {

            // perform split to get date and title
            list($date, $title) = explode(' - ', $rssItem->get_title());

            $output .= '<li class="event">' .
            '<time class="event-date">';

            $output .= '<span class="event-month">' . date_format(date_create($date), 'M') . '</span>' .
            '<span class="event-day">' . date_format(date_create($date), 'd') . '</span>' .
            '</time>';

            $output .= '<div class="event-desc">' .
            '<h4 class="event-desc-header">' . $title . '</h4>' .
            '<span class="event-desc-detail"><span class="event-desc-time"></span>' . substr(strip_tags($rssItem->get_description()), 0, $this->description_length) . '...</span>' .
            '<a href="' . $rssItem->get_permalink() .'" class="small button rsvp">RSVP &amp; Details</a>' .
            '</div>' .
            '</li>';
        }

        $output .= '</ul>';
        $output .= '</section>';

        echo $output;
        //return view('@Chamber/widgets/chamber_master_rss.twig'); ~ not sure why this isn't working.  shitty documentation on herbert...

    }

}
