<?php
session_start();
require_once 'classes/tracking.php';

$uploadOk = 1;
$target_file = '';

if (isset($_FILES["file"]["tmp_name"])) {
    $target_dir = "uploads/" . $_POST['hdnfileid'] . "/";
    $target_file = $target_dir . basename($_FILES["file"]["name"]);
    
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
// Check if image file is a actual image or fake image

    $check = getimagesize($_FILES["file"]["tmp_name"]);
    if ($check !== false) {
        $_SESSION['msg'] =  "File is an image - " . $check["mime"] . ".";
        $uploadOk = 1;
    } else {
        $_SESSION['msg'] =  "File is not an image.";
        $uploadOk = 0;
    }

// Check if file already exists
    if (file_exists($target_file)) {
        $_SESSION['msg'] =  "Sorry, file already exists.";
        $uploadOk = 0;
    }
// Check file size
    if ($_FILES["file"]["size"] > 500000) {
        $_SESSION['msg'] =  "Sorry, your file is too large.";
        $uploadOk = 0;
    }
// Allow certain file formats
    if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
        $_SESSION['msg'] =  "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
        $uploadOk = 0;
    }
// Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) {
        $_SESSION['msg'] =  "Sorry, your file was not uploaded.";
// if everything is ok, try to upload file
    } else {
        if (move_uploaded_file($_FILES["file"]["tmp_name"], $target_file)) {
            $_SESSION['msg'] =  "The file " . basename($_FILES["file"]["name"]) . " has been uploaded.";
        } else {
            $_SESSION['msg'] =  "Sorry, there was an error uploading your file.";
        }
    }
}

$tracking = new tracking();
$tracking->edoc_file_id = $_POST['hdnfileid'];
$tracking->in_date = date("Y-m-d");
$tracking->out_date = date("Y-m-d");
$tracking->source = $_SESSION['userid'];
$tracking->destination = $_POST['file_user'];
$tracking->subject = $_POST['subject'];
$tracking->contents = $_POST['contents'];
$tracking->file_path = $target_file;
$tracking->status = $_POST['status'];
$tracking->created_date = date("Y-m-d h:i:s");
$tracking->created_by = $_SESSION['userid'];
$tracking->modified_by = $_SESSION['userid'];
$tracking->modified_date = date("Y-m-d h:i:s");
$track = $tracking->save();

if ($track) {
    require_once 'classes/files.php';
    $files = new files();
    $files->pk_id = $_POST['hdnfileid'];
    $files->modified_by = $_POST['file_user'];
    $files->modified_date = date("Y-m-d h:i:s");
    $files->save();

    $_SESSION['msg'] = "File has been transfered successfully!";
} else {
    $_SESSION['msg'] = "There is some error transfering this file. Please try again!";
}

header("location:files.php");
