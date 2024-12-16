<?php
/***
 * 
 * Template Name: Product Cart
 */

get_header(); // call the header
?>
<section class="p-16">
    <div id="cartItemsContainer">
        <table class="w-full mb-10">
            <thead class="border-b bg-slate-100 text-xl font-md shadow-b-md">
                <th class="p-4"></th>
                <th class="p-4">Product</th>
                <th class="p-4">Price</th>
                <th class="p-4">Quantity</th>
                <th class="p-4">Subtotal</th>
            </thead>
            <tbody id="cartItems">
                <!-- cart items are append dynamically here -->
            </tbody>
        </table>

        <!-- cart operation button continer  -->
         <div class="w-full flex items-center justify-between">
            <div class="gap-6 items-center flex">
            <button class="bg-red-500 rounded-lg text-white py-2 px-4 hover:bg-red-600" id="removeFromCart"><i class="fa-regular fa-square-minus"></i> Remove from Cart</button>
            <button id="checkout" class="bg-sky-500 rounded-lg text-white py-2 px-4 hover:bg-sky-600">Checkout</button>
            </div>
            <button class="bg-red-500 rounded-lg text-white py-2 px-4 hover:bg-red-600" id="cleatCart"><i class="fa-regular fa-trash-can"></i> Clear Cart</button>
         </div>
    </div>
</section>
<?php
get_footer();//call the footer