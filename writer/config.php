<?php
return array(
    'writer' => array(
        'base_dir' => 'path/to/storage', // root folders directory
        'file_size_min' => 10 * 1024,
        'file_size_max' => 20 * 1024,
        'folder_size_max' => 10000 * 1024,
        'use_db' => false, // whether use database
    ),
    'folders' => array(
        'test1',
        'test2',
        'test3',
    ),
    'db' => array(
        'host' => 'localhost',
        'name' => 'test',
        'user' => 'root',
        'pass' => '',
    ),
);