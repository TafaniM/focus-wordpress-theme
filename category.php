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
    'post_type' => 'post',
    'post_status' => 'publish',
    'cat' => get_queried_object()->term_id,
    'order_by' => 'date',
    'order' => 'DESC',
);

$context['posts'] = Timber::get_posts($args);

$context['category_title'] = get_queried_object()->name;

Timber::render( array( 'category.twig' ), $context );