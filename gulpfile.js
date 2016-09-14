var elixir = require("laravel-elixir");

/*
 |--------------------------------------------------------------------------
 | Elixir Asset Management
 |--------------------------------------------------------------------------
 |
 | Elixir provides a clean, fluent API for defining some basic Gulp tasks
 | for your Laravel application. By default, we are compiling the Sass
 | file for our application, as well as publishing vendor resources.
 |
 */

elixir.config.css.autoprefix.options.browsers = ["last 2 versions", "ie >= 10"];

elixir(function(mix) {

  mix.sass( "chamber-panel.scss" );

  mix.sass( "chamber-post.scss" );

  mix.scripts([
    "jquery.oni.tabs.js"
    "jquery.cardWidget.js"
  ], "chamber-panel.js");

  mix.scripts([
    "jquery.svgIconPicker.js",
    "jquery.svgIconPicker.ajax.js"
  ], "chamber-post.js");

  mix.scripts( "jquery.acfRestrictColorPicker.js" );

}