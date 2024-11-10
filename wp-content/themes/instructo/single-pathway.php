<?php get_header(); ?>

<main id="main" class="site-main">
    <div class="container">
        <?php
        if (have_posts()) :
            while (have_posts()) : the_post();
            $user_id = get_current_user_id(); // Get the current user's ID
            $pathway_id = get_the_ID(); // Get the current pathway's ID

            // Check if the user is enrolled in this pathway (Assuming you have a custom function or a way to check)
            $is_enrolled = check_user_enrollment($user_id, $pathway_id); // You need to define this function

                ?>
                
                <h1><?php the_title(); ?></h1>

                <?php if (has_post_thumbnail()) {
                    echo get_the_post_thumbnail($post->ID, 'large');
                } ?>

                <div><?php the_content(); ?></div>

                <?php if (is_user_logged_in() && !$is_enrolled) : ?>
                    <button class="button" id="enroll-button" data-pathway-id="<?php the_ID(); ?>">Enrol in this Pathway</button>
                    <div id="enrollment-message"></div>
                <?php elseif (is_user_logged_in() && $is_enrolled) : ?>
                    <p>You are already enrolled in this pathway.</p>
                <?php else : ?>
                    <p>Please log in to enrol in this pathway.</p>
                <?php endif; ?>
                
                <?php
                // Get related modules
                $related_modules = get_post_meta($post->ID, 'related_modules', true);
                if (!empty($related_modules)) :
                    $modules_data = [];

                    foreach ($related_modules as $module_id) {
                        $modules_data[] = [
                            'id' => $module_id,
                            'title' => get_the_title($module_id),
                            'content' => apply_filters('the_content', get_post_field('post_content', $module_id))
                        ];
                    }

                    // Pass modules data to JavaScript
                    echo '<script>const relatedModules = ' . json_encode($modules_data) . ';</script>';
                endif;
                ?>
                
                <!-- Module content container -->
                <div id="module-content" class="module-content">
                    <p>Select a module from the navigation menu to view its content.</p>
                </div>

            <?php endwhile;
        endif;
        ?>
    </div>
    <?php get_sidebar(); ?>
</main>

<style>
.module-content {
    margin-top: 20px;
}

.lesson-heading {
    font-weight: bold;
    color: #333;
    padding: 5px 10px;
    cursor: default;
}

.enrol-button-container {
    margin-top: 20px;
    text-align: center;
}

.enrol-button {
    background-color: #0073e6;
    color: #fff;
    padding: 10px 20px;
    text-decoration: none;
    border-radius: 4px;
}
</style>

<script>
// JavaScript to dynamically add "Lesson Content:" heading and modules to the navigation bar

document.addEventListener('DOMContentLoaded', function () {
    const navigationMenu = document.getElementById('primary-menu');
    const moduleContentContainer = document.getElementById('module-content');

    if (relatedModules && navigationMenu) {
        // Create and add "Lesson Content:" heading
        const headingItem = document.createElement('li');
        headingItem.classList.add('lesson-heading');
        headingItem.textContent = 'Lesson Content:';
        navigationMenu.appendChild(headingItem);

        // Add each module as a new menu item
        relatedModules.forEach((module) => {
            const menuItem = document.createElement('li');
            menuItem.classList.add('menu-item', 'module-item'); // Add custom 'module-item' class
            const menuLink = document.createElement('a');
            menuLink.href = '#';
            menuLink.textContent = module.title;
            menuLink.dataset.moduleId = module.id;
            menuItem.appendChild(menuLink);

            // Append the new menu item to the navigation menu
            navigationMenu.appendChild(menuItem);

            // Add click event to load module content
            menuLink.addEventListener('click', (event) => {
                event.preventDefault();

                // Remove 'active-module' class from all module items
                const allModuleItems = navigationMenu.querySelectorAll('.module-item');
                allModuleItems.forEach(item => item.classList.remove('active-module'));

                // Add 'active-module' class to the clicked module item
                menuItem.classList.add('active-module');

                // Display the selected module content
                moduleContentContainer.innerHTML = `<h2 class="module-title">${module.title}</h2>${module.content}`;
            });
        });
    }
});
</script>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const enrollButton = document.getElementById('enroll-button');
    const enrollmentMessage = document.getElementById('enrollment-message');

    if (enrollButton) {
        enrollButton.addEventListener('click', function () {
            const pathwayId = enrollButton.getAttribute('data-pathway-id');

            fetch('<?php echo admin_url("admin-ajax.php"); ?>?action=enroll_user_in_pathway', {
                method: 'POST',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                body: 'pathway_id=' + encodeURIComponent(pathwayId),
                credentials: 'same-origin'
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    enrollmentMessage.textContent = 'You have successfully enrolled in this pathway!';
                    enrollButton.style.display = 'none'; // Hide the button after successful enrollment
                } else {
                    enrollmentMessage.textContent = 'Enrolment failed. Please try again.';
                }
            })
            .catch(error => {
                console.error('Error:', error);
                enrollmentMessage.textContent = 'Error occurred. Please try again later.';
            });
        });
    }
});
</script>