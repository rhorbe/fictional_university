<?php
if (!is_user_logged_in()){
    wp_redirect(esc_url(site_url('/')));
}


get_header();

while (have_posts()) {
    $currentPageId = get_the_ID();
    the_post();
    pageBanner();
?>
    <div class="container container--narrow page-section">

        Hola mundo

    </div>

<?php
}

get_footer();
