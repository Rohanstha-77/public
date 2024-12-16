<?php

if (!session_id()) {
    session_start();
}

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    wp_redirect(home_url('/login-page'));
    exit;
}

// Get user ID from session
$user_id = intval($_SESSION['user_id']); 

get_header();
?>
<section class="grid grid-cols-2 h-auto p-16 gap-10">
    <!-- Image Section -->
    <div class="w-full h-full">
        <?php if (has_post_thumbnail()): ?>
            <?php $featured_image = get_the_post_thumbnail_url(); ?>
            <img src="<?php echo $featured_image; ?>" class="w-full h-full object-contain" />
        <?php endif; ?>
    </div>

    <!-- Content Section -->
    <div class="px-8 flex flex-col">
        <h2 class="text-4xl font-bold mb-4"><?php the_title(); ?></h2>
        <p class="text-xl flex items-center text-slate-500 font-md mb-6">
            <?php
            $categories = get_the_terms($post->ID, 'categories');
            // echo "<pre>";
            // var_dump($categories);
            // echo "<pre>";
            
            foreach ($categories as $category) {
                echo esc_html($category->name) . ', ';
            }
            ?>
        </p>

        <div class="text-lg">
            <?php the_content(); ?>
        </div>
        <div class="mt-6 mb-6 flex items-center justify-between">
            <?php
            $product_id = $post->ID;
            $product_price = get_post_meta($post->ID, '_plantStore_product_price', true);
            $product_discount = get_post_meta($post->ID, '_plantStore_product_discount', true);
            $post_slug = get_post_field('post_name', $product_id);


            // var_dump($post_slug);
            ?>
            <p class="text-2xl text-slate-700"><?php
            if (!empty($product_discount)) {
                $discounted_price = $product_price - ($product_price * $product_discount) / 100;

                echo "<span class='line-through text-slate-400'>Rs. $product_price</span> " . "Rs. " . $discounted_price;
            } else {
                echo "Rs. " . $product_price;
            }
            ?></p>

            <p class="text-lg text-slate-700"><?php
            if (!empty($product_discount)) {
                echo "Discount " . $product_discount . "%";
            }
            ?></p>
        </div>
       
        <div class="flex w-full items-center gap-6">
            <div class="flex items-center border h-full">
                <span id="decreaseNumber"
                    class="border p-2 hover:bg-gray-200 h-full flex items-center cursor-pointer"><i
                        class="fa-solid fa-minus"></i>
                </span>
                <!-- prooduct amount is added here  -->
                <p id="product_number" class="border p-3 h-full flex items-center ">1</p>
                <span id="increaseNumber"
                    class="border p-2 hover:bg-gray-200 h-full flex items-center cursor-pointer"><i
                        class="fa-solid fa-plus"></i>
                </span>
            </div>
            <div class="flex w-full space-x-2 items-center">
                <button
                    class="buyNow rounded-lg bg-[#5B58EB] hover:bg-[#5654f5] w-full text-center py-4 text-xl text-white font-bold"
                    data-product-title="<?php the_title(); ?>" 
                data-product-id="<?php echo $product_id; ?>"
                    data-product-price="<?php
                    if (!empty($product_discount)) {
                        $discounted_price = $product_price - ($product_price * $product_discount) / 100;
                        echo $discounted_price;
                    } else {
                        echo $product_price;
                    }
                    ?>" data-product-image="<?php echo $featured_image; ?>"
                    data-product-slug="<?php echo $post_slug; ?>"
                    data-user-id="<?php echo $user_id; ?>"
                    >Buy
                    Now</button>
                <button class="productCart rounded-lg bg-[#75c9ef] hover:bg-[#4ebdf1] w-full py-4 text-xl text-white font-bold"
                    data-product-title="<?php the_title(); ?>" data-product-id="<?php echo $product_id; ?>"
                    data-product-price="<?php
                    if (!empty($product_discount)) {
                        $discounted_price = $product_price - ($product_price * $product_discount) / 100;
                        echo $discounted_price;
                    } else {
                        echo $product_price;
                    }
                    ?>" data-product-image="<?php echo $featured_image; ?>"
                    data-product-slug="<?php echo $post_slug; ?>"
                    data-user-id="<?php echo $user_id; ?>"
                    >Add to
                    Cart</button>
            </div>
        </div>
    </div>
</section>


<!-- related product  -->
<section>
    <h2 class="text-5xl font-bold text-center">Related Products</h2>
    <div class="p-16 grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-10">
        <?php
        $category_slugs = array();
        foreach ($categories as $category) {
            $category_slugs[] = $category->slug;
        }
        $args = array(
            'post_type' => 'products',
            'posts_per_page' => 4,
            'tax_query' => array(
                array(
                    'taxonomy' => 'categories',
                    'field' => 'slug',
                    'terms' => $category_slugs,
                )
            ),
        );

        $products_loop = new WP_Query($args);
        // echo "<pre>";
        // print_r(($products_loop));
        // echo "<pre>";
        if ($products_loop->have_posts()) {
            while ($products_loop->have_posts()) {
                $products_loop->the_post();
                $image_path = wp_get_attachment_image_src(get_post_thumbnail_id(), 'large');
                $product_price = get_post_meta($post->ID, '_plantStore_product_price', true);
                $post_slug = get_post_field('post_name', $post->ID);
                // var_dump($post_slug);
        
                ?>
                <div>
                    <a class="bg-slate-50 shadow-md hover:shadow-lg" href="<?php the_permalink(); ?>">
                        <div class="relative h-96 w-full">
                            <img src="<?php echo $image_path[0]; ?>" class="w-full h-full object-cover" />
                        </div>
                        <div class="px-4 py-2">
                            <p class="text-xl font-bold"><?php the_title(); ?></p>
                            <p class="text-lg text-slate-600 mb-2 flex items-center justify-between">
                                <span>
                                    <?php

                                    if (!empty($product_discount)) {
                                        $discounted_price = $product_price - ($product_price * $product_discount) / 100;

                                        echo "<span class='line-through text-slate-400'>Rs. $product_price</span> " . "Rs. " . $discounted_price;
                                    } else {
                                        echo "Rs. " . $product_price;
                                    }
                                    ?>
                                </span>
                                <?php
                                if (!empty($product_discount)) {
                                    echo "<span class='text-sm'>Discount " . $product_discount . "%" . "</span>";
                                }
                                ?>
                            </p>
                        </div>
                    </a>
                    <div class="flex space-x-2">

                        <button class="productCart bg-[#5B58EB] flex-1 text-white text-xl px-4 py-2 hover:bg-[#5452f2]"
                            data-product-title="<?php the_title(); ?>" 
                            data-product-id="<?php echo $post->ID; ?>"
                            data-product-price="<?php
                            if (!empty($product_discount)) {
                                $discounted_price = $product_price - ($product_price * $product_discount) / 100;
                                echo $discounted_price;
                            } else {
                                echo $product_price;
                            }
                            ?>" data-product-image="<?php echo $image_path[0]; ?>"
                            data-product-slug="<?php echo $post_slug; ?>"
                            data-user-id="<?php echo $user_id; ?>"
                            >Add To
                            Cart</button>
                    </div>
                </div>
                <?php
            }
        } else {
            echo '<p class="text-center text-lg text-slate-500">No products found.</p>';
        }
        ?>
    </div>
</section>

<?php
get_footer();