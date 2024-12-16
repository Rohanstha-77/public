jQuery(document).ready(function ($) {

    let cart = [];
    let total = 0;

    // Load cart from local storage on page load
    loadCart();
    updateCart();

    $('.productCart').on('click', function () {

        // Retrieve data attributes
        let productTitle = $(this).data('product-title');
        let productImage = $(this).data('product-image');
        let productId = $(this).data('product-id');
        let productSlug = $(this).data('product-slug');
        let userId = $(this).data('user-id');
        let productPrice = parseFloat($(this).data('product-price'));
        let productAmount = parseInt($('#product_number').html() || 1);

        // console.log(productTitle)
        // console.log(productImage)
        // console.log(productId)
        // console.log(productSlug)
        // console.log(productPrice)
        // console.log(productAmount)
        // console.log(userId)


        // Check if the product already exists in the cart
        const ArrayIndex = cart.findIndex((item) => item.productId === productId);
        // console.log(ArrayIndex)
        if (ArrayIndex > -1) {
            cart[ArrayIndex].productAmount += productAmount;
        } else {
            cart.push({ productTitle, productPrice, productId, productAmount, productImage, productSlug, userId });
        }

        updateCart();
        storeCart();
    });

    function storeCart() {
        localStorage.setItem("cart", JSON.stringify(cart));
        alert('Add to cart successfully');
    }

    function loadCart() {
        const storedCart = localStorage.getItem("cart");
        if (storedCart) {
            cart = JSON.parse(storedCart);
        }
    }

    function updateCart() {
        total = 0;
        cart.forEach((item) => {
            total += item.productPrice * item.productAmount;
        });

        $('#totalCart').html(total.toFixed(2));
    }







    ///add the data to the checkout page when click buynow button
    $('.buyNow').on('click', function () {
        // Retrieve data attributes
        let productTitle = $(this).data('product-title');
        let productImage = $(this).data('product-image');
        let productId = $(this).data('product-id');
        let userId = $(this).data('user-id');
        let productSlug = $(this).data('product-slug');
        let productPrice = parseFloat($(this).data('product-price'));
        let productAmount = parseInt($('#product_number').html() || 1);

        // Log product data to console for debugging
        // console.log(productTitle);
        // console.log(productImage);
        // console.log(productId);
        // console.log(productSlug);
        // console.log(productPrice);
        // console.log(productAmount);

        // Create an object to store the product details
        let productData = {
            title: productTitle,
            image: productImage,
            id: productId,
            slug: productSlug,
            price: productPrice,
            amount: productAmount,
            userId: userId
        };

        // Check if there are already products stored in localStorage
        let checkout = JSON.parse(localStorage.getItem('checkout')) || [];

        // Add the new product data to the cart array
        checkout.push(productData);

        // Save the updated cart array back to localStorage
        localStorage.setItem('checkout', JSON.stringify(checkout));

        // Optionally, redirect to checkout page
        window.location.href = 'http://fashion-store.local/checkout/';
    });



    // clear the localstorage checkout if the url is not matched 
    $(document).ready(function () {

        // Define the checkout URL
        const checkoutURL = 'http://fashion-store.local/checkout/';

        // Check if the current site URL is not the checkout URL
        if (window.location.href !== checkoutURL) {
            localStorage.removeItem('checkout');
        }
    });






    // remove the product from localstorage 'cart'
    var currentUrl = window.location.href;

    var baseUrl = currentUrl.split('?')[0];

    // Log or use the base URL
    // console.log("Base URL: " + baseUrl);

    if (baseUrl == "http://fashion-store.local/payment-success/") {
        // If the page is reloaded, don't do it again
        // if (!localStorage.getItem('pageReloaded')) {
        // Parse the JSON data from the hidden input field
        let order_details = JSON.parse($('#order_data').val());
        console.log(order_details)
        let product_details_container = $("#product_card")
        let totalPrice = 0;
        let name = "";
        let address = "";
        let contact = "";

        order_details.forEach(function (order) {
            // Extract the product_id
            let product_id = order.product_id;

            cart = cart.filter(item => !product_id.includes(item.productId.toString()));

            localStorage.setItem("cart", JSON.stringify(cart));


            totalPrice += order.qty * order.price
            name = order.name;
            address = order.address;
            contact = order.contact;
            //append the product details to the billl
            product_details_container.append(`
            
                                <tr>
                                    <td class="py-3 px-6 border flex items-start gap-4">
                                        <div class="h-20 w-20">
                                            <img src="${order.image}" alt="product image" class="object-cover w-full h-full"/> 
                                        </div>
                                        <p class="text-xl mt-2">${order.title}</p>
                                    </td>
                                    <td class="py-3 px-6 border text-xl">Rs. ${order.price}</td>
                                    <td class="py-3 px-6 border text-xl">${order.qty}</td>
                                    <td class="py-3 px-6 border text-xl">Rs. ${order.qty * order.price}</td>
                                </tr>

                
                `);
        });

        $("#shipping_details").append(`
            <h2 class="mb-6 text-2xl text-gray-500 font-bold">Total price:<span class="text-black"> Rs. ${totalPrice}</span></h2>
            <div class="flex flex-col items-start gap-2">
                <p class="text-lg text-slate-500">Customer Name: <span class="text-black">${name}</span></p>
                <p class="text-lg text-slate-500">Customer Shipping Address: <span class="text-black">${address}</span></p>
                <p class="text-lg text-slate-500">Customer Contact: <span class="text-black">${contact}</span></p>
            </div>
            `)

        // Set a flag in localStorage that the page has been reloaded
        // localStorage.setItem('pageReloaded', 'true');

        // Reload the page once after modifying the cart
        // location.reload();
        // }


    }




});

