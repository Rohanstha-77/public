
jQuery(document).ready(function ($) {
    // alert('alskfdjhl');
    let cart = JSON.parse(localStorage.getItem("cart")) || [];
    // console.log(cart)

    let total = 0;

    if (cart.length > 0) {
        let CartItems = $('#cartItems');

        // Clear the cart area before appending
        CartItems.empty();

        // Loop through the cart and append items
        cart.forEach((item) => {
            CartItems.append(`
                <tr class="border-b hover:bg-slate-300 text-xl">
                  <td class="text-center"><label><input class="checkProduct" type='checkbox' value="${item.productId}"
                  data-product-title="${item.productTitle}" 
                data-product-id="${item.productId}"
                    data-product-price="${item.productPrice}" 
                    data-product-image="${item.productImage}"
                    data-product-slug="${item.productSlug}"
                    data-product-amount="${item.productAmount}"
                    data-user-id="${item.userId}"
                  /></label></td>
                  <td class="flex items-center gap-4">
                    <a href="/products/${item.productSlug}" class="w-20 h-20 bg-red-300">
                      <img src="${item.productImage}" alt="product featured image" class="object-fill w-full h-full"/>
                    </a>
                    <h2>${item.productTitle}</h2>
                  </td>
                  <td class="text-center">Rs. <span>${item.productPrice}</span></td>
                  <td class="text-center">${item.productAmount}</td>
                 <td class="text-center">Rs.<span> ${item.productPrice * item.productAmount}</span></td>
                </tr>
            `);

            // total += item.productPrice * item.productAmount;
        });

    } else {
        $('#cartItemsContainer').html("<p>Your cart is empty.</p>");
    }




    //clear cart
    $('#cleatCart').on('click', () => {
        var confirmDelete = confirm("Are you sure, you want to clear the cart data.");
        let CartItems = $('#cartItems');

        if (confirmDelete) {
            // alert('delete success fully')
            localStorage.removeItem('cart');
            $('#cartItemsContainer').html("<p>Your cart is empty.</p>");
            $('#totalCart').html('00.00');
            cart = [];
        }
    })




    //remove the product from cart
    $('#removeFromCart').on('click', function () {
        // Get all selected product IDs
        let selectedProductIds = $('.checkProduct:checked').map(function () {
            return $(this).val(); // Ensure this matches the type of productId in cart
        }).get();

        // console.log('Selected Product IDs:', selectedProductIds);

        if (selectedProductIds.length === 0) {
            alert("Please select at least one product to remove.");
            return;
        }

        // Ensure type consistency between selectedProductIds and cart.productId
        cart = cart.filter(item => !selectedProductIds.includes(item.productId.toString()));

        // Update localStorage with the modified cart
        localStorage.setItem("cart", JSON.stringify(cart));

        location.reload();
    });


    //checkout btn in the cart page add the products to the checkout page if the checkout clicked
    $('#checkout').click(function () {

        $('.checkProduct:checked').each(function () {
            // Retrieve the data attributes using jQuery's data() method
            let productTitle = $(this).data('product-title');
            let productId = $(this).data('product-id');
            let userId = $(this).data('user-id');
            let productPrice = $(this).data('product-price');
            let productImage = $(this).data('product-image');
            let productSlug = $(this).data('product-slug');
            let productAmount = $(this).data('product-amount');

            // Log the data to the console
            // console.log('Product Title:', productTitle);
            // console.log('Product ID:', productId);
            // console.log('Product Price:', productPrice);
            // console.log('Product Image:', productImage);
            // console.log('Product Slug:', productSlug);
            // console.log('product Amount:', productAmount)

            let productData = {
                title: productTitle,
                image: productImage,
                id: productId,
                slug: productSlug,
                price: productPrice,
                amount: productAmount,
                userId:userId
            };

      
            let checkout = JSON.parse(localStorage.getItem('checkout')) || [];
            
            // Add the new product data to the cart array
            checkout.push(productData);

            // Save the updated cart array back to localStorage
            localStorage.setItem('checkout', JSON.stringify(checkout));
            // redirect to the checkout page 
            window.location.href = 'http://fashion-store.local/checkout/';

        })
    });

});



