<?php 
get_header();
?>
<section class="w-full h-screen mb-20">

        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 p-16 gap-10">
            <?php

            $args = array(
                'post_type' => 'post',
                'posts_per_page' => 6,
                   
            );
            $products_loop = new WP_Query($args);

            if ($products_loop->have_posts()) {
                while ($products_loop->have_posts()) {
                    $products_loop->the_post();
                    $image_path = wp_get_attachment_image_src(get_post_thumbnail_id(), 'large');
                    // $product_price = get_post_meta($post->ID, '_plantStore_product_price', true);
                    // $product_discount = get_post_meta($post->ID, '_plantStore_product_discount', true);
                    ?>

                    <a class="bg-slate-50 shadow-md hover:shadow-lg" href="<?php echo get_permalink(get_page_by_path('page-single-post')); ?>?post_id=<?php echo get_the_ID(); ?>">
                        <div class="relative h-96 w-full">
                            <img src="<?php echo $image_path[0]; ?>" class="w-full h-full object-cover" />
                        </div>
                        <div class="px-4 py-2">
                            <p class="text-xl font-bold"><?php the_title(); ?></p>
                            <p class="text-sm text-slate-400"><?php echo get_the_date()?></p>
                            <p><?php echo wp_trim_words(get_the_content(), 20, '...'); ?></p>

                        </div>
                    </a>
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