<?php

use App\Model\UserData;

// https://{{domain}}/api/users/update

${basename(__FILE__, '.php')} = function () {
    if ($this->get_request_method() == 'POST' && !empty($this->_request)) {
        $ud = new UserData($this->getUsername());
        $post_fields = ['fname', 'lname', 'website', 'job', 'bio', 'location', 'twitter', 'instagram'];
        $data = [];

        foreach ($post_fields as $field) {
            if (isset($this->_request[$field])) {
                $data[$field] = $this->_request[$field];
            }
        }

        $ud->update($data['fname'], $data['lname'], $data['website'], $data['job'], $data['bio'], $data['location'], $data['twitter'], $data['instagram']);
        if (isset($_FILES) && $_FILES['user_image']['error'] !== UPLOAD_ERR_NO_FILE) {
            $ud->setNewAvatar($_FILES['user_image']['tmp_name']);
        }
        
        $this->response($this->json([
            'message'=>'Updated'
        ]), 200);
    } else {
        $this->response($this->json([
            'message'=> "Not Acceptable"
        ]), 406);
    }
};