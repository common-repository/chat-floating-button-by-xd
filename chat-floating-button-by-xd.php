<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
/*
  Plugin Name: Chat Floating Button BY XD
  Description: Add a floating WhatsApp chat button to your WordPress site. Chat with your website visitors via their favorite channels WhatsApp. Show a chat icon on the bottom of your site and communicate with your website visitors.
  Version: 2.0
  Author: Xpert Dezine IT
  Author URI: https://facebook.com/xpertdezineit
  License: GPLv2 or later
  License URI: http://www.gnu.org/licenses/gpl-2.0.html
  Icon: icon.gif
*/

// Enqueue WhatsApp button script and styles
function xdwhatsapp_enqueue_assets() {
    wp_enqueue_style('xdwhatsapp-style', plugins_url('css/xdwhatsapp.min.css', __FILE__), array(), '1.0');
    wp_enqueue_script('xdwhatsapp-script', plugins_url('js/xdwhatsapp.min.js', __FILE__), array('jquery'), '1.0', true);
}
add_action('wp_enqueue_scripts', 'xdwhatsapp_enqueue_assets');

// Add WhatsApp button HTML
function xdwhatsapp_chat_button() {
    $whatsapp_number = get_option('xdwhatsapp_number', '1234567890'); // Default number if not set
    $button_text = get_option('xdwhatsapp_button_text', 'Chat with us'); // Default button text if not set
    $button_visibility = get_option('xdwhatsapp_button_visibility', '1'); // Default visibility is visible
    
    if ($button_visibility == '1') {
        echo '<a href="https://wa.me/' . esc_attr($whatsapp_number) . '" class="xdwhatsapp-button" target="_blank">';
        echo '<svg viewBox="0 0 35 32" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" style="width: 100%; height: 100%; margin-left: 4px; fill: rgb(255, 255, 255); stroke: none;">
                <path d="M19.11 17.205c-.372 0-1.088 1.39-1.518 1.39a.63.63 0 0 1-.315-.1c-.802-.402-1.504-.817-2.163-1.447-.545-.516-1.146-1.29-1.46-1.963a.426.426 0 0 1-.073-.215c0-.33.99-.945.99-1.49 0-.143-.73-2.09-.832-2.335-.143-.372-.214-.487-.6-.487-.187 0-.36-.043-.53-.043-.302 0-.53.115-.746.315-.688.645-1.032 1.318-1.06 2.264v.114c-.015.99.472 1.977 1.017 2.78 1.23 1.82 2.506 3.41 4.554 4.34.616.287 2.035.888 2.722.888.817 0 2.15-.515 2.478-1.318.13-.33.244-.73.244-1.088 0-.058 0-.144-.03-.215-.1-.172-2.434-1.39-2.678-1.39zm-2.908 7.593c-1.747 0-3.48-.53-4.942-1.49L7.793 24.41l1.132-3.337a8.955 8.955 0 0 1-1.72-5.272c0-4.955 4.04-8.995 8.997-8.995S25.2 10.845 25.2 15.8c0 4.958-4.04 8.998-8.998 8.998zm0-19.798c-5.96 0-10.8 4.842-10.8 10.8 0 1.964.53 3.898 1.546 5.574L5 27.176l5.974-1.92a10.807 10.807 0 0 0 16.03-9.455c0-5.958-4.842-10.8-10.802-10.8z"></path>
            </svg>';
        //echo '<span class="xdwhatsapp-button-text">' . esc_html($button_text) . '</span>';
        echo '</a>';
    }
}
add_action('wp_footer', 'xdwhatsapp_chat_button');

// Register plugin settings
function xdwhatsapp_register_settings() {
    add_option('xdwhatsapp_number', ''); // WhatsApp number
    add_option('xdwhatsapp_button_text', 'Chat with us'); // Button text
    add_option('xdwhatsapp_button_visibility', '1'); // Button visibility
    register_setting('xdwhatsapp_options_group', 'xdwhatsapp_number');
    register_setting('xdwhatsapp_options_group', 'xdwhatsapp_button_text');
    register_setting('xdwhatsapp_options_group', 'xdwhatsapp_button_visibility');
}
add_action('admin_init', 'xdwhatsapp_register_settings');

// Add plugin settings menu
function xdwhatsapp_settings_menu() {
    add_menu_page('WhatsApp Chat Button Settings', 'WhatsApp Chat', 'manage_options', 'xdwhatsapp-main-menu', 'xdwhatsapp_main_menu_page', 'dashicons-whatsapp');
    add_submenu_page('xdwhatsapp-main-menu', 'Settings', 'Settings', 'manage_options', 'xdwhatsapp-settings', 'xdwhatsapp_settings_page');
}
add_action('admin_menu', 'xdwhatsapp_settings_menu');


// Display main menu page
function xdwhatsapp_main_menu_page() {
    ?>
    <div class="wrap" style="padding:50px;text-align:center;">
        <h2>Welcome to WhatsApp Chat Button Plugin</h2>
        <p>Use the settings page to configure your WhatsApp chat button.</p>
        <p>Or <a href="?page=xdwhatsapp-settings"><b>Click Here</b></a></p>
    </div>
    <?php
}

// Display plugin settings page
function xdwhatsapp_settings_page() {
    ?>
    <div class="wrap" style="padding:50px;">
        <h2>WhatsApp Chat Button Settings</h2>
        <form method="post" action="options.php">
            <?php settings_fields('xdwhatsapp_options_group'); ?>
            <?php do_settings_sections('xdwhatsapp-options'); ?>
            <table class="form-table">
                <tr valign="top">
                    <th scope="row">WhatsApp Number:</th>
                    <td><input type="text" name="xdwhatsapp_number" value="<?php echo esc_attr(get_option('xdwhatsapp_number')); ?>" /></td>
                </tr>
                <tr valign="top">
                    <th scope="row">Button Text:</th>
                    <td><input type="text" name="xdwhatsapp_button_text" value="<?php echo esc_attr(get_option('xdwhatsapp_button_text')); ?>" /></td>
                </tr>
                <tr valign="top">
                    <th scope="row">Button Visibility:</th>
                    <td>
                        <input type="checkbox" name="xdwhatsapp_button_visibility" value="1" <?php checked(1, get_option('xdwhatsapp_button_visibility'), true); ?> /> Show Button
                    </td>
                </tr>
            </table>
            <?php submit_button(); ?>
        </form>
        
        <h2 style="margin-top: 40px;">Plugin Information</h2>
        <p>
            <a href="https://wordpress.org/plugins/chat-floating-button-by-xd/" target="_blank" class="button button-primary">View Details</a>
            <a href="https://wordpress.org/support/plugin/chat-floating-button-by-xd/reviews/" target="_blank" class="button button-secondary">Leave A Review</a>
        </p>
    </div>
    <?php
}



// Add plugin settings link to the plugins page
function xdwhatsapp_plugin_settings_link($links) {
    $settings_link = '<a href="admin.php?page=xdwhatsapp-settings">Settings</a>';
    array_unshift($links, $settings_link);
    return $links;
}
$plugin = plugin_basename(__FILE__);
add_filter("plugin_action_links_$plugin", 'xdwhatsapp_plugin_settings_link');
