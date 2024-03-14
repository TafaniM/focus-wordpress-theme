<?php
/**
 * The Template for displaying all single posts
 *
 * Methods for TimberHelper can be found in the /lib sub-directory
 *
 * @package  WordPress
 * @subpackage  Timber
 * @since    Timber 0.1
 */

$context         = Timber::context();
$timber_post     = Timber::get_post();
$context['post'] = $timber_post;

$taxonomy = $timber_post->terms( 'photographer-name' );
$context['photographer-slug'] = reset( $taxonomy ) -> slug;

// print_r($timber_post->terms( 'photographer-name' ));
// print_r(reset( $taxonomy ) -> slug);
// $context['category'] = reset( $categories );

$args = array(
    'posts_per_page' => '-1',
    'post_status' => 'inherit',
    'post_type' => 'attachment',
    'post_mime_type' => 'image',
    'tax_query' => array(
        array(
        'taxonomy' => 'photographer-name',
        'field' => 'slug',
        'terms' => $context['photographer-slug'],
        ),
    ),
    'order_by' => 'date',
    'order' => 'DESC',
);

$context['pictures'] = Timber::get_posts($args);

Timber::render( 'single-photographer.twig', $context );
