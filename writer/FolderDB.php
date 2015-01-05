<?php

namespace writer;

class FolderDB extends Folder
{
    public function  newFileName($size)
    {
        $connection = DB::connection();
        $connection->prepare('INSERT INTO writer SET size = :size, folder = :folder')
            ->execute(array(
                ':size' => $size,
                ':folder' => $this->getPath(),
            ));
        return $connection->lastInsertId();
    }

    public function recalculateSize()
    {
        $st = DB::connection()->prepare('SELECT SUM(size) FROM writer WHERE folder = :folder');
        $st->bindParam(':folder', $this->getPath());
        $st->execute();
        $this->_size = $st->fetchColumn() + 0;
        return $this->_size;
    }
}