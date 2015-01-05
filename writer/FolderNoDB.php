<?php

namespace writer;


class FolderNoDB extends Folder
{

    public function newFileName($size)
    {
        $name = uniqid() . (microtime(true) * 10000) . '_' . $size;
        if (!file_exists($this->getPath() . DIRECTORY_SEPARATOR . $name)) {
            return $name;
        }
        return $this->newFileName($size);
    }

    public function recalculateSize()
    {
        $totalFilesSize = 0;
        foreach (scandir($this->getPath()) as $fileName) {
            $filePath = $this->getFileFullPath($fileName);
            if (is_file($filePath)) {
                $totalFilesSize += filesize($filePath);
            }
        }
        $this->_size = $totalFilesSize;
    }
}