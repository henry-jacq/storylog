<?php

use App\Core\Session;
use App\Model\UserData;

// Delete user avatar
// https://{{domain}}/api/users/profile/delete

${basename(__FILE__, '.php')} = function () {
    if ($this->isAuthenticated() && $this->get_request_method() == 'POST') {
        try {
            $ud = new UserData(Session::getUser()->getUsername());

            $this->response($this->json([
                'message' => $ud->deleteAvatarImage()
            ]), 200);
        } catch (\Exception $e) {
            $this->response($this->json([
                'message' => $e->getMessage()
            ]), 406);
        }
    } else {
        $this->response($this->json([
            'message' => "Bad Request"
        ]), 400);
    }
};