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

/**
 * Get URL for assets if it exists
 */
function get_asset_path($assetType, $fileName) {
    $asset_path = STORAGE_PATH . "/static/{$assetType}/{$fileName}";
    if (file_exists($asset_path) && is_readable($asset_path)) {
        return "/static/{$assetType}/{$fileName}";
    }
    return null;
}

/**
 * Return asset contents
 */
function get_asset_content($assetType, $fileName) {
    $assetPath = STORAGE_PATH . "/static/{$assetType}/{$fileName}";
    if (file_exists($assetPath) && is_readable($assetPath)) {
        return [
            'content' => file_get_contents($assetPath),
            'path' => $assetPath,
        ];
    }
    return null;
}
