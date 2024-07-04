<?php

namespace App\Service;

class FileType
{
    public function checkFileType($fileName)
    {
        if (!file_exists($fileName)) {
            return 'File does not exist';
        }

        $fileInfo = pathinfo($fileName);
        if (!isset($fileInfo['extension'])) {
            return 'unknown';
        }

        $extension = strtolower($fileInfo['extension']);

        switch ($extension) {
            case 'xml':
                return 'xml';
            case 'json':
                return 'json';
            default:
                return 'Unprocessable file type';
        }
    }
}
