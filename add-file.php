<?php

session_start();
require_once 'classes/files.php';
require_once 'classes/tracking.php';
require_once 'classes/attachments.php';

$files = new files();
if (isset($_POST['fileid']) && !empty($_POST['fileid'])) {
    $files->pk_id = $_POST['fileid'];
}
$files->file_no = $_POST['fileno'];
$files->file_title = $_POST['title'];
$files->receive_from = $_POST['receive_from'];
$files->file_description = $_POST['description'];
$files->file_department = $_POST['file_department'];
$files->status = $_POST['status'];
$files->created_date = date("Y-m-d h:i:s");
$files->created_by = $_SESSION['userid'];
$files->modified_by = $_SESSION['userid'];
$files->modified_date = date("Y-m-d h:i:s");
$file = $files->save();

if ($file) {
    if (!file_exists("uploads/$file")) {
        mkdir("uploads/$file", 0777, true);
    }

    $tracking = new tracking();
    $tracking->edoc_file_id = $file;
    $tracking->in_date = date("Y-m-d h:i:s");
    $tracking->out_date = "0000-00-00";
    $tracking->source = $_SESSION['userid'];
    $tracking->destination = $_SESSION['userid'];
    $tracking->subject = $_POST['fileno'];
    $tracking->status = 1;
    $tracking->created_date = date("Y-m-d h:i:s");
    $tracking->created_by = $_SESSION['userid'];
    $tracking->modified_by = $_SESSION['userid'];
    $tracking->modified_date = date("Y-m-d h:i:s");
    $track = $tracking->save();

    //Upload Start
    $uploadOk = 1;
    $target_file = '';

    if (count($_FILES["file"]["name"]) > 0) {
        for ($i = 0; $i < count($_FILES['file']['name']); $i++) {
            $target_dir = "uploads/" . $file . "/";
            $ext = pathinfo($_FILES["file"]["name"][$i], PATHINFO_EXTENSION);
            $target_file = $target_dir . basename(preg_replace("/[^a-zA-Z0-9]+/", "", str_replace($ext, "", $_FILES["file"]["name"][$i]))).".".$ext;

            $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
            // Check if image file is a actual image or fake image

            $check = getimagesize($_FILES["file"]["tmp_name"][$i]);
//            if ($check !== false) {
//                $_SESSION['msg'] = "File is an image - " . $check["mime"] . ".";
//                $uploadOk = 1;
//            } else {
//                $_SESSION['msg'] = "File is not an image.";
//                $uploadOk = 0;
//            }
            // Check if file already exists
            if (file_exists($target_file)) {
                $_SESSION['msg'] = "Sorry, file already exists.";
                $uploadOk = 0;
            }
            // Check file size
//            if ($_FILES["file"]["size"] > 500000) {
//                $_SESSION['msg'] = "Sorry, your file is too large.";
//                $uploadOk = 0;
//            }
//            // Allow certain file formats
//            if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
//                $_SESSION['msg'] = "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
//                $uploadOk = 0;
//            }
            // Check if $uploadOk is set to 0 by an error
            if ($uploadOk == 0) {
                $_SESSION['msg'] = "Sorry, your file was not uploaded.";
                // if everything is ok, try to upload file
            } else {
                if (move_uploaded_file($_FILES["file"]["tmp_name"][$i], $target_file)) {
                    $_SESSION['msg'] = "The file " . basename($_FILES["file"]["name"][$i]) . " has been uploaded.";
                } else {
                    $_SESSION['msg'] = "Sorry, there was an error uploading your file.";
                }
            }

            $attachments = new attachments();
            $attachments->file_name = preg_replace("/[^a-zA-Z0-9]+/", "", str_replace($ext, "", $_FILES["file"]["name"][$i])).".".$ext;
            $attachments->file_id = $file;
            $attachments->user_id = $_SESSION['userid'];
            $attachments->save();
        }
    }
    //Upload End

    $_SESSION['msg'] = "File has been added successfully!";
    header("location:files.php");
} else {
    $_SESSION['msg'] = "There is some error creating a file. Please try again!";
    header("location:files.php?status=forbidden");
}