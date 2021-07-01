<?php
/*
    Plugin Name: Our Test Plugin
    Description: A truly amazing plugin.
    Version: 1.0
    Author: Rafael
    Author URI: https://uniquecode.dev
    Text Domain: wcpdomain
    Domain Path: /languages
*/

class WordCountAndTimePlugin
{
    function __construct()
    {
        add_action('admin_menu', array($this, 'adminPage'));
        add_action('admin_init', array($this, 'settings'));
        add_filter('the_content', array($this, 'ifWrap'));
        add_action('init', array($this, 'languages'));
    }

    function languages()
    {
        load_plugin_textdomain('wcpdomain', false, dirname(plugin_basename(__FILE__)) . '/languages');
    }

    function ifWrap($content)
    {
        if (
            is_main_query() and
            is_single() and
            (get_option('wcp_wordcount', '1') or
                get_option('wcp_charactercount', '1') or
                get_option('wcp_readtime', '1'))
        ) {
            return $this->createHTML($content);
        }
        return $content;
    }

    function createHTML($content)
    {
        $html = '<h3>' . esc_html(get_option('wcp_headline', 'Post Statistics')) . '</h3>';
        $html .= '<p>';

        if (get_option('wcp_wordcount', '1') or get_option('wcp_readtime', '1')) {
            $wordCount = str_word_count((strip_tags($content)));
        }

        if (get_option('wcp_wordcount', '1')) {
            $html .= esc_html__('This post has', 'wcpdomain') . ' ' . $wordCount . ' ' . esc_html__('words', 'wcpdomain') . '.<br>';
        }

        if (get_option('wcp_charactercount', '1')) {
            $html .= 'This post has ' . strlen(strip_tags($content)) . ' characters.<br>';
        }

        if (get_option('wcp_realtime', '1')) {
            $html .= 'This post will take about ' . round($wordCount / 255) . ' minute(s) to read.<br>';
        }

        $html .= '</p>';

        if (get_option('wpc_location', '0') == '0') {
            return $html . $content;
        }
        return $content . $html;
    }

    function adminPage()
    {
        add_options_page(
            'Word Count Settings',      // Título en pestaña navegador
            esc_html__('Word Count', 'wcpdomain'),               // Título en Sección de Ajustes
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
            'wcp_wordcount',
            'Word Count',
            array(
                $this,
                "checkboxHTML", //Nombre de la funcions con el template para este campo
            ),
            'word-count-settings-page',
            'wcp_first_section',
            array('theName' => 'wcp_wordcount') //Argumentos para el función con el template
        );

        register_setting(
            'wordcountplugin',
            'wcp_wordcount',
            array(
                'sanitize_callback' => 'sanitize_text_field',
                'default' => '1'
            )
        );

        add_settings_field(
            'wcp_charactercount',
            'Character count',
            array(
                $this,
                "checkboxHTML", //Nombre de la funcions con el template para este campo
            ),
            'word-count-settings-page',
            'wcp_first_section',
            array('theName' => 'wcp_charactercount') //Argumentos para el función con el template
        );
        register_setting(
            'wordcountplugin',
            'wcp_charactercount',
            array(
                'sanitize_callback' => 'sanitize_text_field',
                'default' => '1'
            )
        );

        add_settings_field(
            'wcp_readtime',
            'Readtime',
            array(
                $this,
                "checkboxHTML", //Nombre de la funcions con el template para este campo
            ),
            'word-count-settings-page',
            'wcp_first_section',
            array('theName' => 'wcp_readtime') //Argumentos para el función con el template
        );
        register_setting(
            'wordcountplugin',
            'wcp_readtime',
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