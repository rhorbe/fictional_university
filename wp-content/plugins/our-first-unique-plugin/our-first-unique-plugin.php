    <?php
    /*
    Plugin Name: Our Test Plugin
    Description: A truly amazing plugin.
    Version: 1.0
    Author: Rafael
    Author URI: uniquecode.dev
*/

    class WordCountAndTimePlugin
    {
        function __construct()
        {
            add_action('admin_menu', array($this, 'adminPage'));
            add_action('admin_init', array($this, 'settings'));
        }

        function adminPage()
        {
            add_options_page(
                'Word Count Settings',      // Título en pestaña navegador
                'Word Count',               // Título en Sección de Ajustes
                'manage_options',           // Permisos
                'word-count-settings-page', // Slug identidicador
                array($this, 'ourHTML')
            );
        }

        function settings()
        {
            add_settings_section(
                'wcp_first_section',
                'Settings',         // Nombre de la sección
                null,
                'word-count-settings-page'
            );


            add_settings_field(
                'wcp_location',
                'Display Location',
                array(
                    $this,
                    'locationHTML'
                ),
                'word-count-settings-page',
                'wcp_first_section'
            );
            register_setting(
                'wordcountplugin',
                'wcp_location',
                array(
                    'sanitize_callback' => array($this, 'sanitizeLocation'),
                    'default' => '0'
                )
            );

            add_settings_field(
                'wcp_headline',
                'Headline Text',
                array(
                    $this,
                    'headlineHTML'
                ),
                'word-count-settings-page',
                'wcp_first_section'
            );

            register_setting(
                'wordcountplugin',
                'wcp_headline',
                array(
                    'sanitize_callback' => 'sanitize_text_field',
                    'default' => 'Post Statistics'
                )
            );

            add_settings_field(
                'wcp_word_count',
                'Word Count',
                array(
                    $this,
                    "checkboxHTML", //Nombre de la funcions con el template para este campo
                ),
                'word-count-settings-page',
                'wcp_first_section',
                array('theName' => 'wcp_word_count') //Argumentos para el función con el template
            );

            register_setting(
                'wordcountplugin',
                'wcp_word_count',
                array(
                    'sanitize_callback' => 'sanitize_text_field',
                    'default' => '1'
                )
            );

            add_settings_field(
                'wcp_character_count',
                'Character count',
                array(
                    $this,
                    "checkboxHTML", //Nombre de la funcions con el template para este campo
                ),
                'word-count-settings-page',
                'wcp_first_section',
                array('theName' => 'wcp_character_count') //Argumentos para el función con el template
            );
            register_setting(
                'wordcountplugin',
                'wcp_character_count',
                array(
                    'sanitize_callback' => 'sanitize_text_field',
                    'default' => '1'
                )
            );

            add_settings_field(
                'wcp_read_time',
                'Read time',
                array(
                    $this,
                    "checkboxHTML", //Nombre de la funcions con el template para este campo
                ),
                'word-count-settings-page',
                'wcp_first_section',
                array('theName' => 'wcp_read_time') //Argumentos para el función con el template
            );
            register_setting(
                'wordcountplugin',
                'wcp_read_time',
                array(
                    'sanitize_callback' => 'sanitize_text_field',
                    'default' => '1'
                )
            );
        }

        function sanitizeLocation($input)
        {
            if ($input != '0' and $input != '1') {
                add_settings_error('wcp_location', 'wcp_location_error', 'Display location must be either 0 or 1');
                return get_option('wcp_location');
            }
            return $input;
        }

        function checkboxHTML($args)
        { ?>
            <input type="checkbox" name="<?php echo $args['theName'] ?>" value="1" <?php checked(get_option($args['theName']), '1') ?>>
        <?php
        }

        function headlineHTML()
        { ?>
            <input name="wcp_headline" type="text" value="<?php echo esc_attr(get_option('wcp_headline', 'Post Statistics')) ?>">

        <?php
        }

        function locationHTML()
        { ?>
            <select name="wcp_location">
                <option value="0" <?php selected(get_option('wcp_location'), '0') ?>>Beginning of post</option>
                <option value="1" <?php selected(get_option('wcp_location'), '1') ?>>End of post</option>
            </select>
        <?php
        }

        function ourHTML()
        {
        ?>
            <div class="wrap">
                <h1>Word Count Settings</h1> <!-- Título a mostrar en la página de configuración del plugin -->
                <form action="options.php" method="POST">
                    <?php
                    settings_fields('wordcountplugin');
                    do_settings_sections('word-count-settings-page');
                    submit_button()
                    ?>
                </form>
            </div>
    <?php
        }
    }

    $wordCountAndTimePlugin  = new WordCountAndTimePlugin();
    ?>