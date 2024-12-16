<?php
/***
 * Template Name: Login
 */


if (!session_id()) {
    session_start();
}
global $wpdb;

// Check if the form is submitted
if (isset($_POST['login_btn'])) {
    // Sanitize and validate the form data
    $username = sanitize_text_field($_POST['username']);
    $password = sanitize_text_field($_POST['password']);

    // Check if the username is an email or username
    if (is_email($username)) {
        // Search for the email in the custom table
        $user = $wpdb->get_row($wpdb->prepare("SELECT * FROM {$wpdb->prefix}customer WHERE customer_email = %s", $username));
    } else {
        // Search for the username in the custom table
        $user = $wpdb->get_row($wpdb->prepare("SELECT * FROM {$wpdb->prefix}customer WHERE username = %s", $username));
    }

    // Verify password
    if ($user && $password === $user->password) {
        // Password matches, store user data in session
        $_SESSION['user_id'] = $user->id;
        // $_SESSION['username'] = $user->username;
        // $_SESSION['email'] = $user->customer_email;
        // $_SESSION['fullname'] = $user->customer_name;

        // After storing user data in the session
        // echo '<pre>';
        // print_r($_SESSION);
        // echo '</pre>';


        // Redirect to the front page
        wp_redirect(home_url());
        exit;
    } else {
        // If no match, display an error message
        echo 'Invalid username or password. Please try again.';
    }
}
?>

<main>
    <div style="background-color:rgb(240 253 244 / var(--tw-bg-opacity, 1)); height:100vh; display:flex; justify-content:center; padding:50px">
        <div style="background-color: white; display:flex; flex-direction:column; align-items:center; height:400px; padding:20px;">
            <img src="<?php echo get_template_directory_uri(); ?>/assets/images/logo.png" alt="fashionstore logo"
                style="width:100px; margin-bottom:20px;" />
            <form method="post">
                <div style="display:flex; flex-direction:column; margin-bottom:20px;">
                    <label style="margin-bottom:5px;" for="username">Username or Email</label>
                    <input style="padding:5px 10px; width:300px; border-radius:5px; font-size:18px;" type="text" name="username" placeholder="Enter your username or email" required />
                </div>
                <div style="display:flex; flex-direction:column; margin-bottom:20px;">
                    <label style="margin-bottom:5px;" for="password">Password</label>
                    <input style="padding:5px 10px; width:300px; border-radius:5px; font-size:18px;" type="password" name="password" placeholder="Enter your password" required />
                </div>
                <div style="display:flex; flex-direction:column; margin-bottom:20px;">
                    <button style="font-size:18px; font-weight:500; color:white; background-color:#5B58EB; padding:10px;" type="submit" name="login_btn">Login</button>
                    <p style="font-size:18px;">Don't have an account? <a style="text-decoration:none; color:#5B58EB;" href="<?php echo site_url(); ?>/register-page">Register</a></p>
                </div>
            </form>
        </div>
    </div>
</main>