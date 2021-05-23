<?php
get_header();
pageBanner(array(
    'title' => 'Our campuses',
    'subtitle' => 'We have several conveniently located campuses. '
))
?>

<div class="container container--narrow page-section">

    <ul class="link-list min-list">
        <?php

        while (have_posts()) {
            the_post();


        }
        echo paginate_links();
        ?>
    </ul>

    <?php
    get_footer();
    ?>