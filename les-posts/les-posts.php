<?php
/*
Plugin Name: Les posts
Description: Affiche les articles.
Version: 1.0
Author: Syphax Mokraoui
*/

// Fonction pour obtenir les données météorologiques d'une ville depuis OpenWeatherMap
function get_data_meteo($la_ville) {
    $api_key = 'd636c413c55d65254552ccdefe7f3808';
   
    $url = "https://api.openweathermap.org/data/2.5/weather?q=" . urlencode($la_ville) . "&appid=$api_key&units=metric";
    $response = file_get_contents($url);
    $data = json_decode($response, true);

    if ($data && isset($data['main'])) {
        $temp_min = $data['main']['temp_min'];
        $temp_max = $data['main']['temp_max'];
        $humidity = $data['main']['humidity'];
        return array($temp_min, $temp_max, $humidity);
    } else {
        return array('N/A', 'N/A'); // Retourner des valeurs par défaut si les données ne sont pas disponibles
    }
}


function custom_article_list_page() {
    echo '<div class="wrap">';
    echo '<h2>Custom Article List</h2>';

    // Get all published posts
    $args = array(
        'post_type'      => 'post',
        'post_status'    => 'publish',
        'posts_per_page' => -1,
        'orderby'        => 'title',  // Tri par post_title
        'order'          => 'ASC',    // Ordre croissant (A à Z)
    );

    $posts = get_posts($args);

    // Afficher le nombre total de posts




    if ($posts) {
        $total_posts = count($posts);

        // require_once("processus/bdd_retirer_repetition.php");
        // récupère les villes avoisinantes
        require_once("data/ville.php");
        // print_r ($ville);
        echo '<table class="wp-list-table widefat fixed striped">';
        echo '<thead>';
        echo '<tr>';
        echo '<th>Post Title  - (' . $total_posts . ' articles) </th>';
        echo '<th>Ville avoisinante</th>';
        echo '<th>Température minimale</th>';
        echo '<th>Température maximale</th>';
        echo '<th>Précipitation</th>';
        echo '<th>Categories</th>';
        echo '</tr>';
        echo '</thead>';
        echo '<tbody>';

        foreach ($posts as $post) {
            setup_postdata($post);
       
            $post_title =  get_the_title($post);
    
            $data_meteo = get_data_meteo($ville[$post_title]); // Obtenir les données météorologiques
            // Utiliser les slug de champs personnalisé défini dans ACF
            update_field('temperature_minimum', $data_meteo[0],  $post->ID);
            update_field('temperature_maximum', $data_meteo[1],  $post->ID);
            update_field('ville_avoisinante', $ville[$post_title], $post->ID );

            
            // Get post categories
            $categories = get_the_category($post);



            echo '<tr>';
            echo '<td>' . esc_html($post_title) . '</td>';
            echo '<td>' . $ville[esc_html($post_title)] . '</td>';
            echo '<td>' .  $data_meteo[0] . '</td>';
            echo '<td>' .  $data_meteo[1] . '</td>';
            echo '<td>' . $total_posts  . '</td>';
            echo '<td>';

            if ($categories) {
                $category_names = array();

                foreach ($categories as $category) {
                    $category_names[] = esc_html($category->name);
                }

                echo implode(', ', $category_names);
            }

            echo '</td>';
            echo '</tr>';
        }

        echo '</tbody>';
        echo '</table>';
    } else {
        echo '<p>No posts found.</p>';
    }

    echo '</div>';
    // Exemple de débogage
error_log('Custom Article List Plugin is running.'); // Vérifie si le plugin est en cours d'exécution
error_log('Number of posts found: ' . count($posts)); // Affiche le nombre d'articles récupérés
}

// Add custom dashboard page menu item
function custom_article_list_menu() {
    add_menu_page('Custom Article List', 'Article List', 'manage_options', 'custom-article-list', 'custom_article_list_page');
}

// Hook functions into WordPress
add_action('admin_menu', 'custom_article_list_menu');