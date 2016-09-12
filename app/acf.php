<?php

namespace Chamber;

use Chamber\ACF\SvgIconPickerField;

if( ! function_exists('acf_add_local_field_group') ) {

  add_action( 'admin_notices', function() {
    echo '<div class="message message-error">ACF5 Pro is not activated. Make sure the plugin is installed and activated by running <code>composer update</code> if you have admin priveleges.</div>';
  });
  return;
}

// if( function_exists('acf_add_local_field_group') ):
//   include_once( '/CustomFields/AttractionsCategory.php' );
//   include_once( '/CustomFields/Location.php' );
//   include_once( '/CustomFields/Price.php' );
// endif;

// include_once( '/CustomFields/IconPickerField.php' );
new SvgIconPickerField();
