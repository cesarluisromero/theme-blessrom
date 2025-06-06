<?php

add_action('wp_ajax_custom_search', 'custom_search_handler');
add_action('wp_ajax_nopriv_custom_search', 'custom_search_handler');

function custom_search_handler() {
    $query = isset($_GET['query']) ? sanitize_text_field($_GET['query']) : '';
    $results = [];

    if (strlen($query) < 2) {
        wp_send_json($results);
        wp_die();
    }

    // Buscar categorías
    $terms = get_terms([
        'taxonomy'   => 'product_cat',
        'hide_empty' => true,
        'name__like' => $query,
    ]);

    if (!is_wp_error($terms)) {
        foreach ($terms as $term) {
            $slug = $term->slug;
            $parent = $term->parent ? get_term($term->parent, 'product_cat') : null;
            $parent_name = $parent ? $parent->name : '';
            $results[] = [
                'id'    => $term->term_id,
                'title' => $term->name,
                'url'   => home_url('/tienda/?categorias[]=' . $slug),
                'type'  => $parent_name ? "Categoría de $parent_name" : 'Categoría',
                'image' => wc_placeholder_img_src(),
            ];
        }
    }
    // Buscar productos
    $product_query = new WP_Query([
        'post_type'      => 'product',
        'posts_per_page' => 10,
        's'              => $query,
        'post_status'    => 'publish',
    ]);

    if ($product_query->have_posts()) {
        foreach ($product_query->posts as $product_post) {
            $product = wc_get_product($product_post->ID);
            if ($product) {
                $results[] = [
                    'id'    => $product->get_id(),
                    'title' => $product->get_name(),
                    'url'   => get_permalink($product->get_id()),
                    'type'  => 'Producto',
                    'image' => get_the_post_thumbnail_url($product->get_id(), 'thumbnail'),
                ];
            }
        }
    }

    // Buscar por atributos como talla y marca
    $attribute_taxonomies = ['pa_talla', 'pa_marcas'];
    foreach ($attribute_taxonomies as $taxonomy) {
        $terms = get_terms([
            'taxonomy'   => $taxonomy,
            'hide_empty' => true,
            'name__like' => $query,
        ]);

        if (!is_wp_error($terms)) {
            foreach ($terms as $term) {
                $results[] = [
                    'id'    => $term->term_id,
                    'title' => $term->name,
                    'url'   => home_url("/tienda/?{$taxonomy}[]=" . $term->slug),
                    'type'  => ucfirst(str_replace('pa_', '', $taxonomy)),
                    'image' => wc_placeholder_img_src(),
                ];
            }
        }
    }

    wp_send_json($results);
    wp_die();
}
