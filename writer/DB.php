<?php

class DB
{
    /**
     * @throws WriterException
     * @return PDO
     */
    public static function connection()
    {
        static $_connection = null;
        if (empty($_connection)) {
            try {
                $dbConfig = ConfigLoader::load('db');
                $_connection = new PDO(
                    'mysql:dbname=' . $dbConfig['name'] . ';host=' . $dbConfig['host'],
                    $dbConfig['user'],
                    $dbConfig['pass']
                );
            } catch (PDOException $e) {
                throw new WriterException("DB error \n" . $e->getTraceAsString());
            }
        }
        return $_connection;
    }
}