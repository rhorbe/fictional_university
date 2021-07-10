<?php

/*
    Plugin Name: Are You Paying Attention Quiz
    Description: Give your readers a multiple choice questions.
    Version 1.0
    Author: Rafael
    Author URI: https://uniquecode.dev
*/

if (!defined('ABSPATH')) exit;

class AreYouPayintAttention
{
    function __construct()
    {
        // add_action('enqueue_block_editor_assets', array($this, 'adminAssets'));
        add_action('init', array($this, 'adminAssets'));
    }

    function adminAssets()
    {
        wp_register_script('ournewblocktype', plugin_dir_url(__FILE__) . 'build/index.js', array('wp-blocks', 'wp-element'));
        register_block_type('ourplugin/are-you-paying-attention', array(
            'editor_script' => 'ournewblocktype',
            'render_callback' => array($this, 'theHTML')
        ));
        // wp_enqueue_script('ournewblocktype', plugin_dir_url(__FILE__) . 'build/index.js', array('wp-blocks', 'wp-element'));
    }

    function theHTML($attributes)
    {
        return '<h3>Today the sky is ' . $attributes['skyColor'] . ' and the grass is ' . $attributes['grassColor'] . '.</h3>';
    }
}

$areYouPayintAttention =  new AreYouPayintAttention();
