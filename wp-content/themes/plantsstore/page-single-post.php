<?php
/*
Template Name: Single Post Display
*/
get_header();
?>

<div class="single-post-content p-16">
    <?php
    // Fetch the post ID from the query string (URL parameter)
    $post_id = isset($_GET['post_id']) ? intval($_GET['post_id']) : 0;

    // If we have a valid post ID, query the post
    if ($post_id) {
        $post = get_post($post_id);
        $image_path = wp_get_attachment_image_src(get_post_thumbnail_id(), 'large');

        if ($post) {
            setup_postdata($post);
            ?>
            <div class="flex items-start">
                <div class="relative h-96 w-1/2">
                    <img src="<?php echo $image_path[0]; ?>" class="w-full h-full object-cover" />
                </div>
                <div class="w-1/2 px-6">
                    <h1 class="text-3xl font-bold mb-4"><?php the_title(); ?></h1>
                    <div class="text-xl"><?php the_content(); ?></div>
                </div>
            </div>
            <?php
            wp_reset_postdata();
        } else {
            echo '<p>Post not found.</p>';
        }
    } else {
        echo '<p>No post specified.</p>';
    }
    ?>
</div>

<?php get_footer(); ?>