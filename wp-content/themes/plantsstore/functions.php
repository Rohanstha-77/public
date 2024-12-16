<?php

function theme01_enqueue_scripts()
{
    //register styles
    wp_register_style(
        'style-css',
        get_stylesheet_uri(),
        [],
        filemtime(get_template_directory() . '/style.css'),
        'all'
    );

    if (is_front_page()) {
        wp_enqueue_script(
            'main-js',
            get_template_directory_uri() . '/assets/js/main.js',
            [],
            '1.0',
            true
        );
    }


    if (is_single()) {
        wp_enqueue_script(
            'single-js',
            get_template_directory_uri() . '/assets/js/single.js',
            [],
            '1.0',
            true
        );
    }

    // Custom JavaScript
    wp_enqueue_script(
        'custom-js',
        get_template_directory_uri() . '/assets/js/custom.js',
        [],
        '1.0',
        true
    );

    // cart product js
    if (is_page('cart')) {

        wp_enqueue_script('jquery');

        wp_enqueue_script(
            'product-cart-js',
            get_template_directory_uri() . '/assets/js/product-cart.js',
            ['jquery'],
            '1.0',
            true
        );
    }

    // cart product js
    if (is_page('checkout')) {

        wp_enqueue_script('jquery');

        wp_enqueue_script(
            'checkout-js',
            get_template_directory_uri() . '/assets/js/checkout.js',
            ['jquery'],
            '1.0',
            true
        );
    }
    //enqueue style
    wp_enqueue_style('style-css');


}
add_action('wp_enqueue_scripts', 'theme01_enqueue_scripts');

//register menu 
register_nav_menus(
    array('primary-menu' => 'Header Menu', 'secondary-menu'=> 'Footer Menu')
);

add_theme_support('post-thumbnails');
function theme01_custom_post_type_products()
{
    register_post_type(
        'products',
        array(
            'labels' => array(
                'name' => _x('Products', 'products', 'text_domain'),
                'singular_name' => _x('Product', 'product', 'text_domain'),
                'menu_name' => __('Products', 'text_domain'),
                'name_admin_bar' => __('Post Type', 'text_domain'),
                'archives' => __('Product Archives', 'text_domain'),
                'attributes' => __('Product Attributes', 'text_domain'),
                'parent_item_colon' => __('Parent Product:', 'text_domain'),
                'all_items' => __('All Products', 'text_domain'),
                'add_new_item' => __('Add New Products', 'text_domain'),
                'add_new' => __('Add New', 'text_domain'),
                'new_item' => __('New Product', 'text_domain'),
                'edit_item' => __('Edit Product', 'text_domain'),
                'update_item' => __('Update Product', 'text_domain'),
                'view_item' => __('View Product', 'text_domain'),
                'view_items' => __('View Product', 'text_domain'),
                'search_items' => __('Search Product', 'text_domain'),
                'not_found' => __('Not found', 'text_domain'),
                'not_found_in_trash' => __('Not found in Trash', 'text_domain'),
                'featured_image' => __('Featured Image', 'text_domain'),
                'set_featured_image' => __('Set featured image', 'text_domain'),
                'remove_featured_image' => __('Remove featured image', 'text_domain'),
                'use_featured_image' => __('Use as featured image', 'text_domain'),
                'insert_into_item' => __('Insert into Product', 'text_domain'),
                'uploaded_to_this_item' => __('Uploaded to this Product', 'text_domain'),
                'items_list' => __('Products list', 'text_domain'),
                'items_list_navigation' => __('Products list navigation', 'text_domain'),
                'filter_items_list' => __('Filter Products list', 'text_domain'),
            ),
            'hierarchical' => true,
            'public' => true,
            'show_ui' => true,
            'show_in_menu' => true,
            'menu_position' => 5,
            'show_in_admin_bar' => true,
            'show_in_nav_menus' => true,
            'can_export' => true,
            'has_archive' => true,
            'exclude_from_search' => false,
            'publicly_queryable' => true,
            'capability_type' => 'page',
            'show_in_admin' => true,
            'rewrite' => array('slug' => 'products'),
            'supports' => array('title', 'editor', 'thumbnail'),

        )
    );
}
add_action('init', 'theme01_custom_post_type_products');



function plantStore_product_fields()
{
    add_meta_box(
        "product_details",
        'Product Details',
        'plantStore_product_details_callback',
        'products',
        "normal",
        "default",
    );
}
add_action('add_meta_boxes', 'plantStore_product_fields');


function plantStore_product_details_callback($post)
{
    $product_price = get_post_meta($post->ID, '_plantStore_product_price', true);
    $product_discount = get_post_meta($post->ID, '_plantStore_product_discount', true);
    ?>
    <div>
        <div>
            <label for="Product_price">Price</label>
            <input type="number" name="product_price" value="<?php echo $product_price ?>" placeholder="product price"
                required>
        </div>
        <div>
            <label for="Product_price">Discount Amount</label>
            <input type="number" name="product_discount" value="<?php echo $product_discount; ?>"
                placeholder="product discount">
        </div>
    </div>
    <?php
}

function plantStore_product_details_save($product_id)
{
    if (isset($_POST['product_price'])) {
        update_post_meta($product_id, '_plantStore_product_price', $_POST['product_price']);
    }
    if (isset($_POST['product_discount'])) {
        update_post_meta($product_id, '_plantStore_product_discount', $_POST['product_discount']);
    }
}
add_action('save_post', 'plantStore_product_details_save');

function enqueue_custom_scripts()
{
    wp_enqueue_script('jquery');
    wp_enqueue_script(
        'custom-js',
        get_template_directory_uri() . '/assets/js/main.js',
        array('jquery'),
        '1.0',
        true
    );

    wp_localize_script(
        'custom-js',
        'product_cate_filter',
        array(
            'ajaxurl' => esc_url(admin_url('admin-ajax.php')),
        )
    );

    wp_localize_script(
        'checkout-js',
        'checkout_product',
        array(
            'ajaxurl' => esc_url(admin_url('admin-ajax.php')),
        )
    );
}
add_action('wp_enqueue_scripts', 'enqueue_custom_scripts');

function filter_category_callback()
{
    $category_slug = isset($_POST['category']) ? sanitize_text_field($_POST['category']) : '';
    // var_dump($category_slug);

    if (!empty($category_slug)) {

        $args = array(
            'post_type' => 'products',
            'posts_per_page' => 4,
            'tax_query' => array(
                array(
                    'taxonomy' => 'categories',
                    'field' => 'slug',
                    'terms' => explode(',', $category_slug),
                ),
            ),
        );

        $products_loop = new WP_Query($args);

        if ($products_loop->have_posts()) {

            while ($products_loop->have_posts()) {
                $products_loop->the_post();
                $product_id = get_the_ID();
                $product_price = get_post_meta($product_id, '_plantStore_product_price', true);
                $product_discount = get_post_meta($product_id, '_plantStore_product_discount', true);
                $image_path = wp_get_attachment_image_src(get_post_thumbnail_id(), 'large');
                $post_slug = get_post_field('post_name', $product_id);

                $output .= '<div>';
                $output .= '<a class="bg-slate-50 shadow-md hover:shadow-lg" href="' . get_the_permalink() . '">';
                $output .= '<div class="relative h-96 w-full">';
                $output .= '<img src="' . esc_url($image_path[0]) . '" class="w-full h-full object-cover" />';
                $output .= '</div>';
                $output .= '<div class="px-4 py-2">';
                $output .= '<p class="text-xl font-bold">' . get_the_title() . '</p>';
                $output .= '<p class="text-lg text-slate-600 mb-2 flex items-center justify-between"><span>';

                if (!empty($product_discount)) {
                    $discounted_price = $product_price - ($product_price * $product_discount) / 100;
                    $output .= "<span class='line-through text-slate-400'>Rs. $product_price</span> Rs. $discounted_price";
                } else {
                    $output .= "Rs. $product_price";
                }

                $output .= '</span>';

                if (!empty($product_discount)) {
                    $output .= "<span class='text-sm'>Discount " . $product_discount . "%" . "</span>";
                }
                $output .= '</p>';
                $output .= '</div>';
                $output .= '</a>';
                $output .= '<div class="flex space-x-2">';

                $output .= '<button class="listed bg-[#5B58EB] flex-1 text-white text-xl px-4 py-2 hover:bg-[#4f4ded]"
                                data-product-title="' . get_the_title() . '" 
                                data-product-id="' . $product_id . '"
                                data-product-price="' . ($product_discount ? $product_price - ($product_price * $product_discount) / 100 : $product_price) . '" 
                                data-product-image="' . esc_url($image_path[0]) . '"
                                data-product-slug="' . $post_slug . '"
                                
                                >
                                Add To Cart
                            </button>';

                $output .= '</div>';
                $output .= '</div>';
            }
            wp_send_json_success($output);
        } else {
            wp_send_json_error('No products found.');
        }

        wp_reset_postdata();
    } else {
        wp_send_json_error('Invalid category.');
    }

    wp_die();
}

// Hook for logged-in users
add_action('wp_ajax_filter_category', 'filter_category_callback');

// Hook for guests
add_action('wp_ajax_nopriv_filter_category', 'filter_category_callback');

//start session
add_action('init', 'custom_session_start', 1);
function custom_session_start() {
    if (!session_id()) {
        session_start();
    }
}


//processed to pay action store the data in order table
add_action('wp_ajax_process_to_pay', 'handle_process_to_pay');
add_action('wp_ajax_nopriv_process_to_pay', 'handle_process_to_pay');

function handle_process_to_pay()
{
    // Ensure that the 'productdetails' is sent and is an array
    if (isset($_POST['productdetails']) && is_array($_POST['productdetails']) && isset($_POST['shipping']) && is_array($_POST['shipping'])) {
        $productDetails = $_POST['productdetails'];
        $ship = $_POST['shipping'];
        $payment_id = sanitize_text_field($_POST['payment_id']); 
        $_SESSION['payment_id'] = $payment_id; 

        $combined_array = array_map(function ($product) use ($ship) {
            return array_merge($product, $ship);
        }, $productDetails);

    
        global $wpdb;
        $table_name = $wpdb->prefix . 'orders';

        foreach ($combined_array as $product) {
            $order_data = array(
                'product_id'=>$product['id'],
                'product_title' => $product['title'],
                'product_slug' => $product['slug'],
                'product_image' => $product['image'],
                'product_price' => $product['price'],
                'product_qty' => $product['qty'],
                'user_name' => $product['username'],
                'shipping_address' => $product['address'],
                'contact' => $product['contact'],
                'user_id' => $product['userId'],
                'payment_id' => $payment_id,
                'status' => 1,
                'date' => current_time('mysql')
            );

            // Insert the data into the custom orders table
            $wpdb->insert($table_name, $order_data);
        }
        if ($wpdb->insert_id) {
            $response = [
                'status' => 'success',
                'message' => 'Payment processing initiated',
                'data' => $combined_array,

            ];
        } else {
            $response = [
                'status' => 'error',
                'message' => 'Failed to store data',
                'db_error' => $wpdb->last_error // Retrieve and log the database error
            ];
        }
        // }

    } else {
        $response = [
            'status' => 'error',
            'message' => 'No product details provided or invalid format'
        ];
    }

    // Return a response to the JavaScript request
    wp_send_json($response);

    // Always die after the request is handled
    wp_die();
}
