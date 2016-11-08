<?php

namespace Chamber\Plugin;

/** @var \Oni\Framework\Shortcode $shortcode */

// person shortcode
$shortcode->add(
    'person', function ($person_id) {
        echo $person_id; 

});


// attraction shortcode
$shortcode->add(
    'attraction', function ($attraction_id) {


});
