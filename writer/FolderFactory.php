<?php

namespace writer;


/**
 * Create folder instance
 * Class FolderFactory
 */
class FolderFactory
{

    /**
     * @param $path
     * @throws WriterException
     * @return Folder
     */
    public function create($path)
    {
        try {
            $config = ConfigLoader::load('writer');

            if (!empty($config['use_db'])) {
                return new FolderDB($path);
            } else {
                return new FolderNoDB($path);
            }
        } catch (WriterFolderException $e) {
            throw new WriterException('Folder init error: ' . $e->getMessage());
        }
    }
}