<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * NovaDrop_Hooks — pre-controller hooks
 */
class NovaDrop_Hooks
{
    /**
     * Load .env file and define global env() helper.
     * Called before any controller is instantiated.
     */
    public function env_bootstrap(): void
    {
        $env_file = FCPATH . '.env';
        if (!file_exists($env_file)) return;

        foreach (file($env_file, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES) as $line) {
            $line = trim($line);
            if ($line === '' || $line[0] === '#' || strpos($line, '=') === false) continue;
            [$k, $v] = explode('=', $line, 2);
            $k = trim($k); $v = trim($v);
            if (!isset($_ENV[$k])) {
                putenv("$k=$v");
                $_ENV[$k]    = $v;
                $_SERVER[$k] = $v;
            }
        }

        // Define global env() helper once
        if (!function_exists('env')) {
            function env(string $key, mixed $default = null): mixed {
                $val = $_ENV[$key] ?? getenv($key);
                return ($val === false || $val === null) ? $default : $val;
            }
        }
    }
}
