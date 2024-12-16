<?php
/**
 * Template Name: Payment Success
 */


if (!session_id()) {
    session_start();
}

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    wp_redirect(home_url('/login-page'));
    exit;
}

$payment_id = $_SESSION['payment_id'];
// echo $payment_id;

// get the current url 
function get_current_url()
{
    $current_url = (is_ssl() ? 'https://' : 'http://') . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
    return $current_url;
}
$url = get_current_url();
$base_url = explode('?', $url)[0];
// echo $base_url;

if ($base_url === "http://fashion-store.local/payment-success/") {
    global $wpdb;

    $table_name = $wpdb->prefix . 'orders';
    $orders = $wpdb->get_results(
        $wpdb->prepare(
            "SELECT * FROM $table_name WHERE payment_id = %s",
            $payment_id
        )
    );

    // print_r($orders);
    if (!empty($orders)) {
        $status = 2;
        foreach ($orders as $order) {
            // Update the orders table
            $update_result = $wpdb->update(
                $table_name,
                ['status' => $status],
                ['payment_id' => $payment_id],
                ['%s'],
                ['%d']
            );

            $bill[] = [
                'order_id' => $order->id,
                'product_id' => $order->product_id,
                'payment_id' => $order->payment_id,
                'title' => $order->product_title,
                'image' => $order->product_image,
                'price' => $order->product_price,
                'qty' => $order->product_qty,
                'name' => $order->user_name,
                'address' => $order->shipping_address,
                'contact' => $order->contact,
                'status' => $order->status,
            ];
            $bill_json = json_encode($bill);
        }

    } else {
        echo 'No orders found with the specified payment ID.';
    }

}

// print_r($bill_json);
get_header();
?>
<div class="bg-white w-full p-4 text-center shadow-sm flex items-center flex-col mb-6">
    <img src="<?php echo get_template_directory_uri() ?>/assets/images/logo.png" width="200" class="mb-4" />
    <h2 class="text-4xl font-bold mb-4 text-green-500">Payment Successfull!</h2>
    <p class="text-2xl text-slate-500 font-md ">Thank you for using service</p>
</div>
<section class="p-16 bg-white w-full h-full">
    <input id="order_data" type="hidden" value='<?php echo $bill_json; ?>' />
    <div class="w-full ">
        <h class="text-3xl font-bold">Statement</h>
        <table class="mt-6">
            <thead class="bg-slate-50 text-xl font-bold">
                <th class="py-3 px-6 border">Product</th>
                <th class="py-3 px-6 border">Price</th>
                <th class="py-3 px-6 border">Qty</th>
                <th class="py-3 px-6 border">Sub-Total</th>
            </thead>
            <tbody id="product_card" class="">
                <!-- here the product details will be added -->
            </tbody>
        </table>

        <div id="shipping_details">
            <!-- total and shipping details will be added hereh -->
        </div>
    </div>

</section>
<?php

get_footer();