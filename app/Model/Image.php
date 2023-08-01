<?php

namespace Storylog\Model;

use Exception;

class Image
{
    private $image;
    private $imageType;
    private $supportedTypes = [
        'image/jpeg',
        'image/png'
    ];
    
    private array $image_errors = [
        UPLOAD_ERR_OK,
        UPLOAD_ERR_INI_SIZE,
        UPLOAD_ERR_FORM_SIZE,
        UPLOAD_ERR_PARTIAL,
        UPLOAD_ERR_NO_FILE,
        UPLOAD_ERR_NO_TMP_DIR,
        UPLOAD_ERR_CANT_WRITE,
        UPLOAD_ERR_EXTENSION
    ];
    
    public function __construct()
    {
    }

    // Save Image to specified location
    public function save(object $image, string $pathCategory)
    {        
        if (!isset($this->image, $this->imageType)) {
            $this->image = $image;
            $this->imageType = $image->getClientMediaType();
        }
        $tmpFilePath = $this->image->getFilePath();
        $fileExtension = image_type_to_extension(exif_imagetype($tmpFilePath));
        $newFileName = md5(mt_rand(1, 10000) . $fileExtension) . $fileExtension;
        $newFilePath = DIRECTORY_SEPARATOR . $pathCategory . DIRECTORY_SEPARATOR . $newFileName;
        $newFileLocation = STORAGE_PATH . $newFilePath;
        
        if (!in_array($this->imageType, $this->supportedTypes)) {
            throw new Exception("Image type is not supported.");
        }

        if (move_uploaded_file($tmpFilePath, $newFileLocation)) {
            return $newFilePath;
        }
        
        throw new Exception("Image not uploaded!");
    }

    public function exists(object $image)
    {
        $errorCode = $image->getError();
        if (in_array($errorCode, $this->image_errors)) {
            if ($this->image_errors[$errorCode] == 0) {
                return true;
            }
            if ($this->image_errors[$errorCode] == 4) {
                return false;
            }
            throw new Exception("Image not uploaded. Error Code: ".$errorCode);
        }
    }

    public function getImage()
    {

    }

    public function deleteImage($id)
    {
        
    }

    public function display()
    {
        header('Content-Type: ' . image_type_to_mime_type($this->imageType));
        $imageOutputFunction = 'image' . $this->supportedTypes[$this->imageType];
        $imageOutputFunction($this->image);
    }

    public function getWidth(): int
    {
        return imagesx($this->image);
    }

    public function getHeight(): int
    {
        return imagesy($this->image);
    }

    public function destroy()
    {
        imagedestroy($this->image);
    }
}