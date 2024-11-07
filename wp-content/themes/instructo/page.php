<?php get_header(); ?>

<main id="main" class="site-main">
    <div class="container">
        <h1> <?php echo get_the_title(); ?> </h1>
        <div class="homepage-tile coursesearch-container">
            <h2 class="h2home">Want to learn something new? Search for a Course</h2>
            <div style="height: 10px; display: block; clear: both;"></div>
            <div class="live-search-container">
            <input type="text" id="live-search-input" placeholder="Search for your course here...">
            <div id="live-search-results"></div>
            </div>
        </div>
        <?php if ( have_posts() ) : while ( have_posts() ) : the_post();
        if ( has_post_thumbnail() ) {
            echo get_the_post_thumbnail( $post->ID, 'large' );
        }
        the_content();
        endwhile; else: ?>
        <p>Sorry, no posts matched your criteria.</p>
        <?php endif; ?>
    </div>
    <?php get_sidebar(); ?>
</main>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
    const searchInput = document.getElementById('live-search-input');
    const resultsContainer = document.getElementById('live-search-results');

    searchInput.addEventListener('input', function () {
        const query = searchInput.value;

        if (query.length < 2) {
            resultsContainer.innerHTML = ''; // Clear results if the input is too short
            return;
        }

        // Make an AJAX request to WordPress
        fetch('<?php echo admin_url('admin-ajax.php'); ?>?action=live_search&query=' + encodeURIComponent(query))
            .then(response => response.json())
            .then(data => {
                resultsContainer.innerHTML = ''; // Clear previous results

                if (data.length) {
                    data.forEach(post => {
                        const postItem = document.createElement('div');
                        postItem.classList.add('search-result-item');
                        postItem.innerHTML = `
                            <div class="homepage-tile homepage-thirds">
                                <img src="${post.thumbnail}" alt="${post.title}" class="post-thumbnail">
                                <h2 class="CourseName">${post.title}</h2>
                                <a class="button" href="${post.link}" title="Enrol on ${post.title}">Enrol</a>
                            </div>
                        `;
                        resultsContainer.appendChild(postItem);
                    });
                } else {
                    resultsContainer.innerHTML = '<p>No results found.</p>';
                }
            })
            .catch(error => {
                console.error('Error fetching search results:', error);
                resultsContainer.innerHTML = '<p>Error fetching results.</p>';
            });
    });
});

    </script>
