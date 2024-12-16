<?php
/**
 * Template Name: User Profile
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
$table_name = $wpdb->prefix . 'customer'; // wp_customer table name
$user_data = $wpdb->get_row(
    $wpdb->prepare(
        "SELECT * FROM $table_name WHERE ID = %d",
        $user_id
    )
);

// If user data exists, display it
if ($user_data) {
    $username = esc_html($user_data->username);
    $email = esc_html($user_data->customer_email);
    $fullname = esc_html($user_data->customer_name);
} else {
    echo 'No user data found.';
    exit;
}

get_header();
?>
<section>
    <container class="w-1/4 border-r h-screen flex flex-col bg-white absolute">
        <a class="bg-slate-100 text-xl font-medium border-b py-4 px-20 hover:bg-slate-100" href="#">Profile</a>
        <a class="text-xl font-medium border-b py-4 px-20 hover:bg-slate-100" href="http://fashion-store.local/orders/">Orders</a>
        <a class="text-xl font-medium border-b py-4 px-20 hover:bg-slate-100" href="#">Settings</a>

        <!-- Logout Form -->
        <form method="post">
            <button class="text-xl font-medium border-b py-4 px-20 hover:bg-slate-100 w-full text-start" type="submit"
                name="logout">Logout</button>
        </form>
    </container>
    <constiner class="flex items-center">
        <div class="w-1/4"></div>
        <div class="w-3/4 p-6 bg-white h-screen">
            <!-- Display User Profile -->
            <h1 class="text-2xl font-bold mb-6">User Details</h1>
            <div class="flex flex-col items-start">
                <label class="mb-2"><strong>Display Name:</strong></label>
                <input class="border focus:outline-none p-2 w-1/2 text-xl rounded-md" type="text" value="  <?php echo $fullname; ?>" readonly />
            </div>
            <div class="flex flex-col items-start">
                <label class="mb-2"><strong>Email:</strong></label>
                <input class="border focus:outline-none p-2 w-1/2 text-xl rounded-md" type="text" value="  <?php echo $email; ?>" readonly />
            </div>
            
        </div>

    </constiner>

</section>
<?php
get_footer();
