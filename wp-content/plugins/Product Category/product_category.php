<?php
/*
 * Plugin Name: Product Category
 * Description: a custom product category for products post type
 * Version: 1.0
 * Author: Gokarna Chaudhary
 * Author URI: gokarnachaudhary.kesug.com
 */


function plantStore_product_category()
{
    $labels = array(
        'name' => _x('Categories', 'taxonomy general name'),
        'singular_name' => _x('Category', 'taxonomy singular name'),
        'search_items' => __('Search Category'),
        'all_items' => __('All Category'),
        'parent_item' => __('Parent Category'),
        'parent_item_colon' => __('Parent Category:'),
        'edit_item' => __('Edit Category'),
        'update_item' => __('Update Category'),
        'add_new_item' => __('Add New Category'),
        'new_item_name' => __('New Category Name'),
        'menu_name' => __('categories'),
    );
    $args = array(
        'hierarchical' => true,
        'labels' => $labels,
        'show_ui' => true,
        'show_admin_column' => true,
        'query_var' => true,
        'rewrite' => ['slug' => 'categories'],
    );
    register_taxonomy('categories', ['products'], $args);
}
add_action('init', 'plantStore_product_category');


