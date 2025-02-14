<?php
/**
 * Plugin Name: SVG Inline Cache Manager
 * Description: Optimises rendering of remote SVGs by caching them locally and serving them as inline SVGs.
 * Version: 1.0
 * Author: Cameron Stephen
 * Text Domain: svg-inline-cache-manager
 */

use PDSUK\SVGInlineCacheManager\SVGInlineCacheManager;

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

require_once plugin_dir_path(__FILE__) . 'includes/SVGInlineCacheManager.php';
require_once plugin_dir_path(__FILE__) . 'includes/functions.php';

new SVGInlineCacheManager();