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

Timber::render( array( 'taxonomy.twig' ), $context );