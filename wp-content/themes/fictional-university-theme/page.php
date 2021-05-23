<?php

get_header();

while (have_posts()) {
    $currentPageId = get_the_ID();
    the_post();
    pageBanner(array(
        'title' => 'Hello there',
        'photo' => 'https://upload.wikimedia.org/wikipedia/commons/thumb/3/35/Neckertal_20150527-6384.jpg/800px-Neckertal_20150527-6384.jpg'
    ));
?>
    <div class="container container--narrow page-section">

        <?php
        if (isChildPage($currentPageId)) {
            $parentPageId = wp_get_post_parent_id($currentPageId);

        ?>
            <div class="metabox metabox--position-up metabox--with-home-link">
                <p><a class="metabox__blog-home-link" href="<?php echo get_permalink($parentPageId); ?>">
                        <i class="fa fa-home" aria-hidden="true"></i> Back to <?php echo get_the_title($parentPageId); ?>
                    </a> <span class="metabox__main"><?php the_title(); ?> </span></p>
            </div>
        <?php

        }

        if (isChildPage($currentPageId) or isParentPage($currentPageId)) {

        ?>
            <div class="page-links">
                <h2 class="page-links__title">
                    <a href="<?php echo get_permalink($parentPageId); ?>">
                        <?php echo get_the_title($parentPageId); ?>
                    </a>
                </h2>
                <ul class="min-list">
                    <?php

                    if (isChildPage($currentPageId)) {
                        $parentIdOfChildrenToShow = $parentPageId;
                    } else {
                        $parentIdOfChildrenToShow = $currentPageId;
                    }

                    wp_list_pages(array(
                        "title_li" => NULL,
                        "child_of" => $parentIdOfChildrenToShow,
                        'sort_column' => 'menu_order'
                    ));
                    ?>
                </ul>
            </div>
        <?php } ?>

        <div class="generic-content">
            <?php the_content(); ?>
        </div>

    </div>

<?php
}

get_footer();
