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
 
// lien all photographer
$page = get_page_by_path('all-photographer');


if ($page) {
    $page_title = $page->post_title;
    $page_permalink = get_permalink($page->ID);

    $context['all_photographer_title'] = $page_title;
    $context['all_photographer_permalink'] = $page_permalink;
} else {
    $context['all_photographer_title'] = 'Page not found';
    $context['all_photographer_permalink'] = '#';
}

// lien all categories
$page_categories = get_page_by_path('all-categories');

if ($page_categories) {
    $page_categories_title = $page_categories->post_title;
    $page_categories_permalink = get_permalink($page_categories->ID);

    $context['all_categories_title'] = $page_categories_title;
    $context['all_categories_permalink'] = $page_categories_permalink;
} else {
    $context['all_categories_title'] = 'Page not found';
    $context['all_categories_permalink'] = '#';
}

 
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
    'posts_per_page' => '3',
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


// ////
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
// ////

$all_photo_types = Timber::get_terms('photo-type');
$context['photo_types'] = [];

foreach ($all_photo_types as $single_photo_type) {
    // Vérifie si la catégorie est marquée comme populaire
    $is_popular = get_field('categories_popular', $single_photo_type);
    
    if ($is_popular) { // Continue seulement si la catégorie est populaire
        $args = [
            'posts_per_page' => '1',
            'post_type' => 'attachment',
            'post_mime_type' => 'image',
            'post_status' => 'inherit',
            'tax_query' => [
                [
                    'taxonomy' => 'photo-type',
                    'field' => 'id',
                    'terms' => $single_photo_type->ID,
                ],
            ],
            'order_by' => 'date',
            'order' => 'ASC',
        ];

        $image = Timber::get_posts($args);

        if (!empty($image)) {
            $image = reset($image); // Prend la première image trouvée
            $single_photo_type->image_url = $image->link();
            $context['photo_types'][] = $single_photo_type;
        }
    }
}


Timber::render( array( 'front-page.twig' ), $context );