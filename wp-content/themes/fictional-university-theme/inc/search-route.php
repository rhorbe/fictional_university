<?php
add_action('rest_api_init', 'universityRegisterSearch');

function universityRegisterSearch()
{
    register_rest_route('university/v1', 'search', array(
        'methods' => WP_REST_Server::READABLE, //GET
        'callback' => 'universitySearchResults'
    ));
}

function universitySearchResults($data)
{
    $mainQuery = new WP_Query(array(
        'post_type' => array(
            'post',
            'page',
            'professor',
            'program',
            'event',
            'campus'
        ),
        's' => sanitize_text_field($data['term'])
    ));

    $results = array(
        'generalInfo' => array(),
        'professors' => array(),
        'programs' => array(),
        'events' => array(),
        'campuses' => array(),
    );

    while ($mainQuery->have_posts()) {
        $mainQuery->the_post();

        switch (get_post_type()) {
            case 'post':
            case 'page':
                $subArray = 'generalInfo';
                break;
            case 'professor':
                $subArray = 'professors';
                break;
            case 'program':
                $subArray = 'programs';
                break;
            case 'event':
                $subArray = 'events';
                break;
            case 'campus':
                $subArray = 'campuses';
                break;
        }

        $eventDate = new DateTime((get_field('event_date')));
        $description= null;
        if (has_excerpt()){
            $description = get_the_excerpt();
        } else {
            $description = wp_trim_words(get_the_content(),18);
        }
        array_push($results[$subArray], array(
            'title' => get_the_title(),
            'permalink' => get_the_permalink(),
            'postType' => get_post_type(),
            'authorName' => get_the_author(),
            'image' => get_the_post_thumbnail_url(0,'professorLandscape'),
            'month' => $eventDate->format('M'),
            'day' => $eventDate->format('d'),
            // 'description' => 
        ));
    }
    return $results;
}
