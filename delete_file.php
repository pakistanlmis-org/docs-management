<?php

require_once 'classes/files.php';
$files = new files();
$files->pk_id = $_GET['id'];
$res = $files->delete();

if ($res) {
    $dir = "uploads/" . $_GET['id'] . "/";
    $files->_imagecache_recursive_delete($dir);

    header("location: files.php?status=file");
} else {
    header("location: files.php?status=forbidden");
}



