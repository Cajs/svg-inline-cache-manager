<?php

namespace PDSUK\SVGInlineCacheManager;

use Exception;

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

class SVGInlineCacheManager {

    private $cache_dir;
    private $cache_duration;

    public function __construct() {
        // Get cache directory from environment variable, default to 'wp-content/uploads/cached_svgs/'
        $default_cache_dir = wp_upload_dir()['basedir'] . '/cached_svgs/';
        $this->cache_dir = getenv('SVG_CACHE_PATH') ? rtrim(getenv('SVG_CACHE_PATH'), '/') . '/' : $default_cache_dir;

        // Ensure the cache directory exists
        if (!is_dir($this->cache_dir)) {
            mkdir($this->cache_dir, 0755, true);
        }

        // Get cache duration from environment variable, default to 72 hours
        $this->cache_duration = getenv('SVG_CACHE_HOURS') ? (int) getenv('SVG_CACHE_HOURS') * 3600 : 72 * 3600;

        // Hooks
        add_filter('get_attached_file', [$this, 'cached_get_attached_file'], 10, 2);
        add_action('customize_save_after', [$this, 'clear_cache']);
    }

    /**
     * Check if a URL is remote.
     */
    private function is_remote_url($url) {
        return filter_var($url, FILTER_VALIDATE_URL) && parse_url($url, PHP_URL_HOST) !== parse_url(get_site_url(), PHP_URL_HOST);
    }

    /**
     * Caches SVG files and serves them locally if the URL is remote.
     */
    public function cached_get_attached_file($file, $attachment_id) {
        $mime_type = get_post_mime_type($attachment_id);
        if ($mime_type !== 'image/svg+xml') {
            return $file;
        }

        $cdn_url = wp_get_attachment_url($attachment_id);
        if (!$this->is_remote_url($cdn_url)) {
            return $file;
        }

        $file_hash = md5($cdn_url);
        $cached_file_path = $this->cache_dir . $file_hash . '.svg';

        if (file_exists($cached_file_path) && (time() - filemtime($cached_file_path) < $this->cache_duration)) {
            return $cached_file_path;
        }

        try {
            $file_content = file_get_contents($cdn_url);
            if ($file_content !== false) {
                file_put_contents($cached_file_path, $file_content);
                return $cached_file_path;
            }
        } catch (Exception $e) {
            error_log('Failed to fetch SVG from remote URL: ' . $e->getMessage());
        }

        return $file;
    }

    /**
     * Clears the SVG cache when Customizer settings are saved.
     */
    public function clear_cache() {
        $files = glob($this->cache_dir . '*');
        foreach ($files as $file) {
            if (is_file($file)) {
                unlink($file);
            }
        }
    }
}