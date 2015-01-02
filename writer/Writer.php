<?php

class Writer
{

    private $_config;
    /**
     * @var Folder[]
     */
    private $_folders = array();

    public function __construct()
    {
        $this->_config = ConfigLoader::load('writer');
        $this->initFolders();
    }

    /**
     * Initialize collection of folders
     */
    private function initFolders()
    {
        $folderFactory = new FolderFactory();
        $folders = ConfigLoader::load('folders');
        try {
            foreach ($folders as $dirName) {
                $directoryPath = $this->_config['base_dir'] . DIRECTORY_SEPARATOR . $dirName;
                $this->_folders[] = $folderFactory->create($directoryPath);
            }
        } catch (WriterException $e) {
            echo $e->getMessage();
        }
    }

    /**
     * Start folders filling
     * @param $count
     */
    public function run($count)
    {

        for ($x = 0; $x < $count; $x++) {

            $fileImitation = $this->getFileImitation();

            $size = $fileImitation['size'];
            $data = $fileImitation['content'];

            $folder = $this->getFitFolder($size);
            if ($folder) {
                try {
                    $fileName = $folder->write($data, $size);
                    echo "Successfully written " . $folder->getPath() . DIRECTORY_SEPARATOR . $fileName . "\n";

                } catch (WriterFolderException $e) {
                    $folder->recalculateSize(); // recalculate folder size
                    echo $e->getMessage() . "\n";
                }
            } else {
                echo "All folders are full!";
                return;
            }
        }
    }

    /**
     * Find folder of  minimum size
     * @param $fileSize
     * @return Folder | boolean
     */
    private function getFitFolder($fileSize)
    {
        $this->sortFoldersBySize();
        if (isset($this->_folders[0])) {
            if ($this->hasFreeSpace($this->_folders[0], $fileSize)) {
                return $this->_folders[0];
            }
        }
        return false;
    }

    /**
     * Sort collection of folders
     */
    public function sortFoldersBySize()
    {
        usort(
            $this->_folders,
            function (Folder $folder1, Folder $folder2) {
                $size1 = $folder1->size();
                $size2 = $folder2->size();
                if ($size1 == $size2) {
                    return 0;
                }
                return ($size1 < $size2) ? -1 : 1;
            });
    }

    /**
     * Contains content and size of file
     * @return array
     */
    private function getFileImitation()
    {
        $size = rand($this->_config['file_size_min'], $this->_config['file_size_max']);
        return array(
            'size' => $size,
            'content' => str_repeat("0", $size)
        );
    }

    /**
     * Folders collection
     * @return array|Folder[]
     */
    public function getFolders()
    {
        return $this->_folders;
    }

    /**
     * Whether free place in folder to this file size
     * @param Folder $folder
     * @param $fileSize
     * @return bool
     */
    private function hasFreeSpace(Folder $folder, $fileSize)
    {
        return ($this->_config['folder_size_max'] - $folder->size()) >= $fileSize;
    }

}

class WriterException extends Exception
{
}
