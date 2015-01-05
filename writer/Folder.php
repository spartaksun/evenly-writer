<?php

namespace writer;


abstract class Folder
{

    private $_path;
    protected $_size;

    abstract function  newFileName($size);

    public function __construct($path)
    {
        $this->_path = $path;
        if (!is_dir($path)) {
            if (!mkdir($path, 0644)) {
                throw new WriterFolderException('Error creation of directory ' . $path);
            }
        }
        $this->recalculateSize();
    }

    public function size()
    {
        if (is_null($this->_size)) {
            $this->recalculateSize();
        }
        return $this->_size;
    }

    public function sizeString()
    {
        return round(($this->size() / (1024 * 1000)), 2) . ' MB';
    }

    private function plusSize($size)
    {
        $this->_size += $size;
    }

    abstract function recalculateSize();

    /**
     * Fast approach of getting directory size in linux
     * We don't use it =)
     * @return string
     */
    public function recalculateSizeLinux()
    {
        $io = popen('/usr/bin/du -sk ' . $this->_path, 'r');
        $result = fgets($io, 4096);
        $size = substr($result, 0, strpos($result, ' '));
        pclose($io);
        return $size;
    }

    /**
     * @param $content
     * @param $size
     * @throws WriterFolderException
     * @return string file name
     */
    public function write($content, $size)
    {
        $fileName = $this->newFileName($size);

        if (empty($fileName)) {
            throw new WriterFolderException("Error: was received empty file name.");
        }
        $filePath = $this->getFileFullPath($fileName);

        $f = @fopen($filePath, 'x+');
        if ($f === false) { // file already exist
            throw new WriterFolderException("File {$filePath} already exist.");
        }
        if (fwrite($f, $content) === false) {
            fclose($f);
            throw new WriterFolderException("Error of writing file.");
        }
        // Increase folder size counter
        $this->plusSize($size);
        fclose($f);

        return $fileName;
    }

    protected function getFileFullPath($fileName)
    {
        return $this->_path . DIRECTORY_SEPARATOR . $fileName;
    }

    public function getPath()
    {
        return $this->_path;
    }

}

class WriterFolderException extends WriterException
{
}