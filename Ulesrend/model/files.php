<?php
function fileUpload($msg)
{

    $uploadOk = 0;
    $maxFileSize = 10;
    $maxFileSize = $maxFileSize * 1024 * 1024; // MB-ban adjuk meg :)
    $fileName = basename($_FILES["fileToUpload"]["name"]);
    $fileNameArray = preg_split("/\./", $fileName);
    $fileName = $_SESSION['id'] . "." . $fileNameArray[1];
    $target_file = TARGET_DIR . $fileName;


    $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
    if ($check !== false) {
        $uploadOk = 1;
    } else {
        $msg .= "A feltöltött " . $_FILES["fileToUpload"]["name"] . " fájl nem kép. ";
        $uploadOk = 0;
    }

    if ($_FILES["fileToUpload"]["size"] > $maxFileSize) {
        $msg .= "A feltöltött " . $_FILES["fileToUpload"]["name"] . " mérete túl nagy. ";
        $uploadOk = 0;
    }

    if ($uploadOk == 1) {
        foreach (IMG_EXTS as $ext) {
            $imgFile = TARGET_DIR . $_SESSION["id"] . $ext;
            if (file_exists($imgFile)) {
                unlink($imgFile);
            }
        }
        move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file);
    }
    return $msg;
}
?>