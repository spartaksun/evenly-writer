<?php
define('BASE_DIR', __DIR__);
spl_autoload_register(function ($className) {
    require_once BASE_DIR . DIRECTORY_SEPARATOR . 'writer' . DIRECTORY_SEPARATOR . $className . '.php';
});

if (!(empty($argv) && !empty($argv[1]))) {
    try {
        switch($argv[1]){
            case 'write': // filling directories

                if(empty($argv[2])){
                    echo "Missing argument 2";
                } else {
                    $writer = new Writer();
                    $writer->run($argv[2]);
                }

                break;
            case 'stat': // statistic

                $writer = new Writer();
                $writer->sortFoldersBySize();
                foreach($writer->getFolders() as $folder){
                    echo $folder->sizeString().' '.$folder->getPath()."\n";
                }

                break;
        }
    } catch (WriterException $e) {
        echo $e->getMessage() . "'\n" . $e->getTraceAsString();
    }
} else {
    die("Incorrect command");
}





