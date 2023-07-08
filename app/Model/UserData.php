<?php

namespace App\Model;

use Exception;
use App\Core\Database;
use App\Core\Session;
use App\Traits\SQLGetterSetter;
use RuntimeException;

class UserData
{
    public $id;
    public $conn;
    public $table;
    public $username;
    use SQLGetterSetter;
    
    public function __construct(string $username)
    {
        if (!$this->conn) {
            $this->conn = Database::getConnection();
        }
        $this->id = $this->getUserId($username);
        $this->table = 'users';
        $this->username = $username;
    }

    private function escapeString($value)
    {
        return htmlspecialchars(mysqli_real_escape_string($this->conn, $value), ENT_QUOTES | ENT_HTML5, 'UTF-8');
    }

    /**
     * Remove the user avatar from storage
     */
    private function purgeUserAvatar()
    {
        try {
            $image_name = basename($this->getAvatar());
            $image_path = APP_STORAGE_PATH. '/avatars/' .$image_name;
            if (file_exists($image_path)) {
                if (unlink($image_path)) {
                    return true;
                } else {
                    throw new Exception(__CLASS__."::".__FUNCTION__.", can't purge user avatar. Image path: $image_path");
                }
            }
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }
    
    /**
     * Removes avatar from both storage and database
     */
    public function deleteAvatarImage()
    {
       if (!$this->conn) {
            $this->conn = Database::getConnection();
        }

        try {
            if ($this->purgeUserAvatar()) {
                $sql = "UPDATE `$this->table` SET `avatar` = NULL WHERE `id` = '$this->id';";
                if ($this->conn->query($sql)) {
                    return true;
                } else {
                    return false;
                }
            }
        } catch (Exception $e) {
            throw new Exception("can't remove user avatar");
        }
    }

    /**
     * Set new avatar for user
     */
    public function setNewAvatar(string $image_tmp)
    {       
        $image_tmp = $this->escapeString($image_tmp);
        
        if (is_file($image_tmp) && exif_imagetype($image_tmp) !== false) {
            $owner = Session::getUser()->getUsername();
            $image_name = md5($owner.mt_rand(0, 9999)) . image_type_to_extension(exif_imagetype($image_tmp));
            $image_path = APP_STORAGE_PATH . '/avatars/' .$image_name;
            if (move_uploaded_file($image_tmp, $image_path)) {
                // Remove the existing avatar from storage and database
                if (!empty($this->getAvatar())) {
                    $this->deleteAvatarImage($this->getAvatar());
                }
                if (extension_loaded('gd')) {
                    $filename = $image_path;
                    $img = imagecreatefromstring(file_get_contents($filename));
                    $ini_x_size = getimagesize($filename)[0];
                    $ini_y_size = getimagesize($filename)[1];

                    $crop_measure = min($ini_x_size, $ini_y_size);
                    $crop_array = array('x' => 0, 'y' => 0, 'width' => $crop_measure, 'height' => $crop_measure);
                    $cropped_img = imagecrop($img, $crop_array);
                    
                    // Writing the cropped image where the image is stored 
                    imagejpeg($cropped_img, $image_path, 50);
                    
                    // Destory to free up memory
                    imagedestroy($cropped_img);

                    $image_uri = "/files/avatars/$image_name";
                    $sql = "UPDATE `$this->table` SET `avatar` = '$image_uri' WHERE `id` = '$this->id';";
                    if ($this->conn->query($sql)) {
                        return true;
                    } else {
                        return false;
                    }
                } else {
                    throw new RuntimeException('Extension gd is not enabled!');
                }
            } else {
                throw new Exception("Can't move the uploaded file");
            }
        } else {
            throw new Exception("Image not uploaded");
        }
    }
    
    /**
     * Get user avatar URL
     */
    public function getUserAvatar()
    {
        $url = "https://api.dicebear.com/6.x/shapes/svg?seed=";
        if (!empty($this->getAvatar())) {
            return $this->getAvatar();
        } else {
            return $url.$this->id;
        }
    }

    /**
     * Check if the data already exists in the database
     */
    public function exists()
    {
        $sql = "SELECT * FROM `$this->table` WHERE `id` = '$this->id';";

        $result = $this->conn->query($sql);
        if ($result->num_rows == 1) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Update user data
     */
    public function update(string $fname, string $lname, string $email, string $job, string $bio, string $location, string $tw, string $ig)
    {
        $fname = $this->escapeString($fname);
        $lname = $this->escapeString($lname);
        $bio = $this->escapeString($bio);
        $job = $this->escapeString($job);
        $lc = $this->escapeString($location);
        $tw = $this->escapeString($tw);
        $ig = $this->escapeString($ig);
        $email = $this->escapeString($email);

        if ($this->exists()) {
            $sql = "UPDATE `$this->table` SET `first_name` = '$fname', `last_name` = '$lname', `website` = '$email', `job` = '$job', `bio` = '$bio', `location` = '$lc', `twitter` = '$tw', `instagram` = '$ig' WHERE `id` = '$this->id';";
        } else {
            $sql = "INSERT INTO `$this->table` (`id`, `first_name`, `last_name`, `bio`, `job`, `website`, `location`, `twitter`, `instagram`) VALUES ('$this->id', '$fname', '$lname', '$bio', '$job', '$email', '$lc', '$tw', '$ig');";
        }

        try {
            $this->conn->query($sql);
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }
}