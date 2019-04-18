<?php

require_once 'classes/attachments.php';
$attachments = new attachments();
$attachments->pk_id = $_GET['id'];
$res = $attachments->delete();

//rmdir("uploads/".$_GET['fileid']);
if ($res) {
    header("location: files.php?status=attachment");
} else {
    header("location: files.php?status=forbidden");
}
