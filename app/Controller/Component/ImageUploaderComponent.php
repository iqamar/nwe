<?php
/*
 * @package     ImageUploaderComponent
 * @author      Danish Backer
 * @date        22-04-2014
 * @version     1.0
 */

App::uses('Component', 'Controller');

class ImageUploaderComponent extends Component{
    
    /*
     * @param       string $file Name of the file to upload.
     * @param       string $location Location of folder to upload.
     * @param       boolean $logo true or false.
     * @param       boolean $icon true or false.
     * @param       boolean $thumbnail true or false.
     * @param       boolean $cover true or false.
     * @param       string $name Override auto generted output file name.
     * @return      string/boolean $filename/FALSE Will return either name of the file uploaded or FALSE.
     * @usage       $this->ImageUploader->upload($this->request->params['form']['image'], 'folder', TRUE, TRUE, TRUE);
     */
    function upload($file, $location = 'company', $logo = FALSE, $icon = FALSE, $thumbnail = FALSE, $cover = FALSE, $name = '') {
        
        $upload_path = MEDIA_PATH . "files" . DS . $location . DS;
        switch ($file['type']) {
            case 'image/gif' : $ext = '.gif';
                break;
            case 'image/jpeg' :
            case 'image/jpg' : $ext = '.jpg';
                break;
            case 'image/png' : $ext = '.png';
                break;
            default : $ext = '';
                break;
        }
        if (!empty($ext)) {
            $filename = $name ? $name : uniqid("CMP", FALSE) . $ext;
            $dest = $upload_path . 'original' . DS . $filename;
            if (move_uploaded_file($file['tmp_name'], $dest)) { 
                if ($logo)
                    $this->__resize($dest, $upload_path . 'logo' . DS . $filename, 100, 100);
                if ($icon)
                    $this->__resize($dest, $upload_path . 'icon' . DS . $filename, 60, 60);
                if ($thumbnail)
                    $this->__resize($dest, $upload_path . 'thumbnail' . DS . $filename, 100, 100);
                if ($cover)
                    $this->__resize($dest, $upload_path . 'cover' . DS . $filename, 237, 653);
            }
        }
        else
            unset($filename);
        return (!empty($filename)) ? $filename : FALSE;
    }
    
    public function __resize($imagePath, $thumb_path, $destinationWidth, $destinationHeight) {
        // The file has to exist to be resized
        if (file_exists($imagePath)) {
            // Gather some info about the image
            $imageInfo = getimagesize($imagePath);

            // Find the intial size of the image
            $sourceWidth = $imageInfo[0];
            $sourceHeight = $imageInfo[1];

            if ($sourceWidth > $sourceHeight) {
                $temp = $destinationWidth;
                $destinationWidth = $destinationHeight;
                $destinationHeight = $temp;
            }

            // Find the mime type of the image
            $mimeType = $imageInfo['mime'];

            // Create the destination for the new image
            $destination = imagecreatetruecolor($destinationWidth, $destinationHeight);

            // Now determine what kind of image it is and resize it appropriately
            if ($mimeType == 'image/jpeg' || $mimeType == 'image/jpg' || $mimeType == 'image/pjpeg') {
                $source = imagecreatefromjpeg($imagePath);
                imagecopyresampled($destination, $source, 0, 0, 0, 0, $destinationWidth, $destinationHeight, $sourceWidth, $sourceHeight);
                imagejpeg($destination, $thumb_path);
            } else if ($mimeType == 'image/gif') {
                $source = imagecreatefromgif($imagePath);
                imagecopyresampled($destination, $source, 0, 0, 0, 0, $destinationWidth, $destinationHeight, $sourceWidth, $sourceHeight);
                imagegif($destination, $thumb_path);
            } else if ($mimeType == 'image/png' || $mimeType == 'image/x-png') {
                $source = imagecreatefrompng($imagePath);
                imagecopyresampled($destination, $source, 0, 0, 0, 0, $destinationWidth, $destinationHeight, $sourceWidth, $sourceHeight);
                imagepng($destination, $thumb_path);
            } else {
                $this->Session->setFlash(__('This image type is not supported.'), 'flash_error');
            }

            // Free up memory
            imagedestroy($source);
            imagedestroy($destination);
        }
    }
    
}