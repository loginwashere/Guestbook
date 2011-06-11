<?php

class Application_Model_ImagesMapper extends Application_Model_GeustbookMapperAbstract
{
    protected $_dbTableClass = 'Application_Model_DbTable_Images';

    protected $_imagePath = '../public/images/';
    protected $_thumbPath = '../public/images/thumbs/';
    protected $_thumbSize = 200;

    public function save(Application_Model_Images $image)
    {
        $data = array(
            'filename'       => $image->getFilename(),
            'width'          => $image->getWidth(),
            'height'         => $image->getHeight(),
            'resizedwidth'   => $image->getResizedwidth(),
            'resizedheight'  => $image->getResizedheight(),
            'commentid'      => $image->getCommentid(),
        );

        if (null === ($iid = $image->getIid())) {
            unset($data['iid']);
            $data = $this->recieveImage();
            $data['commentid'] = $image->getCommentid();
            $this->getDbTable()->insert($data);
        } else {
            $this->getDbTable()->update($data, array('iid = ?' => $id));
        }
    }

    /**
     * Recieve image and store image information in db
     * return id of recieved image
     *
     * @return array
     */
    public function recieveImage()
    {
        $imageName = $this->_imageUpload($this->_imagePath);
        $imageInfo = $this->_imageResize(
            $this->_imagePath . $imageName,
            $this->_thumbPath . $imageName,
            $this->_thumbSize
        );
        $imageInfo['filename'] = $imageName;
        return $imageInfo;
    }

    /**
     * Upload and rename file
     * return name of uploaded and renamed file
     *
     * @param unknown_type $path
     * @return string
     */
    private function _imageUpload($path)
    {
        $upload = new Zend_File_Transfer_Adapter_Http();
        $upload->setDestination($path);

        //Constructor needs one parameter, the destination path is a good idea
        $renameFilter = new Zend_Filter_File_Rename($path);

        $files = $upload->getFileInfo();
        foreach ($files as $fileID => $fileInfo) {
            if (!$fileInfo['name']=='') {
                $target = uniqid().$fileInfo['name'];
                $renameFilter->addFile(
                    array(
                        'source' => $fileInfo['tmp_name'],
                        'target' => $target,
                        'overwrite' => false
                    )
                );
            }
        }
        // add filters to Zend_File_Transfer_Adapter_Http
        $upload->addFilter($renameFilter);

        // receive all files
        try {
            $upload->receive();
        } catch (Zend_File_Transfer_Exception $e) {
            $this->setErrorMessage($e->getMessage());
        }
        return $target;
    }

	/**
     * Resizes image if necessary
     * returns array of original and resized dimensions
     *
     * @param string $imageName
     * @param string $thumbName
     * @param int    $thumbSize
     * @return array
     */
    private function _imageResize($imageName, $thumbName, $thumbSize)
    {
        $imageExtention = '';
        list($width, $height) = getimagesize($imageName);
        if ($width > $height) {
            $thumbWidth = $thumbSize;
            $thumbHeight = $thumbWidth * $height / $width;
        } else {
            $thumbHeight = $thumbSize;
            $thumbWidth = $thumbHeight * $width / $height;
        }
        if ($thumbSize > $width && $thumbSize > $height) {
            $thumbWidth = $width;
            $thumbHeight = $height;
        }
        $imageType = exif_imagetype($imageName);
        switch ($imageType) {
            case 3:
                $image = imagecreatefrompng($imageName);
                break;
            case 1: //IMAGETYPE_GIF
                $image = imagecreatefromgif($imageName);
                break;
            case 2:
            default:
                $image = imagecreatefromjpeg($imageName);
                break;
        }
        $thumb = imagecreatetruecolor($thumbWidth, $thumbHeight);
        imagecopyresampled(
            $thumb,
            $image,
            0,
            0,
            0,
            0,
            $thumbWidth,
            $thumbHeight,
            $width,
            $height
        );
        switch ($imageType) {
            case 3:
                imagepng($thumb, $thumbName);
                $imageExtention = '.png';
                break;
            case 1:
                imagegif($thumb, $thumbName);
                $imageExtention = '.gif';
                break;
            case 2:
            default:
                imagejpeg($thumb, $thumbName, 100);
                $imageExtention = '.jpg';
                break;
        }
        $result = array(
            'width' => $width,
            'height' => $height,
            'resizedwidth' => $thumbWidth,
            'resizedheight' => $thumbHeight,
        );
        return $result;
    }

}

