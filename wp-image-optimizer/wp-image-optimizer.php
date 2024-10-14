<?php
/*
Plugin Name: WP Image Optimizer
Description: Automatically compresses and optimizes images uploaded to the site.
Version: 1.0
Author: Δ|!ЯΞZΔ
*/

// Prevent direct access to the file
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

// Include the necessary files
require_once plugin_dir_path(__FILE__) . 'includes/settings.php';
require_once plugin_dir_path(__FILE__) . 'includes/image-optimizer.php';

// Enqueue admin styles
add_action('admin_enqueue_scripts', 'wp_image_optimizer_admin_styles');
function wp_image_optimizer_admin_styles() {
    wp_enqueue_style('wp-image-optimizer-style', plugin_dir_url(__FILE__) . 'css/style.css');
}
