<?php
require get_theme_file_path(('/inc/search-route.php'));

function university_custom_rest()
{
    register_rest_field('post', 'authorName', array(
        'get_callback' => function () {
            return get_the_author();
        }
    ));
}

add_action('rest_api_init', 'university_custom_rest');

function pageBanner($args = [])
{
    $title = getTitle($args);
    $subtitle = getSubtitle($args);
    $backgroundImageURL =  getBackgroundImageURL($args);

?>
    <div class="page-banner">
        <div class="page-banner__bg-image" style="background-image:url(<?php echo $backgroundImageURL; ?>);"> </div>
        <div class="page-banner__content container container--narrow">
            <h1 class="page-banner__title"> <?php echo $title; ?> </h1>
            <div class="page-banner__intro">
                <p><?php echo $subtitle ?></p>
            </div>
        </div>
    </div>
<?php
};

function getTitle($args = [])
{
    return $args['title'] ? $args['title'] : get_the_title();
}

function getSubtitle($args = [])
{
    return  $args['subtitle'] ? $args['subtitle'] : get_field('page_banner_subtitle');
}

function getDefaultBackgroundURL()
{
    if (!get_field('page_banner_background_image') or is_archive() or is_home()) {
        $photo = get_theme_file_uri('/images/ocean.jpg');
    } else {
        $photo = get_field('page_banner_background_image')['sizes']['pageBanner'];
    }
    return $photo;
}

function getBackgroundImageURL($args = [])
{
    return $args['photo'] ? $args['photo'] : getDefaultBackgroundURL();
}



function university_files()
{
    // Las siguientes dos líneas eran la versión original
    // wp_enqueue_script('main-universitu-js', get_theme_file_uri('/js/scripts-bundled.js'), NULL, '1.0', true);
    // wp_enqueue_style('university_main_styles', get_stylesheet_uri());
    wp_enqueue_style('font-awesome', '//maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css');
    wp_enqueue_style('custom-google-fonts', '//fonts.googleapis.com/css?family=Roboto+Condensed:300,300i,400,400i,700,700i|Roboto:100,300,400,400i,700,700i');

    if (strstr($_SERVER['SERVER_NAME'], 'localhost')) {
        wp_enqueue_script('main-universitu-js', 'http://localhost:3000/bundled.js', NULL, '1.0', true);
    } else {
        wp_enqueue_script('our-vendors-js', get_theme_file_uri('/bundled-assets/vendors~scripts.1fa169383e64a33bfd0c.js'), NULL, '1.0', true);
        wp_enqueue_script('main-university-js', get_theme_file_uri('/bundled-assets/scripts.bc46957f5967040bf593.js'), NULL, '1.0', true);
        wp_enqueue_style('our-main-styles', get_theme_file_uri('/bundled-assets/styles.bc46957f5967040bf593.css'));
    }
}

add_action('wp_enqueue_scripts', 'university_files');

function university_features()
{
    // register_nav_menu('headerMenuLocation', 'Header Menu Location');
    // register_nav_menu('footerLocationOne', 'Footer Location One');
    // register_nav_menu('footerLocationTwo', 'Footer Location Two');
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    add_image_size('professorLandscape', 400, 260, true);
    add_image_size('professorPortrait', 480, 650, true);
    add_image_size('pageBanner', 1500, 350, true);
}

add_action('after_setup_theme', 'university_features');

function university_adjust_queries($query)
{
    if (is_main_query() and !is_admin() and is_post_type_archive('program')) {
        $query->set('orderby', 'title');
        $query->set('order', 'ASC');
        $query->set('posts_per_page', -1);
    };

    if (is_main_query() and !is_admin() and is_post_type_archive('event')) {
        $today = date('Ymd');

        $query->set('meta_key', 'event_date');
        $query->set('orderby', 'meta_value_num');
        $query->set('order', 'ASC');
        $query->set('meta_query', array(
            array(
                'key' => 'event_date',
                'compare' => '>=',
                'value' => $today,
                'type' => 'numeric'
            )
        ));
    }
}

add_action('pre_get_posts', 'university_adjust_queries');

function universityMapKey($api)
{
    $api['key'] = 'AIzaSyD-k3h-nkA4DjTA4S3zVnpRMiSIcEz_mt4';
    return $api;
}

add_filter('acf/fields/google_map/api', 'universityMapKey');

function isChildPage($id)
{
    $currentPageParentId = wp_get_post_parent_id($id);
    return $currentPageParentId <> 0;
}

function isParentPage($id)
{
    $childrenPages = get_pages(array(
        'child_of' => $id
    ));
    return count($childrenPages) > 0;
}


add_action('admin_init', 'redirectSubsToFrontEnd');

function redirectSubsToFrontEnd()
{
    $ourCurrectUser = wp_get_current_user();
    if (count($ourCurrectUser->roles) == 1 and $ourCurrectUser->roles[0] == 'subscriber') {
        wp_redirect(site_url('/'));
        exit;
    }
};


add_action('wp_loaded', 'noSubsAdminBar');

function noSubsAdminBar()
{
    $ourCurrectUser = wp_get_current_user();
    if (count($ourCurrectUser->roles) == 1 and $ourCurrectUser->roles[0] == 'subscriber') {
        show_admin_bar(false);
    }
};

add_filter('login_headerurl', 'ourHeaderUrl');

function ourHeaderUrl()
{
    return esc_url(site_url('/'));
}

add_action('login_enqueue_scripts', 'ourLoginCSS');

function ourLoginCSS()
{
    wp_enqueue_style('custom-google-fonts', '//fonts.googleapis.com/css?family=Roboto+Condensed:300,300i,400,400i,700,700i|Roboto:100,300,400,400i,700,700i');
    wp_enqueue_style('our-main-styles', get_theme_file_uri('/bundled-assets/styles.bc46957f5967040bf593.css'));
};

add_filter('login_headertitle','outLoginTitle');

function outLoginTitle(){
    return get_bloginfo('name');
}
