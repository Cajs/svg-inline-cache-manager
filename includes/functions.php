<?php

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

/**
 * Helper function to get inline SVG content.
 */
function get_inline_svg($attachment_id) {
    $plugin = new SVGInlineCacheManager();
    $cached_file = $plugin->cached_get_attached_file('', $attachment_id);

    if (file_exists($cached_file)) {
        return file_get_contents($cached_file);
    }

    return '<!-- SVG not available -->';
}