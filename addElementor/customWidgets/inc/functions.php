<?php
/**
 * Helper functions
 *
 * @package Elementwoo
 */

if (!function_exists('elementwoo_do_shortcode')) {
    function elementwoo_do_shortcode($tag, array $atts = array(), $content = null)
    {
        global $shortcode_tags;
        if (!isset($shortcode_tags[$tag])) {
            return false;
        }
        print_r($shortcode_tags[$tag]);

        return call_user_func($shortcode_tags[$tag], $atts, $content, $tag);
    }
}

if (!function_exists('elementwoo_bool_from_yn')) {
    function elementwoo_bool_from_yn($yn)
    {
        $yn = strtolower(trim($yn));
        return ($yn === 'yes' || $yn === 'y' || $yn === 'true');
    }
}

if (!function_exists('elementwoo_comma_val_from_array')) {
    function elementwoo_comma_val_from_array($arr)
    {
        return (!empty($arr) ? implode(',', $arr) : '');
    }
}

if (!function_exists('elementwoo_get_product_terms')) {
    function elementwoo_get_product_terms($taxonomy = 'product_cat')
    {
        $args = [
            'taxonomy' => $taxonomy,
            'orderby' => 'name',
            'order' => 'ASC',
            'hide_empty' => false, //can be 1, '1' too
            'fields' => 'all',
        ];
        $terms = get_terms($args);

        if (!empty($terms) && !is_wp_error($terms)) {
            return wp_list_pluck($terms, 'name', 'slug');
        }
        return [];
    }
}

if (!function_exists('elementwoo_get_product_categories')) {
    function elementwoo_get_product_categories()
    {
        return elementwoo_get_product_terms('product_cat');
    }
}

if (!function_exists('elementwoo_get_product_tags')) {
    function elementwoo_get_product_tags()
    {
        return elementwoo_get_product_terms('product_tag');
    }
}
