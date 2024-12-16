jQuery(document).ready(function ($) {
    let checkout = JSON.parse(localStorage.getItem("checkout")) || [];

    // console.log(checkout);

    let priceTotal = 0;
    let quantityTotal = 0;

    if (checkout.length > 0) {
        let checkOutItems = $('#checkoutItems');

        // Clear the cart area before appending
        checkOutItems.empty();
        const productCheckoutData = [];
        // Loop through the cart and append items
        checkout.forEach((product) => {
            checkOutItems.append(`
                <div class="flex w-full justify-between mb-4">
                    <div class="flex gap-4">
                       <div href="" class="w-20 h-20 bg-red-300">
                        <img src="${product.image}" alt="product featured image" class="object-cover w-full h-full" />
                       </div>
                        <p class="text-xl">${product.title}</p>
                    </div>
                    <p class="text-xl">Rs. ${product.price}</p>
                    <p class="text-xl mr-6">Qty: ${product.amount}</p>
                </div>
            `);

            priceTotal += product.price * product.amount;
            quantityTotal += product.amount;
            const productDetails = {
                id:product.id,
                title: product.title,
                slug: product.slug,
                image: product.image,
                price: product.price,
                qty: product.amount,
                userId: product.userId
            }


            productCheckoutData.push(productDetails)

        });
        var productData = productCheckoutData
        // console.log(productData)

        // Example usage:
        function generateUniqueCode(length = 5, separator = '-') {
            const characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';
            let code = '';
            for (let i = 0; i < length; i++) {
                code += characters.charAt(Math.floor(Math.random() * characters.length));
            }
            return code.match(new RegExp(`.{1,${Math.floor(length / 4)}}`, 'g')).join(separator);
        }

        var uuid = generateUniqueCode(5);
        var total_amount = priceTotal;
        var transaction_uuid = uuid;
        var product_code = 'EPAYTEST';
        var secret_key = '8gBm/:&EnhH.1/q';
        var product_code = 'EPAYTEST';
        // console.log(total_amount)
        // console.log(transaction_uuid)
        // console.log(product_code)
        // console.log(secret_key)

        var hash = CryptoJS.HmacSHA256(`total_amount=${total_amount},transaction_uuid=${transaction_uuid},product_code=${product_code}`, secret_key);
        var signature = CryptoJS.enc.Base64.stringify(hash);

        // console.log(signature)


        // Append the order summary
        $('#orderSummary').append(`  
            <form action="//" method="POST">
                <input type="hidden" id="amount" name="amount" value="${total_amount}" required>
                <input type="hidden" id="tax_amount" name="tax_amount" value ="0" required>
                <input type="hidden" id="total_amount" name="total_amount" value="${total_amount}" required>
                <input type="hidden" id="transaction_uuid" name="transaction_uuid" value="${transaction_uuid}" required>
                <input type="hidden" id="product_code" name="product_code" value ="EPAYTEST" required>
                <input type="hidden" id="product_service_charge" name="product_service_charge" value="0" required>
                <input type="hidden" id="product_delivery_charge" name="product_delivery_charge" value="0" required>
                <input type="hidden" id="success_url" name="success_url" value="http://fashion-store.local/payment-success/" required>
                <input type="hidden" id="failure_url" name="failure_url" value="http://fashion-store.local/payment-failed/" required>
                <input type="hidden" id="signed_field_names" name="signed_field_names" value="total_amount,transaction_uuid,product_code" required>
                <input type="hidden" id="signature" name="signature" value="${signature}" required>
            
                    <h2 class="text-2xl font-bold mb-2">Order Summary</h2>
                    <p class="flex items-center w-full justify-between text-slate-500 text-lg mb-4"><span>Items Total(${quantityTotal})</span><span>Rs. ${priceTotal}</span></p>
                    <p class="flex items-center w-full justify-between font-bold mb-4 border-t pt-2 text-lg"><span>Total:</span><span>Rs.${priceTotal}</span></p>
                    <button id="processed-to-pay"  value="submit" class="bg-green-500 rounded-lg px-4 py-2 text-white text-xl hover:bg-green-600 w-full"           
                    >Proceed to pay</button>
            </form>

        `);
    } else {
        $('#checkoutContainer').html("<p>You don't have selected any product.</p>");
    }





    ///get the data of order when user processed to pay
    $('#processed-to-pay').on("click", function () {
        let fullName = $('#name').val();
        let contactInfo = $('#contactInfo').val();
        let shippingAddress = $('#shipping_address').val();
        var payment_id = transaction_uuid;

        if (!contactInfo && !shippingAddress) {
            alert('Fill all the fields');
            // Highlight the fields
            $('#contactInfo').addClass('border-red-400');
            $('#shipping_address').addClass('border-red-400');
        } else if (!contactInfo) {
            alert('Please provide your contact information');
            $('#contactInfo').addClass('border-red-400');
        } else if (!shippingAddress) {
            alert('Please provide your shipping address');
            $('#shipping_address').addClass('border-red-400');
        } else {

            let ship = {
                username: fullName,
                contact: contactInfo,
                address: shippingAddress
            }

            let data = {
                action: 'process_to_pay',
                productdetails: productData,
                shipping: ship,
                payment_id: payment_id
            };
            // console.log(data)
            // Send the data via AJAX
            $.ajax({
                url: checkout_product.ajaxurl,
                type: 'POST',
                data: data,
                success: function (response) {
                    console.log('Success:', response);
                    // alert('Payment processing initiated successfully!');
                },
                error: function (xhr, status, error) {
                    console.error('Error:', error);
                    // alert('There was an error processing your payment. Please try again.');
                }
            });
        }


    });




});

