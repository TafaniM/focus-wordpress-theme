<?php
/**
 * The template for displaying all pages.
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site will use a
 * different template.
 *
 * To generate specific templates for your pages you can use:
 * /mytheme/templates/page-mypage.twig
 * (which will still route through this PHP file)
 * OR
 * /mytheme/page-mypage.php
 * (in which case you'll want to duplicate this file and save to the above path)
 *
 * Methods for TimberHelper can be found in the /lib sub-directory
 *
 * @package  WordPress
 * @subpackage  Timber
 * @since    Timber 0.1
 */


 $context = Timber::context();

 $timber_post     = new Timber\Post();
 $context['post'] = $timber_post;
 
//  $args = array(
//      'post_type' => 'post',
//      'posts_per_page' => 5,
//      'orderby' => 'date',
//      'order' => 'DESC',
//      'post_status' => 'publish'
//  );
 
// $context['articles'] = Timber::get_posts( $args );

$args = array(
    'post_type' => 'photographer',
    'posts_per_page' => '-1',
    'orderby' => 'date',
    'order' => 'DESC',
    'post_status' => 'publish'
);

$context['photographer'] = Timber::get_posts( $args );

$args = array(
    'post_type' => 'photographer',
    'posts_per_page' => '-1',
    'orderby' => 'date',
    'order' => 'DESC',
    'meta_query' => array(
        array(
        'key' => 'popular',
        'value' => 'true',
        'compare' => 'LIKE',
        ),
    ),
    'post_status' => 'publish'
);

$context['popular'] = Timber::get_posts( $args );
// get_terms() -> aller chercher les termes d'une taxonomie

////
$args = array(
    // 'post_type'      => 'categories',
    // 'posts_per_page' => '-1',
    'orderby'        => 'date',
    'order'          => 'DESC',
    // 'post_status'    => 'publish'
    'taxonomy'       => 'photo-type', // Spécifie la taxonomie à partir de laquelle récupérer les termes
    'hide_empty'     => true, // Inclut les termes qui n'ont pas de publications associées
);


$context['categories'] = Timber::get_terms( $args );
////





Timber::render( array( 'front-page.twig' ), $context );