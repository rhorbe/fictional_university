<?php

function university_post_types()
{
    register_post_type('campus', array(
        'show_in_rest' => true,
        'supports' => array('title', 'editor', 'excerpt'),
        'rewrite' => array('slug' => 'campuses'),
        'has_archive' => true,
        'public' => true,
        'menu_icon' => 'dashicons-location-alt',
        'labels' => array(
            'name' => 'Campus',
            'add_new_item' => 'Agregar nuevo campus',
            'edit_item' => 'Editar campus',
            'all_items' => 'Todos los campus',
            'singular_name' => 'Campus'
        )
    ));

    register_post_type('event', array(
        'show_in_rest' => true,
        'capability_type' => 'event',
        'map_meta_cap' => true,
        'supports' => array('title', 'editor', 'excerpt'),
        'rewrite' => array('slug' => 'events'),
        'has_archive' => true,
        'public' => true,
        'menu_icon' => 'dashicons-calendar',
        'labels' => array(
            'name' => 'Eventos',
            'add_new_item' => 'Agregar nuevo evento',
            'edit_item' => 'Editar evento',
            'all_items' => 'Todos los eventos',
            'singular_name' => 'Evento'
        )
    ));

    register_post_type('program', array(
        'show_in_rest' => true,
        'supports' => array('title'),
        'rewrite' => array('slug' => 'programs'),
        'has_archive' => true,
        'public' => true,
        'menu_icon' => 'dashicons-awards',
        'labels' => array(
            'name' => 'Programas',
            'add_new_item' => 'Agregar nuevo programa',
            'edit_item' => 'Editar programa',
            'all_items' => 'Todos los programas',
            'singular_name' => 'Programa'
        )
    ));

    register_post_type('professor', array(
        'show_in_rest' => true,
        'supports' => array('title', 'editor', 'thumbnail'),
        'public' => true,
        'menu_icon' => 'dashicons-welcome-learn-more',
        'labels' => array(
            'name' => 'Professor',
            'add_new_item' => 'Agregar nuevo profesor',
            'edit_item' => 'Editar profesor',
            'all_items' => 'Todos los profesores',
            'singular_name' => 'Profesor'
        )
    ));
}

add_action('init', 'university_post_types');
