<?php

use App\Core\Session;
use App\Core\UserSession;

${basename(__FILE__, '.php')} = function () {
    if (!$this->isAuthenticated() && $this->get_request_method() == 'POST') {
        if ($this->paramsExists(['user', 'pass']) && strlen($this->_request['user']) < 32) {
            $user = $this->_request['user'];
            $password = $this->_request['pass'];
            $fg = isset($_COOKIE['fingerprint']) ? $_COOKIE['fingerprint'] : null;
            
            $token = UserSession::authenticate($user, $password, $fg);
            if ($token) {
                $redirect_to = URL_ROOT;
                if (Session::isset('_redirect')) {
                    $redirect_to = Session::get('_redirect');
                    Session::set('_redirect', false);
                }
                usleep(mt_rand(400000, 1300000));
                $this->response($this->json([
                    'message' => 'Authenticated',
                    'redirect' => $redirect_to
                ]), 202);
            } else {
                usleep(mt_rand(300000, 1300000));
                $this->response($this->json([
                    'message' => 'Unauthorized'
                ]), 401);
            }
        } else {
            $this->response($this->json([
                'message' => 'Bad Request'
            ]), 400);
        }
    } else {
        $this->response($this->json([
            'message'=>"Bad Request"
        ]), 400);
    }
};
