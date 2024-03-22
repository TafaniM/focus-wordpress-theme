<?php
/**
 * The template for displaying all category pages.
 *
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package  WordPress
 * @subpackage  Timber
 * @since    Timber 0.1
 */

$context = Timber::context();

$args = array(
    'posts_per_page' => '-1',
    'post_status' => 'publish',
    'post_type' => 'photographer',
    'tax_query' => array(
        array(
        'taxonomy' => get_queried_object()->taxonomy,
        'field' => 'slug',
        'terms' => get_queried_object()->slug,
        ),
    ),
    'order_by' => 'date',
    'order' => 'DESC',
);

$context['posts'] = Timber::get_posts($args);


$args = array(
    'posts_per_page' => '-1',
    'post_status' => 'inherit',
    'post_type' => 'attachment',
    'post_mime_type' => 'image',
    'tax_query' => array(
        array(
        'taxonomy' => get_queried_object()->taxonomy,
        'field' => 'slug',
        'terms' => get_queried_object()->slug,
        ),
    ),
    'order_by' => 'date',
    'order' => 'DESC',
);

$context['pictures'] = Timber::get_posts($args);

$context['taxonomy_title'] = get_queried_object()->name;


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


$timber_post = new Timber\Post();
$context['post'] = $timber_post;

$current_photo_type_slugs = array_map(function($term) {
    return $term->slug;
}, $timber_post->terms('photo-type'));

$all_photo_types = Timber::get_terms('photo-type');
$context['othercategories'] = [];

foreach ($all_photo_types as $single_photo_type) {
    if (in_array($single_photo_type->slug, $current_photo_type_slugs)) {
        continue;
    }

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
        $context['othercategories'][] = $single_photo_type;
    }

    if (count($context['othercategories']) >= 3) break;
}


Timber::render( array( 'taxonomy.twig' ), $context );