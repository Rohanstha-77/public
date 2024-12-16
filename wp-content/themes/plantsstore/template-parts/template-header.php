<?php
/**
 * header template
 */

?>

<nav class="bg-white border-b shadow-sm flex items-center justify-center p-4">
    <div class="w-full">
        <a class="navbar-brand flex items-center gap-2" href="<?php echo site_url(); ?>">
            <!-- <img src="<?php echo get_template_directory_uri() ?>/assets/images/logo.png" alt="logo image" width="50"> -->
             <i class = ""></i>
            <h1 class="text-2xl font-bold text-[#5B58EB]"><?php echo bloginfo('name')?></h1>
        </a>
    </div>
    <div class="w-full">
        <!-- calling nav items -->
        <?php wp_nav_menu(array(
            'theme_location' => 'primary-menu'
            ,
            'menu_class' => 'header-nav'
        )) ?>
    </div>
    <div class="w-1/2 flex items-ceter gap-4">
        <a href="<?php echo site_url('user-profile'); ?>"
            class="bg-[#FFCC70] w-10 h-10 flex justify-center items-center rounded-full">
            <i class="fa-regular fa-user font-thin text-2xl"></i>
        </a>

        <a href="<?php echo site_url('cart'); ?>" class="flex items-center bg-[#5B58EB] rounded-full px-3 py-2">
            <div class="flex items-center text-xl gap-4 text-white">
                <i class="fa-solid fa-cart-shopping text
                -lg"></i>
                <!-- cart product will be here dynamically -->
                <div class="text-lg">Rs. <span id="totalCart">00.00</span></div>
            </div>
        </a>
    </div>
</nav>