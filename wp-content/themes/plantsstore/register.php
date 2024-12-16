<?php
/***
 * Template Name: Register 
 */

global $wpdb;

// Check if the form is submitted
if (isset($_POST['register_btn'])) {
    // Sanitize and validate the form data
    $username = sanitize_text_field($_POST['username']);
    $email = sanitize_email($_POST['email']);
    $password = sanitize_text_field($_POST['password']);
    $fullname = sanitize_text_field($_POST['fullname']);

    // Hash the password before storing
    // $hashed_password = wp_hash_password($password);

    // Prepare the data for insertion
    $data = array(
        'username' => $username,
        'password' => $password,
        'customer_name' => $fullname,
        'customer_email' => $email,
        'created_at' => current_time('mysql'),
    );

    // var_dump($data);

    $table_name = $wpdb->prefix . 'customer';
    $wpdb->insert($table_name, $data);


    // Check for success and handle accordingly
    if ($wpdb->insert_id) {
        echo 'Registration successful!';
        wp_redirect(home_url('/login-page')); 
        exit;
    } else {
        echo 'Registration failed. Please try again.';
    }
}
?>

<main>
    <div
        style="background-color:rgb(240 253 244 / var(--tw-bg-opacity, 1)); height:100vh; display:flex; justify-content:center; padding:50px">
        <div
            style="background-color: white; display:flex; flex-direction:column; align-items:center; height:400px; padding:20px;">

            <img src="<?php echo get_template_directory_uri(); ?>/assets/images/logo.png" 
                style="width:100px; margin-bottom:20px;" />
            <form method="post">
                <div style="display:flex; flex-direction:column; margin-bottom:20px;">
                    <lable style="margin-bottom:5px;">Username</lable>
                    <input style="padding:5px 10px; width:300px; border-radius:5px; font-size:18px;" type="text" name="username" placeholder="Enter your email" />
                </div>
                <div style="display:flex; flex-direction:column; margin-bottom:20px;">
                    <lable style="margin-bottom:5px;">Password</lable>
                    <input style="padding:5px 10px; width:300px; border-radius:5px; font-size:18px;" type="password" name="password" placeholder="Enter your password" />
                </div>
                <div style="display:flex; flex-direction:column; margin-bottom:20px;">
                    <lable style="margin-bottom:5px;">FullName</lable>
                    <input style="padding:5px 10px; width:300px; border-radius:5px; font-size:18px;" type="text" name="fullname" placeholder="Enter your fullname" />
                </div>
                <div style="display:flex; flex-direction:column; margin-bottom:20px;">
                    <lable style="margin-bottom:5px;">Email</lable>
                    <input style="padding:5px 10px; width:300px; border-radius:5px; font-size:18px;" type="email" name="email" placeholder="Enter your email" />
                </div>
                <div style="display:flex; flex-direction:column; margin-bottom:20px;">
                    <button style="font-size:18px; font-weight:500; color:white; background-color:green; padding:10px;" type="submit" name="register_btn">Register</button>
                    <p style="font-size:18px;">Don't have account? <a style="text-decoration:none; color:green;" href="<?php echo site_url() ?>/login-page">Login</a></p>
                </div>
            </form> 
        </div>
    </div>
</main>
