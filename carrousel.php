<?php

/**
 * Plugin Name: premier plugin
 * Author: Syphax Mokraoui
 * Description : Une première extension pour comprendre
 * version: 1.0.0
 * Plugin URI: https://github.com/phaxypop/
 */
function enqueue_style_script()
{
    $version_css = filemtime(plugin_dir_path(__FILE__) . "style.css");
    $version_js = filemtime(plugin_dir_path(__FILE__) . "js/carrousel.js");

    wp_enqueue_style(
        'em_plugin_carrousel_css',
        plugin_dir_url(__FILE__) . "style.css",
        array(),
        $version_css
    );

    wp_enqueue_script(
        'em_plugin_carrousel_js',
        plugin_dir_url(__FILE__) . "js/carrousel.js",
        array(),
        $version_js,
        true
    );
}
// il faut  wp_head();  soit ajouté juste avant la balise </head>
// et que wp_footer(); soit ajouté juste avant la balise </body>
add_action('wp_enqueue_scripts', 'enqueue_style_script');



function genere_html()
{

    $html = '
    <button class="bouton__ouvrir">Ouvrir Carrousel</button>
    <div class="carrousel">
        <button class="carrousel__x">X</button>
        <figure class="carrousel__figure"></figure>
        <form action="" class="carrousel__form"></form>
    </div>
    ';
    return $html;
}
// [carrousel] juste après la galerie dans votre article ou page
// Quand la fonction the_content() rencontrera [carrousel] c'est à ce moment 
// que le carrousel sera initialisé
add_shortcode('carrousel', 'genere_html');
