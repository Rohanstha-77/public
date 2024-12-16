<?php
/**
 * footer template
 */

?>
<div class="bg-[#5B58EB] text-white py-10 px-16">
    <div class="flex items-start w-full gap-[70px]">
        <div class="w-2/5 flex justify-between items-center gap-6">
            <a class="flex justify-center" href="<?php echo site_url(); ?>">
                <img src="<?php echo get_template_directory_uri() ?>/assets/images/logo.png" class="mb-4" />
            </a>
            <div class="w-3/4">
                <p class="text-sm mb-6">We're here to make your shopping experience easy and fashionable, from special offers to classic style advice. For the most recent information, follow us on social media, or contact our support staff at any time if you need help. Together, let's create your style path and stay in touch!
                </p>
                <a class="border w-full py-2 px-4  rounded-md cursor-pointer hover:bg-white hover:text-black" href="">Get
                    Started</a>
            </div>
        </div>
        <!-- <div class="w-1/5 text-center">
            <h2 class="text-2xl font-bold mb-4">Nav Menu</h2>
            
            <?php /*wp_nav_menu(array(
                'theme_location' => 'secondery-menu'
                ,
                'menu_class' => 'footer-nav'
            )) */?>
        </div> -->
        <div class="w-1/5 text-center">
            <h2 class="text-2xl font-bold mb-4">Categories</h2>
            <?php
            $categories = get_terms([
                'taxonomy' => 'categories',
                'hide_empty' => false,
            ]);
            // var_dump($categories);
            foreach ($categories as $category) {
                ?>
                <p class="text-lg hover:text-sky-500 mb-2"><?php echo $category->name; ?></p>
                <?php
            }
            ?>
        </div>

        <div class="w-1/5 flex justify-center items-center flex-col">
            <h2 class="text-2xl font-bold mb-2">Get in touch</h2>
            <p class="text-xl mb-2">Fashstore@gmail.com</p>
            <div class="flex items-center justify-between gap-4">
                <input class="border rounded-md py-1 px-2" type="text" placeholder="Type here ..." />
                <button
                    class="border bg-transparent text-lg py-1 px-4 rounded-md hover:bg-white hover:text-black">Send</button>
            </div>
        </div>
    </div>