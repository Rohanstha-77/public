jQuery(document).ready(function ($) {
    $('.category_list').on('click', function () {

        // Remove the 'active' class from all li elements
        $('.category_list').removeClass('text-blue-400');

        // Add the 'active' class to the clicked li
        $(this).addClass('text-blue-400');

        const category_slug = $(this).data('slug');
        // console.log('Sending slug:', category_slug);


        $.ajax({
            url: product_cate_filter.ajaxurl,
            type: 'POST',
            data: {
                action: 'filter_category',
                category: category_slug,
            },
            success: function (response) {
                if (response.success) {
                    $('#results').html(response.data);
                } else {
                    console.log('Error:', response.data);
                    $('#results').html('<p>' + response.data + '</p>');
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.error('AJAX request failed:', textStatus, errorThrown); // Log detailed error
                console.log('Response:', jqXHR.responseText); // Log the raw response text from server
                $('#results').html('<p>An error occurred. Please try again later.</p>');
            }
        });




        ///here add to cart data store to local storage

        let cart = [];
        let total = 0;

        // Load cart from local storage on page load
        loadCart();
        updateCart();

        $(document).on('click', '.listed', function () {
            // Retrieve data attributes
            let productTitle = $(this).data('product-title');
            let productImage = $(this).data('product-image');
            let productId = $(this).data('product-id');
            let productSlug = $(this).data('product-slug');
            let productPrice = parseFloat($(this).data('product-price'));
            let productAmount = parseInt($('#product_number').html() || 1);

            // console.log(productTitle)
            // console.log(productImage)
            // console.log(productId)
            // console.log(productSlug)
            // console.log(productPrice)
            // console.log(productAmount)


            // Check if the product already exists in the cart
            const ArrayIndex = cart.findIndex((item) => item.productId === productId);

            if (ArrayIndex > -1) {
                cart[ArrayIndex].productAmount += productAmount;
            } else {
                cart.push({ productTitle, productPrice, productId, productAmount, productImage, productSlug });
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

    });
});
