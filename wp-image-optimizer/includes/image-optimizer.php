<?php

// Prevent direct access to the file
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

// Hook to optimize images on upload
add_action('wp_handle_upload', 'wp_image_optimizer');

function wp_image_optimizer($upload) {
    $options = get_option('wp_image_optimizer_options');

    // Get the uploaded file path
    $file_path = $upload['file'];
    $file_extension = pathinfo($file_path, PATHINFO_EXTENSION);

    // Check if the file type is allowed for optimization
    if (isset($options[$file_extension]) && $options[$file_extension]) {
        // Compression logic
        if (class_exists('Imagick')) {
            $imagick = new Imagick($file_path);
            $imagick->setImageCompression(Imagick::COMPRESSION_JPEG);
            $imagick->setCompressionQuality(75);
            $imagick->stripImage();
            $imagick->writeImage($file_path);
            $imagick->destroy();
        } elseif (function_exists('gd_info')) {
            $image_info = getimagesize($file_path);
            if ($image_info) {
                switch ($image_info['mime']) {
                    case 'image/jpeg':
                        $image = imagecreatefromjpeg($file_path);
                        imagejpeg($image, $file_path, 75);
                        break;
                    case 'image/png':
                        $image = imagecreatefrompng($file_path);
                        imagepng($image, $file_path, 7);
                        break;
                }
                imagedestroy($image);
            }
        }

        // Check if WebP conversion is enabled
        if (isset($options['webp_conversion']) && $options['webp_conversion']) {
            // Convert to WebP
            $webp_file_path = preg_replace('/\.(jpg|jpeg|png)$/i', '.webp', $file_path);
            if ($file_extension === 'jpeg' || $file_extension === 'jpg') {
                $image = imagecreatefromjpeg($file_path);
            } elseif ($file_extension === 'png') {
                $image = imagecreatefrompng($file_path);
            } else {
                return $upload;
            }
            imagewebp($image, $webp_file_path, 75);
            imagedestroy($image);
        }
    }

    return $upload;
}
