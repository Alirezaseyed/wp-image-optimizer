<?php

// Prevent direct access to the file
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

// Add menu item to the admin dashboard
add_action('admin_menu', 'wp_image_optimizer_menu');

function wp_image_optimizer_menu() {
    add_options_page(
        'WP Image Optimizer Settings',
        'Image Optimizer',
        'manage_options',
        'wp-image-optimizer',
        'wp_image_optimizer_settings_page'
    );
}

// Settings page
function wp_image_optimizer_settings_page() {
    ?>
    <div class="wrap">
        <h1>WP Image Optimizer Settings</h1>
        <form method="post" action="options.php">
            <?php
            settings_fields('wp_image_optimizer_options_group');
            do_settings_sections('wp-image-optimizer');
            $options = get_option('wp_image_optimizer_options');
            ?>
            <h2>Select Image Formats to Optimize</h2>
            <table class="form-table">
                <tr valign="top">
                    <th scope="row">JPEG</th>
                    <td>
                        <input type="checkbox" name="wp_image_optimizer_options[jpeg]" value="1" <?php checked(1, isset($options['jpeg'])); ?> />
                    </td>
                </tr>
                <tr valign="top">
                    <th scope="row">PNG</th>
                    <td>
                        <input type="checkbox" name="wp_image_optimizer_options[png]" value="1" <?php checked(1, isset($options['png'])); ?> />
                    </td>
                </tr>
                <tr valign="top">
                    <th scope="row">GIF</th>
                    <td>
                        <input type="checkbox" name="wp_image_optimizer_options[gif]" value="1" <?php checked(1, isset($options['gif'])); ?> />
                    </td>
                </tr>
                <tr valign="top">
                    <th scope="row">WebP Conversion</th>
                    <td>
                        <input type="checkbox" name="wp_image_optimizer_options[webp_conversion]" value="1" <?php checked(1, isset($options['webp_conversion'])); ?> />
                        <p class="description">Enable WebP conversion for optimized images.</p>
                    </td>
                </tr>
            </table>
            <?php submit_button(); ?>
        </form>
    </div>
    <?php
}

// Register settings
add_action('admin_init', 'wp_image_optimizer_register_settings');

function wp_image_optimizer_register_settings() {
    register_setting('wp_image_optimizer_options_group', 'wp_image_optimizer_options');
}
