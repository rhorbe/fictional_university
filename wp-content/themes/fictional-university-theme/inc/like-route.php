<?php

add_action('rest_api_init', 'universityLikeRoutes');

function universityLikeRoutes()
{
    register_rest_route('university/v1/', 'managelike', array(
        'methods' => 'POST',
        'callback' => 'createLike'
    ));

    register_rest_route('university/v1/', 'managelike', array(
        'methods' => 'DELETE',
        'callback' => 'deleteLike'
    ));
}

function createLike($data)
{
    if (is_user_logged_in()) {
        $profesorId = sanitize_text_field($data['professorId']);

        $existQuery = new WP_Query(array(
            'author' => get_current_user_id(),
            'post_type' => 'like',
            'meta_query' => array(
                array(
                    'key' => 'liked_professor_id',
                    'compare' => '=',
                    'value' => $profesorId
                )
            )
        ));

        if ($existQuery->found_posts == 0 and get_post_type($profesorId) == 'professor') {
            return wp_insert_post(
                array(
                    'post_type' => 'like',
                    'post_status' => 'publish',
                    'post_title' => '2nd PHP create post test',
                    'meta_input' => array(
                        'liked_professor_id' => $profesorId
                    )
                )
            );
        } else {
            die("Invalid professor id");
        }
    } else {
        die("Only logged in users can create a like.");
    }
}

function deleteLike($data)
{
    $likeId = sanitize_text_field($data['like']);
    if (
        get_current_user_id() == get_post_field('post_author', $likeId) and
        get_post_type($likeId) == 'like'
    ) {
        wp_delete_post($likeId, true);
        return 'Congrats like deleted.';
    } else {
        die("You do not have permission to delete that.");
    }
}
