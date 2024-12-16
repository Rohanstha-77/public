<?php
/**
 * Template Name: Orders
 */

if (!session_id()) {
    session_start();
}

//logout
if (isset($_POST['logout'])) {
    // Destroy session and log the user out
    session_unset();
    session_destroy();
    wp_redirect(home_url('/login-page'));
    exit;
}

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    wp_redirect(home_url('/login-page'));
    exit;
}

// Get user ID from session
$user_id = intval($_SESSION['user_id']); // Ensure it's an integer for safety

// Access global $wpdb object
global $wpdb;

// Fetch user data from wp_customer table
$table_name = $wpdb->prefix . 'orders';

$order_data = $wpdb->get_results(
    $wpdb->prepare(
        "SELECT * FROM $table_name WHERE user_id = %d",
        $user_id
    ),
    ARRAY_A // Fetch as an array of associative arrays
);
// print_r($order_data);

get_header();
?>
<section>
    <container class="w-1/4 border-r h-screen flex flex-col bg-white absolute">
        <a class="text-xl font-medium border-b py-4 px-20 hover:bg-slate-100"
            href="http://fashion-store.local/user-profile/">Profile</a>
        <a class="bg-slate-100 text-xl font-medium border-b py-4 px-20 hover:bg-slate-100"
            href="http://fashion-store.local/orders/">Orders</a>
        <a class="text-xl font-medium border-b py-4 px-20 hover:bg-slate-100" href="#">Settings</a>

        <!-- Logout Form -->
        <form method="post">
            <button class="text-xl font-medium border-b py-4 px-20 hover:bg-slate-100 w-full text-start" type="submit"
                name="logout">Logout</button>
        </form>
    </container>
    <constiner class="flex items-center">
        <div class="w-1/4 h-full"></div>
        <div class="w-3/4 p-6 bg-white h-screen snap-y">
            <!-- Display User Profile -->
            <h1 class="text-2xl font-bold mb-6">Orders Details</h1>
            <div class="overflow-y-auto h-[600px]">
                <table class="w-full">
                    <thead class="bg-gray-100 sticky top-0 z-10">
                        <tr>
                            <th class="border border-gray-300 px-4 py-2 text-left">Product</th>
                            <th class="border border-gray-300 px-4 py-2 text-left">Price</th>
                            <th class="border border-gray-300 px-4 py-2 text-left">Qty</th>
                            <th class="border border-gray-300 px-4 py-2 text-left">Payment ID</th>
                            <th class="border border-gray-300 px-4 py-2 text-left">Shipping Address</th>
                            <th class="border border-gray-300 px-4 py-2 text-left">Contact</th>
                            <th class="border border-gray-300 px-4 py-2 text-left">Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if ($order_data) {
                            foreach ((array) $order_data as $order) {
                                ?>
                                <tr class="hover:bg-slate-100">
                                    <td class="border border-gray-300 px-4 py-2">
                                        <div class="flex items-start gap-2">
                                            <div class="w-20 h-20">
                                                <img src="<?php echo $order['product_image'] ?>"
                                                    class="w-full h-full object-cover" />
                                            </div>
                                            <p><?php echo $order['product_title'] ?></p>
                                        </div>
                                    </td>
                                    <td class="border border-gray-300 px-4 py-2"><?php echo $order['product_price'] ?></td>
                                    <td class="border border-gray-300 px-4 py-2"><?php echo $order['product_qty'] ?></td>
                                    <td class="border border-gray-300 px-4 py-2"><?php echo $order['payment_id'] ?></td>
                                    <td class="border border-gray-300 px-4 py-2"><?php echo $order['shipping_address'] ?></td>
                                    <td class="border border-gray-300 px-4 py-2"><?php echo $order['contact'] ?></td>
                                    <td class="border border-gray-300 px-4 py-2"><?php echo $order['date'] ?></td>
                                </tr>
                                <?php
                            }
                        } else {
                            echo "<tr><td colspan='7' class='text-center py-4'>No orders found for this user.</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>


    </constiner>

</section>
<?php
get_footer();