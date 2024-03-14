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

// $context = Timber::context();

// $timber_post     = new Timber\Post();
// $context['post'] = $timber_post;

// $args = array(
//     // 'post_type'      => 'categories',
//     // 'posts_per_page' => '-1',
//     'orderby'        => 'date',
//     'order'          => 'DESC',
//     // 'post_status'    => 'publish'
//     'taxonomy'       => 'photo-type', // Spécifie la taxonomie à partir de laquelle récupérer les termes
//     'hide_empty'     => true, // Inclut les termes qui n'ont pas de publications associées
// );


// $context['categories'] = Timber::get_terms( $args );

// Timber::render( array( 'page-all-categories.twig' ), $context );





$context = Timber::context();

$timber_post     = new Timber\Post();
$context['post'] = $timber_post;

$all_photo_types = Timber::get_terms( 'photo-type' );
$context['photo_types'] = [];

foreach ( $all_photo_types as $single_photo_type ) {
    $args = array(
        'posts_per_page' => '1',
        'post_type' => 'attachment',
        'post_mime_type' => 'image',
        'post_status' => 'inherit',
        'tax_query' => array(
            array(
                'taxonomy' => 'photo-type',
                'field' => 'id',
                'terms' => $single_photo_type->ID,
            ),
        ),
        'order_by' => 'date',
        'order' => 'ASC'
    );

    $image = Timber::get_posts( $args );

    if(!empty($image)) {
        $image = reset($image); // Prend la premiere image trouvée
        $single_photo_type->image_url = $image->link();
    } else {
        $single_photo_type->image_url = null;
    }

    $context['photo_types'][] = $single_photo_type;

}

Timber::render( array( 'page-all-categories.twig' ), $context );