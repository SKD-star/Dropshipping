<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Global CSRF Helpers for CodeIgniter 3
 */

if (!function_exists('csrf_field')) {
    function csrf_field(): string
    {
        $CI =& get_instance();
        if (isset($CI->security)) {
            $name = $CI->security->get_csrf_token_name();
            $hash = $CI->security->get_csrf_hash();
            return '<input type="hidden" name="' . htmlspecialchars($name, ENT_QUOTES, 'UTF-8') . '" value="' . htmlspecialchars($hash, ENT_QUOTES, 'UTF-8') . '">';
        }
        return '';
    }
}

if (!function_exists('csrf_token')) {
    function csrf_token(): string
    {
        $CI =& get_instance();
        return isset($CI->security) ? $CI->security->get_csrf_hash() : '';
    }
}

if (!function_exists('csrf_name')) {
    function csrf_name(): string
    {
        $CI =& get_instance();
        return isset($CI->security) ? $CI->security->get_csrf_token_name() : 'csrf_novadrop';
    }
}

if (!function_exists('old')) {
    function old(string $field, mixed $default = ''): mixed
    {
        $CI =& get_instance();
        return $CI->input->post($field) ?? $default;
    }
}

if (!function_exists('asset_url')) {
    function asset_url(string $path = ''): string
    {
        return base_url('assets/' . ltrim($path, '/'));
    }
}

