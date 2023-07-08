<?php

namespace App\Core;

use Exception;

class WebAPI extends API
{
    public $site_config_path;

    public function __construct()
    {
        if (php_sapi_name() == "cli") {
            $this->site_config_path = dirname(dirname(__DIR__)).'/config/config.php';
            require_once $this->site_config_path;
        } elseif (php_sapi_name() == "apache2handler") {
            $this->site_config_path = $_SERVER['DOCUMENT_ROOT'] . '/../config/config.php';
            require_once $this->site_config_path;
        }
    }

    public function initiateSession()
    {
        if (php_sapi_name() != "cli") {
            session_cache_limiter('none');
            Session::start();
            if (Session::isset('session_token')) {
                try {
                    Session::$usersession = UserSession::authorize(Session::get('session_token'));
                } catch (Exception $e) {
                    // TODO: Handle error
                    print  $e->getMessage();
                }
            }
        }
    }

    public function gen_hash()
    {
        $st = microtime(true);
        if (isset($this->_request['pass'])) {
            $cost = (int)$this->_request['cost'];
            $options = [
                "cost" => $cost
            ];
            $hash = password_hash($this->_request['pass'], PASSWORD_BCRYPT, $options);
            $data = [
                "hash" => $hash,
                "info" => password_get_info($hash),
                "val" => $this->_request['pass'],
                "verified" => password_verify($this->_request['pass'], $hash),
                "time_in_ms" => microtime(true) - $st
            ];
            $data = $this->json($data);
            $this->response($data, 200);
        }
    }

    public function verify_hash()
    {
        if (isset($this->_request['pass']) and isset($this->_request['hash'])) {
            $hash = $this->_request['hash'];
            $data = [
                "hash" => $hash,
                "info" => password_get_info($hash),
                "val" => $this->_request['pass'],
                "verified" => password_verify($this->_request['pass'], $hash),
            ];
            $data = $this->json($data);
            $this->response($data, 200);
        }
    }
}
