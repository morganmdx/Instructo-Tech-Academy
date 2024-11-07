<?php get_header(); ?>

<main id="main" class="site-main">
    <div class="container">
        <?php
        if (have_posts()) :
            while (have_posts()) : the_post();
                $pathway_id = get_the_ID();
                ?>
                
                <h1><?php the_title(); ?></h1>

                <?php if (has_post_thumbnail()) {
                    echo get_the_post_thumbnail($post->ID, 'large');
                } ?>

                <div><?php the_content(); ?></div>
                
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
                moduleContentContainer.innerHTML = `<h2 class="module-title"><img src="data:image/svg+xml;base64,PCFET0NUWVBFIHN2ZyBQVUJMSUMgIi0vL1czQy8vRFREIFNWRyAxLjEvL0VOIiAiaHR0cDovL3d3dy53My5vcmcvR3JhcGhpY3MvU1ZHLzEuMS9EVEQvc3ZnMTEuZHRkIj4KDTwhLS0gVXBsb2FkZWQgdG86IFNWRyBSZXBvLCB3d3cuc3ZncmVwby5jb20sIFRyYW5zZm9ybWVkIGJ5OiBTVkcgUmVwbyBNaXhlciBUb29scyAtLT4KPHN2ZyB3aWR0aD0iODAwcHgiIGhlaWdodD0iODAwcHgiIHZpZXdCb3g9IjAgMCAyNCAyNCIgZmlsbD0ibm9uZSIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj4KDTxnIGlkPSJTVkdSZXBvX2JnQ2FycmllciIgc3Ryb2tlLXdpZHRoPSIwIi8+Cg08ZyBpZD0iU1ZHUmVwb190cmFjZXJDYXJyaWVyIiBzdHJva2UtbGluZWNhcD0icm91bmQiIHN0cm9rZS1saW5lam9pbj0icm91bmQiLz4KDTxnIGlkPSJTVkdSZXBvX2ljb25DYXJyaWVyIj4gPHJlY3Qgd2lkdGg9IjI0IiBoZWlnaHQ9IjI0IiBmaWxsPSJ3aGl0ZSIvPiA8cGF0aCBkPSJNMTIgNi45MDkwOUMxMC44OTk5IDUuNTA4OTMgOS4yMDQwNiA0LjEwODc3IDUuMDAxMTkgNC4wMDYwMkM0LjcyNTEzIDMuOTk5MjggNC41IDQuMjIzNTEgNC41IDQuNDk5NjVDNC41IDYuNTQ4MTMgNC41IDE0LjMwMzQgNC41IDE2LjU5N0M0LjUgMTYuODczMSA0LjcyNTE1IDE3LjA5IDUuMDAxMTQgMTcuMDk5QzkuMjA0MDUgMTcuMjM2NCAxMC44OTk5IDE5LjA5OTggMTIgMjAuNU0xMiA2LjkwOTA5QzEzLjEwMDEgNS41MDg5MyAxNC43OTU5IDQuMTA4NzcgMTguOTk4OCA0LjAwNjAyQzE5LjI3NDkgMy45OTkyOCAxOS41IDQuMjE4NDcgMTkuNSA0LjQ5NDYxQzE5LjUgNi43ODQ0NyAxOS41IDE0LjMwNjQgMTkuNSAxNi41OTYzQzE5LjUgMTYuODcyNCAxOS4yNzQ5IDE3LjA5IDE4Ljk5ODkgMTcuMDk5QzE0Ljc5NiAxNy4yMzY0IDEzLjEwMDEgMTkuMDk5OCAxMiAyMC41TTEyIDYuOTA5MDlMMTIgMjAuNSIgc3Ryb2tlPSIjMjIyMjIyIiBzdHJva2UtbGluZWpvaW49InJvdW5kIi8+IDxwYXRoIGQ9Ik0xOS4yMzUzIDZIMjEuNUMyMS43NzYxIDYgMjIgNi4yMjM4NiAyMiA2LjVWMTkuNTM5QzIyIDE5Ljk0MzYgMjEuNTIzMyAyMC4yMTI0IDIxLjE1MzUgMjAuMDQ4MUMyMC4zNTg0IDE5LjY5NDggMTkuMDMxNSAxOS4yNjMyIDE3LjI5NDEgMTkuMjYzMkMxNC4zNTI5IDE5LjI2MzIgMTIgMjEgMTIgMjFDMTIgMjEgOS42NDcwNiAxOS4yNjMyIDYuNzA1ODggMTkuMjYzMkM0Ljk2ODQ1IDE5LjI2MzIgMy42NDE1NiAxOS42OTQ4IDIuODQ2NDcgMjAuMDQ4MUMyLjQ3NjY4IDIwLjIxMjQgMiAxOS45NDM2IDIgMTkuNTM5VjYuNUMyIDYuMjIzODYgMi4yMjM4NiA2IDIuNSA2SDQuNzY0NzEiIHN0cm9rZT0iIzIyMjIyMiIgc3Ryb2tlLWxpbmVqb2luPSJyb3VuZCIvPiA8L2c+Cg08L3N2Zz4=" width="20">${module.title}</h2>${module.content}`;
            });
        });
    }
});
</script>

