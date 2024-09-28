<?php

// Helper functions

/**
 * Dump and Die
 */
function dd($data)
{
    echo '<pre>';
    var_dump($data);
    echo '</pre>';
    die();
}

/**
 * Return current date and time
 */
function now()
{
    return date('Y-m-d H:i:s');
}

/**
 * Return json encoded data
 */
function packJson(array $data)
{
    if (is_array($data)) {
        return json_encode($data, JSON_PRETTY_PRINT|JSON_UNESCAPED_SLASHES);
    }
    return '{}';
}

/**
 * Return json encoded data
 */
function unpackJson(string $data)
{
    return json_decode($data);
}

/**
 * Return the length of the given data
 */
function getLength($data)
{
    if (is_array($data)) {
        return count($data);
    } else if (is_object($data)) {
        return count(get_object_vars($data));
    } else {
        return strlen((string) $data);
    }
}

/**
 * Validate given email
 */
function filterEmail(string $email)
{
    return filter_var($email, FILTER_VALIDATE_EMAIL);
}

function dump($var)
{
    if (is_bool($var)) {
        $var = 'bool(' . ($var ? 'true' : 'false') . ')';
    }

    if (php_sapi_name() === 'cli') {
        print_r($var);
    } else {
        highlight_string("<?php\n" . var_export($var, true));
    }
}

function get_assets($asset) {
    // $asset = "resources/css/app.css";
    $manifestPath = PUBLIC_PATH . '/build/.vite/manifest.json';

    if (strtolower($_ENV['APP_ENV']) == 'dev') {
        if (!file_exists($manifestPath)) {
            // Handle case where manifest does not exist (e.g., in development)
            return 'http://localhost:5173/'.$asset;
        }
        return 'http://localhost:5173/' . $asset;
    }

    if (!file_exists($manifestPath)) {
        throw new Exception("Production assets not found!");
    }

    $manifest = json_decode(file_get_contents($manifestPath), true);
    if (isset($manifest[$asset])) {
        return '/build/' . $manifest[$asset]['file'];
    }
    
    // Handle case where the asset is not found in the manifest
    return $asset;
}
