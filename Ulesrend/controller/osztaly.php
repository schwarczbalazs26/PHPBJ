<?php

require "model/osztaly.php";

$osztaly = new Osztaly();  

$msg = '';

if(isset($_POST['felhasznalonev']) and isset($_POST['jelszo'])) {
    // ha érkezik login adat
    if(empty($_POST['felhasznalonev'])) $msg .= "A felhasználónév nem került megadásra. ";
    if(empty($_POST['jelszo'])) $msg .= "A jelszó nem került megadásra. ";
    if(!$msg) {
        $msg = $osztaly->checkLogin($msg);
    }
}
// ha érkezik módosításra név és id
elseif(isset($_POST['modositandoNev']) and isset($_SESSION['id'])) {

    if(!empty($_FILES["fileToUpload"]["name"])) {

        $filemanager = new Filemanager;
        $msg = $filemanager->fileUpload($msg);
    }

    $nev = StringHelper::safe_input($_POST['modositandoNev']);

    $msg = StringHelper::checkName($nev, $msg);

    if ($msg == '') {
        $msg = $osztaly->updateOsztaly();
    }
}

function renderView($osztaly) {
    $action = $_GET['action'] ?? FALSE;

    switch($action) {
        case 'login':
            include "view/login.php";
        break;
    
        case 'datamod':
            include "view/datamod.php";
        break;

        case 'user':
            include "view/user.php";
        break;
    
        default:
            $result = $osztaly->getOsztaly();
            if ($result->num_rows > 0) {
                include "view/index.php";
            }
    }
}

?>