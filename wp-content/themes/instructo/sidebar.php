<aside id="sidebar">
    <h3>Your Profile <!-- Link to an external SVG file --> 
        <img src="<?= get_template_directory_uri() . "/ellipsis-vertical.svg" ?>" alt="SVG Icon" width="30px" height="30px">
    </h3>
    <div class="userPhoto">
        <?php 
        global $current_user;
        wp_get_current_user();
        
        // Check if user is logged in and get the first letter of first and last name
        if ( is_user_logged_in()  ) { 
            $first_name = $current_user->user_firstname; 
            $last_name = $current_user->user_lastname; 

            if ( $first_name && $last_name ) { 
                // Get the first letter of first and last name
                $initials = strtoupper(substr($first_name, 0, 1) . substr($last_name, 0, 1)); 
                echo $initials;
            }
            else {
                echo "IT";
            }
        } else {
            echo "NN";  // Display "NN" if the user is not logged in
        }
        ?>
    </div>
    <?php 
    if ( is_user_logged_in() ) { 
        echo '<p>Good morning, ' . $current_user->display_name . "</p>"; 
    } else { 
        wp_loginout(); 
    } ?>
</aside>
