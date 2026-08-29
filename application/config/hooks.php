<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| NovaDrop — Hooks Config
|--------------------------------------------------------------------------
| Hooks allow you to execute script with particular points in the execution cycle.
|--------------------------------------------------------------------------
*/

// Register HMVC MX loader
$hook['pre_system'][] = [
    'class'    => '',
    'function' => '',
    'filename' => '',
    'filepath' => '',
];

// NOTE: HMVC MX is loaded via MY_Controller / index.php
// Pre-controller hook: Load .env, define env() helper
$hook['pre_controller'][] = [
    'class'    => 'NovaDrop_Hooks',
    'function' => 'env_bootstrap',
    'filename' => 'NovaDrop_Hooks.php',
    'filepath' => 'hooks',
];
