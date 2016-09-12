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
  mix.copy( elixir.config.assetsPath + "/images", elixir.config.publicPath + "/images" );

  mix.sass( "oni-icons.scss", elixir.config.publicPath + "/css/oni-icons.css" )
     .sass( "oni-iconpicker.scss", elixir.config.publicPath + "/css/oni-iconpicker.css" )
     .sass( "oni-options.scss", elixir.config.publicPath + "/css/oni-options.css" );

  mix.scripts( "oni.tabs.js", elixir.config.publicPath + "/js/oni.options.js" );

  mix.scripts([
    "oni.iconpicker.js",
    "oni.svgiconpicker.js",
    "oni.ajax.svgsprite.js",
    "oni.changetelpattern.js"
  ], elixir.config.publicPath + "/js/oni.edit.js");

});