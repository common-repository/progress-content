<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
class progcontent_Progress
{
    function __construct()
    {
        add_action('admin_menu', array($this, 'progcontent_addAdminPage'));
        add_action('wp_body_open', array($this, 'progcontent_addProgressBar'));
        add_action('wp_enqueue_scripts', array($this, 'progcontent_registerAssets'));
        add_action('admin_enqueue_scripts', array($this, 'progcontent_registerAssetsAdmin'));
        add_action( 'init', array($this, 'progcontent_load_textdomain'));

        register_activation_hook(__FILE__, array($this, 'progcontent_activate'));
        add_filter('plugin_action_links_progress-content/index.php', array($this, 'progcontent_filter_action_links'), 10, 1);
        $this->progcontent_checking_options();
    }

    public function progcontent_load_textdomain() {
        load_plugin_textdomain( 'progress-content', false, dirname( plugin_basename( __FILE__ ) ) . '/languages' ); 

    }

    public function progcontent_checking_options()
    {
        if (get_option('progcontent_color_bar') == false) {
            $this->progcontent_activate();
        }
    }

    public function progcontent_filter_action_links($links)
    {
        $links['settings'] = '<a href="' . admin_url('themes.php?page=progress-admin') . '">Configuration</a>';
        return $links;
    }

    public function progcontent_registerAssets()
    {
        $optionsBar = array(
            'post_type' => (get_option('progcontent_post_type_bar')) ? get_option('progcontent_post_type_bar') : array('post')
        );
        if (in_array(get_post_type(), $optionsBar['post_type'])) {
            wp_enqueue_script('pc-progress-bar', plugin_dir_url(__FILE__) . 'progress.js', array('jquery'), '1.0', true);
            wp_enqueue_style('pc-progress-bar', plugin_dir_url(__FILE__) . 'progress.css', array(), '1.0');
        }
    }

    public function progcontent_registerAssetsAdmin() {
        wp_enqueue_style('pc-progress-bar-admin', plugin_dir_url(__FILE__) . 'pages/progress-admin.css', array(), '1.0');
        wp_enqueue_script('pc-progress-bar-admin', plugin_dir_url(__FILE__) . 'pages/progress-admin.js', array('jquery'), '1.0', true);
    }

    public function progcontent_activate()
    {
        update_option('progcontent_color_bar', '#010101');
        update_option('progcontent_height_bar', 4);
        update_option('progcontent_post_type_bar', array('post', 'page'));
        update_option('progcontent_style_bar', 'default');
    }

    public function progcontent_addAdminPage()
    {
        add_theme_page(__('Progress bar', 'progress-content'), __('Progress bar', 'progress-content'), 'administrator', 'progress-admin', array($this, 'progcontent_adminPage'));
    }

    public function progcontent_getAllStylesBar()
    {
        $allStyles = [
            [
                'Name' => __('Default', 'progress-content'),
                'Class' => 'default'
            ],
            [
                'Name' => __('Progress Modern', 'progress-content'),
                'Class' => 'progress-style-1'
            ],
            [
                'Name' => __('Progress shadowed', 'progress-content'),
                'Class' => 'progress-style-2'
            ]
        ];
        return $allStyles;
    }

    public function progcontent_getAllPostTypes()
    {
        return get_post_types(array('public' => true));
    }

    public function progcontent_adminPage()
    {
        if (isset($_POST['color_bar']) && isset($_POST['wp_nonce_bar']) && isset($_POST['height_bar']) && isset($_POST['post_type']) && isset($_POST['style_bar'])) {
            if (wp_verify_nonce(sanitize_text_field(wp_unslash($_POST['wp_nonce_bar'])), 'bar') != 1) {
                echo '<div class="notice notice-error is-dismissible"><p>Sorry, your nonce is not valid, please try again</p></div>';
                return;
            }
            update_option('progcontent_color_bar', sanitize_hex_color(wp_unslash($_POST['color_bar'])));
            update_option('progcontent_height_bar', sanitize_text_field(wp_unslash($_POST['height_bar'])));
            update_option('progcontent_post_type_bar', array_map('sanitize_text_field', $_POST['post_type']));
            update_option('progcontent_style_bar', sanitize_text_field(wp_unslash($_POST['style_bar'])));
            echo '<div class="notice notice-success is-dismissible"><p>' . __('Configuration saved and applyed for all new visitors !', 'progress-content') . '</p></div>';
        }
        $optionsBar = array(
            'color' => get_option('progcontent_color_bar'),
            'height' => get_option('progcontent_height_bar'),
            'post_type' => (get_option('progcontent_post_type_bar')) ? get_option('progcontent_post_type_bar') : array('post'),
            'style_bar' => get_option('progcontent_style_bar')
        );

        $allStylesBar = $this->progcontent_getAllStylesBar();
        $selectedPost = $this->progcontent_getAllPostTypes();
        require ('pages/admin.php');
    }

    public function progcontent_addProgressBar()
    {
        $optionsBar = array(
            'color' => get_option('progcontent_color_bar'),
            'height' => get_option('progcontent_height_bar'),
            'post_type' => (get_option('progcontent_post_type_bar')) ? get_option('progcontent_post_type_bar') : array('post'),
            'style_bar' => get_option('progcontent_style_bar')
        );
        if (in_array(get_post_type(), $optionsBar['post_type'])) {
            echo wp_kses_post('<div id="__progress_bar_front" style="height: ' . esc_html($optionsBar['height']) . 'px;background: ' . esc_html($optionsBar['color']) . ';" class="' . esc_html($optionsBar['style_bar']) . '"></div>');
        }
    }
}
